<x-modal modalId="modalStock" modalTitle="Stock por almacén" modalSize="modal-lg">

    <ul class="list-group list-unstyled">
        @forelse ($inventories as $inventory)
            <li class="list-group-item d-flex justify-content-between mb-2 border-0 shadow-sm">
                <div>
                    <p class="text-muted mb-0">{{$inventory->warehouse->name}}</p>
                    <p class="h6 font-weight-bold text-muted">{{$inventory->warehouse->location}}</p>
                </div>
                <div class="text-right">
                    <p class="text-muted">Stock disponible</p>
                    <p class="h4 font-weight-bold {{$inventory->quantity_balance > 0 ? 'text-success' : 'text-danger'}}">
                        {{$inventory->quantity_balance}}
                    </p>
                </div>
            </li>
        @empty

        <li class="text-center p-5 h5">
            No hay inventarios disponibles.
        </li>

        @endforelse
    </ul>

</x-modal>
