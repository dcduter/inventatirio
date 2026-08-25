# 🎨 Guía de Desarrollo Frontend: Sistema de Inventario

Esta guía está diseñada como referencia práctica y conceptual para construir la interfaz de usuario (UI/UX) del **Sistema de Inventario**, utilizando **Laravel Blade, Tailwind CSS, Livewire 3, Alpine.js y WireUI**.

---

## 🛠️ 1. Stack Tecnológico del Frontend

La arquitectura del frontend en este proyecto utiliza el enfoque **TALL Stack** (Tailwind, Alpine.js, Laravel Blade, Livewire) complementado con **WireUI**:

```text
               +-------------------------------------------------+
               |                   Vistas Blade                  |
               |       (HTML + Sintaxis de Plantilla Laravel)    |
               +-----------------------+-------------------------+
                                       |
       +-------------------------------+-------------------------------+
       |                               |                               |
+------v-------+               +-------v------+                +-------v------+
| Tailwind CSS |               |  Livewire 3  |                |    WireUI    |
| (Estilos utilitarios)        | (Componentes reactivos PHP)   | (Componentes UI prehechos)
+--------------+               +-------+------+                +--------------+
                                       |
                               +-------v------+
                               |  Alpine.js   |
                               | (Reactividad frontend ligera) |
                               +--------------+
```

---

## 🏛️ 2. Jerarquía de Layouts y Componentes Blade

En Laravel, los **Layouts** actúan como cascarones o plantillas maestras donde se inyecta el contenido dinámico de cada vista.

### A. Estructura del Layout Principal (`<x-admin-layout>`)

```blade
<x-admin-layout 
    title="Título de la Página | DevStore"
    :breadcrumb="[
        ['name' => 'Inicio', 'href' => route('admin.dashboard')],
        ['name' => 'Productos']
    ]">

    {{-- El contenido escrito aquí se inyecta en la variable {{ $slot }} --}}
    <div class="p-6 bg-white rounded-lg shadow-sm">
        <h1 class="text-xl font-bold">Gestión de Productos</h1>
    </div>

</x-admin-layout>
```

### B. ¿Cómo funcionan las etiquetas especiales de Blade?

1. **`$slot`**: Es la variable donde se renderiza todo el contenido dinámico dentro del componente.
2. **`@props([...])`**: Declara las propiedades o variables esperadas por el componente con sus valores por defecto.
3. **`:variable="..."` (Atributo Reactivo)**: Al anteponer dos puntos `:`, Blade ejecuta el valor como código PHP (ej. arreglos o variables). Sin los dos puntos, se pasa como texto plano.
4. **`@include('ruta.vista')`**: Incluye parciales de vista (como el sidebar, la navegación o el breadcrumb).

---

## ⚡ 3. Reactividad con Livewire 3

Livewire te permite crear interfaces reactivas en tiempo real sin escribir APIs REST ni código JavaScript complejo.

### Directivas Clave de Livewire:

| Directiva | Descripción | Ejemplo de Uso |
| :--- | :--- | :--- |
| `wire:model` | Enlaza un input del HTML con una propiedad pública en la clase PHP. | `<input wire:model="search" />` |
| `wire:model.live` | Actualiza la propiedad e inicia la re-renderización de inmediato al escribir. | `<input wire:model.live="search" />` |
| `wire:click` | Ejecuta un método de la clase PHP al hacer clic. | `<button wire:click="save">Guardar</button>` |
| `wire:submit` | Previene la recarga del formulario y ejecuta el método indicado. | `<form wire:submit="createProduct">` |
| `wire:loading` | Muestra u oculta elementos visuales durante las peticiones en segundo plano. | `<div wire:loading>Cargando...</div>` |

---

## 🧩 4. Componentes UI con WireUI (Prefijo `wire-`)

En tu proyecto, **WireUI** está configurado con el prefijo `'prefix' => 'wire-'` en `config/wireui.php`. Esto evita conflictos con otros componentes de Blade.

### A. Botones (`<x-wire-button>`)

```blade
{{-- Botón Principal --}}
<x-wire-button primary label="Guardar Producto" icon="plus" wire:click="save" />

{{-- Botón Secundario / Cancelar --}}
<x-wire-button secondary label="Cancelar" href="{{ route('admin.dashboard') }}" />

{{-- Botón de Peligro / Eliminar --}}
<x-wire-button red label="Eliminar" icon="trash" wire:click="delete" />
```

### B. Formulario e Inputs (`<x-wire-input>`, `<x-wire-select>`)

```blade
{{-- Input de texto con etiqueta y placeholder --}}
<x-wire-input label="Nombre del Producto" placeholder="Ej. Laptop HP" wire:model="name" />

{{-- Input numérico para precio --}}
<x-wire-input label="Precio" prefix="$" placeholder="0.00" wire:model="price" />

{{-- Selector / Dropdown --}}
<x-wire-select 
    label="Categoría" 
    placeholder="Seleccione una categoría" 
    :options="$categories" 
    option-label="name" 
    option-value="id" 
    wire:model="category_id" 
/>
```

### C. Tarjetas y Modales (`<x-wire-card>`, `<x-wire-modal>`)

```blade
{{-- Tarjeta contenedora --}}
<x-wire-card title="Lista de Inventario">
    <p class="text-sm text-gray-600">Aquí se muestran los productos registrados.</p>
</x-wire-card>
```

---

## 🎯 5. Reglas de Estilo y Buenas Prácticas UI

1. **Diseño Responsivo con Tailwind CSS**:
   - Diseñar pensando primero en móviles (*Mobile First*) y ajustar para pantallas grandes usando los prefijos `sm:`, `md:`, `lg:`, `xl:`.
2. **Comentarios de Identificación de IA**:
   - Todo código escrito o editado por la IA incluirá el comentario `{{-- cambio por IA --}}` o `<!-- cambio por IA -->`.
3. **Feedback y Notificaciones**:
   - Usar estados de carga (`wire:loading`) en botones de guardado para evitar múltiples clics accidentales.
   - Mostrar notificaciones y alertas claras al usuario tras crear, actualizar o eliminar registros.
