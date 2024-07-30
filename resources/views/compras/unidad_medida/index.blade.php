@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>UNIDADES DE MEDIDA</strong>
            </div>
        </div>
            @include('compras.unidad_medida.partials.search')
            @include('compras.unidad_medida.partials.table')
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

        function get_items(){
            var url = "{{ route('item.index') }}";
            window.location.href = url;
        }

        function limpiar(){
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
