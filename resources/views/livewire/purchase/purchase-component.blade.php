    <div x-data="{
        products: @entangle('products').live,

        total: @entangle('total'),

        removeProduct(index) {
            this.products.splice(index, 1);
        },

        init() {
            this.$watch('products', (newProducts) => {
                let total = 0;

                newProducts.forEach(product => {
                    total += product.quantity * product.price;
                });

                this.total = total;
            });
        }
    }">

        <div class="container-fluid">

            <x-card cardTitle="Ordenes de compra">
                <x-slot:cardTools>

                </x-slot:cardTools>

                <div class="card bg-light shadow-none">
                    <div class="card-body">
                        <form wire:submit="save">
                            <div class="row">

                                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                    <label for="voucher_type">Tipo de comprobante</label>
                                    <select wire:model='voucher_type' id="voucher_type" class="custom-select w-100">
                                        <option value="1">Factura</option>
                                        <option value="2">Boleta</option>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                    <label for="serie">Serie</label>
                                    <input wire:model='serie' type="text" class="form-control w-100"
                                        placeholder="Serie del comprobante" id="serie">
                                </div>

                                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                    <label for="correlative">Correlativo</label>
                                    <input wire:model='correlative' type="text" class="form-control w-100"
                                        placeholder="Correlativo del comprobante">
                                </div>

                                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                    <label for="date">Fecha</label>
                                    <input wire:model='date' type="date" class="form-control w-100" id="date">
                                </div>

                                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">

                                    <div wire:ignore>
                                        <label>Orden de compra</label>
                                        <select id="purchaseOrder" class="form-control">
                                            <option>Seleccionar orden de compra</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    {{-- {{ $supplier_id }} --}}
                                    {{-- Select2 --}}
                                    <div wire:ignore>
                                        <label>Proveedor</label>
                                        <select id="supplier" class="form-control">
                                            <option>Seleccionar proveedor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">

                                    {{-- Select2 --}}
                                    <div wire:ignore>
                                        <label>Almacenes</label>
                                        <select id="warehouse" class="form-control">
                                            <option>Seleccionar almacen</option>
                                        </select>
                                    </div>
                                </div>
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
                                        <span>
                                            <i class="fas fa-plus-square"></i>
                                            Agregar producto
                                        </span>
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

                                    <template x-for="(product, index) in products" :key="product.id">
                                        <tr class="text-center">
                                            <td x-text="product.name"></td>

                                            <td>
                                                <input x-model="product.quantity" type="number"
                                                    class="form-control w-100">
                                            </td>
                                            <td>
                                                <input x-model="product.price" type="number" step="0.01"
                                                    class="form-control w-100">
                                            </td>

                                            <td x-text="(product.quantity * product.price).toFixed(2)"></td>

                                            <td>
                                                <a class="btn btn-sm bg-red" x-on:click="removeProduct(index)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    </template>

                                    <template x-if="products.length === 0">
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                No hay productos agregados
                                            </td>
                                        </tr>
                                    </template>

                                </x-table>

                                <div class="d-flex align-items-end gap-2 mt-1">
                                    <div class="flex-grow-1">
                                        <label>Observaciones</label>
                                        <input wire:model="observation" class="form-control w-100">
                                    </div>
                                    <div class="ml-2">
                                        Total: C$ <span x-text="total.toFixed(2)" class="ml-2"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-2">
                                <button wire:submit="save" class="btn btn-success">
                                    <span>
                                        <i class="fas fa-check"></i>
                                        Guardar
                                    </span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <x-slot:cardFooter>

                </x-slot:cardFooter>
            </x-card>

            <x-card cardTitle="Listado de ordenes de compra">
                <x-slot:cardTools>

                </x-slot:cardTools>

                <div class="mt-3">
                    <x-table>
                        <x-slot:thead>
                            <th width="3%">Id</th>
                            <th width="3%">Fecha</th>
                            <th width="3%">Serie</th>
                            <th width="3%">Correlativo</th>
                            <th width="3%">Document NUM</th>
                            <th width="3%">Proveedor</th>
                            <th width="3%">Total</th>
                            <th width="3%">Acciones</th>
                        </x-slot:thead>

                        @forelse ($purchases as $index => $purchases)
                            <tr wire:key="Purchase-{{ $index }}" class="text-center">
                                <td>{{ $purchases->id }}</td>
                                <td>{{ $purchases->date->format('Y-m-d') }}</td>
                                <td>{{ $purchases->serie }}</td>
                                <td>{{ $purchases->correlative }}</td>
                                <td>{{ $purchases->supplier->document_number }}</td>
                                <td>{{ $purchases->supplier->name }}</td>
                                <td>C${{ number_format($purchases->total, 2) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm bg-purple">
                                            <i class="fas fa-envelope"></i>
                                        </a>

                                        <a class="btn btn-sm bg-green">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No hay ordenes de compra</td>
                            </tr>
                        @endforelse

                    </x-table>
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
                            data: params => ({
                                search: params.term
                            }),
                            processResults: data => ({
                                results: data
                            })
                        }
                    });

                    $('#supplier').on('change', function() {
                        @this.set('supplier_id', $(this).val());
                    });

                    // Escuchando evento para actualizar el select del proveedor
                    Livewire.on('set-supplier', (data) => {

                        let id = data.id;

                        // Crear opción manualmente si no existe
                        let option = new Option("Cargando...", id, true, true);
                        $('#supplier').append(option).trigger('change');

                        // Opcional: traer el nombre real del supplier
                        $.ajax({
                            url: "{{ route('api.suppliers.index') }}",
                            type: 'POST',
                            data: {
                                selected: [id]
                            },
                            success: function(response) {
                                let supplier = response[0];

                                if (supplier) {
                                    let option = new Option(supplier.text, supplier.id, true, true);
                                    $('#supplier').empty().append(option).trigger('change');
                                }
                            }
                        });

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

            <script>
                document.addEventListener('livewire:init', () => {

                    $('#purchaseOrder').select2({
                        width: '100%',
                        ajax: {
                            url: "{{ route('api.purchase-order.index') }}",
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

                    $('#purchaseOrder').on('change', function() {
                        let value = $(this).val();
                        @this.set('purchase_order_id', value);
                    });

                });
            </script>

            <script>
                document.addEventListener('livewire:init', () => {

                    $('#warehouse').select2({
                        width: '100%',
                        ajax: {
                            url: "{{ route('api.warehouses.index') }}",
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

                    $('#warehouse').on('change', function() {
                        let value = $(this).val();
                        @this.set('warehouse_id', value);
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
