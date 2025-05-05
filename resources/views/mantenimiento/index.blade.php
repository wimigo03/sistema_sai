@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MANTENIMIENTOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('mantenimiento.partials.search')
        @include('mantenimiento.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#clasificacion').select2({
                theme: "bootstrap4",
                placeholder: "-- Clasficacion --",
                width: '100%'
            });

            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "-- Procedencia --",
                width: '100%'
            });

            $('#empleado_id').select2({
                theme: "bootstrap4",
                placeholder: "-- Encargado --",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "-- Estado --",
                width: '100%'
            });

            $('#estado_detalle').select2({
                theme: "bootstrap4",
                placeholder: "-- Estado Detalle--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function procesar(){
            var url = "{{ route('mantenimientos.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            window.location.href = "{{ route('mantenimientos.index') }}";
        }

        function create(){
            window.location.href = "{{ route('mantenimientos.create') }}";
        }
    </script>
@endsection
