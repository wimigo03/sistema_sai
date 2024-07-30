@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>ALMACENES</strong>
            </div>
        </div>
        @include('almacenes.almacen.partials.search')
        @include('almacenes.almacen.partials.table')
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
@endsection
