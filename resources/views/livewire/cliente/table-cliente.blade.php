
    <!--Clientes-->
        <div class="card-header">
            <h3>
                Listado de Clientes
            </h3>
        </div>


        <div class="container">
            <br>
            <input wire:model='search' type="text" class="form-control" placeholder="Buscar por cualquier criterio">
        </div>
        @if ($clientes->count())
            <div class="card-body">
                <table class="table table-striped table-sm table-responsive table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Razon</th>
                        <th>DNI</th>
                        <th>RUC</th>
                        <th>Tipo Cliente</th>
                        <th>Persona</th>
                        <th>telefono</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr style="cursor: pointer;" wire:click="listaDetalle({{ $cliente->id_cliente }})">
                                <td>{{ $cliente->id_cliente }}</td>
                                <td>{{ $cliente->nombre_cli }}</td>
                                <td>{{ $cliente->razon_cli }}</td>
                                <td>{{ $cliente->dni_cli }}</td>
                                <td>{{ $cliente->ruc_cli }}</td>
                                <td>{{ $cliente->nombre_tipo }}</td>
                                <td>{{ $cliente->nombre_per }}</td>
                                <td>{{ $cliente->telefono_cli }}</td>
                                <td>{{ $cliente->email_cli }}</td>


                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div id="{{ $cliente->id_cliente }}" style="display:none">



                                        <div id="none" style="display: none" class="card">
                                            <div class="modal-header">
                                                <h5>No se encontró embarcaciones</h5>
                                                <button onclick="slideOff({{ $cliente->id_cliente }})" type="button"
                                                    class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div id="display" class="card">
                                            <div class="modal-header">
                                                <h5>Embarcaciones de <strong>{{ $cliente->nombre_cli }}</strong></h5>
                                                <button onclick="slideOff({{ $cliente->id_cliente }})" type="button"
                                                    class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="card-body">

                                                <table class="table-responsive-sm table-secondary table-striped"
                                                    style="table-layout: fixed; width: 100%;">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Matrícula</th>
                                                            <th>Dueño</th>
                                                            <th>Razon Social</th>
                                                            <th>Ruc</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($embarcaciones as $embarcacion)
                                                            <tr>
                                                                <td>{{ $embarcacion->nombre_emb }}</td>
                                                                <td>{{ $embarcacion->matricula_emb }}</td>
                                                                <td>{{ $embarcacion->duenio_emb }}</td>
                                                                <td>{{ $embarcacion->razon_emb }}</td>
                                                                <td>{{ $embarcacion->ruc_emb }}</td>
                                                                <td>{{ $embarcacion->estado_emb == '1' ? 'Activo' : 'Inactivo' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="card-footer mx-auto">
                {{ $clientes->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No se encontraron resultados</strong>
            </div>
        @endif




<script>
    window.addEventListener('slider', event => {
        var div = '#' + event.detail.id;
        var filas = event.detail.filas;
        if (filas != 0) {
            $(div).slideDown("slow");
        } else if (filas == 0) {
            Swal.fire({
                type: 'error',
                title: 'No se encontraron embarcaciones',
                showConfirmButton: false,
                timer: 2000
            })
        }

    });

    function slideOff(id) {
        var div = '#' + id;
        $(div).slideUp("slow");
    }
</script>
