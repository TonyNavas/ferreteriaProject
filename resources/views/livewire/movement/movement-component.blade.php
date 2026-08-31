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

            // Deshabilitar almacén si hay productos
            $('#warehouse')
                .prop('disabled', newProducts.length > 0)
                .trigger('change.select2');

        });

    }
}">

    <div class="container-fluid">

        <x-card cardTitle="Entradas y salidas">
            <x-slot:cardTools>

            </x-slot:cardTools>

            <div class="card bg-light shadow-none">
                <div class="card-body">
                    <form wire:submit="save">
                        {{-- {{$type}} --}}
                        <div class="row">


                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="type">Tipo de movimiento</label>
                                <select wire:model='type' id="type" class="custom-select w-100">
                                    <option value="1">Ingreso</option>
                                    <option value="2">Salida</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="serie">Serie</label>
                                <input wire:model='serie' type="text" class="form-control w-100"
                                    placeholder="Serie del comprobante" id="serie" readonly>
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="correlative">Correlativo</label>
                                <input wire:model='correlative' type="text" class="form-control w-100"
                                    placeholder="Correlativo del comprobante" readonly>
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="date">Fecha</label>
                                <input wire:model='date' type="date" class="form-control w-100" id="date">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div wire:ignore>
                                    <label>Almacenes</label>
                                    <select id="warehouse" class="form-control">
                                        <option>Seleccionar almacen</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div wire:ignore>
                                    <label>Motivo de traslado/movimiento</label>
                                    <select id="reason" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Select2 product --}}
                        <div class="d-flex align-items-end gap-2 mt-1">
                            {{-- {{ count($products) }} --}}
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
                                    <th width="3%">Precio costo</th>
                                    <th width="3%">Subtotal</th>
                                    <th width="3%">Acciones</th>
                                </x-slot:thead>

                                <template x-for="(product, index) in products" :key="product.id">
                                    <tr class="text-center">
                                        <td x-text="product.name"></td>

                                        <td>
                                            <input x-model="product.quantity" type="number" class="form-control w-100">
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

        <x-card cardTitle="Listado de movimientos">
            <x-slot:cardTools>

            </x-slot:cardTools>

            <div class="mt-3">
                <x-table>
                    <x-slot:thead>
                        <th width="3%">Id</th>
                        <th width="3%">Fecha</th>
                        <th width="3%">Tipo</th>
                        <th width="3%">Serie</th>
                        <th width="3%">Correlativo</th>
                        <th width="3%">Almacén</th>
                        <th width="3%">Motivo</th>
                        <th width="3%">Total</th>
                        <th width="3%">Acciones</th>
                    </x-slot:thead>

                    @forelse ($movements as $index => $movement)
                        <tr wire:key="Purchase-{{ $index }}" class="text-center">
                            <td>{{ $movement->id }}</td>
                            <td>{{ $movement->date->format('Y-m-d') }}</td>
                            <td>{{ $movement->type_label }}</td>
                            <td>{{ $movement->serie }}</td>
                            <td>{{ $movement->correlative }}</td>
                            <td>{{ $movement->warehouse->name }}</td>
                            <td>{{ $movement->reason->name }}</td>
                            <td>C${{ $movement->total }}</td>
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

        {{-- Cliente --}}
        <script>
            document.addEventListener('livewire:init', () => {

                $('#customer').select2({
                    width: '100%',
                    ajax: {
                        url: "{{ route('api.customers.index') }}",
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

                $('#customer').on('change', function() {
                    @this.set('customer_id', $(this).val());
                });

                // Escuchando evento para actualizar el select del cliente
                Livewire.on('set-customer', (data) => {

                    let id = data.id;

                    // Crear opción manualmente si no existe
                    let option = new Option("Cargando...", id, true, true);
                    $('#customer').append(option).trigger('change');

                    // Opcional: traer el nombre real del supplier
                    $.ajax({
                        url: "{{ route('api.customers.index') }}",
                        type: 'POST',
                        data: {
                            selected: [id]
                        },
                        success: function(response) {
                            let customer = response[0];

                            if (customer) {
                                let option = new Option(customer.text, customer.id, true, true);
                                $('#customer').empty().append(option).trigger('change');
                            }
                        }
                    });

                });

            });
        </script>

        {{-- Productos --}}
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

                Livewire.on('reset-product-select', () => {

                    $('#product').val(null).trigger('change');

                });



            });
        </script>

        {{-- Razon --}}
        <script>
            document.addEventListener('livewire:init', () => {

                // Inicializar select2 de razones
                $('#reason').select2({
                    width: '100%',
                    ajax: {
                        url: "{{ route('api.reasons.index') }}",
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,

                        data: function(params) {
                            return {
                                search: params.term,
                                type: $('#type').val() // 👈 enviar tipo
                            };
                        },

                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });

                // Guardar valor en Livewire
                $('#reason').on('change', function() {
                    let value = $(this).val();
                    @this.set('reason_id', value);
                });

                // Cuando cambie ingreso/salida
                $('#type').on('change', function() {

                    // Limpiar select2
                    $('#reason').val(null).trigger('change');

                    // Limpiar propiedad Livewire
                    @this.set('reason_id', null);

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
