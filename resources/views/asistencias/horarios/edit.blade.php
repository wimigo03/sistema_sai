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

            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="tipo" id='tipo' class="form-control form-control-sm font-verdana-sm" value="{{ $horario->tipo }}" placeholder="Ingrese el nombre del Horario" required>

                    @if($horario->tipo == 1)
                    <form method="POST" action="{{ route('horarios.update', $horario->id) }}" id="actualizarForm">
                        @csrf
                        @method('PUT')
                        <div class="row font-verdana-sm">
                            <div class="col-md-6 font-verdana-sm ">
                                <fieldset class="form-group border p-3">
                                    <legend class="w-auto px-2 font-verdana-bg"><b>DATOS DEL HORARIO</b></legend>

                                    <div class="form-group row font-verdana-sm ">
                                        <!-- Campos del formulario -->
                                        <div class="form-group col-md-6">

                                            <label for="nombre">Nombre de Horario</label>
                                            <input type="text" name="Nombre" class="form-control form-control-sm font-verdana-sm" value="{{ $horario->Nombre }}" placeholder="Ingrese el nombre del Horario" required>

                                            @error('Nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="excepcion">Tiempo de Excepción</label>
                                            <input type="time" name="excepcion" id="excepcion" class="form-control form-control-sm" required value="{{ $horario->excepcion }}">
                                            <p> (Minutos de tolerancia al marcar entrada)</p>
                                            <p id="mensaje_error_excep" style="color: red; display: none;">Se restableció el valor. El tiempo ingresado no es válido.</p>

                                        </div>
                                    </div>
                                    <div class="form-group row font-verdana-sm ">
                                        <div class="col-md-6">
                                            <b>TURNO MAÑANA:</b>
                                            <hr class="hrr">
                                            <div class="form-group row font-verdana-sm">
                                                <div class="form-group col-md-6">
                                                    <label for="hora_inicio">Hora Entrada</label>
                                                    <input type="time" id="hora_inicio" name="hora_inicio" class="form-control form-control-sm" value="{{ date('H:i', strtotime($horario->hora_inicio)) }}" required>
                                                    @error('hora_inicio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="hora_salida">Hora Salida</label>
                                                    <input type="time" id="hora_salida" name="hora_salida" value="{{ date('H:i', strtotime($horario->hora_salida)) }}" class="form-control  form-control-sm" required>
                                                    @error('hora_salida')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <b>TURNO TARDE:</b>
                                            <hr class="hrr">
                                            <div class="form-group row font-verdana-sm">
                                                <div class="form-group col-md-6">
                                                    <label for="hora_entrada">Hora Entrada</label>
                                                    <input type="time" id="hora_entrada" name="hora_entrada" value="{{ date('H:i', strtotime($horario->hora_entrada)) }}"class="form-control form-control-sm" required>
                                                    @error('hora_entrada')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="hora_final">Hora Salida</label>
                                                    <input type="time" id="hora_final" name="hora_final" value="{{ date('H:i', strtotime($horario->hora_final)) }}"class="form-control form-control-sm" required>
                                                    @error('hora_final')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>



                            <div class="col-md-6">
                                <fieldset class="form-group border p-3">
                                    <legend class="w-auto px-2 font-verdana-bg"><b>OPCIONES:</b></legend>
                                    <hr class="hrr">
                                    <div class="form-group row font-verdana-sm">
                                        <div class="form-group col-md-4">
                                            <label for="inicio_jornada">Inicio de Jornada</label>
                                            <input type="time" id="inicio_jornada" name="inicio_jornada" value="05:00" class="form-control form-control-sm" required>
                                            <p id="inicio_jornada_am"></p>
                                            <p id="mensaje_error" style="color: red; display: none;">Se restableció el valor. El horario ingresado no es válido.</p>

                                        </div>




                                        <div class="form-group col-md-4 form-check">
                                            <label for="asignado">Asignar a Todos</label>
                                            <input type="checkbox" name="asignado" value="1" {{$asignados ? 'checked' : '' }} class="form-control form-control-sm">
                                        </div>


                                    </div>
                                </fieldset>
                                <div class="form-group row font-verdana-bg">

                                    <div class="form-group col-md-12 text-right">
                                        <hr class="hrr">

                                        <!-- Botón para guardar -->
                                        <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                                    </div>

                                </div>
                            </div>



                        </div>

                    </form>
                    @else
                    <form method="POST" action="{{ route('horarios.update', $horario->id) }}" id="actualizarForm">
                        @csrf
                        @method('PUT')
                        <div class="row font-verdana-sm">
                            <div class="col-md-6 font-verdana-sm ">
                                <fieldset class="form-group border p-3">
                                    <legend class="w-auto px-2 font-verdana-bg"><b>DATOS DEL HORARIO</b></legend>

                                    <div class="form-group row font-verdana-sm ">
                                        <!-- Campos del formulario -->
                                        <div class="form-group col-md-6">
                                            <label for="nombre">Nombre de Horario</label>
                                            <input type="text" name="Nombre" class="form-control form-control-sm" value="{{$horario->Nombre }}" placeholder="Ingrese el nombre del Horario" required>
                                            @error('Nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="excepcion">Tiempo de Excepción</label>
                                            <input type="time" name="excepcion" id="excepcion" class="form-control form-control-sm" required value="00:05">
                                            <p> (Minutos de tolerancia al marcar entrada)</p>
                                            <p id="mensaje_error_excep" style="color: red; display: none;">Se restableció el valor. El tiempo ingresado no era válido.</p>

                                        </div>
                                    </div>
                                    <div class="form-group row font-verdana-sm ">
                                        <div class="col-md-12">
                                            <b>HORARIO:</b>
                                            <hr class="hrr">
                                            <div class="form-group row font-verdana-sm">
                                                <div class="form-group col-md-6">
                                                    <label for="hora_inicio">Hora Entrada</label>
                                                    <input type="time" id="hora_inicio" name="hora_inicio" class="form-control form-control-sm" value="{{ date('H:i', strtotime($horario->hora_inicio)) }}" required>
                                                    <p id="mensaje_inicio" style="color: red; display: none;">Introducir hora de entrada</p>
                                                    @error('hora_inicio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="hora_final">Hora Salida</label>
                                                    <input type="time" id="hora_final" name="hora_final" value="{{ date('H:i', strtotime($horario->hora_final)) }}"  class="form-control form-control-sm" required>
                                                    @error('hora_final')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-group border p-3">
                                    <legend class="w-auto px-2 font-verdana-bg"><b>OPCIONES:</b></legend>
                                    <hr class="hrr">
                                    <div class="form-group row font-verdana-sm">
                                        <div class="form-group col-md-4">
                                            <label for="inicio_jornada">Inicio de Jornada</label>
                                            <input type="time" id="inicio_jornada" name="inicio_jornada" value="05:00" class="form-control form-control-sm" required>
                                            <p id="inicio_jornada_am"></p>
                                            <p id="mensaje_error" style="color: red; display: none;">Se restableció el valor. El horario ingresado no era válido.</p>

                                        </div>

                                        <div class="form-group col-md-4 form-check">
                                            <label for="sumar_horas">Media Jornada</label>
                                            <input type="checkbox" name="sumar_horas" id="sumar_horas" class="form-control form-control-sm">
                                        </div>


                                        <div class="form-group col-md-4 form-check">
                                            <label for="asignado">Asignar a Todos</label>
                                            <input type="checkbox" name="asignado" value="1" {{$asignados ? 'checked' : '' }} class="form-control form-control-sm">
                                        </div>


                                    </div>
                                </fieldset>
                                <div class="form-group row font-verdana-bg">

                                    <div class="form-group col-md-12 text-right">
                                        <hr class="hrr">

                                        <!-- Botón para guardar -->
                                        <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    @endif

                </div>
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
                    <button type="button" class="btn btn-success" id="confirmarBtn">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var tipoHorarioInput = document.getElementById('tipo');
        var tipoHorario = tipoHorarioInput.value;

        // Obtiene los elementos de entrada de hora inicio y hora final
        var horaInicioInput = document.getElementById('hora_inicio');
        var horaFinalInput = document.getElementById('hora_final');
        var mensaje_i_Error = document.getElementById('mensaje_inicio');



        if (tipoHorario == '1') {
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
                    horaEntradaInput.value = '';
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




        } else {
            var horaSalidaInput = '';
            var horaEntradaInput = '';
            var horajornadaInput = document.getElementById('sumar_horas');
            // Agrega un listener para el evento 'input' en el campo de hora inicio
            horaInicioInput.addEventListener('input', function() {
                // Obtén el valor de la hora de inicio en formato HH:MM
                var horaInicio = horaInicioInput.value;


                if (!horaInicio) {
                    // Borra el campo de hora final si se ingresa una hora en hora_salida
                    horaFinalInput.value = '--:--';

                    mensaje_i_Error.style.display = 'block'; // Mostrar mensaje de error


                } else {
                    mensaje_i_Error.style.display = 'none'; // Ocultar mensaje de error

                    if (horajornadaInput.checked) {
                        // Sumar 4 horas cuando el checkbox está marcado
                        sumarHoras(4);

                    } else {
                        // Restablecer las horas cuando el checkbox está desmarcado
                        horaFinalInput.value = '';
                        sumarHoras(8);

                    }
                }
            });
            // Agrega un listener para el evento 'input' en el campo de hora salida
            horaFinalInput.addEventListener('input', function() {

               
                if (horajornadaInput.checked && !horaInicioInput.value) {
                    // Sumar 4 horas cuando el checkbox está marcado
                    horaFinalInput.value = '';

                }
                if (!horajornadaInput.checked && !horaInicioInput.value) {
                    // Sumar 4 horas cuando el checkbox está marcado
                    horaFinalInput.value = '';

                }

            });

            document.getElementById('sumar_horas').addEventListener('change', function() {
                if (this.checked) {
                    // Sumar 4 horas cuando el checkbox está marcado
                    sumarHoras(4);

                } else {
                    // Restablecer las horas cuando el checkbox está desmarcado
                    horaFinalInput.value = '';
                    sumarHoras(8);
                }
            });
        }
        // Función para sumar horas al horario
        function sumarHoras(horasASumar) {
            var horaInicio = horaInicioInput.value;
            var fechaHoraInicio = new Date("1970-01-01T" + horaInicio);

            // Suma las horas especificadas
            fechaHoraInicio.setHours(fechaHoraInicio.getHours() + horasASumar);

            // Formatea la nueva hora en HH:MM y colócala en el campo de hora final
            var nuevaHoraFinal = fechaHoraInicio.toTimeString().substring(0, 5);
            horaFinalInput.value = nuevaHoraFinal;
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
            });

            // Agrega un event listener al formulario para evitar el envío directo
            document.forms['actualizarForm'].addEventListener('submit', function(event) {
                event.preventDefault();
                confirmarModal.show();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para convertir la hora a formato AM
            function convertirHoraAM(hora) {
                var partes = hora.split(':');
                var horas = parseInt(partes[0]);
                var minutos = parseInt(partes[1]);

                // Verificar si las partes son números válidos
                if (isNaN(horas) || isNaN(minutos)) {
                    return ""; // Si no son válidos, devolver cadena vacía
                }
                // Si la hora es mayor o igual a 12, es PM, de lo contrario, es AM
                var periodo = (horas >= 12) ? 'PM' : 'AM';

                // Si es mayor que 12, convertir a formato de 12 horas
                if (horas > 12) {
                    horas -= 12;
                }

                return horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0') + ' ' + periodo;
            }

            // Obtener el elemento de entrada de inicio de jornada
            var inicioJornadaInput = document.getElementById('inicio_jornada');

            // Obtener el elemento de párrafo para mostrar la hora convertida en formato AM
            var inicioJornadaAM = document.getElementById('inicio_jornada_am');

            // Obtener el elemento de mensaje de error
            var mensajeError = document.getElementById('mensaje_error');

            // Agregar un evento de cambio al campo de entrada
            inicioJornadaInput.addEventListener('input', function() {
                // Obtener el valor de la hora
                var hora = this.value;

                // Validar si la hora es mayor a "05:00"
                if (hora > "05:00") {
                    this.value = "05:00";
                    mensajeError.style.display = 'block'; // Mostrar mensaje de error
                } else {
                    mensajeError.style.display = 'none'; // Ocultar mensaje de error
                }

                // Convertir la hora a formato AM
                var horaAM = convertirHoraAM(this.value);

                // Mostrar la hora convertida
                inicioJornadaAM.textContent = 'Hora en formato AM: ' + horaAM;
            });

            // Ejecutar la conversión inicial al cargar la página
            var horaInicial = inicioJornadaInput.value;
            inicioJornadaAM.textContent = 'Hora en formato AM: ' + convertirHoraAM(horaInicial);
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento de entrada de excepción
            var excepcionInput = document.getElementById('excepcion');
            var excepcionInput2 = document.getElementById('excepcion2');

            // Obtener el elemento de mensaje de error
            var mensajeError = document.getElementById('mensaje_error_excep');
            var mensajeError2 = document.getElementById('mensaje_error_excep2');

            // Agregar un evento de cambio al campo de entrada
            excepcionInput.addEventListener('input', function() {
                // Obtener el valor del tiempo
                var tiempo = this.value.split(':');
                var horas = parseInt(tiempo[0]);
                var minutos = parseInt(tiempo[1]);

                // Calcular el total de minutos
                var totalMinutos = horas * 60 + minutos;

                // Validar si el total de minutos es mayor a 59
                if (totalMinutos > 5) {
                    mensajeError.style.display = 'block'; // Mostrar mensaje de error
                    this.value = "00:05"; // Restablecer a un valor válido
                } else {
                    mensajeError.style.display = 'none'; // Ocultar mensaje de error
                }
            });

        });
    </script>


    @endsection