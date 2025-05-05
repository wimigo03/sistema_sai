@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PERMISOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('admin.permissions.partials.search')
        @include('admin.permissions.partials.table')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready( function () {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#titulo').select2({
                theme: "bootstrap4",
                placeholder: "--Titulo--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function create(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('permissions.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function procesar(){
            var url = "{{ route('permissions.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('permissions.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
