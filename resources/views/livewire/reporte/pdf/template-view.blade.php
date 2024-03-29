<style>
    td {
        font-size: x-small
    }

    tr {
        font-size: x-small
    }

    a {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        size: 30%;
        color: black;
    }
</style>
<div class="col-12 clearfix ">
    <span class="float-left">
        <table>
            <tbody>
                <tr>
                    <td width="50%">
                        <img width="140px" src="{{ public_path('vendor/adminlte/dist/img/AdminLTELogo.png') }}"
                            alt="">
                    </td>
                </tr>
            </tbody>
        </table>
    </span>
    <span class="float-right">
        <table>
            <thead>
                <tr>
                    <div class="card" style="width: 15rem; height: 8rem;">
                        <div class="card-header">
                            Registro:
                        </div>
                        <div class="card-body">
                            <strong>USUARIO:</strong> {{ $user }}
                            <strong>FECHA:</strong> {{ $date }}
                        </div>
                    </div>
                </tr>
            </thead>
        </table>
    </span>
</div>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container table-responsive m-0 row justify-content-center col-12">
        <div class="text-center row">

            <div>
                <strong>
                    <p style="font-size: 130%">{{ $title }}</p>
                    @if ($subtitle)
                        <p style="font-size: 110%">({{ $subtitle }})</p>
                    @endif
                </strong>
            </div>
        </div>
        <br>
        <table id="tabla" class="table table-striped table-sm table-responsive-sm">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th>
                    <th>Punto</th>
                    <th>Operario</th>
                    <th>E/P</th>
                    <th>MATRÍCULA</th>
                    <th>TIPO PAGO</th>
                    <th>BANCO</th>
                    <th>FECHA </th>
                    <th>OBSERVACIONES</th>
                    <th>PRECIO GALÓN</th>
                    <th>GALONES</th>
                    <th>PAGO</th>
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
                            <td>
                                @switch($venta->local)
                                    @case($venta->local == 'Gildemeister')
                                        <small class="badge badge-warning">{{ $venta->local }}</small>
                                    @break

                                    @case($venta->local == 'Chata Chimbote')
                                        <small class="badge badge-primary">{{ $venta->local }}</small>
                                    @break

                                    @case($venta->local == 'Chata Paita')
                                        <small class="badge badge-info">{{ $venta->local }}</small>
                                    @break

                                    @case($venta->local == 'Cridany')
                                        <small class="badge badge-danger">{{ $venta->local }}</small>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td>{{ $venta->user_create_venta }}</td>
                            <td>{{ $venta->nombre_emb }} <br> ({{ $venta->razon_cli }} <br> {{ $venta->duenio_cli }})
                            </td>
                            <td>{{ $venta->matricula_emb }}</td>
                            <td>{{ $venta->nombre_tipo_pago }}</td>
                            <td>
                                <small class="badge badge-success">{{ $venta->nombre_banco_venta }}</small>
                                <br>
                                {{ $venta->num_operacion_venta }}
                            </td>
                            <td>{{ $venta->fecha_venta }}</td>
                            <td>{{ $venta->observacion_venta }}</td>
                            <td><?php
                            if ($venta->nombre_tipo_pago != 'Credito') {
                                echo 'S/ ' . $venta->precio_x_galon_venta;
                            }
                            ?></td>


                            <td>
                                <span class="text-info">
                                    <i class="fas fa-caret-down me-1"></i><span>{{ $venta->galonaje_venta }}</span>
                                </span>
                            </td>
                            <td>
                                <span class="text-primary">
                                    <i class="fas fa-caret-up me-1"></i><span>
                                        <?php
                                        if ($venta->nombre_tipo_pago != 'Credito') {
                                            echo 'S/ ' . $venta->precio_venta;
                                        }
                                        ?>
                                    </span>
                                </span>
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
                        <td></td>
                        <td></td>
                        <td><strong>TOTAL:</strong></td>
                        <td>
                            <span class="text-info">
                                <i class="fas fa-caret-down me-1"></i><strong><span>{{ $totalGalones }}</span></strong>
                            </span>
                        </td>
                        <td>
                            <span class="text-primary">
                                <i
                                    class="fas fa-caret-down me-1"></i><strong><span>S/{{ $totalVenta }}</span></strong>
                            </span>
                        </td>
                    </tr>
                @else
                    <tr style="cursor:pointer;">
                        <th colspan="12" style="background-color: bisque" scope="row">No hay resultados</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
