<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .div_detalle, .div_cabecera {
        padding: 15px;
        border-radius: 8px;
        background-color: #f1f1f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .div_cabecera {
        margin-bottom: 20px;
    }

    .div_detalle {
        margin-top: 20px;
    }

    .row {
        margin-bottom: 15px;
    }

    .form-control {
        font-size: 14px;
        height: 38px;
    }

    .is-invalid {
        border: 1px solid red;
    }
</style>
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('farmacias.turnos.index') }}"> Farmacias de turno</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Registrar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-plus fa-fw"></i>&nbsp;<b class="font-verdana-16">GENERAR TURNOS </b>
        </div>

        <div class="card-body">
            @include('farmacias-turno.partials.form')
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

            var Modal = function(mensaje){
                $("#modal-alert .modal-body").html(mensaje);
                $('#modal-alert').modal({keyboard: false});
            }

            $('.intro').on('keypress', function(event) {
                if (event.which === 13) {
                    procesar();
                    event.preventDefault();
                }
            });

            function procesar() {
                if(!validar()){
                    return false;
                }

                $('#modal_confirmacion').modal({
                    keyboard: false
                })
            }

            function confirmar(){
                var url = "{{ route('farmacias.turnos.store') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('farmacias.turnos.index') }}";
                window.location.href = url;
            }

            function validar(){
                if($("#fecha_i").val() == ""){
                    Modal("Se debe agregar una <b>[FECHA DE INCIO]</b> para continuar");
                    return false;
                }
                if($("#fecha_f").val() == ""){
                    Modal("Se debe agregar una <b>[FECHA FINAL]</b> para continuar.");
                    return false;
                }
                return true;
            }
        </script>
    @endsection
@endsection
