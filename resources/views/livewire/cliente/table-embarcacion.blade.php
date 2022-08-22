
       <div class="card-header">
            <h3>
                Listado de Embarcaciones
            </h3>
            <input wire:model='searchEmb' type="text" class="form-control"
                placeholder="Buscar por cualquier criterio">
        </div>


        @if ($clientes->count())
            <div class="card-body">
                <table class="table table-striped table-sm table-responsive table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Nombre Embarcación</th>
                        <th>Giro de Embarcación</th>
                        <th>Cliente (Empresa)</th>
                        <th>Matrícula</th>
                        <th>Dueño</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        @foreach ($embarcacionesList as $embarcaciones)
                            <tr style="cursor: pointer;">
                                <td>{{ $embarcaciones->id }}</td>
                                <td>{{ $embarcaciones->nombre_emb }}</td>
                                <td>{{ $embarcaciones->nombre_tipo }}</td>
                                <td>{{ $embarcaciones->nombre_cli }}</td>
                                <td>{{ $embarcaciones->matricula_emb }}</td>
                                <td>{{ $embarcaciones->duenio_emb }}</td>
                                <td>

                                        <a wire:click='deleteEmb({{$embarcaciones->id}})' class="btn" >
                                            <i class='fa fa-trash text-dark'></i>
                                        </a>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer mx-auto">
                {{ $embarcacionesList->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No se encontraron resultados</strong>
            </div>
        @endif