<?php

namespace App\Livewire\Transfer;

use App\Facades\Kardex;
use App\Models\Product;
use App\Models\Transfer;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ferreteria Victoria | Traferencias')]
class TransferComponent extends Component
{
    public $serie = 'T001';
    public $correlative;
    public $date;
    public $origin_warehouse_id;
    public $destination_warehouse_id;

    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];

    public function mount()
    {
        $this->correlative = Transfer::max('correlative') + 1;
    }

    public function addProduct()
    {
        try {
            $this->validate([
                'product_id' => 'required|exists:products,id',
                'origin_warehouse_id' => 'required|exists:warehouses,id',
            ], [], [
                'product_id' => 'producto',
                'origin_warehouse_id' => 'almacén de origen',
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

            $lastRecord = Kardex::getLastRecord(
                $product->id,
                $this->origin_warehouse_id,
            );

            $this->products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $lastRecord['cost'],
                'subtotal' => $lastRecord['cost'],
            ];

            $this->reset('product_id');
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
                    'serie' => 'required|string|max:10',
                    'correlative' => 'required|numeric|min:1',
                    'date' => 'nullable|date',
                    'origin_warehouse_id' => 'required|exists:warehouses,id',
                    // Destino diferente al origen
                    'destination_warehouse_id' => 'required|different:origin_warehouse_id|exists:warehouses,id',
                    'total' => 'required|numeric|min:0',
                    'observation' => 'nullable|string|max:255',

                    'products' => 'required|array|min:1',
                    'products.*.id' => 'required|exists:products,id',
                    'products.*.quantity' => 'required|numeric|min:1',
                    'products.*.price' => 'required|numeric|min:0',
                ],
                [],
                [
                    'serie' => 'serie',
                    'correlative' => 'correlativo',
                    'date' => 'fecha',
                    'origin_warehouse_id' => 'almacén de origen',
                    'destination_warehouse_id' => 'almacén de destino',
                    'total' => 'total',
                    'observation' => 'observación',
                    'products' => 'productos',
                    'products.*.id' => 'producto',
                    'products.*.quantity' => 'cantidad',
                    'products.*.price' => 'precio',
                ]
            );

            $transfer = Transfer::create([
                'serie' => $this->serie,
                'correlative' => $this->correlative,
                'date' => $this->date ?? now(),
                'origin_warehouse_id' => $this->origin_warehouse_id,
                'destination_warehouse_id' => $this->destination_warehouse_id,
                'total' => $this->total,
                'observation' => $this->observation,
            ]);

            foreach ($this->products as $product) {

                $transfer->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['quantity'] * $product['price'],
                ]);

                Kardex::registerExit($transfer, $product, $this->origin_warehouse_id, "Transferencia");

                Kardex::registerEntry($transfer, $product, $this->destination_warehouse_id, "Transferencia");
            }

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => '¡Bien hecho!',
                'text' => 'Transferencia realizada exitosamente!',
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
        $transfers = Transfer::orderBy('id', 'desc')->get();
        return view('livewire.transfer.transfer-component', compact('transfers'));
    }
}
