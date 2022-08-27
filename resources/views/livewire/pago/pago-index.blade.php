<div class="row">


    <div class="card col-md-6">
        
        @include('livewire.pago.create-pago')

    </div>
    <div class="card col-md-6">
        
        @include('livewire.pago.table-pago')

    </div>


</div>

<script type="text/javascript">
    window.addEventListener('respuesta', event => {
        let res = event.detail.res;
        Swal.fire({
            type: 'success',
            title: res,
            showConfirmButton: false,
            timer: 2000
        })
    });
    window.addEventListener('modal-detalle', event => {
        $('#modalDetalleEmbarcacion').modal('show');

    });
</script>