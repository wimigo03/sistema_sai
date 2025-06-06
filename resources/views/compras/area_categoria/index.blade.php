@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Gestionar areas</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa fa-shop fa-fw"></i>&nbsp;<b class="title-size">
                    GESTIONAR AREAS / {{ $categoria_programatica->codigo }} - {{ $categoria_programatica->nombre }}
                </b>
            </div>
        </div>

        <div class="card-body">
            @include('compras.area_categoria.partials.search')
            @include('compras.area_categoria.partials.table')
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
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
