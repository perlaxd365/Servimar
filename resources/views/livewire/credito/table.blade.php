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
                    <th>Ver </th>
                    <th>Precio por Galones</th>
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
                                        <i class='fa fa-address-card'></i>&nbsp;Créditos
                                    </button>
                                </div>
                            </td>
                            <td class="center-text">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button
                                        wire:click="modalPrecioGalon({{ $cliente->id_cliente }},'{{ $cliente->razon_cli }}')"
                                        type="button" class="btn btn-primary">
                                        <i class='fas fa-dollar-sign'></i>&nbsp;Editar
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
                            <a class="nav-link active" id="pills-home-tab"
                                data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                                aria-selected="true">Créditos Pendientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="pills-profile-tab" data-toggle="pill"
                                href="#pills-profile" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Historial de Créditos
                            </a>
                        </li>
                        @if ($mostrar_edit_precio)
                            <li class="col-md-6 col-md-offset-2">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <b>Actualizar Precio</b>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="number" wire:model='precio_galon_credito_individual_form'
                                                    class="form-control" placeholder="Precio">
                                            </div>
                                            <div class="col-md-2">

                                                <div class="col-md-1">
                                                    <button wire:click="updatePrecioGalonIndivual"
                                                        class="btn btn-primary">Actualizar</button>
                                                </div>
                                                <div class="col-md-1">
                                                    <button wire:click="limpiarPrecioGalonIndividual"
                                                        class="btn btn-danger">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                    <div wire:ignore.self class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">

                            <div id="ok" class="alert alert-success" style="display:none" role="alert">registrado exitosamente! <i class="fa fa-check-circle" aria-hidden="true"></i>
                            </div>
                            @if ($embarcaciones->count())
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Embarcación</th>
                                                <th scope="col">Punto</th>
                                                <th scope="col">Dueño</th>
                                                <th scope="col">Matrícula</th>
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
                                                <?php $monto_credito = $embarcacion->precio_galon_credito * $embarcacion->galones_credito; ?>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $embarcacion->nombre_emb }}</td>
                                                    <td>{{ $embarcacion->user_sede }}</td>
                                                    <td>{{ $embarcacion->duenio_emb }}</td>
                                                    <td>{{ $embarcacion->matricula_emb }}</td>
                                                    <td>{{ $embarcacion->fecha_credito }}</td>
                                                    <td>{{ $embarcacion->precio_galon_credito }}

                                                        &nbsp;
                                                        <a wire:click='editarPrecioIndividual({{ $embarcacion->precio_galon_credito }}, {{ $embarcacion->id_credito }})'
                                                            href="javascript:"><i class='fas fa-pencil-alt text-danger'>
                                                            </i></a>
                                                    </td>
                                                    <td>{{ $embarcacion->galones_credito }}</td>
                                                    <td class="center-text">
                                                        <button
                                                            wire:click="modalPago({{ $embarcacion->id_credito }}, {{ $monto_credito }} )"
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

                                </div>
                            @else
                                <div class="card-body">
                                    <strong>No se encontraron resultados</strong>
                                </div>
                            @endif
                        </div>
                        <!-- TABLA DE HISTORIAL DE PAGOS -->
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            @if ($historialCreditos->count())
                                <div class="table-responsive">

                                    <table class="table table-striped table-sm">
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
                                                <th scope="col">Pago</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $totalGalones = 0;
                                            $totalPago = 0; ?>
                                            @foreach ($historialCreditos as $key => $historial)
                                                <?php $totalGalones = $totalGalones + $historial->galones_credito; ?>
                                                <?php $totalPago = $totalPago + $historial->monto_credito_pagado; ?>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $historial->nombre_emb }}</td>
                                                    <td>{{ $historial->duenio_emb }}</td>
                                                    <td>{{ $historial->matricula_emb }}</td>
                                                    <td>{{ $historial->telefono_emb }}</td>
                                                    <td>{{ $historial->fecha_credito }}</td>
                                                    <td>{{ $historial->precio_galon_credito }}</td>
                                                    <td>{{ $historial->galones_credito }}</td>
                                                    <td>S/{{ $historial->monto_credito_pagado }}</td>
                                                    <td>
                                                        <span class="badge badge-success">
                                                            Pagado
                                                        </span>
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
                                                <td>{{ $totalGalones }}</td>
                                                <td>S/{{ $totalPago }}</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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

    <!-- Modal detalle-->
    <div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalUpdatePrecioGalon" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Embarcaciones
                        <span class="badge badge-primary">
                            {{ $razon_cliente }}
                        </span>
                        &nbsp;
                        |
                        &nbsp;
                        <strong>Actualizacion de Precio x Galón a Créditos</strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <b>Ingresar precio por Galón General</b>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="number" wire:model='precio_galon_credito_form'
                                                    class="form-control" placeholder="Ingresar Precio">
                                            </div>
                                            <div class="col-md-2">
                                                <button wire:click="updatePrecioGalon"
                                                    class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@else
    <div class="card-body">
        <strong>No se encontraron resultados</strong>
    </div>
@endif
