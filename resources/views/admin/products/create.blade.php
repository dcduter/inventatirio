{{-- cambio por IA: Explicación y documentación detallada de cómo funciona este código --}}

{{-- 
    1. Uso del componente Blade (<x-admin-layout>):
       Llama al diseño base de la sección administrativa (layouts/admin.blade.php).

    2. Paso de variables mediante atributo reactivo (:breadcrumb="..."):
       El prefijo con dos puntos ':' es clave en Blade. Le indica al compilador que ejecute 
       el contenido como código PHP (un arreglo en este caso) en lugar de una simple cadena de texto.
--}}
<x-admin-layout 
title="Productos | DevStore"
:breadcrumb="[ 
    
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
        'href' => route('admin.products.index'),
    ],
    [
        'name' => 'Nuevo',
    ],

]"> 
    <x-wire-card>
        
        {{-- cambio por IA: Formulario alineado estrictamente con el diagrama ERD de inventario (eliminados campos ajenos de ShopCreativa) --}}
        <form action="{{ route('admin.products.store') }}" method="POST" class='space-y-4'>

            @csrf

            <x-wire-input
                label="Nombre"
                name="name"
                value="{{ old('name') }}"
                placeholder="Ingresa el nombre del producto"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input
                    label="SKU"
                    name="sku"
                    value="{{ old('sku') }}"
                    placeholder="Código único de producto (opcional)"
                />

                <x-wire-input
                    label="Código de barras"
                    name="barcode"
                    value="{{ old('barcode') }}"
                    placeholder="Código de barras (opcional)"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input
                    label="Precio"
                    type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    value="{{ old('price') }}"
                    placeholder="0.00"
                />

                <x-wire-native-select label="Categoría" name="category_id">
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>
            </div>

            <x-wire-textarea
                label="Descripción"
                name="description"
                value="{{ old('description') }}"
                placeholder="Descripción del producto"
            />

            <div class="flex justify-end pt-2">
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