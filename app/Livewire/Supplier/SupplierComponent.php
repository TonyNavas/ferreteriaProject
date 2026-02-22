<?php

namespace App\Livewire\Supplier;

use App\Models\{Identity, Supplier};
use Livewire\{Component, WithPagination};
use Livewire\Attributes\{On, Title};

#[Title('Proveedores')]
class SupplierComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $identity_id, $document_number, $name, $address, $email, $phone;

    // Propiedades de la clase
    public $categoryCount = 0, $search = '', $Id;
    public $pagination = 10;

    public function resetModal()
    {
        $this->reset(['identity_id']);
        $this->reset(['document_number']);
        $this->reset(['name']);
        $this->reset(['address']);
        $this->reset(['email']);
        $this->reset(['phone']);
        $this->resetErrorBag();
    }

    public function openModalCreate()
    {
        $this->Id = 0;
        $this->resetModal();
        $this->dispatch('open-modal', 'modalSupplier');
    }

    public function openModalEdit(Supplier $supplier)
    {
        $this->resetModal();
        $this->Id = $supplier->id;
        $this->identity_id = $supplier->identity_id;
        $this->document_number = $supplier->document_number;
        $this->name = $supplier->name;
        $this->address = $supplier->address;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;

        $this->dispatch('open-modal', 'modalSupplier');
    }

    public function storeSupplier()
    {
        $data = $this->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|max:20|unique:suppliers,document_number',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:1000',
            'phone' => 'required|string|max:255',
        ]);

        // dd($data);
        Supplier::create($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Proveedor creado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalSupplier');
    }

    public function updateSupplier(Supplier $supplier)
    {
        $data = $this->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|max:20|unique:suppliers,document_number, ' . $supplier->id,
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:1000',
            'phone' => 'required|string|max:255',
        ]);

        // dd($data);
        $supplier->update($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Proveedor editado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalSupplier');
    }

    #[On('destroySupplier')]
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->purchaseOrders()->exists() || $supplier->purchases()->exists()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No se puede eliminar el cliente porque tiene compras o ordenes de compras asociadas!',
            ]);
        }

        $supplier->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha eliminado correctamente!',
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $suppliers = Supplier::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);

        $identities = Identity::all();

        return view('livewire.supplier.supplier-component', compact('suppliers', 'identities'));
    }
}
