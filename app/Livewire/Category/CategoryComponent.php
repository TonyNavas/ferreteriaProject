<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Administrar Categorías')]
class CategoryComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Propiedades del modelo
    public $name, $description;

    // Propiedades de la clase
    public $categoryCount = 0, $search = '', $Id;
    public $pagination = 10;

    public function resetModal()
    {
        $this->reset(['name']);
        $this->reset(['description']);
        $this->resetErrorBag();
    }

    public function openModalCreate()
    {
        $this->Id = 0;
        $this->resetModal();
        $this->dispatch('open-modal', 'modalCategory');
    }

    public function openModalEdit(Category $category)
    {
        $this->resetModal();
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->dispatch('open-modal', 'modalCategory');
    }

    public function storeCategory()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Categoría creada correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalCategory');
    }

    public function updateCategory(Category $category)
    {
        $data = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Categoría actualizada correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalCategory');
    }

    #[On('destroyCategory')]
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No se puede eliminar la categoria porque tiene productos asociados!',
            ]);
        }
        $category->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La categoría se ha eliminado correctamente!',
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $categories = Category::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);

        return view('livewire.category.category-component', compact('categories'));
    }
}
