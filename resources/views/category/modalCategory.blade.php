<x-modal modalId="modalCategory" modalTitle="Categorias">
    <form wire:submit={{ $Id == 0 ? 'storeCategory' : "updateCategory($Id)" }}>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="name">Nombre:</label>
                <input wire:model.defer="name" type="text" class="form-control" placeholder="Nombre categoria" id="name">
                @error('name')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-12">
                <label>Descripción</label>
                <textarea wire:model.defer="description" class="form-control" rows="3"
                    placeholder="Ingrese la descripcion (Opcional)"></textarea>
                @error('descrption')
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
