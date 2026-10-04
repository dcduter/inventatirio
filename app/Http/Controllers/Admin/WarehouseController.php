<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       // return $request->all();
       // validar datos
       $data = $request->validate([
        'name' => 'required|string|max:225',
        'location' => 'required|string|max:225',
       ]);

       // se guarda en la base de datos
       $warehouse = Warehouse::create($data);

       // variable de sesion flash para mostrar mensaje
      session()->flash('swal',[
            
        'icon' => 'success',
        'title' => 'Almacén creado exitosamente',
        'text' => 'El almacén ha sido creado correctamente',
      ]);

       //se redirecciona a edit
       return redirect()->route('admin.warehouses.edit', $warehouse)->with('success', 'Almacén creado exitosamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        //
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //return $request->all();

        // validacion de datos
          $data = $request->validate([
        'name' => 'required|string|max:225',
        'location' => 'required|string|max:225',
       ]);

       // se actualiza en la base de datos
       $warehouse->update($data);

       // variable de sesion flash
       session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Exitoso',
        'text' => 'Se Actualizo Correctamente',
       ]);

       // redirect a edit
       return redirect()->route('admin.warehouses.edit', $warehouse)->with('success', 'Se actualizo Correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        // no se elimina si tiene registros relacionados con inventarios
        if($warehouse->inventories()->exists()){
            // varible de sesion flash
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se puede eliminar el almacén porque tiene registros relacionados con inventarios',
            ]);
            
            // redirect a index
            return redirect()->route('admin.warehouses.index')->with('success', 'No se puede eliminar el almacén porque tiene registros relacionados con inventarios');
        }

        $warehouse->delete();

        // variable de sesion flash
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Exitoso',
            'text' => 'Se Elimino Correctamente',
        ]);

        // redirect a index
        return redirect()->route('admin.warehouses.index')->with('success', 'Se Elimino Correctamente');
    }
}
