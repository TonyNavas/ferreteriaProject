<x-modal modalId="modalProduct" modalTitle="Productos" modalSize="modal-lg">

    <form wire:submit={{ $Id == 0 ? 'storeProduct' : "updateProduct($Id)" }}>
        <div class="form-row">

            {{-- Input name --}}
            <div class="form-group col-md-7">
                <label for="name">Nombre:</label>
                <input wire:model='name' type="text" class="form-control" placeholder="Nombre producto"
                    id="name">
                @error('name')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select category --}}
            <div class="form-group col-md-5">
                <label for="category_id">Categoria:</label>
                <select wire:model='category_id' id="category_id" class="form-control">
                    <option value="0">Selecionar</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Textarea description --}}
            <div class="form-group col-md-12">
                <label for="description">Descripción:</label>
                <textarea wire:model='description' id="description" class="form-control" rows="3"></textarea>
                @error('description')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Checkbox active --}}
            <div class="form-group col-md-3">
                <label for="price">Precio:</label>
                <input wire:model='price' min="0" step="any" type="number" class="form-control"
                    placeholder="0.00" id="price">
                @error('price')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input imagen --}}
            <div class="form-group col-md-3">

                <label for="image">Imagen</label>
                <input wire:model='image' type="file" id="imagen" accept="image/*">

                @error('image')
                    <div class="alert bg-danger text-white bold text-center w-100 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mostrar preview imagen --}}
            <div class="form-group col-md-6">

                @if ($Id > 0)
                    <x-image :item="$product = App\Models\Product::find($Id)" width="200" height="200" position="float-right" />
                @endif

                @if ($this->image)
                    <img src="{{ $image->temporaryUrl() }}" class="rounded float-right img-fluid" width="200">
                @endif
            </div>

        </div>

        <hr>
        <button wire:loading.attr = 'disabled'
            class="btn btn-dark float-end">{{ $Id == 0 ? 'Guardar' : 'Editar' }}</button>
    </form>

</x-modal>
