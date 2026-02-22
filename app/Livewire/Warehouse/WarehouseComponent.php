<?php

namespace App\Livewire\Warehouse;

use App\Models\Warehouse;
use Livewire\{Component, WithPagination};
use Livewire\Attributes\{On, Title};

#[Title('Almacen')]
class WarehouseComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $location;

    // Propiedades de la clase
    public $categoryCount = 0, $search = '', $Id;
    public $pagination = 10;

    public function resetModal()
    {
        $this->reset(['name']);
        $this->reset(['location']);
        $this->resetErrorBag();
    }

    public function openModalCreate()
    {
        $this->Id = 0;
        $this->resetModal();
        $this->dispatch('open-modal', 'modalWarehouse');
    }

    public function openModalEdit(Warehouse $warehouse)
    {
        $this->resetModal();
        $this->Id = $warehouse->id;
        $this->name = $warehouse->name;
        $this->location = $warehouse->location;
        $this->dispatch('open-modal', 'modalWarehouse');
    }

    public function storeWarehouse()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255'
        ]);

        Warehouse::create($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Almacén creado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalWarehouse');
    }

        public function updateWarehouse(Warehouse $warehouse)
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255'
        ]);

        $warehouse->update($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Almacén actualizado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalWarehouse');
    }

    #[On('destroyWarehouse')]
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        if ($warehouse->inventories()->exists()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No se puede eliminar el almacén porque tiene inventarios asociados!',
            ]);
        }

        $warehouse->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El almacén se ha eliminado correctamente!',
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $warehouses = Warehouse::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);

        return view('livewire.warehouse.warehouse-component', compact('warehouses'));
    }
}
