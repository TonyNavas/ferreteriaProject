<div class="container-fluid">

    <x-card cardTitle="Listado de almacenes ({{ $warehouses->count() }})">
        <x-slot:cardTools>
            <button type="button" class="btn btn-primary" wire:click="openModalCreate">
                <span>
                    <i class="fas fa-plus circle"></i>
                    Nuevo
                </span>
            </button>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>
                <th width="3%">ID</th>
                <th width="3%">Nombre</th>
                <th width="3%">Dirección</th>
                <th width="3%">Acciones</th>
            </x-slot:thead>

            @forelse ($warehouses as $index => $warehouse)
                <tr wire:key="Category-{{ $index }}" class="text-center">
                    <td>{{ $warehouse->id }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->location }}</td>
                    <td>
                        <div class="btn-group">
                            <a a href="" class="btn btn-sm bg-dark">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="#" wire:click="openModalEdit({{ $warehouse->id }})"
                                class="btn btn-sm bg-primary ">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a wire:click="$dispatch('delete', {id : {{ $warehouse->id }},
                                eventName:'destroyWarehouse'})"
                                class="btn btn-sm bg-red">
                                <i class="fa fa-trash"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Sin registros</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $warehouses->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('warehouse.modalWarehouse')
</div>
