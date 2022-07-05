@extends('layout.app')

@section('content')
<div class="jumbotron" style=" margin-bottom: 100%">
    <h1 class="display-4">Bienvenidos a Servimar</h1>
    <p class="lead">El sistema dispone de: Gestion de Clientes, Gestión de Productos y Gestión de Ventas</p>
    <hr class="my-4">
    <p>Para iniciar una venta, por favor hacer click debajo</p>
    <p class="lead">
      <a class="btn btn-primary" href="{{ route('admin.ventas.index') }}" role="button">Ir a Ventas</a>
    </p>
  </div>
@endsection
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#tarjeta").remove();
});
</script>
    