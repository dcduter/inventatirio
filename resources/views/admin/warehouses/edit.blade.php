{{-- cambio por IA: Explicación y documentación detallada de cómo funciona este código --}}

{{-- 
    1. Uso del componente Blade (<x-admin-layout>):
       Llama al diseño base de la sección administrativa (layouts/admin.blade.php).

    2. Paso de variables mediante atributo reactivo (:breadcrumb="..."):
       El prefijo con dos puntos ':' es clave en Blade. Le indica al compilador que ejecute 
       el contenido como código PHP (un arreglo en este caso) en lugar de una simple cadena de texto.
--}}
<x-admin-layout 
title="Almacenes | DevStore"
:breadcrumb="[ 
    
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Almacenes',
        'href' => route('admin.warehouses.index'),
    ],
    [
        'name' => 'Editar Almacén',
    ],

]"> 

      <x-wire-card>
        
        <form action="{{ route('admin.warehouses.update', $warehouse) }}" method="POST" class='space-y-4'>

            @csrf

            @method('PUT')

            <x-wire-input
            label="Nombre"
            name="name"
            value="{{ old('name', $warehouse->name) }}"
            placeholder="Ingresa el almacen"
            />

            <x-wire-input
            label="Ubicación"
            name="location"
            value="{{ old('location', $warehouse->location) }}"
            placeholder="Ingresa la ubicación del almacén"
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