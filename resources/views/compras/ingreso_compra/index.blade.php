@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>INGRESOS POR COMPRAS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('compras.ingreso_compra.partials.search')
        @include('compras.ingreso_compra.partials.table')
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#almacen_id').select2({
                theme: "bootstrap4",
                placeholder: "--Almacen--",
                width: '100%'
            });

            $('#proveedor_id').select2({
                theme: "bootstrap4",
                placeholder: "--Proveedor--",
                width: '100%'
            });

            $('#categoria_programatica_id').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria Programatica--",
                width: '100%'
            });

            $('#programa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Programa--",
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

        function search(){
            var url = "{{ route('ingreso.compra.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('ingreso.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
