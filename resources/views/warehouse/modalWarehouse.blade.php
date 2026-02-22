<x-modal modalId="modalWarehouse" modalTitle="Almacén">
    <form wire:submit={{ $Id == 0 ? 'storeWarehouse' : "updateWarehouse($Id)" }}>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="name">Nombre</label>
                <input wire:model.defer="name" type="text" class="form-control" placeholder="Nombre del almacén" id="name">
                @error('name')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-12">
                <label for="location">Dirección</label>
                <input wire:model.defer="location" type="text" class="form-control" placeholder="Ubicación del almacén" id="location">
                @error('location')
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
