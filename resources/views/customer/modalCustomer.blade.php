<x-modal modalId="modalCustomer" modalTitle="Clientes" modalSize="modal-lg">
    <form wire:submit={{ $Id == 0 ? 'storeCustomer' : "updateCustomer($Id)" }}>
        <div class="form-row">

            <div class="form-group col-6">
                <label for="category_id">Tipo de documento</label>
                <select wire:model='identity_id' id="identity_id" class="form-control">
                    <option value="0">Selecionar</option>
                    @foreach ($identities as $identity)
                        <option value="{{$identity->id }}">{{ $identity->name }}</option>
                    @endforeach
                </select>
                @error('identity_id')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- NUM DOC --}}
            <div class="form-group col-6">
                <label for="document_number">Número de documento</label>
                <input wire:model.defer="document_number" type="text" class="form-control" placeholder="Número de documento" id="document_number">
                @error('document_number')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nombre --}}
            <div class="form-group col-12">
                <label for="name">Nombre del cliente</label>
                <input wire:model.defer="name" type="text" class="form-control" placeholder="Nombre del cliente" id="name">
                @error('name')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Direccion --}}
            <div class="form-group col-12">
                <label for="address">Dirección</label>
                <input wire:model.defer="address" type="text" class="form-control" placeholder="Dirección del cliente" id="address">
                @error('address')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group col-6">
                <label for="email">Correo electrónico</label>
                <input wire:model.defer="email" type="email" class="form-control" placeholder="ejemplo@gmail.com" id="email">
                @error('email')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Telefono --}}
            <div class="form-group col-6">
                <label for="phone">Número de télefono</label>
                <input wire:model.defer="phone" type="number" class="form-control" placeholder="Número de teléfono" id="phone">
                @error('phone')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr>
        <div class="d-flex justify-content-end">
            <button class="btn btn-dark float-end">{{ $Id == 0 ? 'Guardar' : 'Editar' }}</button>
        </div>
    </form>
</x-modal>
