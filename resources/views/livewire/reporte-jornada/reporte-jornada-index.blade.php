<div>


    <div class="card">
        
        @include('livewire.reporte-jornada.jornadas.reporte-jornadas')
 
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
    window.addEventListener('error', event => {
        let res = event.detail.res;
        Swal.fire({
            type: 'warning',
            title: res,
            showConfirmButton: false,
            timer: 2000
        })
    });
 </script>