@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar horarios">
                <a href="{{route('horarios.index')}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Agregar Nuevo Horario Laboral</b>
        </div>

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana-sm" type="button" aria-label="Cerrar">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link {{ old('hora_inicio') && old('hora_final')&& old('hora_entrada') && old('hora_salida') || !old('hora_inicio') && !old('hora_final')&& !old('hora_entrada') && !old('hora_salida') ? 'active' : '' }}" data-toggle="tab" href="#tab1">Horario Discontinuo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ old('hora_inicio') && old('hora_final')&& !old('hora_entrada') && !old('hora_salida') ? 'active' : '' }}" data-toggle="tab" href="#tab2">Horario Contínuo</a>
            </li>

        </ul>
    </div>
</div>
<div class="tab-content font-verdana">
    <div class="tab-pane fade {{ old('hora_inicio') && old('hora_final')&& old('hora_entrada') && old('hora_salida') || !old('hora_inicio') && !old('hora_final')&& !old('hora_entrada') && !old('hora_salida') ? 'show active' : '' }}" id="tab1">
        <div class="row font-verdana">
            <hr class="hr">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('horarios.store') }}" id="crearForm">
                            @csrf
                            <div class="row font-verdana-sm">
                                <div class="col-md-6 font-verdana-sm ">
                                    <fieldset class="form-group border p-3">
                                        <legend class="w-auto px-2 font-verdana-bg"><b>DATOS DEL HORARIO</b></legend>

                                        <div class="form-group row font-verdana-sm ">
                                            <!-- Campos del formulario -->
                                            <div class="form-group col-md-6">
                                                <label for="nombre">Nombre de Horario</label>
                                                <input type="text" name="Nombre" class="form-control form-control-sm" value="{{ old('Nombre') }}" placeholder="Ingrese el nombre del Horario" onchange="javascript:this.value=this.value.toUpperCase();" required>
                                                @error('Nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="excepcion">Tiempo de Excepción</label>
                                                <input type="time" name="excepcion" id="excepcion" class="form-control form-control-sm" required value="00:05">
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
                                                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control form-control-sm" value="{{ old('hora_inicio') }}" required>
                                                        @error('hora_inicio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <p id="mensaje_inicio" style="color: red; display: none;">Introducir hora de entrada</p>

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="hora_salida">Hora Salida</label>
                                                        <input type="time" id="hora_salida" name="hora_salida" value="{{ old('hora_salida') }}" class="form-control  form-control-sm" required>
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
                                                        <input type="time" id="hora_entrada" name="hora_entrada" value="{{ old('hora_entrada') }}" class="form-control form-control-sm" required>
                                                        @error('hora_entrada')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="hora_final">Hora Salida</label>
                                                        <input type="time" id="hora_final" name="hora_final" value="{{ old('hora_final') }}" class="form-control form-control-sm" required>
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
                                                <input type="checkbox" name="asignado" value="1" class="form-control form-control-sm">
                                            </div>


                                        </div>
                                        <div class="form-group row font-verdana-sm ">
                                            <div class="col-md-12">
                                                <b>DETALLE DE JORNADA:</b>
                                                <hr class="hrr">
                                                <b>Total Horas:</b> <span id="total_horas"></span>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group row font-verdana-bg">

                                        <div class="form-group col-md-12 text-right">

                                            <!-- Botón para guardar -->
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                        </div>

                                    </div>
                                </div>



                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade  {{ old('hora_inicio') && old('hora_final') && !old('hora_salida') && !old('hora_entrada') ? 'show active' : '' }}" id="tab2">

        <div class="row font-verdana">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('horarios.store') }}" id="crearForm">
                            @csrf
                            <div class="row font-verdana-sm">
                                <div class="col-md-6 font-verdana-sm ">
                                    <fieldset class="form-group border p-3">
                                        <legend class="w-auto px-2 font-verdana-bg"><b>DATOS DEL HORARIO</b></legend>

                                        <div class="form-group row font-verdana-sm ">
                                            <!-- Campos del formulario -->
                                            <div class="form-group col-md-6">
                                                <label for="nombre">Nombre de Horario</label>
                                                <input type="text" name="Nombre" class="form-control form-control-sm" value="{{ old('Nombre') }}" placeholder="Ingrese el nombre del Horario" onchange="javascript:this.value=this.value.toUpperCase();" required>
                                                @error('Nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="excepcion">Tiempo de Excepción</label>
                                                <input type="time" name="excepcion" id="excepcion2" class="form-control form-control-sm" required value="00:05">
                                                <p> (Minutos de tolerancia al marcar entrada)</p>
                                                <p id="mensaje_error_excep2" style="color: red; display: none;">Se restableció el valor. El tiempo ingresado no era válido.</p>

                                            </div>
                                        </div>
                                        <div class="form-group row font-verdana-sm ">
                                            <div class="col-md-12">
                                                <b>HORARIO:</b>
                                                <hr class="hrr">
                                                <div class="form-group row font-verdana-sm">
                                                    <div class="form-group col-md-6">
                                                        <label for="hora_inicio">Hora Entrada</label>
                                                        <input type="time" id="hora_inicio2" name="hora_inicio" class="form-control form-control-sm" value="{{ old('hora_inicio') }}" required>
                                                        @error('hora_inicio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <p id="mensaje_inicio2" style="color: red; display: none;">Introducir hora de entrada</p>

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="hora_final">Hora Salida</label>
                                                        <input type="time" id="hora_final2" name="hora_final" value="{{ old('hora_final') }}" class="form-control form-control-sm" required>
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
                                                <input type="time" id="inicio_jornada2" name="inicio_jornada" value="05:00" class="form-control form-control-sm" required>
                                                <p id="inicio_jornada_am2"></p>
                                                <p id="mensaje_error2" style="color: red; display: none;">Se restableció el valor. El horario ingresado no era válido.</p>

                                            </div>

                                            <div class="form-group col-md-4 form-check">
                                                <label for="sumar_horas">Media Jornada</label>
                                                <input type="checkbox" name="sumar_horas" id="sumar_horas" class="form-control form-control-sm">
                                            </div>


                                            <div class="form-group col-md-4 form-check">
                                                <label for="asignado">Asignar a Todos</label>
                                                <input type="checkbox" name="asignado" value="1" class="form-control form-control-sm">
                                            </div>


                                        </div>
                                        <div class="form-group row font-verdana-sm ">
                                            <div class="col-md-12">
                                                <b>DETALLE DE JORNADA:</b>
                                                <hr class="hrr">
                                                <?php
                                                // Obtener las horas desde el formulario
                                                $horaInicio = old('hora_inicio');
                                                $horaFinal = old('hora_final');

                                                // Convertir las horas a minutos
                                                $minutosInicio = strtotime($horaInicio) / 60;
                                                $minutosFinal = strtotime($horaFinal) / 60;

                                                // Calcular la diferencia en minutos
                                                $diferenciaMinutos = $minutosFinal - $minutosInicio;

                                                // Convertir la diferencia a horas y minutos
                                                $diferenciaHoras = floor($diferenciaMinutos / 60);
                                                $diferenciaMinutosRestantes = $diferenciaMinutos % 60;

                                                // Mostrar la diferencia de horas y minutos
                                                ?>
                                                <b>Total Horas:</b>
                                                <span id="total_horas2" class="{{ $diferenciaHoras <= 0 ? 'text-danger' : '' }}">
                                                    @if ($diferenciaHoras <= 0) Horario no válido @else {{ $diferenciaHoras }} horas {{ $diferenciaMinutosRestantes }} minutos @endif </span>


                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group row font-verdana-bg">

                                        <div class="form-group col-md-12 text-right">

                                            <!-- Botón para guardar -->
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>





<!-- Modal de Confirmación para Creación -->
<div class="modal fade" id="confirmarCrearModal" tabindex="-1" role="dialog" aria-labelledby="confirmarCrearModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarCrearModalLabel">Confirmar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas crear este nuevo horario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarCrearBtn">Confirmar</button>
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

    var horaInicioInput2 = document.getElementById('hora_inicio2');
    var horaFinalInput2 = document.getElementById('hora_final2');
    var mensaje_i_Error = document.getElementById('mensaje_inicio2');


    var horajornadaInput = document.getElementById('sumar_horas');
    var horajornadaInput2 = document.getElementById('sumar_horas');


    // Agrega un listener para el evento 'input' en el campo de hora inicio
    horaInicioInput2.addEventListener('input', function() {
        // Obtén el valor de la hora de inicio en formato HH:MM
        var horaInicio = horaInicioInput2.value;


        if (!horaInicio) {
            // Borra el campo de hora final si se ingresa una hora en hora_salida
            horaFinalInput2.value = '--:--';
            horajornadaInput.checked = false; 

            mensaje_i_Error.style.display = 'block'; // Mostrar mensaje de error


        } else {
            mensaje_i_Error.style.display = 'none'; // Ocultar mensaje de error

            if (horajornadaInput.checked) {
                // Sumar 4 horas cuando el checkbox está marcado
                sumarHoras(4);

            } else {
                // Restablecer las horas cuando el checkbox está desmarcado
                horaFinalInput2.value = '';
                sumarHoras(8);

            }
        }
        // Función para sumar horas al horario
        function sumarHoras(horasASumar) {
            var horaInicio2 = horaInicioInput2.value;
            var fechaHoraInicio2 = new Date("1970-01-01T" + horaInicio2);

            // Suma las horas especificadas
            fechaHoraInicio2.setHours(fechaHoraInicio2.getHours() + horasASumar);

            // Formatea la nueva hora en HH:MM y colócala en el campo de hora final
            var nuevaHoraFinal2 = fechaHoraInicio2.toTimeString().substring(0, 5);
            horaFinalInput2.value = nuevaHoraFinal2;
        }
    });
    horaFinalInput2.addEventListener('input', function() {


        if (horajornadaInput.checked && !horaInicioInput2.value) {
            // Sumar 4 horas cuando el checkbox está marcado
            horaFinalInput2.value = '';
            horajornadaInput.checked = false; 

        }
        
        if (horajornadaInput.checked && horaInicioInput2.value) {
            // Sumar 4 horas cuando el checkbox está marcado
            horaFinalInput2.value = '';
            horajornadaInput.checked = false; 

        }
        if (!horajornadaInput.checked && !horaInicioInput2.value) {
            // Sumar 4 horas cuando el checkbox está marcado
            horaFinalInput2.value = '';
            horajornadaInput.checked = false; 

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

    horajornadaInput2.addEventListener('change', function() {
        if (this.checked) {
            // Sumar 4 horas cuando el checkbox está marcado
            horaFinalInput2.value = '00:00';

            sumarHoras(4);
            sumarHoras2();

        } else {
            // Restablecer las horas cuando el checkbox está desmarcado
            horaFinalInput2.value = '00:00';
            sumarHoras(8);
            sumarHoras2();
        }
        // Función para sumar horas al horario
        function sumarHoras(horasASumar) {
            var horaInicio2 = horaInicioInput2.value;
            var fechaHoraInicio2 = new Date("1970-01-01T" + horaInicio2);

            // Suma las horas especificadas
            fechaHoraInicio2.setHours(fechaHoraInicio2.getHours() + horasASumar);

            // Formatea la nueva hora en HH:MM y colócala en el campo de hora final
            var nuevaHoraFinal2 = fechaHoraInicio2.toTimeString().substring(0, 5);
            horaFinalInput2.value = nuevaHoraFinal2;
        }
    });
</script>

<!-- Agrega este script al final de tu vista Blade para creación de horarios -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var confirmarCrearBtn = document.getElementById('confirmarCrearBtn');
        var confirmarCrearModal = new bootstrap.Modal(document.getElementById('confirmarCrearModal'));

        confirmarCrearBtn.addEventListener('click', function() {
            // Simplemente envía el formulario cuando el usuario confirma
            document.forms['crearForm'].submit();
        });

        // Agrega un event listener al formulario para evitar el envío directo
        document.forms['crearForm'].addEventListener('submit', function(event) {
            event.preventDefault();
            confirmarCrearModal.show();
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
        var inicioJornadaInput = document.getElementById('inicio_jornada2');

        // Obtener el elemento de párrafo para mostrar la hora convertida en formato AM
        var inicioJornadaAM = document.getElementById('inicio_jornada_am2');

        // Obtener el elemento de mensaje de error
        var mensajeError = document.getElementById('mensaje_error2');

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
        excepcionInput2.addEventListener('change', function() {
            // Obtener el valor del tiempo
            var tiempo = this.value.split(':');
            var horas = parseInt(tiempo[0]);
            var minutos = parseInt(tiempo[1]);

            // Calcular el total de minutos
            var totalMinutos = horas * 60 + minutos;

            // Validar si el total de minutos es mayor a 59
            if (totalMinutos > 5) {
                mensajeError2.style.display = 'block'; // Mostrar mensaje de error
                this.value = "00:05"; // Restablecer a un valor válido
            } else {
                mensajeError2.style.display = 'none'; // Ocultar mensaje de error
            }
        });
    });
</script>

<script>
    // Función para calcular la suma de horas
    // Función auxiliar para formatear el tiempo
    function formatTime(hours) {
        var hh = Math.floor(hours);
        var mm = Math.round((hours - hh) * 60);
        return (hh < 10 ? '0' : '') + hh + ':' + (mm < 10 ? '0' : '') + mm;
    }

    function sumarHoras() {
        var horaInicioManana = document.getElementById('hora_inicio').value;
        var horaSalidaManana = document.getElementById('hora_salida').value;
        var horaEntradaTarde = document.getElementById('hora_entrada').value;
        var horaFinalTarde = document.getElementById('hora_final').value;

        // Convertir las horas a objetos de tipo Date
        var fechaInicioManana = new Date('1970-01-01T' + horaInicioManana);
        var fechaSalidaManana = new Date('1970-01-01T' + horaSalidaManana);
        var fechaEntradaTarde = new Date('1970-01-01T' + horaEntradaTarde);
        var fechaFinalTarde = new Date('1970-01-01T' + horaFinalTarde);

        // Calcular la diferencia en milisegundos
        var diferenciaManana = fechaSalidaManana - fechaInicioManana;
        var diferenciaTarde = fechaFinalTarde - fechaEntradaTarde;

        // Calcular la diferencia en horas
        var diferenciaHorasManana = diferenciaManana / 1000 / 60 / 60;
        var diferenciaHorasTarde = diferenciaTarde / 1000 / 60 / 60;



        // Sumar las horas de ambos turnos
        var totalHoras = diferenciaHorasManana + diferenciaHorasTarde;
        if (isNaN(totalHoras)) {
            if (isNaN(diferenciaHorasManana)) {
                document.getElementById('total_horas').innerText = "--";
            } else {
                document.getElementById('total_horas').innerText = formatTime(diferenciaHorasManana);
            }
        } else {
            document.getElementById('total_horas').innerText = formatTime(totalHoras);
        }
        // Mostrar el total en la página
    }

    // Llamar a la función cuando cambien los valores de las horas
    document.getElementById('hora_inicio').addEventListener('change', sumarHoras);
    document.getElementById('hora_salida').addEventListener('change', sumarHoras);
    document.getElementById('hora_entrada').addEventListener('change', sumarHoras);
    document.getElementById('hora_final').addEventListener('change', sumarHoras);
</script>
<script>
    // Función para calcular la suma de horas
    // Función auxiliar para formatear el tiempo
    function formatTime(hours) {
        var hh = Math.floor(hours);
        var mm = Math.round((hours - hh) * 60);
        return (hh < 10 ? '0' : '') + hh + ':' + (mm < 10 ? '0' : '') + mm;
    }

    function sumarHoras2() {
        var horaInicioManana = document.getElementById('hora_inicio2').value;
        var horaFinalTarde = document.getElementById('hora_final2').value;

        // Convertir las horas a objetos de tipo Date
        var fechaInicioManana = new Date('1970-01-01T' + horaInicioManana);
        var fechaFinalTarde = new Date('1970-01-01T' + horaFinalTarde);

        // Calcular la diferencia en milisegundos
        var diferencia = fechaFinalTarde - fechaInicioManana;

        // Calcular la diferencia en horas
        var diferenciaHoras = diferencia / 1000 / 60 / 60;



        // Sumar las horas de ambos turnos
        var totalHoras = diferenciaHoras;
        if (isNaN(totalHoras)) {
            document.getElementById('total_horas2').innerText = "--";
            document.getElementById('total_horas2').classList.add('text-muted'); // Agregar estilo Bootstrap para texto gris
        } else {
            if (totalHoras <= 0) {
                document.getElementById('total_horas2').innerText = "Horario no válido";
                document.getElementById('total_horas2').classList.add('text-danger'); // Agregar estilo Bootstrap para texto rojo
            } else {
                document.getElementById('total_horas2').innerText = formatTime(totalHoras);
                document.getElementById('total_horas2').classList.remove('text-muted', 'text-danger'); // Remover estilos anteriores si existen
            }
        }

        // Mostrar el total en la página
    }

    // Llamar a la función cuando cambien los valores de las horas
    document.getElementById('hora_inicio2').addEventListener('change', sumarHoras2);
    document.getElementById('hora_final2').addEventListener('change', sumarHoras2);
</script>

@endsection