@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Crear Permiso para Empleado</span>
                    <span class="text-right">{{ $permiso->permiso }}</span>
                    <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{ route('permisospersonales.index') }}">
                        <button class="btn btn-sm btn-danger font-verdana" type="button" aria-label="Cerrar">
                            &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                        </button>
                    </a>
                </div>
                <div class="col-md-12">
                    <!-- Dentro de tu vista -->
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if(session('message'))
                    <div class="alert alert-info">
                        {{ session('message') }}
                    </div>
                    @endif

                    <hr class="hrr">
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('permisospersonales.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empleado_id">Nombre:</label>
                                    <input type="hidden" name="empleado_id" id="empleado_id" value="{{ $empleado->idemp }}" readonly class="form-control">
                                    <input type="text" name="empleado" id="empleado" value="{{ $empleado->nombres }}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_solicitud">Fecha de Solicitud:</label>
                                    <input type="date" name="fecha_solicitud" id="fecha_solicitud" value="{{ date('Y-m-d') }}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permiso_id">Asunto:</label>
                                    <input type="hidden" name="permiso_id" value="{{ $permiso->id }}" readonly class="form-control">
                                    <input type="text" name="asunto" value="Personal" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duracion">Horas Utilizadas:</label>
                                    <select name="duracion" id="duracion" class="form-control" required>
                                        @for ($i = 0; $i <= 120; $i +=30) @php $hours=floor($i / 60); $minutes=$i % 60; $hourLabel=($hours===1) ? 'hora' : 'horas' ; $minuteLabel=($minutes===1) ? 'minuto' : 'minutos' ; $durationText='' ; if ($hours> 0) {
                                            $durationText .= "$hours $hourLabel";
                                            }

                                            if ($hours > 0 && $minutes > 0) {
                                            $durationText .= ' y ';
                                            }

                                            if ($minutes > 0) {
                                            $durationText .= "$minutes $minuteLabel";
                                            }
                                            @endphp
                                            <option value="{{ $i }}">{{ $durationText }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_salida">Hora de Salida:</label>
                                    <input type="time" name="hora_salida_input" id="hora_salida_input" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_retorno">Hora de Retorno:</label>
                                    <input type="time" name="hora_retorno" id="hora_retorno" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="hora_actual" id="hora_salida" value="{{ date('H:i') }}" required class="form-control">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Crear Permiso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para redondear la hora al próximo minuto múltiplo de 5
    function roundToNextMultipleOf5() {
        const currentTime = new Date();
        const minutes = currentTime.getMinutes();
        const remainder = minutes % 5;
        if (remainder !== 0) {
            // Redondea al próximo múltiplo de 5
            const roundedMinutes = minutes + (5 - remainder);
            currentTime.setMinutes(roundedMinutes);
        }
        const formattedTime = currentTime.toTimeString().slice(0, 5); // Formato HH:mm
        document.getElementById('hora_salida_input').value = formattedTime;
    }

    // Llama a la función cuando se carga la página
    window.onload = roundToNextMultipleOf5;

    // Función para actualizar el texto de la duración
    function actualizarTextoDuracion() {
        const duracionSelect = document.getElementById('duracion');
        const duracionText = document.getElementById('duracion_text');

        const selectedOption = duracionSelect.options[duracionSelect.selectedIndex];
        if (selectedOption) {
            const selectedText = selectedOption.text;
            duracionText.textContent = selectedText;
        }
    }

    // Escuchar cambios en el selector de duración
    document.getElementById('duracion').addEventListener('change', actualizarTextoDuracion);

    // Función para calcular la hora de retorno
    function calcularHoraRetorno() {
        const horaSalidaInput = document.getElementById('hora_salida_input');
        const duracionSelect = document.getElementById('duracion');
        const horaRetornoInput = document.getElementById('hora_retorno');

        const horaSalida = new Date(`2023-01-01T${horaSalidaInput.value}`);
        const duracion = parseInt(duracionSelect.value);

        if (!isNaN(duracion)) {
            // Sumar la duración en minutos a la hora de salida
            horaSalida.setMinutes(horaSalida.getMinutes() + duracion);

            // Formatear la hora de retorno como "HH:mm"
            const horaRetorno = horaSalida.toTimeString().slice(0, 5);

            // Establecer el valor en el campo de hora de retorno
            horaRetornoInput.value = horaRetorno;
        }
    }

    // Escuchar cambios en la hora de salida y la duración
    document.getElementById('hora_salida').addEventListener('change', calcularHoraRetorno);
    document.getElementById('duracion').addEventListener('change', calcularHoraRetorno);
</script>

@endsection