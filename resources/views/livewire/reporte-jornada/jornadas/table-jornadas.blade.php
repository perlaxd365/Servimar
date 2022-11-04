<div class="card">
    <div class="card-body row  table-responsive">
        <table id="tabla" class="table table-striped ">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>OPERARIO</th>
                    <th>PUNTO</th>
                    <th>ENTRADA</th>
                    <th>SALIDA</th>
                    <th>ESTADO</th>
                    <th>VER VENTAS</th>
                </tr>
            </thead>
            <tbody>
                @if (count($listaBusqueda) > 0)
                    @foreach ($listaBusqueda as $users)
                        <tr>
                            <td>{{ $users->id }}</td>
                            <td>{{ $users->name }}</td>
                            <td>{{ $users->descripcion }}</td>
                            <td>{{ $users->entrada_jornada }}</td>
                            <td>{{ $users->salida_jornada }}</td>
                            <td>
                                @if ($users->estado_jornada)
                                    <span class="badge badge-success">Activo
                                    </span>
                                @else
                                <span class="badge badge-danger">Inactivo
                                </span>
                                @endif
                            </td>
                            <td>
                                <button  type="button"  
                                wire:click="verVentasJornada('{{ $users->name }}', '{{$users->entrada_jornada}}', '{{$users->salida_jornada}}', {{ $users->id_jornada }})"
                                    class="btn btn-outline-info" data-toggle="modal" data-target="#detalleVentaJornada">
                                    <i class='fas fa-eye'></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="cursor:pointer;">
                        <th colspan="12" style="background-color: bisque" scope="row">No hay resultados</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!--  Modal Buscar usuario -->
@include('livewire.reporte-jornada.modals.md-ventas-jornada')
<!-- Fin Modal -->

