<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // cambio por IA

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $identitis = Identity::all();
        return view('admin.suppliers.create', compact('identitis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // store se usa para guardar datos en la base de datos
    {
       $data = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|unique:suppliers,document_number|max:10',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            // cambio por IA: validación unique para email
            'email' => 'nullable|string|email|max:255|unique:suppliers,email',
            'phone' => 'nullable|string|max:10',
        ]);
       // return $data;
        // se crea el proveedor
        $supplier = Supplier::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proveedor creado exitosamente',
            'text' => 'El proveedor se ha creado correctamente.',
        ]);
        //redirecciona a la vista edit con los datos del proveedor
        return redirect()->route('admin.suppliers.edit', $supplier);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {  
        // Obtiene todas las identidades y se las pasa a la vista
        $identitis = Identity::all();
        // retorna la vista edit con los datos del cliente y las identidades
        return view('admin.suppliers.edit', compact('supplier', 'identitis'));
    }

    /**
     * Actualiza el cliente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  Petición HTTP con los datos a actualizar.
     * @param  \App\Models\Supplier  $supplier  Modelo del cliente a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirecciona a la vista de edición con mensaje flash.
     */
    public function update(Request $request, Supplier $supplier)
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
                Rule::unique('suppliers', 'document_number')->ignore($supplier->id),
            ],
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            // cambio por IA: validación de email único ignorando el id actual
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($supplier->id),
            ],
            'phone' => 'nullable|string|max:10',
        ]);

        // se actualiza el proveedor
        $supplier->update($data);

        // variable de sesion flash
        // Esta variable se almacena temporalmente y se elimina después de la siguiente solicitud.
        // Se utiliza para mostrar mensajes flash (notificaciones que aparecen una sola vez después de una acción). 

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proveedor actualizado exitosamente', // cambio por IA: corregido de Cliente a Proveedor
            'text' => 'El proveedor se ha actualizado correctamente.', // cambio por IA: corregido de Cliente a Proveedor
        ]);

        //redirecciona a la vista edit con los datos del proveedor
        return redirect()->route('admin.suppliers.edit', $supplier);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // verificamos si el cliente tiene relaciones con purchase_orders y purchases para que no se pueda eliminar
        if($supplier->purchaseOrders()->exists() || $supplier->purchases()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'No se puede eliminar el proveedor',
                'text' => 'El proveedor tiene ordenes de compra o compras asociadas y no se puede eliminar.',
            ]);
            return redirect()->route('admin.suppliers.index');
        }


        //
        $supplier->delete();

        //variable de sesion flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proveedor eliminado exitosamente',
            'text' => 'El proveedor se ha eliminado correctamente.',
        ]);
        //redirecciona a la lista de clientes
        return redirect()->route('admin.suppliers.index');
    }
}
