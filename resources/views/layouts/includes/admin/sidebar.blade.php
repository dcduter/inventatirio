{{-- Cambio por IA: Corrección de comentarios para evitar errores de compilación con la directiva foreach --}}
@php
    // Inicia el bloque PHP nativo dentro de la plantilla Blade

    /* LINKS DE LA SIDEBAR DINAMICOS */
    // Define el arreglo asociativo con la estructura de navegación del menú lateral
    $links = [

        // Elemento del menú: Dashboard
        [
            // Nombre visible que se mostrará en la opción del menú
            "name" => "Dashboard",
            // Genera la URL dinámica a partir del nombre de la ruta registrada en Laravel
            "href" => route('admin.dashboard'),
            // Clases CSS de FontAwesome para el ícono representativo
            "icon" => "fa-solid fa-gauge",
            // Evalúa si la ruta actual coincide con 'admin.dashboard' para determinar el estado activo
            "active" => request()->routeIs('admin.dashboard')
        ],

        [
            'header' => 'Administrar Páginas'
        ],
        // Elemento del menú: Dashboard
        [
            // Nombre visible que se mostrará en la opción del menú
            "name" => "Dashboard",
            // Genera la URL dinámica a partir del nombre de la ruta registrada en Laravel
            "href" => route('admin.dashboard'),
            // Clases CSS de FontAwesome para el ícono representativo
            "icon" => "fa-solid fa-gauge",
            // Evalúa si la ruta actual coincide con 'admin.dashboard' para determinar el estado activo
            "active" => false,
            "submenu" => [
                [
                    "name" => "Productos",
                    "href" => route('admin.dashboard'),
                    // "icon" => "fa-solid fa-box",
                    "active" => false
                ],
                [
                    "name" => "Categorias",
                    "href" => route('admin.dashboard'),
                    // "icon" => "fa-solid fa-list",
                    "active" => false
                ],
                [
                    "name" => "Proveedores",
                    "href" => route('admin.dashboard'),
                    // "icon" => "fa-solid fa-user",
                    "active" => false
                ]

            ]
        ]


    ];
    // Finaliza el bloque PHP nativo
@endphp

{{-- Etiqueta semántica HTML aside (posicionamiento fijo, responsive, transición y accesibilidad aria-label) --}}
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    {{-- Contenedor interno con scroll vertical automático y estilos de fondo/borde --}}
    <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
        {{-- Enlace del logotipo principal que redirige a la página de inicio o marca --}}
        <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
            {{-- Imagen del logotipo con altura fija y margen a la derecha --}}
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3" alt="Flowbite Logo" />
            {{-- Texto de la marca con tipografía semi-negrita y prevención de salto de línea --}}
            <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Flowbite</span>
        </a>
        {{-- Lista desordenada para agrupar los elementos de menú con espaciado vertical --}}
        <ul class="space-y-2 font-medium">
            {{-- Recorre el arreglo de enlaces dinámicos $links --}}
            @foreach ($links as $link)
                <li>
                    {{-- Evalúa si el elemento actual es un encabezado de sección --}}
                    @isset($link['header'])
                        {{-- Renderiza el título o sección del menú --}}
                        <div class="px-2 pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            {{ $link['header'] }}
                        </div>
                    @else


                        @isset($link['submenu'])
                            {{-- Cambio por IA: Menú desplegable dinámico vinculado al arreglo $link['submenu'] --}}
                            <button type="button"
                                class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group"
                                aria-controls="dropdown-{{ $loop->index }}" data-collapse-toggle="dropdown-{{ $loop->index }}">
                                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap text-gray-500">{{ $link['name'] }}</span>
                                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                            <ul id="dropdown-{{ $loop->index }}" class="hidden py-2 space-y-2">
                                @foreach ($link['submenu'] as $item)
                                    <li>
                                        <a href="{{ $item['href'] }}"
                                            class="pl-11 flex items-center px-2 py-1.5 text-sm text-gray-500 rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $item['active'] ? 'bg-gray-100' : '' }}">
                                            {{ $item['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ $link['href'] }}"
                                class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $link['active'] ? 'bg-gray-100' : '' }}">
                                {{-- Contenedor span centrado para alinear el ícono dinámico --}}
                                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
                                    {{-- Etiqueta i que renderiza la clase del ícono FontAwesome suministrada --}}
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                {{-- Span que muestra el nombre de la ruta/opción con margen a la izquierda --}}
                                <span class="ms-3 text-gray-500">{{ $link['name'] }}</span>
                            </a>
                        @endisset

                        {{-- Elemento de lista para la opción interactiva del menú --}}

                    @endisset
                </li>
                {{-- Finaliza el bucle de iteración del menú --}}
            @endforeach

            <li>

            </li>

        </ul>
    </div>
</aside>