<div>


    <div class="card">
        
        @include('livewire.credito.table')

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