<div class="card-header">
    <h3>
        Listado de Usuarios
    </h3>
    <input wire:model='search' type="text" class="form-control" placeholder="Buscar">
</div>

@if ($users->count())
    <div class="card-body">
        <div class="card-body">
            <table class="table table-striped table-sm table-responsive-sm">
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
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->dni }}</td>
                            <td>{{ $user->email }}</td>
                            @can('admin.users.update')
                                <td>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-primary btn-sm">Permisos</a>
                                </td>
                                <td>
                                    <a wire:click="editar({{ $user->id }})" class="btn btn-secondary btn-sm">Editar</a>
                                </td>
                            @endcan
                            @can('admin.users.delete')
                                <td>
                                    <a wire:click="delete({{ $user->id }})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            @endcan
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
