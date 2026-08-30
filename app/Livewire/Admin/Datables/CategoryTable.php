<?php

namespace App\Livewire\Admin\Datables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Category;

class CategoryTable extends DataTableComponent
{
    // cambio por IA: Componente de tabla Livewire para gestionar y listar las categorías
    protected $model = Category::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Descripción", "description")
                ->sortable(),
            column::make('Acciones')
                ->label(function($row){
                    return view('admin.categories.actions', ['category' => $row]);
                })
        ];
    }
}
