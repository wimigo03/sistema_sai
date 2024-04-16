@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>SOLICITUDES DE COMPRAS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('compras.solicitud_compra.partials.search')
        @include('compras.solicitud_compra.partials.table')
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area--",
                width: '100%'
            });

            $('#solicitante_id').select2({
                theme: "bootstrap4",
                placeholder: "--Solicitante--",
                width: '100%'
            });

            $('#aprobante_id').select2({
                theme: "bootstrap4",
                placeholder: "--Aprobados por--",
                width: '100%'
            });

            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_registro', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_registro").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
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
            var url = "{{ route('solicitud.compra.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('solicitud.compra.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('solicitud.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
