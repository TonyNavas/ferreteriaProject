<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Identity;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Clientes')]
class CustomerComponent extends Component
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
        $this->dispatch('open-modal', 'modalCustomer');
    }

    public function openModalEdit(Customer $customer)
    {
        $this->resetModal();
        $this->Id = $customer->id;
        $this->identity_id = $customer->identity_id;
        $this->document_number = $customer->document_number;
        $this->name = $customer->name;
        $this->address = $customer->address;
        $this->email = $customer->email;
        $this->phone = $customer->phone;

        $this->dispatch('open-modal', 'modalCustomer');
    }

    public function storeCustomer()
    {
        $data = $this->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|max:20|unique:customers,document_number',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:1000',
            'phone' => 'required|string|max:255',
        ]);

        // dd($data);
        Customer::create($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Cliente creado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalCustomer');
    }

    public function updateCustomer(Customer $customer)
    {
        $data = $this->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|max:20|unique:customers,document_number, ' . $customer->id,
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:1000',
            'phone' => 'required|string|max:255',
        ]);

        // dd($data);
        $customer->update($data);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Cliente creado correctamente!',
        ]);

        $this->resetModal();
        $this->dispatch('close-modal', 'modalCustomer');
    }

    #[On('destroyCustomer')]
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->quotes()->exists() || $customer->sales()->exists()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No se puede eliminar el cliente porque tiene cotizaciones o ventas asociadas!',
            ]);
        }

        $customer->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El cliente se ha eliminado correctamente!',
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $customers = Customer::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);

        $identities = Identity::all();

        return view('livewire.customer.customer-component', compact('customers', 'identities'));
    }
}
