<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Title('Productos')]
class ProductComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $name, $description, $price, $category_id, $image;

    // Propiedades de la clase
    public $ProductsCount = 0, $search = '', $Id;
    public $pagination = 10;

    public function resetModal()
    {
        $this->reset(['name']);
        $this->reset(['description']);
        $this->reset(['price']);
        $this->reset(['category_id']);
        $this->resetErrorBag();
    }

    public function openModalCreate()
    {
        $this->Id = 0;
        $this->resetModal();
        $this->dispatch('open-modal', 'modalProduct');
    }

    public function storeProduct()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|max:2048|nullable',
        ]);

        $product = Product::create($data);

        if ($this->image) {
            $customName = 'products/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $size = $this->image->getSize();
            $product->image()->create([
                'path' => $customName,
                'size' => $size,
            ]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto creado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalProduct');
    }

    public function openModalEdit(Product $product)
    {
        $this->resetModal();
        $this->Id = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->dispatch('open-modal', 'modalProduct');
    }

    public function updateProduct(Product $product)
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($data);

        if ($this->image) {
            if ($product->image != null) {
                Storage::delete('public/' . $product->image->path);
                $product->image()->delete();
            }
            $customName = 'products/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $size = $this->image->getSize();
            $product->image()->create([
                'path' => $customName,
                'size' => $size,
                ]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto actualizado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalProduct');
    }

    #[On('destroyProduct')]
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->inventories()->exists()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No se puede eliminar el producto porque tiene inventarios asociados!',
            ]);
        }

        if ($product->purchaseOrders()->exists() || $product->quotes()->exists()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No se puede eliminar el producto porque tiene ordenes de compra o cotizaciones asociadas!',
            ]);
        }

        if ($product->image != null) {
            Storage::delete('public/' . $product->image->path);
            $product->image()->delete();
        }

        $product->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha eliminado correctamente!',
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $products = Product::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);

        $categories = Category::all();

        return view('livewire.product.product-component', compact('products', 'categories'));
    }
}
