@if (count($listaBusqueda) > 0)
    @foreach ($listaBusqueda as $obj)
        <div class="card">
            <div class="card-body row  table-responsive">
                <div class="jumbotron" style="padding: 1%">
                    <h3 class="display-9">{{ $obj->razon_cli }} {{ $obj->duenio_cli }}</h3>
                    <p class="lead">RUC : {{ $obj->ruc_cli }} </p>
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
                                    ->leftjoin('ventas', 'ventas.id_embarcacion', '=', 'embarcacions.id')
                                    ->where('embarcacions.id_cliente', '=', $obj->id_cliente)
                                    ->where('creditos.estado_credito', '=', true)
                                    ->orderby('creditos.fecha_credito', 'asc')
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
                                @if ($item->nombre_emb != '')
                                    <tr>
                                        <td>{{ $item->nombre_emb }}</td>
                                        <td>{{ $item->user_sede }}</td>
                                        <td>{{ $item->user_create_venta }}</td>
                                        <td>{{ $item->fecha_credito}}</td>
                                        <td>{{ $item->precio_galon_credito }}</td>
                                        <td>{{ $item->galones_credito }}</td>
                                        <td>{{ $item->precio_galon_credito * $item->galones_credito }}</td>
                                    </tr>
                                @endif
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
    <div class="card-header">
        No hay resultados
    </div>
@endif
