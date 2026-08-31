<?php

namespace App\Livewire\Movement;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Movement;
use App\Models\Product;
use App\Services\KardexService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ferreteria Victoria | Movimientos')]
class MovementComponent extends Component
{
    public $type = 1;
    public $serie = 'M001';
    public $correlative;
    public $date;
    public $warehouse_id;
    public $reason_id;
    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];

    public function mount()
    {
        $this->correlative = Movement::max('correlative') + 1;
    }


    public function updated($property, $value)
    {
        if ($property == 'type') {
            $this->reset('reason_id');
        }
    }

    public function addProduct()
    {
        try {
            $this->validate([
                'product_id' => 'required|exists:products,id',
                'warehouse_id' => 'required|exists:warehouses,id',
            ], [], [
                'product_id' => 'producto',
                'warehouse_id' => 'almacén',
            ]);

            $existing = collect($this->products)->firstWhere('id', $this->product_id);

            if ($existing) {
                $this->dispatch('swal', [
                    'icon' => 'warning',
                    'title' => '¡Producto ya agregado!',
                    'text' => 'El producto ya se encuentra en la lista!',
                ]);

                return;
            }

            $product = Product::find($this->product_id);
            // Kardex
            $lastRecord = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $this->warehouse_id)
                ->latest('id')
                ->first();

            $costBalance = $lastRecord?->cost_balance ?? 0;

            $this->products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $costBalance,
                'subtotal' => $costBalance,
            ];

            $this->reset('product_id');
            $this->dispatch('reset-product-select');
        } catch (ValidationException $e) {

            $errors = collect($e->errors())
                ->flatten()
                ->implode("\n");

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Errores de validación',
                'text' => $errors,
            ]);
        } catch (\Exception $e) {

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function save()
    {
        try {
            $this->validate(
                [
                    'type' => 'required|in:1,2',
                    'serie' => 'required|string|max:10',
                    'correlative' => 'required|numeric|min:1',
                    'date' => 'nullable|date',
                    'warehouse_id' => 'required|exists:warehouses,id',
                    'reason_id' => 'required|exists:reasons,id',
                    'total' => 'required|numeric|min:0',
                    'observation' => 'nullable|string|max:255',

                    'products' => 'required|array|min:1',
                    'products.*.id' => 'required|exists:products,id',
                    'products.*.quantity' => 'required|numeric|min:1',
                    'products.*.price' => 'required|numeric|min:0',
                ],
                [],
                [
                    'type' => 'tipo de movimiento',
                    'serie' => 'serie',
                    'correlative' => 'correlativo',
                    'date' => 'fecha',
                    'warehouse_id' => 'almacén',
                    'reason_id' => 'motivo',
                    'total' => 'total',
                    'observation' => 'observación',
                    'products' => 'productos',
                    'products.*.id' => 'producto',
                    'products.*.quantity' => 'cantidad',
                    'products.*.price' => 'precio',
                ]
            );

            $movement = Movement::create([
                'type' => $this->type,
                'serie' => $this->serie,
                'correlative' => $this->correlative,
                'date' => $this->date ?? now(),
                'warehouse_id' => $this->warehouse_id,
                'reason_id' => $this->reason_id,
                'total' => $this->total,
                'observation' => $this->observation,
            ]);

            foreach ($this->products as $product) {

                $movement->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['quantity'] * $product['price'],
                ]);

                // Kardex

                if ($this->type == 1) {
                    Kardex::registerEntry($movement, $product, $this->warehouse_id, 'Movimiento');
                } elseif ($this->type == 2) {
                    Kardex::registerExit($movement, $product, $this->warehouse_id, 'Movimiento');
                }
            }

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => '¡Bien hecho!',
                'text' => 'Movimiento realizado exitosamente!',
            ]);
        } catch (ValidationException $e) {

            $errors = collect($e->errors())
                ->flatten()
                ->implode("\n");

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Errores de validación',
                'text' => $errors,
            ]);
        } catch (\Exception $e) {

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage(),
            ]);
        }
    }
    public function render()
    {
        $movements = Movement::orderBy('id', 'desc')->get();
        return view('livewire.movement.movement-component', compact('movements'));
    }
}
