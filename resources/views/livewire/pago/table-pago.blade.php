
       <div class="card-header">
            <h3>
                Listado de Clientes
            </h3>
            <input wire:model='searchPago' type="text" class="form-control"
                placeholder="Buscar por cualquier criterio">
        </div>


        @if ($pagos->count())
            <div wire:ignore.self  class="card-body">
                <table class="table table-striped table-sm table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Pagos</th>
                        <th>Acción</th>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr style="cursor: pointer;">
                                <td>{{ $pago->id_pago }}</td>
                                <td>{{ $pago->razon_cli }}</td>
                                <td>{{ $pago->monto_pago }}</td>
                                <td>

                                        <a wire:click='detallePagosModal({{$pago->id_pago}})' class="btn btn-outline-info" data-toggle="modal" data-target="#detallePagos" >
                                            <i class='fa fa-eye'></i>
                                        </a>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer mx-auto">
                {{ $pagos->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No se encontraron resultados</strong>
            </div>
        @endif


<!-- Modal -->
<div wire:ignore.self  data-backdrop="static" data-keyboard="false" class="modal fade" id="detallePagos" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalle de Pagos de </h5>
                <button type="button"  wire:click='defaulPage' class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    @if ($detallePagos->count())
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Pago
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    tr:hover {
                                        background-color: beige;
                                    }
                                </style>
                                @foreach ($detallePagos as $detallePago)
                                    <tr >
                                        <td>
                                            {{ $detallePago->id_detalle_pago }} 
                                        </td>
                                        <td>
                                            S/ {{ $detallePago->monto_detalle_pago }}
                                        </td>
                                        <td>
                                            {{ $detallePago->fecha_pago }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="card-footer container justify-content-center d-inline-flex ">
                            {{ $detallePagos->links() }}
                        </div>
                    @else
                        <div class="card-body">
                            <strong>No se encontraron resultados</strong>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='defaulPage' data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal -->