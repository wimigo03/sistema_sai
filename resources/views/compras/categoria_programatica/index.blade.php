@extends('layouts.admin')
@section('content')
<div class="row abs-center">
    <div class="col-md-8 text-center">
        <div class="card-body">
            <div class="form-group row abs-center font-roboto-18">
                <div class="col-md-12 text-center linea-completa">
                    <strong>CATEGORIAS PROGRAMATICAS</strong>
                </div>
            </div>
            @include('compras.categoria_programatica.partials.search')
            @include('compras.categoria_programatica.partials.table')
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
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
            var url = "{{ route('categoria.programatica.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('categoria.programatica.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('categoria.programatica.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
