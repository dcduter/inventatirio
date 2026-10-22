<div x-data="{ products: @entangle('products'),

    total: @entangle('total'),
    
    removeProduct(index){
        this.products.splice(index, 1) {{-- splice es para eliminar un elemento de un array, el primer parametro es el indice y el segundo es la cantidad de elementos a eliminar --}}
    },

    init(){
      {{-- escucha cada vez que hay un cambio en products --}}
      this.$watch('products', (newProducts) =>{
      
      let total = 0;
      newProducts.forEach(product => {

          total += (product.quantity * product.price);
            })

            this.total = total;
      })
       
    }
}">
    <x-wire-card>
        <form wire:submit="save" class="space-y-4">

            {{-- informacion de la orden de compra --}}
            <div class="grid lg:grid-cols-4 gap-4">

                <x-wire-native-select label="Tipo de Comprobante" wire:model="voucher_type">
                    <option value="0">Seleccionar</option>
                    <option value="1">Factura</option>
                    <option value="2">Boleta</option>
                </x-wire-native-select>

                <x-wire-input label="Serie" wire:model="serie" placeholder="Seria del comprobante" disabled></x-wire-input>
                <x-wire-input label="Correlative" wire:model="correlative" placeholder="Correlativo del comprobante" disabled></x-wire-input>
                <x-wire-input label="Fecha" wire:model="data" type="date"></x-wire-input>
                
                
            </div>

            {{-- componente select de wire ui para proveedor --}}
            <x-wire-select label="Proveedor" wire:model="supplier_id" placeholder="Seleccionar proveedor" :async-data="[
                    'api' =>route('api.suppliers.index'),
                    'method' => 'POST',
                ]"
                option-label="name"
                option-value="id"
            />

            <div class="lg:flex lg:space-x-4"> {{-- flex espacio 4px entre los elementos --}} 
                 <x-wire-select label="Producto" wire:model="product_id" placeholder="Seleccionar producto" 
                    :async-data="[
                        'api' =>route('api.products.index'),
                        'method' => 'POST',
                    ]"
                    option-label="name"
                    option-value="id"
                    class="flex-1"
                />

                <div class="flex-shrink-0">
                    <x-wire-button wire:click="addProduct" spinner="addProduct" class="w-full mt-4 lg:w-auto lg:mt-6.5"> {{-- mt-6.5 es para subir el boton 6.5px --}}
                    Agregar Producto
                    </x-wire-button>
                </div>
            </div>

            {{-- minuto 26 --}}
            <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-700 border-y bg-blue-50">
                        <th class="py-2 px-4">Producto</th>
                        <th class="py-2 px-4">Cantidad</th>
                        <th class="py-2 px-4">Precio</th>
                        <th class="py-2 px-4">Subtotal</th>
                        <th class="py-2 px-4"></th>
                        
                    </tr>
                </thead>
                <tbody>

                    {{-- x-for para iterar --}}
                    {{-- con alpine js se puede hacer esto porque entangle esta habilitado en livewire y ejecuta mucha mas rapido que con el forelse de blade --}}
                    <template x-for="(product, index) in products" :key="product.id">

                         <tr class="border-b">
                        <td class="py-4 px-1" x-text="product.name"></td> {{-- con x-text mostramos el nombre del producto en alpine js --}}
                        <td class="py-4 px-1">
                            {{-- {{ $product['quantity']}} --}}
                            <x-wire-input type="number" class="w-20" x-model="product.quantity"/> {{-- con x-model mostramos el valor de la cantidad --}}

                        </td>
                        <td class="py-4 px-1">
                            {{-- {{ $product['price']}} --}}
                            <x-wire-input type="number" class="w-20" x-model="product.price" step="0.01" min="0"/>
                        </td>
                        <td class="py-4 px-1" x-text="(product.quantity * product.price).toFixed(2)"></td> {{-- hace la multiplicacion y toma 2 decimales --}}
                        <td class="py-4 px-1">
                            <x-wire-mini-button rounded icon="trash" red x-on:click="removeProduct(index)"/>  {{-- aqui se corrige el error de eliminar un producto --}}
                          
                        </td>
                      </tr>

                    </template>

                    <template x-if="products.length === 0">
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                No hay productos agregados
                            </td>
                        </tr>
                    </template>

                 {{-- MINUTO 54 --}}
                    {{--        @forelse ($products as  $index => $product)

                                <tr class="border-b">
                                    <td class="py-4 px-1">{{ $product['name']}}</td>
                                    <td class="py-4 px-1">
                                        {{-- {{ $product['quantity']}} --}}
                                        {{-- <x-wire-input type="number" class="w-20" wire:model.live="products.{{ $index }}.quantity"/> --}}

                                        {{-- minuto 47 --}}
                                {{--   </td>
                                    <td class="py-4 px-1">
                    {{--                    {{-- {{ $product['price']}} --}}
                                        {{-- <x-wire-input type="number" class="w-20" wire:model.live="products.{{ $index }}.price" step="0.01" min="0"/> --}}
                                    {{-- </td>
                                    <td class="py-4 px-1"> {{ number_format((float) ($product['quantity'] ?? 0) * (float) ($product['price'] ?? 0), 2) }}</td>
                                    <td class="py-4 px-1">
                                        <x-wire-mini-button rounded icon="trash" red wire:click="removeItem({{ $index }})">
                                        Eliminar
                                        </x-wire-mini-button>
                                    </td>
                                </tr>
                            @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            No hay productos agregados
                                        </td>
                                    </tr>
                            @endforelse --}}  
                </tbody>
            </table>
            </div>

            <div class="flex items-center space-x-4">

                <x-label >
                    Observaciones
                </x-label>
                <x-wire-input class="flex-1" wire:model="observation"/>
 
                <div>
                    Total: $/. <span x-text="total.toFixed(2)"></span>
                </div>
            </div>
            
            <div class="flex justify-end"> {{-- el contenedor para el boton para que no se encoja --}}
                <x-wire-button type="submit" icon="check" spinner="save" >
                    Guardar
                </x-wire-button>
            </div>
              
        </form>
    </x-wire-card>
</div>

{{-- minuto 7 --}}
