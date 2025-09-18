<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Farmacias</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-notes-medical fa-fw"></i>&nbsp;<b class="font-verdana-18">FARMACIAS</b>
        </div>

        <div class="card-body">
            @include('farmacias.partials.search')
            @include('farmacias.partials.table')
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

            function turnos(){
                var url = "{{ route('farmacias.turnos.index') }}";
                window.location.href = url;
            }

            function create(){
                var url = "{{ route('farmacias.create') }}";
                window.location.href = url;
            }

            function search(){
                var url = "{{ route('farmacias.search') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function limpiar(){
                var url = "{{ route('farmacias.index') }}";
                window.location.href = url;
            }
        </script>
    @endsection
@endsection
