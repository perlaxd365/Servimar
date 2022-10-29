@extends('layout.app')

@section('content')
    <link rel="stylesheet" type="text/css"
        href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <div class="jumbotron" style=" margin-bottom: 100%">
        <h1 class="display-4">Bienvenidos a Servimar</h1>
        <p class="lead">El sistema dispone de: Gestion de Clientes, Gestión de Productos y Gestión de Ventas</p>
        <hr class="my-4">
        <p>Para iniciar una venta, por favor hacer click debajo</p>
        <p class="lead">
            <a class="btn btn-primary" href="{{ route('admin.ventas.index') }}" role="button">Ir a Ventas</a>
        </p>
        
        @can('admin.users.index')
            <div class="grey-bg container-fluid">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-12 mt-3 mb-1">
                            <h4 class="text-success">Estado actual de los puntos</h4>
                            <p>Puntos, Galones y Contómetro</p>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $productos = DB::table('products')
                                ->select(DB::raw('*'))
                                ->join('sedes', 'sedes.id_sede', 'products.id_sede')
                                ->groupby('products.id_producto')
                                ->get();
                        @endphp
                        @foreach ($productos as $item)
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="align-self-center">
                                                    <i class="icon-graph success successfloat-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3>{{ $item->descripcion }}</h3>
                                                    <small class="text-warning">Galones:
                                                    </small><span>{{ $item->stock_pro }}</span>
                                                    <br>
                                                    @php
                                                        $contometro = DB::select('select * from contometros where id_sede = ' . $item->id_sede . ' order by id_contometro desc limit 1 ');
                                                        
                                                    @endphp
                                                    @foreach ($contometro as $contometros)
                                                        @if ($item->id_sede == 4)
                                                            <small>Contómetro: </small><small
                                                                class="text-success">{{ $contometros->contometro_a }}</small> |
                                                            <small class="text-info">{{ $contometros->contometro_b }}</small>
                                                        @else
                                                            <small>Contómetro: </small><small
                                                                class="text-success">{{ $contometros->contometro_1 }}</small>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

            </div>
        @endcan
    </div>
    
@endsection

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#tarjeta").remove();
    });
</script>
