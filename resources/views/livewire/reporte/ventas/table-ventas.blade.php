<div class="card">
    <div class="card-body row  table-responsive">
        <table id="tabla" class="table table-striped ">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Punto</th>
                    <th>Operario</th>
                    <th>E/P</th>
                    <th>MATRÍCULA</th>
                    <th>TIPO PAGO</th>
                    <th>FECHA </th>
                    <th>PRECIO GALÓN</th>
                    <th>GALONES</th>
                    <th>PAGO</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @if (count($listaBusqueda) > 0)
                    <?php $totalGalones = 0;
                    $totalVenta = 0; ?>
                    @foreach ($listaBusqueda as $venta)
                        <?php $totalGalones = $totalGalones + $venta->galonaje_venta; ?>
                        <?php $totalVenta = $totalVenta + $venta->precio_venta; ?>
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
                            <td>S/ {{ $venta->precio_venta }}</td>
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
                        <td></td>
                        <td></td>
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
