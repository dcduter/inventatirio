<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // cambio por IA

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Almacena un producto recién creado en la base de datos.
     *
     * // cambio por IA
     * @param \Illuminate\Http\Request $request Petición HTTP con los datos del producto.
     * @return \Illuminate\Http\RedirectResponse Redirección al listado con mensaje de confirmación.
     */
    public function store(Request $request)
    {
        // cambio por IA: Validación alineada con el diagrama ERD oficial del inventario
        $data = $request->validate([
            'name' => 'required|string|max:250|unique:products,name',
            'description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:45|unique:products,sku',
            'barcode' => 'nullable|string|max:45|unique:products,barcode',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Producto creado',
            'text' => 'El producto ha sido creado exitosamente.',
        ]);

        return redirect()->route('admin.products.index');
    }

    /**
     * Muestra los detalles de un producto específico.
     *
     * @param \App\Models\Product $product
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * // cambio por IA
     * @param \App\Models\Product $product Producto a editar.
     * @return \Illuminate\View\View Vista de edición con categorías.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     *
     * // cambio por IA
     * @param \Illuminate\Http\Request $request Petición HTTP con datos actualizados.
     * @param \App\Models\Product $product Modelo del producto a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirección al formulario con mensaje.
     */
    public function update(Request $request, Product $product)
    {
        // cambio por IA: Validación estricta con Rule::unique ignorando el ID actual
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:250',
                Rule::unique('products', 'name')->ignore($product->id),
            ],
            'description' => 'nullable|string',
            'sku' => [
                'nullable',
                'string',
                'max:45',
                Rule::unique('products', 'sku')->ignore($product->id),
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:45',
                Rule::unique('products', 'barcode')->ignore($product->id),
            ],
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Producto actualizado',
            'text' => 'El producto ha sido actualizado exitosamente.',
        ]);

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Elimina un producto garantizando la integridad de datos del inventario.
     *
     * // cambio por IA
     * @param \App\Models\Product $product Producto a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección al listado.
     */
    public function destroy(Product $product)
    {
        // cambio por IA: Verificación de integridad referencial antes de eliminar
        if ($product->inventories()->exists()) { // se llama la realcion de inventario y se verifica si existe con sql
            session()->flash('swal', [ // crae una sesion temporal para mostrar el mensaje
                'icon' => 'error',
                'title' => 'Acción bloqueada',
                'text' => 'No puedes eliminar este producto porque ya tiene movimientos en el inventario.',
            ]);

            return redirect()->route('admin.products.index'); // si existe retorna al listado con el mensaje de error
        }

        // cambio por IA: Verificación en productables que cubre compras, ventas, órdenes y cotizaciones
        if ($product->productables()->exists() || $product->purchaseOrders()->exists() || $product->quotes()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Acción bloqueada',
                'text' => 'No puedes eliminar este producto porque está vinculado a compras, ventas, cotizaciones u órdenes.',
            ]);

            return redirect()->route('admin.products.index');
        }

        // cambio por IA: Eliminación de archivos de imágenes físicas del disco y de la base de datos
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $product->delete();

        session()->flash('swal', [ // crae una sesion temporal para mostrar el mensaje
            'icon' => 'success',
            'title' => 'Producto eliminado',
            'text' => 'El producto ha sido eliminado correctamente.',
        ]);

        return redirect()->route('admin.products.index'); // retorna al listado con el mensaje de exito
    }

    public function dropzone(Request $request, Product $product)
    {
        // cambio por IA: Guardamos el archivo en el disco 'public' para que sea accesible desde el navegador
       // $path = $request->file('file')->store('images', 'public');
        
        // Si necesitas guardar la relación en la base de datos de una vez:
        $image = $product->images()->create([
            
            'path' => $request->file('file')->store('images', 'public'),
            'size' => $request->file('file')->getSize(),
            
        ]);

        return response()->json([
            'id' => $image->id,
            'path' => $image->path]);
    }
}
