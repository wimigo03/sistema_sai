@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Regularizar Registro de Asistencia</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

    </div>

    @if($registroAsistencia->horario->tipo == 0)
    <div class="body-border ">
        <div class="row">
            <div class="form-group col-md-4 form-check">
                <label for="asignado" id="label1">Biometrico</label>
                <input type="checkbox" name="asignado" id="asignado1" class="form-control" onclick="toggleLabel('label1', 'asignado1', 'registroH_inicio', 'registro_inicio')">
                <input type="time" id="registroH_inicio" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_inicio }}" required>

            </div>
            <div class="form-group col-md-4 form-check">
                <label for="asignado" id="label4">Biometrico</label>
                <input type="checkbox" name="asignado" id="asignado4" class="form-control" onclick="toggleLabel('label4', 'asignado4','registroH_final','registro_final')">
                <input type="time" id="registroH_final" name="registro_final" class="form-control" value="{{ $registroAsistencia->horario->hora_final}}" required>

            </div>
        </div>
        @else
        <div class="row font-verdana">
            <div class=" col-md-6 ">
                <div class="row">
                    <div class="form-group col-md-4 form-check">
                        <label for="asignado">Turno Mañana</label>
                    </div>

                    <div class="form-group col-md-4 form-check">
                        <label for="asignado" id="label1">Biometrico</label>
                        <input type="checkbox" name="asignado" id="asignado1" class="form-control" onclick="toggleLabel('label1', 'asignado1', 'registroH_inicio', 'registro_inicio')">
                        <input type="time" id="registroH_inicio" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_inicio }}" required>

                    </div>

                    <div class="form-group col-md-4 form-check">
                        <label for="asignado" id="label2">Biometrico</label>
                        <input type="checkbox" name="asignado" id="asignado2" class="form-control" onclick="toggleLabel('label2', 'asignado2', 'registroH_salida', 'registro_salida')">
                        <input type="time" id="registroH_salida" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_salida }}" required>

                    </div>

                </div>
            </div>
            <div class="col-md-6 ">
                <div class="row">
                    <div class="form-group col-md-4 form-check">
                        <label for="asignado">Turno Mañana</label>
                    </div>
                    <div class="form-group col-md-4 form-check">
                        <label for="asignado" id="label3">Biometrico</label>
                        <input type="checkbox" name="asignado" id="asignado3" class="form-control" onclick="toggleLabel('label3', 'asignado3','registroH_entrada','registro_entrada')">
                        <input type="time" id="registroH_entrada" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_entrada }}" required>

                    </div>
                    <div class="form-group col-md-4 form-check">
                        <label for="asignado" id="label4">Biometrico</label>
                        <input type="checkbox" name="asignado" id="asignado4" class="form-control" onclick="toggleLabel('label4', 'asignado4','registroH_final','registro_final')">
                        <input type="time" id="registroH_final" name="registro_final" class="form-control" value="{{ $registroAsistencia->horario->hora_final}}" required>

                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Campos del formulario -->
        <div class="row font-verdana">
            <div class="col-md-12 table-responsive center">
                <div class="body-border">

                    <form method="POST" action="{{ route('regularizar_asistencia.update', $registroAsistencia->id) }} " id="actualizarForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group row font-verdana-bg">
                            <div class="form-group col-md-6">
                                <label for="descripcion">Nombres y Apellidos</label>
                                <input type="text" name="descripcion" value="{{ $registroAsistencia->empleado->nombres }} {{$registroAsistencia->empleado->ap_pat}} {{$registroAsistencia->empleado->ap_mat}}" class="form-control" readonly required>
                                <input type="hidden" name="observ" value="Regularizado" class="form-control" readonly>
                                <input type="hidden" name="estado" value="0" class="form-control" readonly>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" class="form-control" value="{{ $registroAsistencia->asistencia->fecha }}" readonly >
                            </div>
                        </div>

                        <div class="form-group row font-verdana-bg">
                            @if($registroAsistencia->registro_inicio)
                            <div class="form-group col-md-6">
                                <label for="registro_inicio">Hora de Inicio</label>
                                <input type="time" id="registro_inicio" name="registro_inicio"   class="form-control" value="" readonly >
                            </div>
                            @else
                            <div class="form-group col-md-6">
                                <label for="registro_inicio">Hora de Inicio</label>
                                <input type="time" id="registro_inicio" name="registro_inicio"  class="form-control"  value="" >
                            </div>
                            @endif
                            @if($registroAsistencia->registro_final)
                            <div class="form-group col-md-6">
                                <label for="registro_final">Hora Final</label>
                                <input type="time" id="registro_final" name="registro_final"  class="form-control"  value="" readonly >
                            </div>
                            @else
                            <div class="form-group col-md-6">
                                <label for="registro_final">Hora Final</label>
                                <input type="time" id="registro_final" name="registro_final" class="form-control" value="" >
                            </div>
                            @endif
                        </div>
                        @if($registroAsistencia->horario->tipo == 0)


                        <div class="form-group row font-verdana-bg">

                        </div>

                        <div class="form-group row font-verdana-bg">
                            <!-- Otros campos del formulario si los hay -->
                        </div>
                        @else
                        <b>DESCANSO:</b>
                        <div class="col-md-12">
                            <hr class="hrr">
                        </div>
                        <div class="form-group row font-verdana-bg">
                            @if($registroAsistencia->registro_salida)
                            <div class="form-group col-md-6">
                                <label for="registro_salida">Hora de salida</label>
                                <input type="time" id="registro_salida" name="registro_salida"  class="form-control" value="" readonly >
                            </div>
                            @else
                            <div class="form-group col-md-6">
                                <label for="registro_salida">Hora de salida</label>
                                <input type="time" id="registro_salida" name="registro_salida"  class="form-control" value="" >
                            </div>
                            @endif
                            @if($registroAsistencia->registro_entrada)
                            <div class="form-group col-md-6">
                                <label for="registro_entrada">Hora de retorno</label>
                                <input type="time" id="registro_entrada" name="registro_entrada"  class="form-control" value="" readonly >
                            </div>
                            @else
                            <div class="form-group col-md-6">
                                <label for="registro_entrada">Hora de retorno</label>
                                <input type="time" id="registro_entrada" name="registro_entrada"  class="form-control" value="" >
                            </div>
                            @endif
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Regularizar</button>
                    </form>

                </div>
            </div>
        </div>


    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarModalLabel">Confirmar Actualización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas actualizar el horario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmarBtn">Confirmar</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Variable para almacenar el valor original de registro_inicio
        var originalRegistroInicioValue = $("#registro_inicio").val();

        function toggleLabel(labelId, checkboxId, sourceInputId, targetInputId) {
            // Obtener el texto original del label
            var originalText = $("#" + labelId).text();

            // Verificar el estado actual del checkbox
            var isChecked = $("#" + checkboxId).prop("checked");

            // Cambiar el texto del label según el estado del checkbox
            $("#" + labelId).text(isChecked ? originalText + " (MANUAL)" : originalText.replace(" (MANUAL)", ""));

            // Obtener el valor del input fuente
            var sourceValue = $("#" + sourceInputId).val();

            // Asignar el valor del input fuente al input destino si el checkbox está marcado
            $("#" + targetInputId).val(isChecked ? sourceValue : originalRegistroInicioValue);
        }
    </script>

    <!-- Agrega este script al final de tu vista Blade -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var confirmarBtn = document.getElementById('confirmarBtn');
            var confirmarModal = new bootstrap.Modal(document.getElementById('confirmarModal'));

            confirmarBtn.addEventListener('click', function() {
                // Simplemente envía el formulario cuando el usuario confirma
                document.forms['actualizarForm'].submit();
                confirmarModal.hide();
            });

            // Agrega un event listener al formulario para evitar el envío directo
            document.forms['actualizarForm'].addEventListener('submit', function(event) {
                event.preventDefault();
                confirmarModal.show();
            });
        });
    </script>

    @endsection