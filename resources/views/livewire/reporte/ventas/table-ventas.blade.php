<div class="card">
    <div class="card-body row  table-responsive">
        <table id="tabla" class="table table-striped table-sm table-responsive-sm">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>PUNTO</th>
                    <th>OPERARIO</th>
                    <th>E/P</th>
                    <th>MATRÍCULA</th>
                    <th>TIPO PAGO</th>
                    <th>FECHA </th>
                    <th>PRECIO GALÓN</th>
                    <th>GALONES</th>
                    <th>PAGO</th>
                    <th>OBSERVACIÓN</th>
                    <th>VER</th>
                </tr>
            </thead>
            <tbody>
                @if (count($listaBusqueda) > 0)
                    <?php
                    $totalGalones = 0;
                    $totalVenta = 0;
                    $galonesCredito = 0;
                    $galonesEfectivo = 0;
                    $galonesDeposito = 0;
                    //Total de efectivos
                    $total_efectivo_soles = 0;
                    $total_deposito_soles = 0;
                    ?>
                    @foreach ($listaBusqueda as $venta)
                        <?php
                        $totalGalones = $totalGalones + $venta->galonaje_venta;
                        $totalVenta = $totalVenta + $venta->precio_venta;
                        if ($venta->nombre_tipo_pago == 'Credito') {
                            $galonesCredito = $galonesCredito + $venta->galonaje_venta;
                        }
                        if ($venta->nombre_tipo_pago == 'Contado Efectivo') {
                            $total_efectivo_soles = $total_efectivo_soles + $venta->precio_venta;
                            $galonesEfectivo = $galonesEfectivo + $venta->galonaje_venta;
                        }
                        if ($venta->nombre_tipo_pago == 'Contado Deposito') {
                            $total_deposito_soles = $total_deposito_soles + $venta->precio_venta;
                            $galonesDeposito = $galonesDeposito + $venta->galonaje_venta;
                        }
                        ?>
                        <tr>
                            <td>{{ $venta->id_venta }}</td>
                            <td>{{ $venta->user_sede }}</td>
                            <td>{{ $venta->user_create_venta }}</td>
                            <td>{{ $venta->nombre_emb }}<br>({{ $venta->razon_cli }} <br> {{ $venta->duenio_cli }})</td>
                            <td>{{ $venta->matricula_emb }}</td>
                            <td>{{ $venta->nombre_tipo_pago }}</td>
                            <td>{{ $venta->fecha_venta }}
                            </td>
                            <td>
                                <?php
                                if ($venta->nombre_tipo_pago != 'Credito') {
                                    echo 'S/ ' . $venta->precio_x_galon_venta;
                                }
                                ?>

                            </td>
                            <td>{{ $venta->galonaje_venta }}</td>
                            <td NOWRAP>
                                <?php
                                if ($venta->nombre_tipo_pago != 'Credito') {
                                    echo 'S/ ' . $venta->precio_venta;
                                }
                                ?>
                            </td>
                            <td>{{ $venta->observacion_venta }}</td>
                            <td>
                                <button wire:click="modalDetalle({{ $venta->id_venta }})" type="button"
                                    class="btn btn-outline-info" data-toggle="modal" data-target="#detalleVenta">
                                    <i class='fas fa-eye'></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td>
                            <strong>TOTAL EFECTIVO: 
                                <small class="badge badge-success">S/{{ $total_efectivo_soles }}</small>
                            </strong>
                        </td>
                        <td>
                            <strong>TOTAL DEPOSITO: 
                                <small class="badge badge-success">S/{{ $total_deposito_soles }}</small>
                            </strong>
                        </td>
                        <td>
                            <strong>TOTAL GALONES EFECTIVO: 
                                <small class="badge badge-success">{{ $galonesEfectivo }}</small>
                            </strong>
                        </td>
                        <td>
                            <strong>TOTAL GALONES DEPÓSITO: 
                                <small class="badge badge-success">{{ $galonesDeposito }}</small>
                            </strong>
                        </td>
                        <td>
                            <strong>TOTAL GALONES CRÉDITO: 
                                <small class="badge badge-success">{{ $galonesCredito }}</small>
                            </strong>
                        </td>
                        <td></td>
                        <td><strong>TOTAL:</strong></td>
                        <td>{{ $totalGalones }}</td>
                        <td>S/{{ $totalVenta }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @else
                    <tr style="cursor:pointer;">
                        <th colspan="12" style="background-color: bisque" scope="row">No hay resultados</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
