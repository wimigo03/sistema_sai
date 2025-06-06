@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Inventario</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fas fa-warehouse fa-fw"></i>&nbsp;<b class="title-size">INVENTARIO</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.inventario.partials.search')
            @include('almacenes.inventario.partials.table')
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

            $('#unidad_id').select2({
                theme: "bootstrap4",
                placeholder: "--Unidad--",
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

        $('#almacen_id').change(function() {
            var id = $(this).val();
            search();
        });

        $('#partida_presupuestaria_id').change(function() {
            var id = $(this).val();
            search();
        });

        $('#categoria_programatica_id').change(function() {
            var id = $(this).val();
            search();
        });

        $('#unidad_id').change(function() {
            var id = $(this).val();
            search();
        });

        function search(){
            var url = "{{ route('inventario.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('inventario.index') }}";
            window.location.href = url;
        }

        function sucursales(){
            var url = "{{ route('sucursal.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
