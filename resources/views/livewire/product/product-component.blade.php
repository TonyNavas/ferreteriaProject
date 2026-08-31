<div class="container-fluid">

    <div class="row">
        @include('product.card-products')
    </div>

    <x-card cardTitle="Mostrando ({{$products->count()}}) productos.">
        <x-slot:searchInput>

        </x-slot:searchInput>
        <x-slot:cardTools>
            <div class="d-none d-lg-flex justify-content-start">
                <div class="mr-2">
                    <input type="text" wire:model.live = "search" class="form-control" placeholder="Buscar...">
                </div>

                <div class="mr-2">
                    <select class="form-control">
                        <option>Todas las categorias</option>
                    </select>
                </div>

                <div class="mr-2">
                    <select class="form-control">
                        <option>Todos los estados</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary m-0" wire:click="openModalCreate">
                    <span>
                        Agregar nuevo producto
                    </span>
                </button>
            </div>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>
                <th width="3%">Producto</th>
                <th width="3%">Categoría</th>
                <th width="3%">Precio</th>
                <th width="3%">Stock</th>
                <th width="3%">Estado</th>
                <th width="3%">Acciones</th>
            </x-slot:thead>

            @forelse ($products as $index => $product)
                <tr wire:key="Category-{{ $index }}" class="text-center">
                    <td class="d-flex align-items-center">
                        <figure class="mr-3 mb-0">
                            <x-image :item="$product" width="50px" height="45px" />
                        </figure>

                        <div class="text-left mb-0">
                            <small class="text-muted d-block font-weight-bold">
                                {{ $product->name }}
                            </small>

                            <small class="mb-0 font-weight-bold">
                                Art-{{ $product->id }}
                            </small>
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-category">
                            {{ $product->category->name }}
                        </span> 
                    </td>
                    <td>
                        <strong class="badge">C$ {{ $product->price }}</strong>
                    </td>
                    <td>
                        <button class="btn" wire:click="showStock({{ $product->id }})">
                            <span class="badge badge-primary" style="color: yellow;">
                                {{ $product->stock }}
                            </span>
                        </button>
                    </td>
                    <td>
                        <span class="badge bg-secondary">
                            Activo
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a a href="{{ route('products.kardex', $product) }}" class="btn btn-sm bg-green">
                                <i class="fas fa-boxes"></i>
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
    @include('product.stock')

    <style>
        .badge-category{
            background: #eef4ff;
            color: #3b82f6;
        }
    </style>
</div>
