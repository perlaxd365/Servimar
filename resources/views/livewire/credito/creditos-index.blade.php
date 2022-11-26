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
    window.addEventListener('respuesta-error', event => {
        let res = event.detail.res;
        Swal.fire({
            type: 'warning',
            title: res,
            showConfirmButton: false,
            timer: 1000
        })
    });
    window.addEventListener('modal-detalle', event => {
        $('#modalDetalleEmbarcacion').modal('show');

    });
    window.addEventListener('modal-precio-galon', event => {
        $('#modalUpdatePrecioGalon').modal('show');

    });
    window.addEventListener('credito-pagado', event => {
        var x = document.getElementById("ok");
        x.style.display = "block";
        setTimeout(function() {
            $("#ok").fadeOut(3000);
        }, 3000);

    });
</script>
