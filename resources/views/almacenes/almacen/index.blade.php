@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item active">Almacenes</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <b class="title-size">ALMACENES</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.almacen.partials.search')
            @include('almacenes.almacen.partials.table')
        </div>
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

            $('#user_id').select2({
                theme: "bootstrap4",
                placeholder: "--Encargado--",
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
            var url = "{{ route('almacen.create') }}";
            window.location.href = url;
        }

        function inventarioGeneral(){
            var url = "{{ route('inventario.index') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('almacen.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('almacen.index') }}";
            window.location.href = url;
        }
    </script>
@stop
