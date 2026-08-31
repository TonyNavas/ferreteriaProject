<?php

namespace App\Livewire\Kardex;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Productos | Kardex')]
class KardexComponent extends Component
{
    use WithPagination;

    public Product $product;
    public $warehouses;
    public $warehouse_id;

    public $fecha_inicial;
    public $fecha_final;

    public function mount(){
        $this->warehouses = Warehouse::all();
        $this->warehouse_id = $this->warehouses->first()->id ?? null;
    }

    public function render()
    {
        $inventories = Inventory::where('product_id', $this->product->id)
            ->where('warehouse_id', $this->warehouse_id)
            ->when($this->fecha_inicial, function ($query){
                $query->whereDate('created_at', '>=', $this->fecha_inicial);
            })
            ->when($this->fecha_final, function ($query){
                $query->whereDate('created_at', '<=', $this->fecha_final);
            })
            ->paginate();

        return view('livewire.kardex.kardex-component', compact('inventories'));
    }
}
