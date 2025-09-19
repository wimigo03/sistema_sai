<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Farmacias</li>
@endsection
<style>
    .img-hover-zoom {
        transition: transform 0.3s ease; /* animación suave */
        cursor: pointer;                /* para indicar que se puede interactuar */
    }

    .img-hover-zoom:hover {
        transform: scale(2.5);          /* zoom razonable */
        z-index: 999;                   /* para que quede por encima de otros elementos */
        position: relative;             /* ayuda a que z-index funcione */
    }

    .img-rounded {
        border-radius: 8px; /* ajusta el valor: 8px = leve, 50% = círculo */
    }
</style>
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
