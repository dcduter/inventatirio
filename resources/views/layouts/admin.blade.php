
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
</head>

<body class="font-sans antialiased bg-gray-50">


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

      @if (session('swal'))
          <script>
             Swal.fire(@json(session('swal')));
             
          </script>
      @endif 

      @stack('js')
</body>

</html>