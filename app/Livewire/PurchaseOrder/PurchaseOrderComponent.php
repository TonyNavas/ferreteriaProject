<?php

namespace App\Livewire\PurchaseOrder;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ordenes de compra')]
class PurchaseOrderComponent extends Component
{

    public $voucher_type = 1;
    public $serie = 'OC-01';
    public $correlative;
    public $date;
    public $supplier_id;
    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];

    public function mount()
    {
        $this->correlative = PurchaseOrder::max('correlative') + 1;
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required',
        ]);

        $product = Product::find($this->product_id);

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];

        $this->reset('product_id');
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function save() {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric:min:1',
            'products.*.price' => 'required|numeric:min:0',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date,
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach($this->products as $product){
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Orden de compra creada exitosamente!',
        ]);
    }

    public function render()
    {
        $purchaseOrders = PurchaseOrder::orderBy('id', 'desc')->get();

        return view('livewire.purchase-order.purchase-order-component', compact('purchaseOrders'));
    }
}
