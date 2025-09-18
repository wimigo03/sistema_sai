<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Farmacias de Turno</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <b class="font-verdana-18">FARMACIAS DE TURNO</b>
        </div>

        <div class="card-body">
            @include('farmacias-turno.partials.search')
            @include('farmacias-turno.partials.table')
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.select2').select2({
                    theme: "bootstrap4",
                    placeholder: "--Seleccionar--",
                    width: '100%'
                });

                var cleave = new Cleave('#fecha_i', {
                    date: true,
                    datePattern: ['d', 'm', 'Y'],
                    delimiter: '-'
                });

                $("#fecha_i").datepicker({
                    inline: false,
                    language: "es",
                    dateFormat: "dd-mm-yyyy",
                    autoClose: true
                });

                var cleave = new Cleave('#fecha_f', {
                    date: true,
                    datePattern: ['d', 'm', 'Y'],
                    delimiter: '-'
                });

                $("#fecha_f").datepicker({
                    inline: false,
                    language: "es",
                    dateFormat: "dd-mm-yyyy",
                    autoClose: true
                });
            });

            $('.intro').on('keypress', function(event) {
                if (event.which === 13) {
                    search();
                    event.preventDefault();
                }
            });

            function farmacias(){
                var url = "{{ route('farmacias.index') }}";
                window.location.href = url;
            }

            function create(){
                var url = "{{ route('farmacias.turnos.create') }}";
                window.location.href = url;
            }

            function search(){
                var url = "{{ route('farmacias.turnos.search') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function limpiar(){
                var url = "{{ route('farmacias.turnos.index') }}";
                window.location.href = url;
            }


            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#farmacia_turno_id').val(id);
                // El data-target ya abre el modal; si quieres forzarlo:
                // $('#modalModificar').modal('show');
            });

            // Evitar doble submit
            $('#formModificar').on('submit', function () {
                $('.btn-submit').prop('disabled', true);
            });
        </script>
    @endsection
@endsection
