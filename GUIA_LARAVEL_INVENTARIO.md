# 📚 Guía de Aprendizaje: Sistema de Inventario en Laravel

¡Bienvenido/a al desarrollo del **Sistema de Inventario**! Este documento sirve como mapa de ruta y guía conceptual para entender la estructura de Laravel y cómo construir cada parte del sistema paso a paso.

---

## 🏗️ 1. Estructura Principal del Proyecto Laravel

Laravel sigue el patrón de arquitectura **MVC (Modelo - Vista - Controlador)**. Aquí está la función de cada directorio clave en tu proyecto:

```text
inventatirio/
├── app/
│   ├── Http/
│   │   └── Controllers/    # 🎮 CONTROLADORES: Lógica de negocio y manejo de peticiones HTTP
│   ├── Models/             # 🗄️ MODELOS: Interacción con la base de datos (Eloquent ORM)
│   └── Livewire/           # ⚡ COMPONENTES LIVEWIRE: Componentes reactivos para la interfaz
├── bootstrap/
│   └── app.php             # ⚙️ CONFIGURACIÓN GLOBAL: Registro de rutas, middlewares y excepciones
├── database/
│   ├── migrations/         # 📐 MIGRACIONES: Estructura y esquemas de tablas SQL en código
│   ├── seeders/            # 🌱 SEEDERS: Datos iniciales de prueba para la base de datos
│   └── factories/          # 🏭 FACTORIES: Generación de datos masivos falsos (Faker)
├── resources/
│   ├── views/              # 🎨 VISTAS: Plantillas HTML/Blade y diseño visual
│   ├── css/                # 🎨 Estilos CSS (Tailwind CSS)
│   └── js/                 # ⚡ Scripts JavaScript
└── routes/
    ├── web.php             # 🛣️ RUTAS WEB: Rutas accesibles desde el navegador
    └── admin.php           # 🛡️ RUTAS ADMIN: Rutas protegidas para el panel de administración
```

---

## ⚡ 2. Comandos Clave en el Día a Día

| Comando | Descripción / Uso |
| :--- | :--- |
| `composer run dev` | Inicia **tanto el servidor PHP como Vite** en un solo comando para desarrollo local. |
| `php artisan make:model Categoria -m` | Crea el modelo `Categoria` y su migración (`-m`) automáticamente. |
| `php artisan make:controller CategoriaController` | Crea un nuevo controlador. |
| `php artisan make:livewire Admin/Categorias` | Crea un componente reactivo de Livewire con su clase y vista Blade. |
| `php artisan migrate` | Ejecuta las migraciones pendientes en la base de datos. |
| `php artisan migrate:fresh --seed` | Reinicia la base de datos desde cero y ejecuta los seeders de prueba. |

---

## 🛡️ 3. Estándares de Codificación y Seguridad

1. **Comentarios Informativos (PHPDoc):** Todo método explicará qué parámetros recibe, qué retorna y qué excepciones puede lanzar.
2. **Identificación de Código IA:** Cada bloque de código creado o editado por la IA incluirá el comentario `// cambio por IA` para que puedas identificar fácilmente las modificaciones.
3. **Seguridad Primero (OWASP):**
   - Uso obligatorio de **Eloquent ORM** o **PDO con sentencias preparadas** (sin consultas raw concatenadas) para prevenir *Inyección SQL*.
   - Validación estricta de datos de entrada en controladores/Livewire (prevención de *XSS*).
   - Secretos y claves siempre en el archivo `.env`.

---

## 📦 4. Dependencias Principales del Proyecto (composer.json)

| Dependencia | Función en el Proyecto |
| :--- | :--- |
| **`laravel/framework`** | El motor principal de Laravel (enrutador, Eloquent ORM, migrador, contenedor de servicios, etc.). |
| **`laravel/jetstream`** | Kit de inicio oficial para gestión completa de autenticación, perfiles de usuario, fotos, 2FA y sesiones. |
| **`livewire/livewire`** | Framework para crear interfaces dinámicas y reactivas en tiempo real escribiendo código PHP + Blade en lugar de JavaScript complejo. |
| **`wireui/wireui`** | Librería de componentes UI preconstruidos (botones, modales, selectores, notificaciones) diseñada para Livewire y Tailwind CSS. |
| **`laravel-lang/common`** | Proporciona las traducciones al español de los mensajes de validación, autenticación y errores de Laravel. |
| **`laravel/sanctum`** | Sistema ligero de autenticación para tokens de API y autenticación de aplicaciones móviles o SPAs. |
| **`laravel/tinker`** | Consola interactiva REPL para probar comandos PHP y consultas Eloquent directamente desde la terminal (`php artisan tinker`). |

---

## 📋 5. Plan Sugerido de Aprendizaje y Desarrollo

- [ ] **Fase 1: Base de Datos y Modelos**
  - Crear modelo y migración de `Category` (Categorías).
  - Crear modelo y migración de `Product` (Productos).
  - Definir relaciones Eloquent (`Category` tiene muchos `Products`).
- [ ] **Fase 2: Panel de Administración y Rutas**
  - Estructurar el Layout principal en `routes/admin.php`.
- [ ] **Fase 3: CRUD de Categorías y Productos (Livewire 3)**
  - Formulario de creación, listado con búsqueda y paginación, edición y eliminación.
- [ ] **Fase 4: Movimientos de Inventario (Entradas / Salidas)**
  - Registro de stock y trazabilidad de productos.

---
*Este documento se irá actualizando a medida que avancemos en el desarrollo del proyecto.*

