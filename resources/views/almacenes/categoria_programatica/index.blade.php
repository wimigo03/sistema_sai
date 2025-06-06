@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Categorias Programaticas</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-bars-staggered fa-fw"></i>&nbsp;<b class="title-size">CATEGORIAS PROGRAMATICAS</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.categoria_programatica.partials.search')
            @include('almacenes.categoria_programatica.partials.table')
        </div>
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
@stop
