<?php

namespace App\Livewire\Purchase;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

use function Symfony\Component\Clock\now;

#[Title('Ferreteria Victoria | Compras')]
class PurchaseComponent extends Component
{
    public $voucher_type = 1;
    public $serie;
    public $correlative;
    public $date;
    public $purchase_order_id;
    public $supplier_id;
    public $warehouse_id;
    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];



    public function updated($property, $value)
    {
        if ($property == 'purchase_order_id') {

            $purchaseOrder = PurchaseOrder::find($value);

            if ($purchaseOrder) {

                $this->voucher_type = $purchaseOrder->voucher_type;
                $this->supplier_id = $purchaseOrder->supplier_id;

                $this->dispatch(
                    'set-supplier',
                    id: $this->supplier_id,
                    text: $purchaseOrder->supplier->name // mejor así
                );

                $this->products = $purchaseOrder->products->map(function ($product) {
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

            $lastRecord = Kardex::getLastRecord(
                $product->id,
                $this->warehouse_id,
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
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|string|max:10',
            'date' => 'nullable|date',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric:min:1',
            'products.*.price' => 'required|numeric:min:0',
        ]);

        $purchase = Purchase::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'purchase_order_id' => $this->purchase_order_id,
            'warehouse_id' => $this->warehouse_id,
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach ($this->products as $product) {
            $purchase->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            // Kardex
            Kardex::registerEntry($purchase, $product, $this->warehouse_id, 'Compra');
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La compra se ha creado exitosamente!',
        ]);
    }
    public function render()
    {
        $purchases = Purchase::orderBy('id', 'desc')->get();
        return view('livewire.purchase.purchase-component', compact('purchases'));
    }
}
