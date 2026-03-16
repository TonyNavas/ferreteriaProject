<div class="container-fluid">

    <x-card cardTitle="Listado de proveedores ({{$suppliers->count()}})">
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
                <th width="1%">ID</th>
                <th width="3%">TIPO DOC</th>
                <th width="3%">NUM DOC</th>
                <th width="3%">Nombre</th>
                <th width="3%">Correo</th>
                <th width="3%">Teléfono</th>
                <th width="3%">Acciones</th>
            </x-slot:thead>

            @forelse ($suppliers as $index => $supplier)
                <tr wire:key="Category-{{ $index }}" class="text-center">
                    <td>{{$supplier->id}}</td>
                    <td>{{$supplier->identity->name}}</td>
                    <td>{{$supplier->document_number}}</td>
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->email}}</td>
                    <td>{{$supplier->phone}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="javascript:void(0)" wire:click="openModalEdit({{ $supplier->id }})" class="btn btn-sm bg-primary ">
                                <i class="fa fa-edit"></i>
                                Editar
                            </a>

                            <a wire:click="$dispatch('delete', {id : {{ $supplier->id }},
                                eventName:'destroySupplier'})"
                                class="btn btn-sm bg-red">
                                <i class="fa fa-trash"></i>
                                Eliminar
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Sin registros</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $suppliers->links() }}
        </x-slot:cardFooter>
    </x-card>

    {{-- Modal --}}
    @include('supplier.modalSupplier')
</div>
