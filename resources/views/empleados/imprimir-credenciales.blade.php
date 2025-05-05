@extends('layouts.dashboard')
<style>
    .rtl-text {
  direction: rtl;
  text-align: right;
}
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>IMPRIMIR CREDENCIALES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('empleados.partials.credenciales-table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            const checkboxes = document.querySelectorAll('.checkbox-item');
            const checkboxGeneral = document.getElementById('checkbox-general');

            checkboxGeneral.addEventListener('change', () => {
            const estado = checkboxGeneral.checked;
                for (const checkbox of checkboxes) {
                    checkbox.checked = estado;
                }
            });
        });

        function search_nro_carnet(){
            let valor = $("#busqueda_nro_carnet").val().toUpperCase();
            if(valor != ""){
                $(".fila").hide();
                $(".nro_carnet").each(function() {
                    let textoCelda = $(this).text().toUpperCase();
                    if(textoCelda.includes(valor)) {
                        $(this).closest('.fila').show();
                    }
                });
            } else {
                $(".fila").show();
            }
        }

        function procesar(){
            var url = "{{ route('empleado.procesar.credenciales') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('empleado.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
