{{-- cambio por IA: Explicación y documentación detallada de cómo funciona este código --}}

{{-- 
    1. Uso del componente Blade (<x-admin-layout>):
       Llama al diseño base de la sección administrativa (layouts/admin.blade.php).

    2. Paso de variables mediante atributo reactivo (:breadcrumb="..."):
       El prefijo con dos puntos ':' es clave en Blade. Le indica al compilador que ejecute 
       el contenido como código PHP (un arreglo en este caso) en lugar de una simple cadena de texto.
--}}
<x-admin-layout 
title="Proveedores | DevStore"
:breadcrumb="[ 
    
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Proveedores',
        'href' => route('admin.suppliers.index'),
    ],
    [
        'name' => 'Editar Proveedor',
    ],

]"> 

      <x-wire-card>
        
        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" class='space-y-4'>

            @csrf

            @method('PUT')

            <div class='grid grid-cols-2 gap-4'>
            
                <x-wire-native-select label="Tipo de documento" name="identity_id">
                
                    @foreach($identitis as $identity)
                     <option value="{{ $identity->id }}" @selected(old('identity_id', $supplier->identity_id) == $identity->id)> 
                        {{ $identity->name }}
                     </option>
                    @endforeach
                </x-wire-native-select>
                

                 <x-wire-input
            label="Numero de Documento"
            name="document_number"  
            value="{{ old('document_number', $supplier->document_number) }}"
            placeholder="Ingresa el documento"
            />
            
            </div>

            <x-wire-input
            label="Nombre"
            name="name"
            value="{{ old('name', $supplier->name) }}"
            placeholder="Nombre del proveedor"
            />

            <x-wire-input
            label="Direccion"
            name="address"
            type="text"
            value="{{ old('address', $supplier->address) }}"
            placeholder="Direccion del proveedor"
            />
            
            <x-wire-input
            label="Email"
            type="email"
            name="email"
            placeholder="Correo electronico del proveedor"
            value="{{ old('email', $supplier->email) }}"
            />

            <x-wire-input
            label="Telefono"
            type="tel"
            name="phone"
            placeholder="Numero de telefono del proveedor"
            value="{{ old('phone', $supplier->phone) }}"
            />

            <div class="flex justify-end">
                <x-button type="submit">
                    Actualizar
                </x-button>
            </div>

        </form>
    </x-wire-card>

    {{-- 
        Todo lo que se coloque aquí adentro representa el contenido dinámico de la página, 
        el cual Blade inyecta automáticamente en la variable {{ $slot }} dentro de admin.blade.php
    --}}

    

</x-admin-layout>