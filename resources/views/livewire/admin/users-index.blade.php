<div>

    <div class="card">
        <div class="card-header">

            @include('livewire.admin.' . $view)
        </div>
    </div>

    <div class="card">
        
        @include('livewire.admin.table')

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
</script>