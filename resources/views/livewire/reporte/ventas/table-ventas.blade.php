<div class="card">
    <div class="card-body row  table-responsive">
        <table id="tabla" class="table table-striped ">
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
                    <?php $totalGalones = 0;
                    $totalVenta = 0;
                    $galonesCredito = 0;
                    $galonesEfectivo = 0;
                    ?>
                    @foreach ($listaBusqueda as $venta)
                        <?php $totalGalones = $totalGalones + $venta->galonaje_venta;
                        $totalVenta = $totalVenta + $venta->precio_venta;
                        if ($venta->nombre_tipo_pago == 'Credito') {
                            $galonesCredito=$galonesCredito+$venta->galonaje_venta;
                        }
                        if ($venta->nombre_tipo_pago == 'Contado Efectivo' || $venta->nombre_tipo_pago == 'Contado Deposito') {
                            $galonesEfectivo=$galonesEfectivo+$venta->galonaje_venta;
                        }
                        ?>
                        <tr>
                            <td>{{ $venta->id_venta }}</td>
                            <td>{{ $venta->user_sede }}</td>
                            <td>{{ $venta->user_create_venta }}</td>
                            <td>{{ $venta->nombre_emb }}</td>
                            <td>{{ $venta->matricula_emb }}</td>
                            <td>{{ $venta->nombre_tipo_pago }}</td>
                            <td>{{ $venta->fecha_venta }}
                            </td>
                            <td>S/ {{ $venta->precio_x_galon_venta }}</td>
                            <td>{{ $venta->galonaje_venta }}</td>
                            <td NOWRAP>S/ {{ $venta->precio_venta }}</td>
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
                        <td></td>
                        <td></td>
                        <td><strong>TOTAL GALONES EFECTIVO O DEPOSITO:</strong></td>
                        <td>{{$galonesEfectivo}}</td>
                        <td><strong>TOTAL GALONES A CRÉDITO:</strong></td>
                        <td>{{$galonesCredito}}</td>
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
