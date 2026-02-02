<div class="container-fluid">

    <x-card cardTitle="Listado de clientes ({{$customers->count()}})">
        <x-slot:cardTools>
                <button type="button" class="btn btn-primary" wire:click="openModalCreate">
                    <span>
                        <i class="fas fa-plus circle"></i>
                        Nuevo
                    </span>
                </button>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>
                <th width="1%">ID</th>
                <th width="3%">TIPO DOC</th>
                <th width="3%">NUM DOC</th>
                <th width="3%">Razón social</th>
                <th width="3%">Correo</th>
                <th width="3%">Teléfono</th>
                <th width="3%">Acciones</th>
            </x-slot:thead>

            @forelse ($customers as $index => $customer)
                <tr wire:key="Category-{{ $index }}" class="text-center">
                    <td>{{$customer->id}}</td>
                    <td>{{$customer->identity->name}}</td>
                    <td>{{$customer->document_number}}</td>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>(+505) {{$customer->phone}}</td>
                    <td>
                        <div class="btn-group">
                            <a a href="javascript:void(0)" class="btn btn-sm bg-dark">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="javascript:void(0)" wire:click="openModalEdit({{ $customer->id }})" class="btn btn-sm bg-primary ">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a wire:click="$dispatch('delete', {id : {{ $customer->id }},
                                eventName:'destroyCustomer'})"
                                class="btn btn-sm bg-red">
                                <i class="fa fa-trash"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Sin registros</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $customers->links() }}
        </x-slot:cardFooter>
    </x-card>

    {{-- Modal --}}
    @include('customer.modalCustomer')
</div>
