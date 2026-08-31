<?php

namespace App\Livewire\Quote;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ferreteria Victoria | Cotizaciones')]
class QuoteComponent extends Component
{
    public $voucher_type = 1;
    public $serie = 'C001';
    public $correlative;
    public $date;
    public $purchase_order_id;
    public $customer_id;
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
        if ($property == 'purchase_order_id') {

            $quote = Quote::find($value);

            if ($quote) {

                $this->voucher_type = $quote->voucher_type;
                $this->customer_id = $quote->customer_id;

                $this->dispatch(
                    'set-customer',
                    id: $this->customer_id,
                    text: $quote->customer->name // mejor así
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
        $this->validate([
            'product_id' => 'required',
        ]);

        $product = Product::find($this->product_id);

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
            'subtotal' => $product->price,
        ];

        $this->reset('product_id');
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
            'date' => 'nullable|date',
            'customer_id' => 'required|exists:customers,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric:min:1',
            'products.*.price' => 'required|numeric:min:0',
        ]);

        $quote = Quote::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'customer_id' => $this->customer_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach ($this->products as $product) {
            $quote->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Cotización creada exitosamente!',
        ]);
    }
    public function render()
    {
        $quotes = Quote::orderBy('id', 'desc')->get();
        return view('livewire.quote.quote-component', compact('quotes'));
    }
}
