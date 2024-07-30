@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>INGRESO DE MATERIALES</strong>
            </div>
        </div>
        @include('compras.ingreso_compra.partials.search')
        @include('compras.ingreso_compra.partials.table')
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

            $('#proveedor_id').select2({
                theme: "bootstrap4",
                placeholder: "--Proveedor--",
                width: '100%'
            });

            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area Solicitante--",
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
