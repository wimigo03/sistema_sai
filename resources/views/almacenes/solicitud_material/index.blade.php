@extends('layouts.dashboard')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>SOLICITUD DE MATERIALES</strong>
            </div>
        </div>
        @include('almacenes.solicitud_material.partials.search')
        @include('almacenes.solicitud_material.partials.table')
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
                placeholder: "--Unidad Solicitante--",
                width: '100%'
            });

            $('#solicitante_id').select2({
                theme: "bootstrap4",
                placeholder: "--Solicitante--",
                width: '100%'
            });

            $('#programa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Programa--",
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
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('solicitud.material.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('solicitud.material.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('solicitud.material.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
