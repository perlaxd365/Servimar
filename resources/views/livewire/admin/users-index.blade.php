<div>

    <div class="card">
        <div class="card-header">

            @include('livewire.admin.' . $view)
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <input wire:model='search' type="text" class="form-control" placeholder="Buscar">
        </div>

        @if ($users->count())
            <div class="card-body">
                <div class="card-body">
                    <table class="table table-striped table-sm">
                        <thead>
                            <th>ID</th>
                            <th>Sede</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->descripcion }}</td>
                                    <td>{{ $user->nombre }}</td>
                                    <td>{{ $user->dni }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-primary btn-sm">Permisos</a>
                                    </td>
                                    <td>
                                        <a wire:click="editar({{$user->id }})" class="btn btn-secondary btn-sm">Editar</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer mx-auto">
                {{ $users->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No se encontraron resultados</strong>
            </div>
        @endif
    </div>


</div>
