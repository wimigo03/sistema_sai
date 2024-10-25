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
        @include('compras.categoria_presupuestaria.partials.search')
        @include('compras.categoria_presupuestaria.partials.table')
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#partida_presupuestaria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Partida Presupuestaria--",
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
            var url = "{{ route('categoria.presupuestaria.store') }}";
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
