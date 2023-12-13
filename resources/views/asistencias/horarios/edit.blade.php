@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row  font-verdana">
        <div class="col-md-8 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Modificar Horario</b>
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
    </div>

    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center font-verdana">
            <div class="body-border">
                <form method="POST" action="{{ route('horarios.update', $horario->id) }}" id="actualizarForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group row font-verdana-bg">
                        <!-- Campos del formulario -->
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $horario->Nombre }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="excepcion">Tiempo de Excepción</label>
                            <input type="time" name="excepcion" class="form-control" value="{{ $horario->excepcion }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hora_entrada">Hora de Inicio</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" value="{{ $horario->hora_inicio }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="hora_salida">Hora Final</label>
                            <input type="time" id="hora_final" name="hora_final" class="form-control" value="{{ $horario->hora_final }}" required>
                        </div>



                    </div>
                    <b>DESCANZO:</b>
                    <div class="col-md-12">

                        <hr class="hrr">
                    </div>
                    <div class="form-group row font-verdana-bg">
                        <div class="form-group col-md-6">
                            <label for="hora_salida">Hora de salida</label>
                            <input type="time" id="hora_salida" name="hora_salida" class="form-control" value="{{ $horario->hora_salida }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="hora_entrada">Hora de retorno</label>
                            <input type="time" id="hora_entrada" name="hora_entrada" class="form-control" value="{{ $horario->hora_entrada }}">
                        </div>
                    </div>
                    <div class="form-group row font-verdana-bg">
                        <div class="form-group col-md-6">
                            <label for="inicio_jornada">Inicio de Jornada</label>
                            <input type="time" id="inicio_jornada" name="inicio_jornada" value="05:00" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6 form-check">
                            <label for="asignado">Asignar a Todos: </label>
                            <input type="checkbox" name="asignado" value="1" {{$asignados ? 'checked' : '' }} class="form-control success">
                        </div>
                    </div>

                    <!-- Botón para guardar -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
        <div class="col-md-12 text-right">
            Creado en : {{$horario->created_at}} por {{$horario->usuario_creacion}}
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
        // Obtiene los elementos de entrada de hora inicio y hora final
        var horaInicioInput = document.getElementById('hora_inicio');
        var horaFinalInput = document.getElementById('hora_final');
        var horaSalidaInput = document.getElementById('hora_salida');
        var horaEntradaInput = document.getElementById('hora_entrada');

        // Agrega un listener para el evento 'input' en el campo de hora inicio
        horaInicioInput.addEventListener('input', function() {
            // Obtén el valor de la hora de inicio en formato HH:MM
            var horaInicio = horaInicioInput.value;
            var horaSalida = horaSalidaInput.value;

            if (horaInicio && horaSalida === '') {
                // Convierte la hora de inicio en un objeto de fecha
                var fechaHoraInicio = new Date("1970-01-01T" + horaInicio);

                // Suma 8 horas a la hora de inicio
                fechaHoraInicio.setHours(fechaHoraInicio.getHours() + 8);

                // Formatea la nueva hora en HH:MM y colócala en el campo de hora final
                var nuevaHoraFinal = fechaHoraInicio.toTimeString().substring(0, 5);
                horaFinalInput.value = nuevaHoraFinal;
            } else {
                // Borra el campo de hora final si se ingresa una hora en hora_salida
                horaFinalInput.value = '';
            }
        });

        // Agrega un listener para el evento 'input' en el campo de hora salida
        horaSalidaInput.addEventListener('input', function() {
            var horaEntrada = horaEntradaInput.value;
            var horaInicio = horaInicioInput.value;
            var horaSalida = horaSalidaInput.value;

            if (!horaSalidaInput.value || !horaEntradaInput.value) {
                horaFinalInput.value = '';
                horaEntradaInput.value = '';
            }
        });

        horaEntradaInput.addEventListener('input', function() {
            var horaInicio = horaInicioInput.value;
            var horaSalida = horaSalidaInput.value;
            var horaEntrada = horaEntradaInput.value;

            if (horaInicio && horaSalida && horaEntrada) {
                var fechaHoraInicio = new Date("1970-01-01T" + horaInicio);
                var fechaHoraSalida = new Date("1970-01-01T" + horaSalida);

                // Calcula la diferencia en minutos
                var diferenciaMilisegundos = fechaHoraSalida - fechaHoraInicio;
                var minutosDiferencia = (fechaHoraSalida - fechaHoraInicio) / (1000 * 60);

                // Convierte la diferencia en horas y minutos
                var diferenciaHoras = diferenciaMilisegundos / (1000 * 60 * 60);
                var minutosRestantes = minutosDiferencia % 60;

                // Resta 8 horas a la diferencia de horas
                diferenciaHoras = 8 - diferenciaHoras;

                var fechahoraEntrada = new Date("1970-01-01T" + horaEntrada);

                // Añade las horas y minutos calculados a la hora de entrada
                fechahoraEntrada.setHours(fechahoraEntrada.getHours() + diferenciaHoras);
                fechahoraEntrada.setMinutes(fechahoraEntrada.getMinutes() + minutosRestantes);

                // Formatea la nueva hora en HH:MM y colócala en el campo de hora final
                var nuevahoraEntrada = fechahoraEntrada.toTimeString().substring(0, 5);
                horaFinalInput.value = nuevahoraEntrada;
            } else {
                // Borra el campo de hora final si falta alguna de las horas
                horaFinalInput.value = '';
            }
        });
    </script>
    <!-- Agrega este script al final de tu vista Blade -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var confirmarBtn = document.getElementById('confirmarBtn');
            var confirmarModal = new bootstrap.Modal(document.getElementById('confirmarModal'));

            confirmarBtn.addEventListener('click', function() {
                // Simplemente envía el formulario cuando el usuario confirma
                document.forms['actualizarForm'].submit();
            });

            // Agrega un event listener al formulario para evitar el envío directo
            document.forms['actualizarForm'].addEventListener('submit', function(event) {
                event.preventDefault();
                confirmarModal.show();
            });
        });
    </script>

    @endsection