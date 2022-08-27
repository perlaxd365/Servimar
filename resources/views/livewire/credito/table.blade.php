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
                                    <button
                                        wire:click="modalDetalle({{ $cliente->id_cliente }},'{{ $cliente->razon_cli }}')"
                                        type="button" class="btn btn-info">
                                        <i class='fa fa-address-card'></i>
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

    <!-- Modal Pago-->
    <div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalPago" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pago
                        <strong>{{ $razon_cliente }}</strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col clearfix">
                        @foreach ($creditoPrePago as $item)
                            <ul class="list-group">
                                <li class="list-group-item">Galones: {{ $item->galones_credito }}</li>
                                <li class="list-group-item">Precio x Galon: {{ $item->precio_galon_credito }} </li>
                                <li class="list-group-item">
                                    <span class="badge badge-warning">Total:
                                    {{ $item->galones_credito * $item->precio_galon_credito }}
                                    </span></li>
                            </ul>
                        @endforeach
                    </div>
                    <div class="col clearfix">
                        <div class="form-row align-items-center">
                            <div class="col-sm-3 my-1">
                                <label>Monto Abonado</label>
                                @if ($pagos->count())

                                @foreach ($pagos as $pago)
                                    <input type="text" class="form-control" readonly value="{{ $pago->monto_pago }}"
                                        placeholder="Monto Abonado">
                                @endforeach
                                @else
                                <br>
                                    No se abonó ningun pago
                                @endif

                                
                            </div>
                            <div class="col-sm-3 my-1">
                                <label>Monto a pagar</label>
                                @foreach ($creditoPrePago as $item)
                              <input type="text" wire:model='monto_pagar' class="form-control"  placeholder="Monto a pagar">
                                @endforeach
                            </div>

                            @if ($pagos->count())
                            <div class="col-sm-3 my-1" style="padding-top: 4%">
                                <button wire:click='store' type="submit" class="btn btn-primary">Realizar Pago</button>
                            </div>
                            @else
                            <br>
                                A la espera de que se realice un pago
                            @endif


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal detalle-->
    <div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalDetalleEmbarcacion" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Embarcaciones
                        <strong>{{ $razon_cliente }}</strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                role="tab" aria-controls="pills-home" aria-selected="true">Créditos Pendientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                role="tab" aria-controls="pills-profile" aria-selected="false">Historial de Créditos
                            </a>
                        </li>
                        <li class="nav-item col clearfix">
                            <div class="col clearfix">
                                <span class="float-right">
                                    <strong>Monto Abonado </strong>
                                    <br>

                                    <span class="badge badge-success">
                                        Total:
                                        @if ($pagos->count())

                                            @foreach ($pagos as $pago)
                                                {{ $pago->monto_pago }}
                                            @endforeach
                                        @else
                                            0
                                        @endif
                                    </span>
                                </span>
                            </div>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">

                            @if ($embarcaciones->count())
                                <table class="table table-striped table-sm table-responsive-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Embarcación</th>
                                            <th scope="col">Dueño</th>
                                            <th scope="col">Matrícula</th>
                                            <th scope="col">Teléfono</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Precio x Galón</th>
                                            <th scope="col">Galones</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                        @foreach ($embarcaciones as $key => $embarcacion)
                                            <?php $total = $total + $embarcacion->galones_credito; ?>
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $embarcacion->nombre_emb }}</td>
                                                <td>{{ $embarcacion->duenio_emb }}</td>
                                                <td>{{ $embarcacion->matricula_emb }}</td>
                                                <td>{{ $embarcacion->telefono_emb }}</td>
                                                <td>{{ $embarcacion->fecha_credito }}</td>
                                                <td>{{ $embarcacion->precio_galon_credito }}</td>
                                                <td>{{ $embarcacion->galones_credito }}</td>
                                                <td class="center-text">
                                                    <button wire:click="modalPago({{ $embarcacion->id_credito }})"
                                                        type="button" data-dismiss="modal" data-toggle="modal"
                                                        data-target="#modalPago" class="btn btn-primary btn-sm">
                                                        Pagar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>TOTAL:</strong></td>
                                            <td>{{ $total }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <div class="card-body">
                                    <strong>No se encontraron resultados</strong>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            @if ($historialCreditos->count())
                                <table class="table table-striped table-sm table-responsive-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Embarcación</th>
                                            <th scope="col">Dueño</th>
                                            <th scope="col">Matrícula</th>
                                            <th scope="col">Teléfono</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Precio x Galón</th>
                                            <th scope="col">Galones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                        @foreach ($historialCreditos as $key => $historial)
                                            <?php $total = $total + $historial->galones_credito; ?>
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $historial->nombre_emb }}</td>
                                                <td>{{ $historial->duenio_emb }}</td>
                                                <td>{{ $historial->matricula_emb }}</td>
                                                <td>{{ $historial->telefono_emb }}</td>
                                                <td>{{ $historial->fecha_credito }}</td>
                                                <td>{{ $historial->precio_galon_credito }}</td>
                                                <td>{{ $historial->galones_credito }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>TOTAL:</strong></td>
                                            <td>{{ $total }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <div class="card-body">
                                    <strong>No se encontraron resultados</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
    window.addEventListener('close-modal', event => {

        $('#modalPago').modal('hide');

    });
</script>
<script></script>
