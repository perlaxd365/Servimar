<!-- Modal -->
<div wire:ignore.self class="modal fade" id="detalleVentaJornada" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>

                    <h5 class="modal-title" id="exampleModalLongTitle">Ventas de
                        <mark><b>{{ $usuarioJornada }}</b></mark>
                    </h5>
                    @if ($salida_jonada)

                        @if ($contometro_a != '')
                            <p>Contómetro Final A: <mark style="color: red">{{ $contometro_a }}</mark></p>
                            <p>Contómetro Final B: <mark style="color: red">{{ $contometro_b }}</mark></p>
                        @else
                            <p>Contómetro Final: <mark style="color: red">{{ $contometro_1 }}</mark></p>
                        @endif
                    @else
                        @if ($contometro_a != '')
                            <p>Contómetro inicial A: <mark style="color: red">{{ $contometro_a }}</mark></p>
                            <p>Contómetro inicial B: <mark style="color: red">{{ $contometro_b }}</mark></p>
                        @else
                            <p>Contómetro inicial: <mark style="color: red">{{ $contometro_1 }}</mark></p>
                        @endif
                    @endif
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <div class="">
                    <table class="table table-striped table-sm ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PUNTO</th>
                                <th>OPERARIO</th>
                                <th>CONTÓMETRO</th>
                                <th>E/P</th>
                                <th>TIPO PAGO</th>
                                <th>FECHA </th>
                                <th>PRECIO GALÓN</th>
                                <th>GALONES</th>
                                <th>PAGO</th>
                                <th>OBSERVACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($detalleVentaJornada) > 0)
                                <?php
                                $totalGalones = 0;
                                $totalVenta = 0;
                                $galonesCredito = 0;
                                $galonesEfectivo = 0;
                                ?>
                                @foreach ($detalleVentaJornada as $venta)
                                    <?php
                                    $totalGalones = $totalGalones + $venta->galonaje_venta;
                                    $totalVenta = $totalVenta + $venta->precio_venta;
                                    if ($venta->nombre_tipo_pago == 'Credito') {
                                        $galonesCredito = $galonesCredito + $venta->galonaje_venta;
                                    }
                                    if ($venta->nombre_tipo_pago == 'Contado Efectivo' || $venta->nombre_tipo_pago == 'Contado Deposito') {
                                        $galonesEfectivo = $galonesEfectivo + $venta->galonaje_venta;
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $venta->id_venta }}</td>
                                        <td>{{ $venta->user_sede }}</td>
                                        <td>{{ $venta->user_create_venta }}</td>
                                        <td>
                                            @if ($venta->contometro_a != null)
                                                A: {{ $venta->contometro_a }}
                                                <br>
                                                B: {{ $venta->contometro_b }}
                                            @else
                                                {{ $venta->contometro_1 }}
                                            @endif
                                        </td>
                                        <td>{{ $venta->nombre_emb }}<br>({{ $venta->razon_cli }}{{ $venta->duenio_cli }})
                                        </td>
                                        <td>{{ $venta->nombre_tipo_pago }}</td>
                                        <td>{{ $venta->fecha_venta }}
                                        </td>
                                        <td>S/ {{ $venta->precio_x_galon_venta }}</td>
                                        <td>{{ $venta->galonaje_venta }}</td>
                                        <td NOWRAP>S/ {{ $venta->precio_venta }}</td>
                                        <td>{{ $venta->observacion_venta }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>TOTAL GALONES EFECTIVO O DEPOSITO:</strong></td>
                                    <td>{{ $galonesEfectivo }}</td>
                                    <td><strong>TOTAL GALONES A CRÉDITO:</strong></td>
                                    <td>{{ $galonesCredito }}</td>
                                    <td><strong>TOTAL:</strong></td>
                                    <td>{{ $totalGalones }}</td>
                                    <td>S/{{ $totalVenta }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                <tr style="cursor:pointer;">
                                    <th colspan="12" style="background-color: bisque" scope="row">No hay resultados
                                    </th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal -->
