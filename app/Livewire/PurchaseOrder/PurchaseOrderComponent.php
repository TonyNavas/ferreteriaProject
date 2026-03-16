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

    public function mount(){
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

    public function save(){

    }

    public function render()
    {
        return view('livewire.purchase-order.purchase-order-component');
    }
}
