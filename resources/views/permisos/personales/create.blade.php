@extends('layouts.admin')

@section('content')
<div class="container font-verdana-bg">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center font-verdana-bg titulo">
                    <span class="mr-auto">REGISTRAR PERMISO PERSONAL</span>
                    @php
                    use Carbon\Carbon;

                    $fechaCarbon = Carbon::createFromFormat('Y-m', $permiso->mes);
                    $fechaEnEspañol = mb_strtoupper($fechaCarbon->locale('es')->isoFormat('MMMM YYYY'), 'UTF-8');

                    @endphp
                    <span class="text-right">{{$fechaEnEspañol}}</span> &nbsp;

                    <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{ route('permisospersonales.index') }}">
                        <button class="btn btn-sm btn-danger font-verdana" type="button" aria-label="Cerrar">
                            &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                        </button>
                    </a>
                </div>
                <div class="col-md-12">
                    <!-- Dentro de tu vista -->
                    @if(session('success'))
                    <hr class="hr">

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <hr class="hr">

                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if(session('message'))

                    <div class="alert alert-info">
                        {{ session('message') }}
                    </div>
                    @endif

                    <hr class="hr">
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('permisospersonales.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empleado_id"><b>Nombres y Apellidos:</b></label>
                                    <input type="hidden" name="permiso_id" value="{{ $permiso->id }}" readonly class="form-control">

                                    <input type="hidden" name="empleado_id" id="empleado_id" value="{{ $empleado->idemp }}" readonly class="form-control">
                                    <input type="text" name="empleado" id="empleado" value="{{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_solicitud"><b>Fecha de Solicitud:</b></label>

                                    @php
                                    $fechaInicioMes = $permiso->mes . '-01'; // Agregar el día 01 al mes seleccionado
                                    $fechaCarbon = \Carbon\Carbon::createFromFormat('Y-m-d', $fechaInicioMes);

                                    $fechaFinalMes = $fechaCarbon->endOfMonth();

                                    @endphp
                                   
                                    <input type="date" name="fecha_solicitud" id="fecha_solicitud" min="{{$fechaInicioMes}}" max="{{ $fechaFinalMes->format('Y-m-d') }}" value="{{ old('fecha_solicitud') }}" required class="form-control">

                                    @if(session('fecha'))
                                    <span class="text-danger"> {{ session('fecha') }}</span>


                                    @endif
                                    @error('fecha_solicitud')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permiso_id"><b>Motivo:</b></label>
                                    <input type="text" name="asunto" value="Personal" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duracion"><b>Tiempo Solicitado:</b></label>

                                    <select name="duracion" id="duracion" class="form-control" required>
                                        <option value="">Seleccione el Tiempo</option>

                                        @for ($i = 30; $i <= $disponible; $i +=30) @php $hours=floor($i / 60); $minutes=$i % 60; $hourLabel=($hours===1) ? 'hora' : 'horas' ; $minuteLabel=($minutes===1) ? 'minuto' : 'minutos' ; $durationText='' ; if ($hours> 0) {
                                            $durationText .= "$hours $hourLabel";
                                            }

                                            if ($hours > 0 && $minutes > 0) {
                                            $durationText .= ' y ';
                                            }

                                            if ($minutes > 0) {
                                            $durationText .= "$minutes $minuteLabel";
                                            }
                                            @endphp

                                            <option value="{{ $i }}" @if(old('duracion')==$i) selected @endif>{{ $durationText }}</option>
                                            @endfor

                                    </select>



                                    @if(session('horas'))
                                    <span class="text-danger"> {{ session('horas') }}</span>


                                    @endif
                                </div>


                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_salida"><b>Hora de Salida:</b></label>
                                    <input type="time" name="hora_salida_input" value="{{old('hora_salida_input')}}" id="hora_salida_input" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_retorno"><b>Hora de Retorno:</b></label>
                                    <input type="time" name="hora_retorno" id="hora_retorno" value="{{old('hora_retorno')}}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="hora_actual" id="hora_salida" value="{{ date('H:i') }}" required class="form-control" readonly>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success">REGISTRAR PERMISO</b></button>
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