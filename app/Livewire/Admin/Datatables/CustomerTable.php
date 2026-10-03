<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder; // cambio por IA: Importación correcta del Builder de Eloquent

class CustomerTable extends DataTableComponent
{
    protected $model = Customer::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    // cambio por IA: Configuración de columnas para el listado de clientes
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Tipo Doc.", "identity.name")
                ->sortable()
                ->searchable(),
            Column::make("N° Documento", "document_number")
                ->sortable()
                ->searchable(),
            Column::make("Razón Social", "name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Teléfono", "phone")
                ->sortable(),
            Column::make("Acciones", "id")
                ->label(fn($row) => view('admin.customers.actions', ['customer' => $row])),
        ];
    }

    /**
     * // cambio por IA: Consulta base con eager loading para evitar problemas N+1
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder(): Builder
    {
        return Customer::query()
            ->with(['identity']);
    }
}
