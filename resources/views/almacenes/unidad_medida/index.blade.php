@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Unidades de medida</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fas fa-balance-scale fa-fw"></i>&nbsp;<b class="title-size">UNIDADES DE MEDIDA</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.unidad_medida.partials.search')
            @include('almacenes.unidad_medida.partials.table')
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
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
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('unidad.medida.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('unidad.medida.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function get_productos(){
            var url = "{{ route('producto.index') }}";
            window.location.href = url;
        }

        function limpiar(){
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }

        function ir_menu(){
            var url = "{{ route('sucursal.configuracion') }}";
            window.location.href = url;
        }
    </script>
@endsection
