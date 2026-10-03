{{-- cambio por IA: Explicación y documentación detallada de cómo funciona este código --}}

{{-- 
    1. Uso del componente Blade (<x-admin-layout>):
       Llama al diseño base de la sección administrativa (layouts/admin.blade.php).

    2. Paso de variables mediante atributo reactivo (:breadcrumb="..."):
       El prefijo con dos puntos ':' es clave en Blade. Le indica al compilador que ejecute 
       el contenido como código PHP (un arreglo en este caso) en lugar de una simple cadena de texto.
--}}
<x-admin-layout 
title="Clientes | DevStore"
:breadcrumb="[ 
    
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Clientes',
        'href' => route('admin.customers.index'),
    ],
    [
        'name' => 'Nuevo',
    ],

]"> 
    <x-wire-card>
        
        <form action="{{ route('admin.customers.store') }}" method="POST" class='space-y-4'>

            @csrf

            <div class='grid grid-cols-2 gap-4'>
            
                <x-wire-native-select label="Tipo de documento" name="identity_id">
                
                    @foreach($identitis as $identity)
                     <option value="{{ $identity->id }}" @selected(old('identity_id') == $identity->id)> 
                        {{ $identity->name }}
                     </option>
                    @endforeach
                </x-wire-native-select>
                

                 <x-wire-input
            label="Numero de Documento"
            name="document_number"
            value="{{ old('document_number') }}" {{-- cambio por IA: corregido old('identity_number') por old('document_number') --}}
            placeholder="Ingresa el documento"
            />
            
            </div>

            <x-wire-input
            label="Nombre"
            name="name"
            value="{{ old('name') }}"
            placeholder="Nombre del cliente"
            />

            <x-wire-input
            label="Direccion"
            name="address"
            type="text"
            value="{{ old('address') }}"
            placeholder="Direccion del cliente"
            />
            
            <x-wire-input
            label="Email"
            type="email"
            name="email"
            placeholder="Correo electronico del cliente"
            value="{{ old('email') }}"
            />

            <x-wire-input
            label="Telefono"
            type="tel"
            name="phone"
            placeholder="Numero de telefono del cliente"
            value="{{ old('phone') }}"
            />

            <div class="flex justify-end">
                <x-button type="submit">
                    Guardar
                </x-button>
            </div>

        </form>
    </x-wire-card>
    {{-- 
        Todo lo que se coloque aquí adentro representa el contenido dinámico de la página, 
        el cual Blade inyecta automáticamente en la variable {{ $slot }} dentro de admin.blade.php
    --}}


</x-admin-layout>