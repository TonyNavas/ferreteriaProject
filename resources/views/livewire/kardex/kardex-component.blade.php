<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="fas fa-filter"></i>
            Filtros
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="fecha_inicial">Fecha inicial</label>
                        <input wire:model.live='fecha_inicial' type="date" class="form-control"
                            placeholder="Ingresar fecha">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="fecha_final">Fecha final</label>
                        <input wire:model.live='fecha_final' type="date" class="form-control"
                            placeholder="Ingresar fecha">
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="fecha_final">Seleccionar almacén</label>
                        <select class="form-control" wire:model.live="warehouse_id">
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

                        <div class="alert alert-product d-flex mt-2">
                <div class="alert-icon">
                    <i class="fas fa-info-circle"></i>
                </div>

                <div class="ml-3">
                    <h6 class="font-weight-bold mb-3">Producto seleccionado</h6>

                    <div class="d-flex">
                        <p class="mb-1 mr-3">
                        <strong>Nombre:</strong>
                        {{ $product->name }}
                    </p>
                    |
                    <p class="mb-1 mr-3 ml-2">
                        <strong>SKU:</strong>
                        {{ $product->sku ?? 'No definido' }}
                    </p>
                    |
                    <p class="mb-0 ml-2">
                        <strong>Stock Total:</strong>
                        {{ $product->stock }}
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="font-weight-bold text-muted">Kardex de productos</h4>

    @if ($inventories->count())

        <x-table>
            <x-slot:thead>
                <tr>
                    <th rowspan="2" class="text-center">Detalle</th>
                    <th colspan="3" class="" style="background: #FEF9C3;">Entradas</th>
                    <th colspan="3" class="" style="background: #d90429; color: #edf2f4;">Salidas</th>
                    <th colspan="3" class="" style="background: #ada7ff; color: #0d47a1;">Balance</th>
                    <th rowspan="2" class="text-center">Fecha</th>
                </tr>
                <th>Cant.</th>
                <th>Costo</th>
                <th>Total</th>
                <th>Cant.</th>
                <th>Costo</th>
                <th>Total</th>
                <th>Cant.</th>
                <th>Costo</th>
                <th>Total</th>
            </x-slot:thead>

            @forelse ($inventories as $index => $inventory)
                <tr wire:key="kardex-{{ $index }}" class="text-center">
                    <td>{{ $inventory->detail }}</td>
                    <td>{{ $inventory->quantity_in }}</td>
                    <td>{{ $inventory->cost_in }}</td>
                    <td>{{ $inventory->total_in }}</td>
                    <td>{{ $inventory->quantity_out }}</td>
                    <td>{{ $inventory->cost_out }}</td>
                    <td>{{ $inventory->total_out }}</td>
                    <td>{{ $inventory->quantity_balance }}</td>
                    <td>{{ $inventory->cost_balance }}</td>
                    <td>{{ $inventory->total_balance }}</td>
                    <td>{{ $inventory->created_at->format('Y-m-d') }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="5">Sin registros</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $inventories->links() }}
        </x-slot:cardFooter>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">

                <div class="empty-icon mx-auto mb-4">
                    <i class="fas fa-box-open"></i>
                </div>

                <h5 class="font-weight-bold mb-2">
                    No hay registros de inventario
                </h5>

                <p class="text-muted mb-0">
                    Aún no se han registrado entradas o salidas de productos en el almacén seleccionado.
                </p>

            </div>
        </div>
    @endif

    <style>
        .empty-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #eef4ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(59, 130, 246, .12);
        }

        .card {
            border-radius: 15px;
        }

        .card-body {
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .alert-product {
            background: #f4f7ff;
            border: 1px solid #dbe7ff;
            border-left: 4px solid #4f7cff;
            border-radius: 12px;
            padding: 1.25rem;
            color: #24458b;
            align-items: flex-start;
            overflow: hidden;
        }

        .alert-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 50%;
            background: #e6efff;
            color: #4f7cff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .alert-product h6 {
            color: #21409a;
        }

        .alert-product p {
            margin-bottom: .35rem;
            color: #4a5f88;
        }

        .alert-product strong {
            color: #21409a;
        }
    </style>
</div>
