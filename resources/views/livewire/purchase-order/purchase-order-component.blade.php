<div class="container-fluid">

    <x-card cardTitle="Ordenes de compra">
        <x-slot:cardTools>

        </x-slot:cardTools>

        <div class="card">
            <div class="card-body">
                <form wire:submit="save">
                    <div class="row">

                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="voucher_type">Tipo de comprobante</label>
                            <select wire:model='voucher_type' id="voucher_type" class="custom-select">
                                <option value="1">Factura</option>
                                <option value="2">Boleta</option>

                            </select>
                            @error('voucher_type')
                                <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="serie">Serie</label>
                            <input wire:model='serie' type="text" class="form-control"
                                placeholder="Serie del comprobante" id="serie" readonly>
                            @error('serie')
                                <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="correlative">Correlativo</label>
                            <input wire:model='correlative' type="text" class="form-control"
                                placeholder="Correlativo del comprobante" id="serie" readonly>
                            @error('correlative')
                                <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                            <label for="date">Fecha</label>
                            <input wire:model='date' type="date" class="form-control" id="date">
                            @error('date')
                                <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{ $supplier_id }}
                    {{-- Select2 --}}
                    <div wire:ignore>
                        <label>Proveedor</label>
                        <select id="supplier" class="form-control">
                            <option>Seleccionar proveedor</option>
                        </select>
                    </div>

                    {{ $product_id }}
                    {{-- Select2 product --}}
                    <div class="d-flex align-items-end gap-2 mt-1">

                        <div class="flex-grow-1" wire:ignore>
                            <label>Producto</label>
                            <select id="product" class="form-control w-100">
                                <option>Seleccionar producto</option>
                            </select>

                        </div>
                        <div>
                            <button type="button" wire:click="addProduct" class="btn btn-primary ml-2">
                                Agregar producto
                            </button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <x-table>
                            <x-slot:thead>
                                <th width="3%">Producto</th>
                                <th width="3%">Cantidad</th>
                                <th width="3%">Precio</th>
                                <th width="3%">Subtotal</th>
                                <th width="3%">Acciones</th>
                            </x-slot:thead>

                            @forelse ($products as $index => $product)
                                <tr wire:key="Category-{{ $index }}" class="text-center">
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>{{ $product['quantity'] * $product['price'] }}</td>
                                    <td>
                                        <a class="btn btn-sm bg-red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No hay productos agregados</td>
                                </tr>
                            @endforelse
                        </x-table>
                    </div>
                </form>
            </div>
        </div>

        <x-slot:cardFooter>

        </x-slot:cardFooter>
    </x-card>

</div>

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {

            $('#supplier').select2({
                width: '100%',
                ajax: {
                    url: "{{ route('api.suppliers.index') }}",
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,

                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },

                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                }
            });

            $('#supplier').on('change', function() {
                let value = $(this).val();
                @this.set('supplier_id', value);
            });

        });
    </script>

    <script>
        document.addEventListener('livewire:init', () => {

            $('#product').select2({
                width: '100%',
                ajax: {
                    url: "{{ route('api.products.index') }}",
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,

                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },

                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                }
            });

            $('#product').on('change', function() {
                let value = $(this).val();
                @this.set('product_id', value);
            });

        });
    </script>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 4px 12px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal;
            padding-left: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
    </style>
@endsection
