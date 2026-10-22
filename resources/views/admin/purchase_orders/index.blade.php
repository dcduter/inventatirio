{{-- cambio por IA: Explicación y documentación detallada de cómo funciona este código --}}

{{-- 
    1. Uso del componente Blade (<x-admin-layout>):
       Llama al diseño base de la sección administrativa (layouts/admin.blade.php).

    2. Paso de variables mediante atributo reactivo (:breadcrumb="..."):
       El prefijo con dos puntos ':' es clave en Blade. Le indica al compilador que ejecute 
       el contenido como código PHP (un arreglo en este caso) en lugar de una simple cadena de texto.
--}}
<x-admin-layout 
title="Ordenes de Compra  | DevStore"
:breadcrumb="[ 
    
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ordener de Compra',
        
    ],


]"> 
   <x-slot name="action">
    <x-wire-button href="{{ route('admin.purchase-orders.create') }}" color="blue">
      <i class="fas fa-plus"></i>
      Nueva Orden de Compra
    </x-wire-button>

  </x-slot>

  {{-- componente Livewire para manejar la tabla de ordenes de compra --}}
  @livewire('admin.datatables.purchase-order-table')
    {{-- 
        Todo lo que se coloque aquí adentro representa el contenido dinámico de la página, 
        el cual Blade inyecta automáticamente en la variable {{ $slot }} dentro de admin.blade.php
    --}}


</x-admin-layout>