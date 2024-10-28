@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>SALIDAS</strong>
            </div>
        </div>
        {{-- @include('almacenes.salidas.partials.search') --}}
        @include('almacenes.salidas.partials.table')
    </div>
@endsection
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
            var url = "{{ route('solicitud.compra.create') }}";
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
