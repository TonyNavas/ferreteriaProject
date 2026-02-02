<div class="container-fluid">

    <x-card cardTitle="Listado categorias ({{$categories->count()}})">
        <x-slot:cardTools>
                <button type="button" class="btn btn-primary" wire:click="openModalCreate">
                    <span>
                        <i class="fas fa-plus circle"></i>
                        Crear nueva categoría
                    </span>
                </button>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>
                <th width="3%">ID</th>
                <th width="3%">Nombre</th>
                <th width="3%">Descripción</th>
                <th width="3%">Acciones</th>
            </x-slot:thead>

            @forelse ($categories as $index => $category)
                <tr wire:key="Category-{{ $index }}" class="text-center">
                    <td>{{++$index}}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <div class="btn-group">
                            <a a href="" class="btn btn-sm bg-dark">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="#" wire:click="openModalEdit({{ $category->id }})" class="btn btn-sm bg-primary ">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a wire:click="$dispatch('delete', {id : {{ $category->id }},
                                eventName:'destroyCategory'})"
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
            {{ $categories->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('category.modalCategory')
</div>
