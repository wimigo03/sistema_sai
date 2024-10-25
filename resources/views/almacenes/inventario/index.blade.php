@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>INVENTARIO</strong>
            </div>
        </div>
        @include('almacenes.inventario.partials.search')
        @include('almacenes.inventario.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#almacen_id').select2({
                theme: "bootstrap4",
                placeholder: "--Almacen--",
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
    </script>
@endsection
