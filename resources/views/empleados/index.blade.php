@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PERSONAL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('empleados.partials.search')
        @include('empleados.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area--",
                width: '100%'
            });

            $('#file_id').select2({
                theme: "bootstrap4",
                placeholder: "--Cargo--",
                width: '100%'
            });

            $('#escala_salarial_id').select2({
                theme: "bootstrap4",
                placeholder: "--Escala Salarial--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_ingreso', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            var cleave = new Cleave('#fecha_retiro', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_ingreso").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $("#fecha_retiro").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            $('#sexo').select2({
                theme: "bootstrap4",
                placeholder: "--Sexo--",
                width: '100%'
            });

            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('empleado.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('empleado.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('empleado.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('empleado.index') }}";
            window.location.href = url;
        }

        function imprimir_credenciales(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('empleado.imprimir.credenciales',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }
    </script>
@endsection
