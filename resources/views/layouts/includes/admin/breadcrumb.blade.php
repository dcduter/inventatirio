{{-- cambio por IA: Archivo de migas de pan (breadcrumb) totalmente comentado y documentado --}}

{{-- 1. Normalización de variable: Acepta tanto $breadcrumbs (plural) como $breadcrumb (singular prop de Blade) --}}
@php
    $breadcrumbs = $breadcrumbs ?? $breadcrumb ?? [];
@endphp

{{-- 2. Verificación inicial: Solo renderiza la estructura si el arreglo de breadcrumbs contiene elementos --}}
@if (count($breadcrumbs) > 0)

    {{-- 3. Etiqueta semántica de navegación con margen inferior mb-4 --}}
    <nav class="mb-4">

        {{-- 4. Lista ordenada alineada de forma horizontal mediante flexbox --}}
        <ol class="flex flex-wrap">
            
            {{-- 5. Bucle de Blade para iterar sobre cada ítem de las migas de pan --}}
            @foreach ($breadcrumbs as $item)

                {{-- 6. Ítem de lista con clases CSS de Tailwind:
                     - text-sm: Tamaño de letra pequeño
                     - leading-normal: Altura de línea estándar
                     - text-slate-700: Color de texto gris oscuro (slate-700)
                     - Condición Blade: Si NO es el primer ítem (! $loop->first), agrega padding a la izquierda (pl-2) 
                       y añade la barra diagonal '/' como separador mediante el pseudoelemento CSS ::before
                --}}
                <li class="text-sm leading-normal text-slate-700 {{ !$loop->first ? "pl-2 before:float-left before:pr-2 before:content-['/']" : '' }}">

                    {{-- 7. Validación: Si el ítem actual contiene la clave 'href', genera un enlace interactivo <a> --}}
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="opacity-50">
                            {{ $item['name'] }}
                        </a>
                    @else
                        {{-- 8. Si no tiene 'href', solo muestra el nombre del elemento plano --}}
                        {{ $item['name'] }}
                    @endisset

                </li>

            @endforeach
        </ol>

        {{-- 9. Título de página: Si hay más de un nivel en las migas de pan, muestra el nombre de la ruta actual --}}
        @if (count($breadcrumbs) > 1)
            {{-- 10. Helper last(): Obtiene el último elemento del arreglo de forma segura --}}
            <h6 class="font-bold">
                {{ last($breadcrumbs)['name'] }}
            </h6>
        @endif

    </nav>

@endif
