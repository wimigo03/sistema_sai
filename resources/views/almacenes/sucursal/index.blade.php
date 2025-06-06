@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Sucursales</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa fa-shop fa-fw"></i>&nbsp;<b class="title-size">SUCURSALES</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.sucursal.partials.search')
            @include('almacenes.sucursal.partials.table')
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
            var url = "{{ route('sucursal.create') }}";
            window.location.href = url;
        }

        function inventarioGeneral(){
            var url = "{{ route('inventario.index') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('sucursal.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('sucursal.index') }}";
            window.location.href = url;
        }

        function inventario_general(){
            var url = "{{ route('inventario.index') }}";
            window.location.href = url;
        }
    </script>
@stop
