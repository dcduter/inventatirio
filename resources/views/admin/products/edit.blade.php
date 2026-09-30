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
        'href' => route('admin.products.index'),
    ],
    [
        'name' => 'Editar',
    ],

]"> 

    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @endpush
    
    <div class="mb-4">
        <form action="{{ route('admin.products.dropzone', $product) }}" class="dropzone" id="my-dropzone" method="POST">
        {{-- se pasa el token csrf --}}
        @csrf
        
        </form>
    </div>

    <x-wire-card>

        
        {{-- cambio por IA: Formulario de edición alineado estrictamente con el diagrama ERD de inventario (eliminados campos ajenos de ShopCreativa) --}}
        <form action="{{ route('admin.products.update', $product) }}" method="POST" class='space-y-4'>

            @csrf
            @method('PUT')

            <x-wire-input
                label="Nombre"
                name="name"
                value="{{ old('name', $product->name) }}"
                placeholder="Ingresa el nombre del producto"
            />

            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <x-wire-input
                    label="SKU"
                    name="sku"
                    value="{{ old('sku', $product->sku) }}"
                    placeholder="Código único de producto (opcional)"
                />
                <x-wire-native-select label="Categoría" name="category_id">
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>
                {{-- <x-wire-input
                    label="Código de barras"
                    name="barcode"
                    value="{{ old('barcode', $product->barcode) }}"
                    placeholder="Código de barras (opcional)"
                /> --}}
            </div>
               <x-wire-textarea
                label="Descripción"
                name="description"
                value="{{ old('description', $product->description) }}"
                placeholder="Descripción del producto"
            />

            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <x-wire-input
                    label="Precio"
                    type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    value="{{ old('price', $product->price) }}"
                    placeholder="0.00"
                />

           
            </div>

         

            <div class="flex justify-end pt-2">
                <x-button type="submit">
                    Actualizar
                </x-button>
            </div>

        </form>
    </x-wire-card>

    @push('js')
        <!-- cambio por IA: Agregamos Axios para que funcione tu petición de borrado -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script>

        // cambio por IA: Configuración de Dropzone comentada línea por línea
        Dropzone.options.myDropzone = {
            addRemoveLinks: true,
            // cambio por IA: Cambiamos el texto que aparece por defecto en el cuadro
            dictDefaultMessage: "Selecciona imagen o arrástrala aquí",
             dictInvalidFileType: "No puedes subir este tipo de archivo",
         
            // La función init se ejecuta automáticamente cuando Dropzone carga
            init: function(){
                // Guardamos 'this' (la instancia de Dropzone) en una variable para no perder el contexto dentro de otras funciones
                let myDropzone = this;

                // Convierte la colección de imágenes del producto (de PHP/Laravel) a un arreglo de objetos JSON (JavaScript)
                let images = @json($product->images);

                // Recorremos cada imagen que vino de la base de datos
                images.forEach(function(image){
                    // Creamos un archivo simulado (mockFile) con la estructura que Dropzone necesita leer
                    let mockFile = { 
                        // Guardamos el ID de la BD
                        id: image.id,
                        // Separamos la ruta por los '/' y tomamos la última parte (pop) que es el nombre del archivo
                        name: image.path.split('/').pop(),
                        // El peso de la imagen en bytes
                        size: image.size,
                        // status: Dropzone.ADDED,
                        // url: image.path
                    }
                    // Le pedimos a Dropzone que dibuje la tarjeta visual de la imagen en la pantalla
                    // Se usa Blade para generar la ruta de Storage, e interpolación de JS para inyectar el path de la imagen
                    myDropzone.displayExistingFile(mockFile, `{{ Storage::url('${image.path}') }}`)
                    myDropzone.emit("complete", mockFile);
                    myDropzone.files.push(mockFile);
                    
                });

                this.on("success", function(file, response){
                    file.id = response.id
                });

                this.on("removedfile", function(file){
                    axios.delete(`/admin/images/${file.id}`)
                    .then(response =>{
                        console.log(response.data);
                    })
                    .catch(error =>{
                        console.error(error);
                    })
                });
            }
         };
     /*        Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("#my-dropzone", {
                url: "/upload",
                method: "post",
                maxFilesize: 5,
                acceptedFiles: "image/*",
                parallelUploads: 1,
                uploadMultiple: false,
                dictDefaultMessage: "Arrastra y suelta imágenes aquí",
                dictMaxFilesExceeded: "No puedes subir más archivos",
                dictFileTooBig: "El archivo es muy grande",
                dictInvalidFileType: "No puedes subir este tipo de archivo",
                dictResponseError: "Error al subir el archivo",
            }); */
        </script>
    @endpush


    {{-- 
        Todo lo que se coloque aquí adentro representa el contenido dinámico de la página, 
        el cual Blade inyecta automáticamente en la variable {{ $slot }} dentro de admin.blade.php
    --}}

    

</x-admin-layout>