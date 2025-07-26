@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Inventario de Productos</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fas fa-warehouse fa-fw"></i>&nbsp;<b class="title-size">INVENTARIO DE PRODUCTOS</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.inventario_almacen.partials.search')

            @isset($inventarios_almacens)
                @include('almacenes.inventario_almacen.partials.table')
            @endisset
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#almacen_id').select2({
                theme: "bootstrap4",
                placeholder: "--Sucursal--",
                width: '100%'
            });

            $('#categoria_programatica_id').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria Programatica--",
                width: '100%'
            });

            $('#partida_presupuestaria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Partida Presupuestaria--",
                width: '100%'
            });

            $('#producto_id').select2({
                theme: "bootstrap4",
                placeholder: "--Productos--",
                width: '100%'
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function search(){
            var url = "{{ route('inventario.almacen.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('inventario.almacen.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
