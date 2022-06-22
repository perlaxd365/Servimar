
       <div class="card-header">
            <h3>
                Listado de Embarcaciones
            </h3>
        </div>


        <div class="container">
            <br>
            <input wire:model='searchEmb' type="text" class="form-control"
                placeholder="Buscar por cualquier criterio">
        </div>
        @if ($clientes->count())
            <div class="card-body">
                <table class="table table-striped table-sm table-responsive table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Nombre Embarcación</th>
                        <th>Cliente</th>
                        <th>Matrícula</th>
                        <th>Dueño</th>
                        <th>Razon Social (Dueño)</th>
                        <th>Ruc (Dueño)</th>
                        <th>Estado</th>
                    </thead>
                    <tbody>
                        @foreach ($embarcacionesList as $embarcaciones)
                            <tr style="cursor: pointer;">
                                <td>{{ $embarcaciones->id }}</td>
                                <td>{{ $embarcaciones->nombre_emb }}</td>
                                <td>{{ $embarcaciones->nombre_cli }}</td>
                                <td>{{ $embarcaciones->matricula_emb }}</td>
                                <td>{{ $embarcaciones->duenio_emb }}</td>
                                <td>{{ $embarcaciones->razon_emb }}</td>
                                <td>{{ $embarcaciones->ruc_emb }}</td>
                                <td>{{ $embarcaciones->estado_emb == '1' ? 'Activo' : 'Inactivo' }}</td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body">
                <strong>No se encontraron resultados</strong>
            </div>
        @endif