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
    ],

]"> 

    @push ('css')

    <style>
        table th span, table td {
           font-size: .75rem !important;
        }
    </style>
    @endpush
  <x-slot name="action">
    <x-wire-button href="{{ route('admin.products.create') }}" color="blue">
      <i class="fas fa-plus"></i>
      Nuevo Producto
    </x-wire-button>

  </x-slot>
  {{-- cambio por IA: Inclusión del componente de tabla Livewire para mostrar las categorías/artículos --}}
 {{-- @livewire('admin.datables.category-table') --}}
 @livewire('admin.datatables.product-table')

 @push('js')

 <script>
    
    forms = document.querySelectorAll('.delete-form');

    forms.forEach(form =>{
        
        form.addEventListener('submit', function(e){

        e.preventDefault();
        Swal.fire({
            title: "¿Seguro?",
          text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
          confirmButtonText: "Si!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
          };
        });
          
        });
    });

 </script>

 @endpush 

</x-admin-layout>