@extends('layouts.dashboard')
<style>
    @keyframes parpadeo {
        0% { background-color: #FFC107; }
        50% { background-color: white; }
        100% { background-color: #FFC107; }
    }

    .parpadear {
        animation: parpadeo 1s infinite;
    }
</style>
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
            $('.options').val('').trigger('change');

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area - Unidad--",
                width: '100%'
            });

            $('#area_asignada_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area Asignada--",
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

            var cleave = new Cleave('#fecha_conclusion_inicio', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            var cleave = new Cleave('#fecha_conclusion_final', {
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

            $("#fecha_conclusion_inicio").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $("#fecha_conclusion_final").datepicker({
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

        function redireccionar(idemp) {
            var input = document.getElementById(idemp);
            var url;

            switch (input.value) {
                case "show":
                    url = '{{ route("empleado.show", ":idemp") }}';
                    url = url.replace(':idemp', idemp);
                    $('.options').val('').trigger('change');
                    window.location.href = url;
                    break;

                case "editar":
                    url = '{{ route("empleado.editar", ":idemp") }}';
                    url = url.replace(':idemp', idemp);
                    $('.options').val('').trigger('change');
                    window.location.href = url;
                    break;

                case "retirar":
                    url = '{{ route("empleado.retirar", ":idemp") }}';
                    url = url.replace(':idemp', idemp);
                    $('.options').val('').trigger('change');
                    window.location.href = url;
                    break;

                case "recontratar":
                    url = '{{ route("empleado.recontratar", ":idemp") }}';
                    url = url.replace(':idemp', idemp);
                    $('.options').val('').trigger('change');
                    window.location.href = url;
                    break;

                case "kardex":
                    url = '{{ route("empleado.pdf.show", ":idemp") }}';
                    url = url.replace(':idemp', idemp);
                    $('.options').val('').trigger('change');
                    window.open(url, '_blank');
                    break;

                case "usuario":
                    url = '{{ route("users._create", ":idemp") }}';
                    url = url.replace(':idemp', idemp);
                    $('.options').val('').trigger('change');
                    window.location.href = url;
                    break;

                default:
                    console.warn("Opción no válida: " + input.value);
                    break;
            }
        }
    </script>
@endsection
