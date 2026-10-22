
<!-- al breadcrum se asignoa [] para que no de error si no recibe valores -->
@props([
  'title' => config('app.name', 'Laravel'),
  'breadcrumb' => [] 
  
  ])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    {{-- sweetalert2 --}}
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- wireui -->
    <!-- cambio por IA: Removida la etiqueta CDN manual de AlpineJS porque Livewire 3 ya incluye AlpineJS integrado y la doble inicialización provocaba la falla de renderizado -->
    <wireui:scripts />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
    {{-- cambio por IA: Agregado el stack de CSS para que funcione Dropzone y otros estilos empujados desde las vistas --}}
    @stack('css')

    {{-- cambio por IA: Detección y aplicación inmediata de modo oscuro para evitar parpadeo blanco (FOUC) --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

{{-- cambio por IA: Soporte de modo oscuro y transición de color en el fondo y texto del body --}}
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">


    @include('layouts.includes.admin.navigation')

    @include('layouts.includes.admin.sidebar')

    <div class="p-4 sm:ml-64">
      <div class="mt-12 flex items-center">

        @include('layouts.includes.admin.breadcrumb')

          @isset($action)
             <div class="ml-auto">
                {{ $action }}
             </div>  
          @endisset
        
        </div>
        {{ $slot }}
    </div>

    @stack('modals')

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

    <script>
        // escuchar eventos de livewire
        Livewire.on('swal', (data) => {
          Swal.fire(data[0]); // se accede al indice 0 para mostrar la alerta
        });
    </script>
        

      @if (session('swal'))
          <script>
             Swal.fire(@json(session('swal')));
             
          </script>
      @endif 

      @stack('js')
</body>

</html>