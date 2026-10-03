<div class="flex items-center space-x-2">

    <x-wire-button href="{{ route('admin.customers.edit', $customer) }}" color="blue" outline>

        <i class="fas fa-edit"></i>
        Editar
    </x-wire-button>

    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="delete-form">

        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red >
            
            <i class="fas fa-trash"></i>
            Eliminar
        </x-wire-button>
        
    </form>


</div>