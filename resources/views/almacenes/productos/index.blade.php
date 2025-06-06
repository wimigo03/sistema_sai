@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Materiales</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-list-check fa-fw"></i>&nbsp;<b class="title-size">MATERIALES</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.productos.partials.search')
            @include('almacenes.productos.partials.table')
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#btn-item').removeClass("btn-outline-dark").addClass("btn-dark");
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#unidad_id').select2({
                theme: "bootstrap4",
                placeholder: "--Unidad de Medida--",
                width: '100%'
            });

            $('#partida_presupuestaria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Partida Presupuestaria--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            /*var cleave = new Cleave('#precio', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand'
            });*/
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('producto.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('producto.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function get_unidades(){
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }

        function limpiar(){
            var url = "{{ route('producto.index') }}";
            window.location.href = url;
        }

        function ir_menu(){
            var url = "{{ route('sucursal.configuracion') }}";
            window.location.href = url;
        }
    </script>
@endsection
