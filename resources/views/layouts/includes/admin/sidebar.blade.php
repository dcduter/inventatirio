{{-- Cambio por IA: Corrección de comentarios para evitar errores de compilación con la directiva foreach --}}
@php
    // Inicia el bloque PHP nativo dentro de la plantilla Blade

    /* LINKS DE LA SIDEBAR DINAMICOS */
    // Define el arreglo asociativo con la estructura de navegación del menú lateral
    $links = [
        
        [
            'header' => 'Principal',
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
            "active" => request()->routeIs('admin.dashboard')
        ],

           [
            'header' => 'Administrar Páginas'
          
        ],

        [
            'name' => "Inventario",
               'icon' => 'fa-solid fa-boxes-stacked',
            'href' => route('admin.dashboard'),
            'active' => false,
            'submenu' => [

                 [
        
                'name' => 'Categorias',
                'icon' => 'fa-solid fa-list',
                'href' => route('admin.categories.index'),
                'active' => request()->routeIs('admin.categories.*')
                
                ],

                [
                'name' => 'Productos',
                'icon' => 'fa-solid fa-box',
                'href' => route('admin.products.index'),
                'active' => request()->routeIs('admin.products.*')
                
                ],

                [
                    "name" => 'Almacenes',
                    "icon" => 'fa-solid fa-warehouse',
                    "href" => route('admin.warehouses.index'),
                    "active" => request()->routeIs('admin.warehouses.*')
                ]

            ]
            
        ],

        [
            'name' => 'Compras', /* minuto 3 */
            'icon' => 'fa-solid fa-cart-shopping',
            'active' => request()->routeIs([
                'admin.suppliers.*',
                'admin.purchase-orders.*',
            ]),
            'submenu' => [

                [

                    "name" => "Proveedores",
                   // "icon" => "fa-solid fa-truck",
                    "href" => route("admin.suppliers.index"),
                    "active" => request()->routeIs("admin.suppliers.*")

                ],
                
                [

                    "name" => "Ordenes de Compra",
                   // "icon" => "fa-solid fa-truck",
                    "href" => route('admin.purchase-orders.index'),
                    "active" => request()->routeIs("admin.purchase-orders.*"), // virifica si la ruta actual es igual a la ruta del enlace

                ],
                [

                    "name" => "Compras",
                  //  "icon" => "fa-solid fa-truck",
                    "href" => '',
                    "active" => false,

                ],


            ]
        ],


        [
            'name' => 'Ventas',
            'icon' => 'fa-solid fa-cash-register',
            'active' => false,
            'submenu' => [
                [
                    'name' => 'Clientes',
                    'href' => route('admin.customers.index'),
                    'active' => request()->routeIs('admin.customers.*')
                    
                ],

                [
                    'name' => 'Cotizaciones',
                    'href' => '',
                    'active' => false
                ],
                
                [
                    'name' => 'Ventas',
                    'href' => '',
                    'active' => false
                ],
                
             /*    [
                    'name' => 'Facturas',
                    'href' => '',
                    'active' => false
                ] */
                
                

            ]
            
        ],

        [
            'name' => 'Movimientos',
            'icon' => 'fa-solid fa-arrows-rotate',
            'active' => false,
            'submenu' => [
                
             /*    [
                    'name' => 'Ajustes',
                    'href' => '',
                    'active' => false
                ], */
                
                [
                    'name' => 'Entradas y Salidas',
                    'href' => '',
                    'active' => false
                ],
                
                [
                    'name' => 'Transferencias',
                    'href' => '',
                    'active' => false
                ]

            ]
        ],
        
        [
            'name' => 'Reportes',
            'icon' => 'fa-solid fa-chart-pie',
            'active' => false,
            'href' => '',
          
        ],

        [
            'header' => 'Configuración'
        ],

        [
            'name' => 'Usuarios',
            'icon' => 'fa-solid fa-user',
            'active' => false,
            'href' => ''
        ],

        [
            'name' => 'Roles',
            'icon' => 'fa-solid fa-shield-halved',
            'active' => false,
            'href' => ''
        ],

        [
            'name' => 'Permisos',
            'icon' => 'fa-solid fa-lock',
            'active' => false,
            'href' => ''
        ],
        [
            'name' => 'Ajustes',
            'icon' => 'fa-solid fa-gear',
            'active' => false,
            'href' => ''
        ],



     
     


        // Elemento del menú: Dashboard
    /*     [
            // Nombre visible que se mostrará en la opción del menú
            "name" => "juan",
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
        ] */


    ];
    // Finaliza el bloque PHP nativo
@endphp

{{-- Etiqueta semántica HTML aside (posicionamiento fijo, responsive, transición y accesibilidad aria-label) --}}
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    {{-- Contenedor interno con scroll vertical automático y estilos de fondo/borde --}}
    {{-- cambio por IA: Contenedor interno con soporte completo para modo oscuro en fondo y bordes --}}
    <div class="h-full px-3 py-4 overflow-y-auto bg-white border-e border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        {{-- Enlace del logotipo principal que redirige a la página de inicio o marca --}}
        <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
            {{-- Imagen del logotipo con altura fija y margen a la derecha --}}
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3" alt="Flowbite Logo" />
            {{-- Texto de la marca con tipografía semi-negrita y soporte de modo oscuro --}}
            <span class="self-center text-lg text-gray-900 dark:text-white font-semibold whitespace-nowrap">Flowbite</span>
        </a>
        {{-- Lista desordenada para agrupar los elementos de menú con espaciado vertical --}}
        <ul class="space-y-2 font-medium">
            {{-- Recorre el arreglo de enlaces dinámicos $links --}}
            @foreach ($links as $link)
                <li>
                    {{-- Evalúa si el elemento actual es un encabezado de sección --}}
                    @isset($link['header'])
                        {{-- Renderiza el título o sección del menú --}}
                        <div class="px-2 pt-3 pb-1 text-xs font-semibold text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                            {{ $link['header'] }}
                        </div>
                    @else


                        {{-- cambio por IA: Documentación y clases de modo oscuro para el menú desplegable y enlaces --}}
                        {{-- 1. Verifica si el elemento actual tiene definido un arreglo de submenús --}}
                        @isset($link['submenu'])
                            {{-- 2. Botón principal que activa el colapso/despliegue del submenú --}}
                            <button type="button"
                                class="flex items-center w-full justify-between px-2 py-1.5 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group"
                                {{-- Vincula mediante accesibilidad y Flowbite JS el botón con el ID único del dropdown --}}
                                aria-controls="dropdown-{{ $loop->index }}" data-collapse-toggle="dropdown-{{ $loop->index }}">
                                {{-- Contenedor del ícono del enlace padre --}}
                                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500 dark:text-gray-400">
                                    {{-- Ícono representativo de la opción --}}
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                {{-- Nombre o etiqueta del menú principal --}}
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $link['name'] }}</span>
                                {{-- Flecha indicadora de menú desplegable --}}
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                            {{-- Contenedor de la lista desplegable (oculto por defecto con la clase 'hidden') --}}
                            <ul id="dropdown-{{ $loop->index }}" class="hidden py-2 space-y-2">
                                {{-- Itera sobre cada opción secundaria dentro del submenú --}}
                                @foreach ($link['submenu'] as $item)
                                    {{-- Elemento de lista para cada opción secundaria --}}
                                    <li>
                                        {{-- Enlace secundario; añade 'bg-gray-100' si es la ruta activa actual --}}
                                        <a href="{{ $item['href'] }}"
                                            class="pl-11 flex items-center px-2 py-1.5 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $item['active'] ? 'bg-gray-100 dark:bg-gray-700 font-semibold text-blue-600 dark:text-blue-400' : '' }}">
                                            {{-- Texto del enlace secundario --}}
                                            {{ $item['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        {{-- 3. Si no existe un submenú, renderiza un enlace simple directo --}}
                        @else
                            {{-- Enlace simple directo; añade fondo gris si la ruta está activa --}}
                            <a href="{{ $link['href'] }}"
                                class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700 font-semibold text-blue-600 dark:text-blue-400' : '' }}">
                                {{-- Contenedor del ícono dinámico --}}
                                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500 dark:text-gray-400">
                                    {{-- Clase de ícono asignada --}}
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                {{-- Nombre de la ruta/opción --}}
                                <span class="ms-3 text-gray-700 dark:text-gray-300">{{ $link['name'] }}</span>
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