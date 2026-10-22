<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Livewire\Component;

class PurchaseOrderCreate extends Component
{
     // se define las propiedades de la tabla purchases para crear una compra
    public $voucher_type = 1;
    public $serie = 'OC01';
    public $correlative;
    public $date;
    public $purchase_order_id;
    public $supplier_id;
    public $warehouse_id;
    public $total = 0;
    public $observation;

    // identificar un producto
    public $product_id;

    // relacion con productos
    public $products = [

    ];

    public function boot(){
        // verificar errores de validacion
        $this->withValidator(function ($validator){
            if($validator->fails()){
                $errors = $validator->errors()->toArray(); /* toma todos los errorer, los pasa a un array */

                $html = "<ul class='text-left'>";

                foreach ($errors as $error) {
                    # code...
                    $html .="<li>{$error[0]}</li>";
                }
                $html .="</ul>";

                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Error de validación',
                    'html' => $html, 
                ]);

                
            }
        });
    }

    public function mount()
    {
        $this->correlative = PurchaseOrder::max('correlative') + 1;
    }

    public function addProduct()
    {
        // validacion que exista el producto
        $this->validate([
            'product_id' => 'required|exists:products,id',
        ],[],[
            'product_id' => 'producto'
        ]);

        // se pregunta si el producto ya existe en el array products
        // se pasa products en una colleccion
        $existing = collect($this->products)
            ->firstWhere('id', $this->product_id); // filtro por el campo id;
        
        if ($existing) {
          
            $this->dispatch('swal', [
                'icon' => 'warning',
                'title' => 'Producto ya agregado',
                'text' => 'El producto ya se encuentra en la lista',
            ]);// evento de livewire, se escucha desde javascript
            /* MINUTO 39 */
            return;
        }   
        
        // se busca en la base de datos
        $product = Product::find($this->product_id);

        // se agrega dentro de array products
        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
        // limpiar el campo product_id
        $this->reset('product_id');

    }
    public function save()
    {
        // guardar en la base de datos
        $this->validate([
            'voucher_type' => 'required|in:1,2', /* toma le valor de 1 o 2 */
            'date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'total' => 'required|numeric',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
            
        ]);
        $purchaseOrder = PurchaseOrder::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        /* asignar los productos relacionados a productables */
        // Cambio por IA: comentarios explicativos sobre la asociación polimórfica en la tabla pivote
        foreach ($this->products as $product) {
            // Asocia el producto con la orden de compra insertando un registro en la tabla intermedia (productables)
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],                     // Cantidad comprada del producto
                'price'    => $product['price'],                        // Precio unitario de compra
                'subtotal' => $product['quantity'] * $product['price'], // Subtotal (cantidad * precio)
            ]);  
        }

        // sesion flash
        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Orden de compra creada',
            'text' => 'La orden de compra se ha creado correctamente',
        ]);
        return redirect()->route('admin.purchase-orders.index');
    }
    public function render()
    {
        return view('livewire.admin.purchase-order-create');
    }
}
