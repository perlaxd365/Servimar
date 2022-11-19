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
                    <div class="card" style="width: 13rem; height: 7rem;">
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
    <div class="table-responsive m-0 row justify-content-center col-12">
        <div class="text-center row">

            <div>
                <strong>
                    <p style="font-size: 130%">{{ $title }}</p>
                </strong>
            </div>
        </div>
        <br>
        @if (count($listaBusqueda) > 0)
            @foreach ($listaBusqueda as $obj)
                <div class="card">
                    <div class="card-body row  table-responsive">
                        <div class="jumbotron" style="padding: 1%">
                            <h3 class="display-9">{{ $obj->razon_cli }} {{ $obj->duenio_cli }}</h3>
                            <h6 class="lead">RUC : {{ $obj->ruc_cli }} </h6>
                            <hr class="my-4">
                            <table id="tabla" class="table table-striped table-sm table-responsive-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>E/P</th>
                                        <th>PUNTO</th>
                                        <th>OPERADOR</th>
                                        <th>FECHA</th>
                                        <th>PRECIO X GALÓN</th>
                                        <th>GALONES</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        
                                        $creditos = DB::table('creditos')
                                            ->select(DB::raw('*'))
                                            ->join('embarcacions', 'embarcacions.id', '=', 'creditos.id_embarcacion')
                                            ->rightjoin('ventas', 'embarcacions.id', '=', 'ventas.id_embarcacion')
                                            ->where('embarcacions.id_cliente', '=', $obj->id_cliente)
                                            ->where('creditos.estado_credito', '=', true)
                                            ->orderby('embarcacions.id_cliente', 'asc')
                                            ->groupby('id_credito')
                                            ->get();
                                        $total = 0;
                                        $total_galones = 0;
                                    @endphp
                                    @foreach ($creditos as $item)
                                        @php
                                            $total_galones = $total_galones + $item->galones_credito;
                                            $total = $total + $item->precio_galon_credito * $item->galones_credito;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->nombre_emb }}</td>
                                            <td>{{ $item->user_sede }}</td>
                                            <td>{{ $item->user_create_venta }}</td>
                                            <td>{{ $item->fecha_venta }}</td>
                                            <td>{{ $item->precio_galon_credito }}</td>
                                            <td>{{ $item->galones_credito }}</td>
                                            <td>{{ $item->precio_galon_credito * $item->galones_credito }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>TOTAL :</b></td>
                                        <td><b>{{ $total_galones }}</b></td>
                                        <td><b>{{ $total }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <tr style="cursor:pointer;">
                <th colspan="12" style="background-color: bisque" scope="row">No hay resultados</th>
            </tr>
        @endif
    </div>
</body>

</html>
