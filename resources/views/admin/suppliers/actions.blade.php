<div class="flex items-center space-x-2">

    <x-wire-button href="{{ route('admin.suppliers.edit', $supplier) }}" color="blue" outline>

        <i class="fas fa-edit"></i>
        Editar
    </x-wire-button>

    <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="delete-form">

        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red >
            
            <i class="fas fa-trash"></i>
            Eliminar
        </x-wire-button>
        
    </form>


</div>