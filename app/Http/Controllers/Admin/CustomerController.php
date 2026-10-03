<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // cambio por IA

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $identitis = Identity::all();
        return view('admin.customers.create', compact('identitis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // store se usa para guardar datos en la base de datos
    {
       $data = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|unique:customers,document_number|max:10',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            // cambio por IA: validación unique para email
            'email' => 'nullable|string|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:10',
        ]);
       // return $data;
        // se crea el cliente
        $customer = Customer::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente creado exitosamente',
            'text' => 'El cliente se ha creado correctamente.',
        ]);
        //redirecciona a la vista edit con los datos del cliente
        return redirect()->route('admin.customers.edit', $customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {  
        // Obtiene todas las identidades y se las pasa a la vista
        $identitis = Identity::all();
        // retorna la vista edit con los datos del cliente y las identidades
        return view('admin.customers.edit', compact('customer', 'identitis'));
    }

    /**
     * Actualiza el cliente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  Petición HTTP con los datos a actualizar.
     * @param  \App\Models\Customer  $customer  Modelo del cliente a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirecciona a la vista de edición con mensaje flash.
     */
    public function update(Request $request, Customer $customer)
    {
        //return $request->all();
        // validaciones
        $data = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            // cambio por IA: se ignora el ID del cliente actual para permitir guardar con su mismo documento
            'document_number' => [
                'required',
                'string',
                'max:10',
                Rule::unique('customers', 'document_number')->ignore($customer->id),
            ],
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            // cambio por IA: validación de email único ignorando el id actual
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer->id),
            ],
            'phone' => 'nullable|string|max:10',
        ]);

        // se actualiza el cliente
        $customer->update($data);

        // variable de sesion flash
        // Esta variable se almacena temporalmente y se elimina después de la siguiente solicitud.
        // Se utiliza para mostrar mensajes flash (notificaciones que aparecen una sola vez después de una acción). 

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente actualizado exitosamente',
            'text' => 'El cliente se ha actualizado correctamente.',
        ]);

        //redirecciona a la vista edit con los datos del cliente
        return redirect()->route('admin.customers.edit', $customer);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // verificamos si el cliente tiene relaciones con quotes y sales para que no se pueda eliminar
        if($customer->quotes()->exists() || $customer->sales()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'No se puede eliminar el cliente',
                'text' => 'El cliente tiene cotizaciones o ventas asociadas y no se puede eliminar.',
            ]);
            return redirect()->route('admin.customers.index');
        }


        //
        $customer->delete();

        //variable de sesion flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente eliminado exitosamente',
            'text' => 'El cliente se ha eliminado correctamente.',
        ]);
        //redirecciona a la lista de clientes
        return redirect()->route('admin.customers.index');
    }
}
