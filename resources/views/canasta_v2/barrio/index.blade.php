@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BARRIOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.barrio.partials.search')
        @include('canasta_v2.barrio.partials.table')
        @foreach ($barrios as $datos)
            @include('canasta_v2.barrio.partials.barrio_edit_delete_create')
        @endforeach
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#tipo_add').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#distrito').select2({
                theme: "bootstrap4",
                placeholder: "--Distrito--",
                width: '100%'
            });

            $('#distrito_add').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#dea').select2({
                theme: "bootstrap4",
                placeholder: "--DEA--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar(){
            var url = "{{ route('barrios.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('barrios.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('barrios.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('barrios.create') }}";
        }
    </script>
@endsection
