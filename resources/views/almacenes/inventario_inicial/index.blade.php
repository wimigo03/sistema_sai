<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Inventarios Iniciales</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-scale-balanced fa-fw"></i>&nbsp;<b class="title-size">INVENTARIO INICIAL</b>
            </div>
        </div>

        <div class="row abs-center">
            <div class="col-md-6">
                <div class="card-body">
                    @include('almacenes.inventario_inicial.partials.search')
                    @include('almacenes.inventario_inicial.partials.table')
                </div>
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
                var url = "{{ route('inventario.inicial.create') }}";
                window.location.href = url;
            }

            function search(){
                var url = "{{ route('inventario.inicial.search') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function limpiar(){
                var url = "{{ route('inventario.inicial.index') }}";
                window.location.href = url;
            }
        </script>
    @endsection
@endsection
