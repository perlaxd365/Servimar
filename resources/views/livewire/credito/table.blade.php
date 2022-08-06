<div class="card-header">
    <h3>
        Listado de Créditos
    </h3>
    <input wire:model='search' type="text" class="form-control" placeholder="Buscar por Cliente">
</div>

@if ($clientes->count())
    <div class="card-body">
        <div class="card-body">
            <table class="table table-striped table-sm table-responsive-sm">
                <thead>
                    <th>ID#</th>
                    <th>Cliente (Empresa)</th>
                    <th>Dueño</th>
                    <th>RUC</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id_cliente }}</td>
                            <td>{{ $cliente->razon_cli }}</td>
                            <td>{{ $cliente->duenio_cli }}</td>
                            <td>{{ $cliente->ruc_cli }}</td>
                            <td>{{ $cliente->nombre_cli }}</td>
                            <td class="center-text">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button wire:click="modalDetalle({{ $cliente->id_cliente }})" type="button"
                                        class="btn btn-secondary">
                                        <i class='fa fa-plus-square'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer mx-auto">
        {{ $clientes->links() }}
    </div>


    <div wire:ignore.self class="modal fade" id="modalDetalleEmbarcacion" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Embarcaciones <strong></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if ($embarcaciones->count())
                    <table class="table table-striped table-sm table-responsive-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Embarcación</th>
                                    <th scope="col">Dueño</th>
                                    <th scope="col">Matrícula</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($embarcaciones as $key => $embarcacion)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $embarcacion->nombre_emb}}</td>
                                        <td>{{ $embarcacion->duenio_emb}}</td>
                                        <td>{{ $embarcacion->matricula_emb}}</td>
                                        <td>{{ $embarcacion->telefono_emb}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="card-body">
                            <strong>No se encontraron resultados</strong>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click='update_producto' class="btn btn-primary">Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card-body">
        <strong>No se encontraron resultados</strong>
    </div>
@endif

<script>
    window.addEventListener('close-modal-update', event => {

        $('#modalUpdateProducto').modal('hide');

    });
</script>
