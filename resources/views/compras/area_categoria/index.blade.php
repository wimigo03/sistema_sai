@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row abs-center font-roboto-14">
            <div class="col-md-12 text-center linea-completa">
                <strong>
                    {{ $categoria_programatica->codigo }}
                    <br>
                    {{ $categoria_programatica->nombre }}
                </strong>
            </div>
        </div>
        @include('compras.area_categoria.partials.search')
        @include('compras.area_categoria.partials.table')
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area o Programa--",
                width: '100%'
            });

            $('#indexAjax').DataTable({
                "processing":true,
                "iDisplayLength": 10,
                "order": [[ 0, "asc" ]],
                language: datatableLanguageConfig
            });
        });

        function procesar(){
            var url = "{{ route('area.categoria.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('categoria.programatica.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
