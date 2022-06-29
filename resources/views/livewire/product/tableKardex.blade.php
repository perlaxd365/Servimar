<div class="card-header">
    <h3>
        Kardex <i class='fas fa-exchange-alt'></i>
    </h3>

    <input wire:model='searchKardex' type="text" class="form-control" placeholder="Buscar">
</div>

@if ($kardexs->count())
    <div class="card-body">
        <div class="card-body">
            <table class="table table-striped table-sm table-responsive-sm">
                <thead>
                    <th>ID</th>
                    <th>Sede</th>
                    <th>Producto</th>
                    <th>Tipo Movimiento</th>
                    <th>Fecha</th>
                    <th>Stock Final</th>
                    <th>Cantidad</th>
                </thead>
                <tbody>
                    @foreach ($kardexs as $kardex)
                        <tr>
                            <td>{{ $kardex->id_kardex }}</td>
                            <td>{{ $kardex->descripcion }}</td>
                            <td>{{ $kardex->nombre_pro }}</td>
                            <td>{{ $kardex->fecha_kardex }}</td>
                            <td>{{ $kardex->nombre_tipo }}</td>
                            <td>{{ $kardex->total_kar }}</td>
                            <td>
                                <?php
                               if($kardex->id_tipo_movimiento == 1 ){
                                echo"<i class='fa fa-plus-square text-success'></i> ";
                               }elseif ($kardex->id_tipo_movimiento == 2) {
                               
                                echo"<i class='fa fa-minus-square text-danger'></i> ";
                               }
                                
                                ?> {{ $kardex->cantidad_kar }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modalStock" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $motivo }} stock a
                        <strong>{{ $nombre_pro }}</strong></h5>
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
                            <label>Cantidad</label>
                            <input wire:model='stock_pro' type="number" Step=".01" class="form-control solo-numero"
                                id="exampleInputEmail1" placeholder="Ingresar Cantidad">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click={{ $motivo }} class="btn btn-primary">{{ $motivo }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer mx-auto">
        {{ $kardexs->links() }}
    </div>
@else
    <div class="card-body">
        <strong>No se encontraron resultados</strong>
    </div>
@endif

<script>
    window.addEventListener('modal', event => {
        var producto = event.detail.producto;
        $('#modalStock').modal('show');

    });
    window.addEventListener('close-modal', event => {

        $('#modalStock').modal('hide');

    });
    $('.solo-numero').keyup(function() {
        this.value = (this.value + '').replace(/[^0-9]/g, '');


    });
</script>
