<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Traspaso de materiales</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="font-verdana-18">TRASPASO DE MATERIALES</b>
        </div>

        <div class="card-body">
            @include('almacenes.traspaso_sucursal.partials.search')
            @include('almacenes.traspaso_sucursal.partials.table')
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

                var cleave = new Cleave('#fecha_registro', {
                    date: true,
                    datePattern: ['d', 'm', 'Y'],
                    delimiter: '-'
                });

                $("#fecha_registro").datepicker({
                    inline: false,
                    dateFormat: "dd-mm-yy",
                    autoClose: true,
                });

                var cleave = new Cleave('#fecha_ingreso', {
                    date: true,
                    datePattern: ['d', 'm', 'Y'],
                    delimiter: '-'
                });

                $("#fecha_ingreso").datepicker({
                    inline: false,
                    dateFormat: "dd-mm-yy",
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
                var url = "{{ route('traspaso.sucursal.create') }}";
                window.location.href = url;
            }

            function search(){
                var url = "{{ route('traspaso.sucursal.search') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function limpiar(){
                var url = "{{ route('traspaso.sucursal.index') }}";
                window.location.href = url;
            }
        </script>
    @endsection
@endsection
