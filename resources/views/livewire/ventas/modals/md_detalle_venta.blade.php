<!-- Modal -->
<div wire:ignore.self class="modal fade" id="detalleVenta" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalle de Venta </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    @if ($detalleVenta->count())
                        <table class="table table-striped table-sm ">
                            <thead class="">
                                <tr>

                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    tr:hover {
                                        background-color: beige;
                                    }
                                </style>
                                @foreach ($detalleVenta as $detalle)
                                    <tr class="bg-success">
                                        <th>USUARIO</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>ID:</th>
                                        <td>{{ $detalle->id_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>E/P:</th>
                                        <td>{{ $detalle->nombre_emb }}</td>
                                    </tr>
                                    <tr>
                                        <th>MATRÍCULA:</th>
                                        <td>{{ $detalle->matricula_emb }}</td>
                                    </tr>
                                    <tr>
                                        <th>TIPO PAGO:</th>
                                        <td>{{ $detalle->nombre_tipo_pago }}</td>
                                    </tr>
                                    <tr>
                                        <th>HORA:</th>

                                        <td>{{ Str::substr($detalle->fecha_venta, 10, 6) . Str::substr($detalle->fecha_venta, 19, 3) }}
                                        </td>

                                    </tr>
                                    <tr class="bg-warning">
                                        <th>VENTA</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>PRODUCTO:</th>
                                        <td>{{ $detalle->nombre_producto }}</td>
                                    </tr>
                                    <tr>
                                        <th>MONEDA:</th>
                                        <td>{{ $detalle->moneda_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>PRECIO X GALÓN:</th>
                                        <td>S/ {{ $detalle->precio_x_galon_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>GALONES:</th>
                                        <td>S/ {{ $detalle->galonaje_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>PAGO:</th>
                                        <td>S/ {{ $detalle->precio_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>OBSERVACIONES:</th>
                                        <td>{{ $detalle->observacion_venta }}</td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <th>REFERENCIA</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>REFERENCIA:</th>
                                        <td>{{ $detalle->nombre_ref_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>DNI:</th>
                                        <td>{{ $detalle->dni_ref_venta }}</td>
                                    </tr>
                                    <tr>
                                        <th>TELEFONO:</th>
                                        <td>{{ $detalle->telefono_ref_venta }}</td>
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

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal -->
