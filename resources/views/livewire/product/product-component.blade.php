<div class="container-fluid">

    <x-card cardTitle="Listado de productos ({{ $products->count() }})">
        <x-slot:cardTools>
            <button type="button" class="btn btn-primary" wire:click="openModalCreate">
                <span>
                    Nuevo
                </span>
            </button>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>
                <th width="1%">ID</th>
                <th width="2%"><i class="fas fa-images"></i></th>
                <th width="3%">Nombre</th>
                <th width="3%">Categoría</th>
                <th width="3%">Precio</th>
                <th width="3%">Acciones</th>
            </x-slot:thead>

            @forelse ($products as $index => $product)
                <tr wire:key="Category-{{ $index }}" class="text-center">
                    <td>PD-{{ $product->id }}</td>
                    <td>
                        <x-image :item="$product"/>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <div class="btn-group">
                            <a a href="javascript:void(0)" class="btn btn-sm bg-dark">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="javascript:void(0)" wire:click="openModalEdit({{ $product->id }})"
                                class="btn btn-sm bg-primary ">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a wire:click="$dispatch('delete', {id : {{ $product->id }},
                                eventName:'destroyProduct'})"
                                class="btn btn-sm bg-red">
                                <i class="fa fa-trash"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Sin registros</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $products->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('product.modalProduct')
</div>

