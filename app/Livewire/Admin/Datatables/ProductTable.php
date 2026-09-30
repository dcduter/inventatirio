<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder; // Cambio por IA: Importación de Builder para la relación con categorías
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            ImageColumn::make("Imagen")
                ->location(fn($row) => $row->image) // toma el registtro actual row y dentro de ese busca la imagen con $row->image y lo muestra con el formato de image 
                ->attributes(fn($row) => [
                    'class' => 'w-20 h-14 object-cover object-center rounded-xl',
                ]),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Categoría", "category.name")
                ->searchable()
                ->sortable(),
            Column::make("Precio", "price")
                ->sortable(),
            Column::make("Acciones", "id")
                ->label(function ($row) {
                    return view('admin.products.actions', ['product' => $row]);
                }),
        ];
    }
    
    public function builder(): Builder
    {
        return Product::query()
            ->with(['category', 'images']);
    }
}
