@extends('layouts.admin')
@section('content')
<div class="card-body">
    <div class="form-group row font-roboto-20">
        <div class="col-md-12 text-center linea-completa">
            <strong>ORDENES DE COMPRA - MATERIAL</strong>
        </div>
    </div>
    @include('compras.orden_compra.partials.search')
    @include('compras.orden_compra.partials.table')
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

            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Unidad Solicitante--",
                width: '100%'
            });

            $('#proveedor_id').select2({
                theme: "bootstrap4",
                placeholder: "--Proveedor--",
                width: '100%'
            });

            $('#solicitante_id').select2({
                theme: "bootstrap4",
                placeholder: "--Solicitante--",
                width: '100%'
            });




            var cleave = new Cleave('#fecha_registro', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_registro").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('orden.compra.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('orden.compra.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('orden.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
