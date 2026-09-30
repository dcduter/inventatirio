<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    // uso de factory para crear datos
    use HasFactory;
    // cambio por IA: Campos fillable alineados estrictamente con el diagrama ERD de la base de datos de inventario
    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'category_id',
    ];

    /* Accesores */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->images->count() ? Storage::url($this->images->first()->path) : 'https://thumb.wikimedia.org/wikipedia/commons/thumb/1/14/No_Image_Available.jpg/250px-No_Image_Available.jpg?utm_source=commons.wikimedia.org&utm_campaign=index&utm_content=thumbnail',
        );
    }

    /**
     * Relación muchos a uno: El producto pertenece a una categoría.
     * 
     * // cambio por IA
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación uno a muchos: Un producto tiene múltiples registros en inventario.
     * En el diagrama ERD, la tabla inventories posee product_id como clave foránea.
     * 
     * // cambio por IA
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Relación uno a muchos: Un producto puede estar en múltiples tablas intermedias/pivote productables.
     * 
     * // cambio por IA
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productables()
    {
        return $this->hasMany(Productable::class);
    }

    // Relacion de muchos a muchos polimorfica con purchaseOrders
    public function purchaseOrders()
    {
        // cambio por IA: Se usa morphedByMany para la relación inversa polimórfica
        return $this->morphedByMany(PurchaseOrder::class, 'productable');
    }

    // Relacion de muchos a muchos polimorfica con quotes
    public function quotes()
    {
        // cambio por IA: Se usa morphedByMany para la relación inversa polimórfica
        return $this->morphedByMany(Quote::class, 'productable');
    }
    
    

    /**
     * Relación polimórfica uno a muchos: Un producto puede tener múltiples imágenes asociadas.
     * 
     * // cambio por IA
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
