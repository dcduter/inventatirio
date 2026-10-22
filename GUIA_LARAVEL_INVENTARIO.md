# 📚 Guía de Arquitectura y Desarrollo: Sistema de Inventario (DevStore)

¡Bienvenido/a al registro de arquitectura del **Sistema de Gestión de Inventario**! Este documento detalla la estructura completa del proyecto, cómo interactúan sus capas (MVC, Livewire, Eloquent, Base de Datos), los 5 CRUDs base completados y la hoja de ruta para los módulos de compras, ventas y movimientos de stock.

---

## 🗺️ 1. Mapa de Arquitectura General del Sistema

El proyecto sigue una arquitectura **MVC desacoplada** combinada con componentes reactivos **Livewire 3** para las tablas de datos, **WireUI** para componentes de interfaz, y **Dropzone + Axios** para la gestión multimedia asíncrona:

```mermaid
flowchart TD
    subgraph Cliente["🖥️ Capa de Presentación (Frontend / Navegador)"]
        UI["Blade Layout (x-admin-layout)"]
        Sidebar["Sidebar de Navegación (/admin)"]
        WireUI["WireUI (Inputs, Cards, Selects, Buttons)"]
        LW_Tables["Rappasoft Livewire Tables (Búsqueda, Ordenamiento, Paginación Reactiva)"]
        Dropzone["Dropzone JS (Subida Asíncrona de Fotos)"]
        Swal["SweetAlert2 (Notificaciones Flash y Modales de Confirmación)"]
    end

    subgraph Enrutamiento["🛣️ Capa de Enrutamiento (routes/admin.php)"]
        R_Cat["Resource: /admin/categories"]
        R_Prod["Resource: /admin/products"]
        R_Drop["POST: /admin/products/{product}/dropzone"]
        R_Cust["Resource: /admin/customers"]
        R_Supp["Resource: /admin/suppliers"]
        R_Ware["Resource: /admin/warehouses"]
        R_Img["DELETE: /admin/images/{image}"]
    end

    subgraph Controladores["🎮 Capa de Controladores (app/Http/Controllers/Admin/)"]
        C_Cat["CategoryController"]
        C_Prod["ProductController"]
        C_Cust["CustomerController"]
        C_Supp["SupplierController"]
        C_Ware["WarehouseController"]
        C_Img["ImageController"]
    end

    subgraph Modelos["🗄️ Capa de Dominio y Datos (app/Models/ - Eloquent ORM)"]
        M_Cat[("Category")]
        M_Prod[("Product")]
        M_Cust[("Customer")]
        M_Supp[("Supplier")]
        M_Ware[("Warehouse")]
        M_Ident[("Identity")]
        M_Img[("Image (Polimórfico)")]
        M_Pable[("Productable (Pivote Polimórfico)")]
        M_Inv[("Inventory (Kardex)")]
    end

    subgraph Almacenamiento["💾 Base de Datos y Disco Físico"]
        MySQL[("MySQL Database (inventario)")]
        Disk[("Disco Público: storage/app/public/images")]
    end

    UI --> Sidebar
    UI --> WireUI
    UI --> LW_Tables
    UI --> Dropzone
    UI --> Swal

    Sidebar --> Enrutamiento
    Enrutamiento --> Controladores
    LW_Tables -.-> Controladores
    Dropzone --> R_Drop --> C_Prod
    Swal -.-> UI

    C_Cat <--> M_Cat
    C_Prod <--> M_Prod
    C_Cust <--> M_Cust
    C_Supp <--> M_Supp
    C_Ware <--> M_Ware
    C_Img <--> M_Img

    M_Cat <--> MySQL
    M_Prod <--> MySQL
    M_Cust <--> MySQL
    M_Supp <--> MySQL
    M_Ware <--> MySQL
    M_Ident <--> MySQL
    M_Img <--> MySQL
    M_Img -.-> Disk
    M_Pable <--> MySQL
    M_Inv <--> MySQL
```

---

## 📊 2. Modelo de Base de Datos (Diagrama ERD)

El diseño de la base de datos centraliza la trazabilidad comercial y el control de inventario mediante relaciones 1:N y tablas pivote polimórficas.

### A. Diagrama Visual Oficial
![Diagrama de Base de Datos](<Captura de pantalla 2026-09-26 031124.png>)

### B. Mapa Relacional en Código (Mermaid ERD)

```mermaid
erDiagram
    IDENTITIES ||--o{ CUSTOMERS : "identifica a"
    IDENTITIES ||--o{ SUPPLIERS : "identifica a"
    CATEGORIES ||--o{ PRODUCTS : "clasifica a"
    PRODUCTS ||--o{ IMAGES : "tiene fotos (polimórfica)"
    PRODUCTS ||--o{ INVENTORIES : "kardex por producto"
    WAREHOUSES ||--o{ INVENTORIES : "stock por almacén"
    
    SUPPLIERS ||--o{ PURCHASE_ORDERS : "emite a"
    SUPPLIERS ||--o{ PURCHASES : "abastece"
    PURCHASE_ORDERS ||--o| PURCHASES : "origina"
    
    CUSTOMERS ||--o{ QUOTES : "solicita"
    CUSTOMERS ||--o{ SALES : "compra en"
    QUOTES ||--o| SALES : "se convierte en"
    
    WAREHOUSES ||--o{ PURCHASES : "recibe stock en"
    WAREHOUSES ||--o{ SALES : "despacha stock desde"
    WAREHOUSES ||--o{ MOVEMENTS : "registra movimientos en"
    REASONS ||--o{ MOVEMENTS : "motivo de movimiento"
    
    WAREHOUSES ||--o{ TRANSFERS : "almacén origen"
    WAREHOUSES ||--o{ TRANSFERS : "almacén destino"

    PRODUCTS ||--o{ PRODUCTABLES : "detalle de ítems"
    PURCHASE_ORDERS ||--o{ PRODUCTABLES : "ítems de orden"
    PURCHASES ||--o{ PRODUCTABLES : "ítems de compra"
    QUOTES ||--o{ PRODUCTABLES : "ítems de cotización"
    SALES ||--o{ PRODUCTABLES : "ítems de venta"

    IDENTITIES {
        int id PK
        string name
    }

    CUSTOMERS {
        int id PK
        int identity_id FK
        string document_number UK
        string name
        string address
        string email UK
        string phone
    }

    SUPPLIERS {
        int id PK
        int identity_id FK
        string document_number UK
        string name
        string address
        string email UK
        string phone
    }

    CATEGORIES {
        int id PK
        string name UK
        string description
    }

    PRODUCTS {
        int id PK
        int category_id FK
        string name UK
        text description
        string sku UK
        string barcode UK
        decimal price
    }

    WAREHOUSES {
        int id PK
        string name
        string location
    }

    IMAGES {
        int id PK
        string path
        int size
        int imageable_id
        string imageable_type
    }

    INVENTORIES {
        int id PK
        int product_id FK
        int warehouse_id FK
        string detail
        decimal quantity_in
        decimal cost_in
        decimal total_in
        decimal quantity_out
        decimal cost_out
        decimal total_out
        decimal quantity_balance
        decimal cost_balance
        decimal total_balance
    }

    PRODUCTABLES {
        int id PK
        int product_id FK
        int productable_id
        string productable_type
        decimal quantity
        decimal price
        decimal subtotal
    }
```

---

## 🗃️ 3. Resumen de Modelos y Relaciones Eloquent

A continuación se muestra el mapa de los modelos implementados en [app/Models/](file:///c:/wamp64/www/laravel/inventatirio/app/Models):

| Modelo | Tabla | Relaciones Definidas | Propósito en el Sistema |
| :--- | :--- | :--- | :--- |
| [`Identity`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Identity.php) | `identities` | `hasMany(Customer)`, `hasMany(Supplier)` | Tipos de documento oficiales (DNI, Pasaporte, RUC, etc.). |
| [`Category`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Category.php) | `categories` | `hasMany(Product)` | Clasificación lógica de productos en el catálogo. |
| [`Product`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Product.php) | `products` | `belongsTo(Category)`, `morphMany(Image)`, `hasMany(Inventory)`, `hasMany(Productable)`, `morphedByMany(PurchaseOrder)`, `morphedByMany(Quote)` | Ítem comercial con control de precio, SKU, barcode e imágenes. |
| [`Customer`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Customer.php) | `customers` | `belongsTo(Identity)`, `hasMany(Quote)`, `hasMany(Sale)` | Clientes destinatarios de cotizaciones y ventas. |
| [`Supplier`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Supplier.php) | `suppliers` | `belongsTo(Identity)`, `hasMany(PurchaseOrder)`, `hasMany(Purchase)` | Proveedores emisores de órdenes de compra y compras. |
| [`Warehouse`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Warehouse.php) | `warehouses` | `hasMany(Inventory)` | Almacenes físicos donde se custodia y distribuye la mercancía. |
| [`Image`](file:///c:/wamp64/www/laravel/inventatirio/app/Models/Image.php) | `images` | `morphTo(imageable)` | Fotos subidas al disco `public` vinculadas polimórficamente a productos. |

---

## 📦 4. Detalle de los 5 Módulos CRUD Completados

Todos los módulos se gestionan desde el panel administrativo con la convención RESTful estándar de Laravel en [routes/admin.php](file:///c:/wamp64/www/laravel/inventatirio/routes/admin.php):

| Módulo | Controlador | Datatable Livewire | Vistas Blade | Reglas de Protección al Eliminar (`destroy`) |
| :--- | :--- | :--- | :--- | :--- |
| **Categorías** | [`CategoryController`](file:///c:/wamp64/www/laravel/inventatirio/app/Http/Controllers/Admin/CategoryController.php) | [`CategoryTable`](file:///c:/wamp64/www/laravel/inventatirio/app/Livewire/Admin/Datatables/CategoryTable.php) | [`resources/views/admin/categories/`](file:///c:/wamp64/www/laravel/inventatirio/resources/views/admin/categories) | Bloquea el borrado si la categoría tiene productos asociados (`$category->products()->exists()`). |
| **Productos** | [`ProductController`](file:///c:/wamp64/www/laravel/inventatirio/app/Http/Controllers/Admin/ProductController.php) | [`ProductTable`](file:///c:/wamp64/www/laravel/inventatirio/app/Livewire/Admin/Datatables/ProductTable.php) | [`resources/views/admin/products/`](file:///c:/wamp64/www/laravel/inventatirio/resources/views/admin/products) | Bloquea si tiene movimientos en inventario (`inventories`) o transacciones (`productables`). Elimina fotos en disco al borrar. |
| **Clientes** | [`CustomerController`](file:///c:/wamp64/www/laravel/inventatirio/app/Http/Controllers/Admin/CustomerController.php) | [`CustomerTable`](file:///c:/wamp64/www/laravel/inventatirio/app/Livewire/Admin/Datatables/CustomerTable.php) | [`resources/views/admin/customers/`](file:///c:/wamp64/www/laravel/inventatirio/resources/views/admin/customers) | Bloquea si el cliente tiene cotizaciones (`quotes`) o ventas (`sales`) registradas. |
| **Proveedores** | [`SupplierController`](file:///c:/wamp64/www/laravel/inventatirio/app/Http/Controllers/Admin/SupplierController.php) | [`SupplierTable`](file:///c:/wamp64/www/laravel/inventatirio/app/Livewire/Admin/Datatables/SupplierTable.php) | [`resources/views/admin/suppliers/`](file:///c:/wamp64/www/laravel/inventatirio/resources/views/admin/suppliers) | Bloquea si el proveedor tiene órdenes de compra (`purchaseOrders`) o compras (`purchases`) activas. |
| **Almacenes** | [`WarehouseController`](file:///c:/wamp64/www/laravel/inventatirio/app/Http/Controllers/Admin/WarehouseController.php) | [`WarehouseTable`](file:///c:/wamp64/www/laravel/inventatirio/app/Livewire/Admin/Datatables/WarehouseTable.php) | [`resources/views/admin/warehouses/`](file:///c:/wamp64/www/laravel/inventatirio/resources/views/admin/warehouses) | Bloquea si el almacén tiene registros de stock en kardex (`inventories()->exists()`). |

---

## 🛡️ 5. Patrones de Seguridad y Buenas Prácticas Aplicadas

1. **Prevención de Inyección SQL (OWASP A03:2021):**
   - Uso 100% estricto de **Eloquent ORM** y **Prepared Statements**.
   - No existen consultas concatenadas con cadenas sin escapar.

2. **Validación de Unicidad con Exclusión de ID Actual:**
   - En las operaciones `update`, se utiliza `Rule::unique()->ignore($model->id)` para evitar falsos positivos cuando el usuario conserva su mismo código, correo o documento:
   ```php
   'document_number' => [
       'required',
       'string',
       'max:10',
       Rule::unique('customers', 'document_number')->ignore($customer->id),
   ],
   ```

3. **Protección de Asignación Masiva (*Mass Assignment*):**
   - Cada modelo define rigurosamente su propiedad `$fillable` para evitar que campos no autorizados (como permisos o IDs de auditoría) sean inyectados vía formulario HTTP.

4. **Integridad Referencial en Aplicación y Base de Datos:**
   - Antes de ejecutar `$model->delete()`, los controladores verifican relaciones existentes para no violar las claves foráneas de MySQL ni dejar registros huérfanos.

5. **Manejo de Almacenamiento Seguro para Imágenes:**
   - Las imágenes subidas por Dropzone se almacenan en `storage/app/public/images` mediante `store('images', 'public')` y se acceden con enlaces simbólicos generados por `php artisan storage:link`.
   - Al borrar fotos, se libera el espacio en disco llamando a `Storage::disk('public')->delete(...)`.

---

## 🚀 6. Próximos Pasos (Roadmap del Proyecto)

```mermaid
gantt
    title Plan de Desarrollo - Sistema de Inventario
    dateFormat  YYYY-MM-DD
    section Fase 1: Catálogos Base (Completada)
    Categorías & Productos       :done,    des1, 2026-08-25, 2026-09-20
    Clientes & Proveedores       :done,    des2, 2026-09-20, 2026-10-03
    Almacenes & Identidades      :done,    des3, 2026-10-03, 2026-10-04
    section Fase 2: Compras y Abastecimiento
    Órdenes de Compra            :active,  des4, 2026-10-05, 2026-10-12
    Recepción de Compras         :         des5, 2026-10-12, 2026-10-19
    section Fase 3: Ventas y Clientes
    Cotizaciones                 :         des6, 2026-10-19, 2026-10-26
    Ventas y Facturación         :         des7, 2026-10-26, 2026-11-02
    section Fase 4: Kardex e Inventario
    Movimientos (Entradas/Salidas):        des8, 2026-11-02, 2026-11-09
    Transferencias entre Almacenes:       des9, 2026-11-09, 2026-11-16
```

- [x] **Fase 1: Catálogos y Entidades Base**
  - [x] Categorías
  - [x] Productos con galería Dropzone
  - [x] Clientes con tipo de documento
  - [x] Proveedores con tipo de documento
  - [x] Almacenes físicos
- [ ] **Fase 2: Gestión de Compras**
  - [ ] Módulo de Órdenes de Compra (`purchase_orders` + tabla pivote `productables`)
  - [ ] Recepción de Compras y registro de costo (`purchases`)
- [ ] **Fase 3: Gestión de Ventas**
  - [ ] Cotizaciones para clientes (`quotes`)
  - [ ] Registro de Ventas (`sales`)
- [ ] **Fase 4: Control de Stock e Inventario Físico (Kardex)**
  - [ ] Movimientos manuales de inventario por motivos (`movements` + `reasons`)
  - [ ] Transferencias entre almacenes (`transfers`)
  - [ ] Consulta y balance de Kardex general (`inventories`)
