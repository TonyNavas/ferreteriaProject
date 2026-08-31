<?php

namespace App\Livewire\Sale;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Quote;
use App\Models\Sale;
use App\Services\KardexService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ferreteria Victoria | Ventas')]
class SaleComponent extends Component
{
    public $voucher_type = 1;
    public $serie = "F001";
    public $correlative;
    public $date;
    public $quote_id;
    public $customer_id;
    public $warehouse_id;
    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];

    public function mount()
    {
        $this->correlative = Quote::max('correlative') + 1;
    }


    public function updated($property, $value)
    {
        if ($property == 'quote_id') {

            $quote = Quote::find($value);

            if ($quote) {

                $this->voucher_type = $quote->voucher_type;
                $this->customer_id = $quote->customer_id;

                $this->dispatch(
                    'set-customer',
                    id: $this->customer_id,
                    text: $quote->customer->name
                );

                $this->products = $quote->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->pivot->price,
                        'subtotal' => $product->pivot->subtotal,
                    ];
                })->toArray();
            }
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

            $this->products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'subtotal' => $product->price,
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
                    'voucher_type' => 'required|in:1,2',
                    'serie' => 'required|string|max:10',
                    'correlative' => 'required|numeric|min:1',
                    'date' => 'nullable|date',
                    'quote_id' => 'nullable|exists:quotes,id',
                    'warehouse_id' => 'required|exists:warehouses,id',
                    'customer_id' => 'required|exists:customers,id',
                    'total' => 'required|numeric|min:0',
                    'observation' => 'nullable|string|max:255',

                    'products' => 'required|array|min:1',
                    'products.*.id' => 'required|exists:products,id',
                    'products.*.quantity' => 'required|numeric|min:1',
                    'products.*.price' => 'required|numeric|min:0',
                ],
                [],
                [
                    'voucher_type' => 'tipo de comprobante',
                    'serie' => 'serie',
                    'correlative' => 'correlativo',
                    'date' => 'fecha',
                    'quote_id' => 'cotización',
                    'warehouse_id' => 'almacén',
                    'customer_id' => 'cliente',
                    'total' => 'total',
                    'observation' => 'observación',
                    'products' => 'productos',
                    'products.*.id' => 'producto',
                    'products.*.quantity' => 'cantidad',
                    'products.*.price' => 'precio',
                ]
            );

            $sale = Sale::create([
                'voucher_type' => $this->voucher_type,
                'serie' => $this->serie,
                'correlative' => $this->correlative,
                'date' => $this->date ?? now(),
                'quote_id' => $this->quote_id,
                'warehouse_id' => $this->warehouse_id,
                'customer_id' => $this->customer_id,
                'total' => $this->total,
                'observation' => $this->observation,
            ]);

            foreach ($this->products as $product) {

                $sale->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'subtotal' => $product['quantity'] * $product['price'],
                ]);

                // Kardex
                Kardex::registerExit($sale, $product, $this->warehouse_id, 'Venta');
            }

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => '¡Bien hecho!',
                'text' => 'La venta se ha realizado exitosamente!',
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
        $sales = Sale::orderBy('id', 'desc')->get();
        return view('livewire.sale.sale-component', compact('sales'));
    }
}
