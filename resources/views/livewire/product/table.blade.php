<div class="card-header">
    <h3>
        Listado de Productos
    </h3>
    <input wire:model='search' type="text" class="form-control" placeholder="Buscar">
</div>

@if ($productos->count())
    <div class="card-body">
        <div class="card-body">
            <table class="table table-striped table-sm table-responsive-sm">
                <thead>
                    <th>ID</th>
                    <th>Punto</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acción</th>
                    <th>Editar</th>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->id_producto }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->nombre_pro }}</td>
                            <td>{{ $producto->precio_pro }}</td>
                            <td>


                                <span class="badge badge-success">
                                    {{ $producto->stock_pro }} {{ $producto->unidad_pro }}
                                </span>
                            </td>
                            <td class="center-text">
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <button wire:click="modalAdd({{ $producto->id_producto }})" type="button"
                                        class="btn btn-outline-success">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;<strong></strong>
                                    </button>
                                    <button wire:click="modalSub({{ $producto->id_producto }})" type="button"
                                        class="btn btn-outline-secondary">
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>&nbsp;<strong></strong>
                                    </button>

                                </div>
                            </td>
                            <td>
                                <button wire:click="modalEdit({{ $producto->id_producto }})" type="button"
                                    class="btn btn-outline-info">
                                    <i class='fas fa-edit'></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modalUpdateProducto" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> 
                        <span class="badge badge-info">Actualizar {{ $nombre_pro }} - {{$sede}}</span> 
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (count($errors) > 0)
                        <div class="alert border-danger">
                            <p>Se encontraron los siguientes errores:</p>
                            <ul>
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="container">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input wire:model='nombre_pro' type="text" class="form-control" id="exampleInputEmail1"
                                Nombre de abastecimiento>
                        </div>
                        <div class="form-group">
                            <label>Precio</label>
                            <input wire:model='precio_pro' type="number" step="0.1" class="form-control"
                                id="exampleInputEmail1" Nombre de abastecimiento>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click='update_producto' class="btn btn-primary">Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card-body">
        <strong>No se encontraron resultados</strong>
    </div>
@endif
