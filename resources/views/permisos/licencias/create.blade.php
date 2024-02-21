@extends('layouts.admin')

@section('content')
<div class="container font-verdana-bg">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Registrar Solicitud de Licencia Cargo RIP -  (2 DÍAS/AÑO) - Personal de Planta </span>
                    @php
                    use Carbon\Carbon;

                    $fechaCarbon = Carbon::createFromFormat('Y', $licencia->licencia);
                    $fechaEnEspañol = mb_strtoupper($fechaCarbon->locale('es')->isoFormat('MMMM YYYY'), 'UTF-8');

                    @endphp
                    <div class="text-right text-white bg-secondary p-2 rounded">{{$fechaEnEspañol}}</div>


                    <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{ route('licenciaspersonales.index') }}">
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
                    <hr class="hr">
                    <div class="alert alert-info">
                        {{ session('message') }}
                    </div>
                    @endif
                    <hr class="hr">

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('licenciaspersonales.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empleado_id">Nombre:</label>
                                    <input type="hidden" name="licencia_id" value="{{ $licencia->id }}" readonly class="form-control">

                                    <input type="hidden" name="empleado_id" id="empleado_id" value="{{ $empleado->idemp }}" readonly class="form-control">
                                    <input type="text" name="empleado" id="empleado" value="{{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_solicitud">Fecha de Solicitud:</label>
                                    <input type="date" name="fecha_solicitud" id="fecha_solicitud" value="{{ $fechaCarbon->format('Y-m-d') }}" required class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="licencia_id">Asunto:</label>
                                    <input type="text" name="asuntoD" value="Licencia Personal" class="form-control">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duracion">Días por Utilizar:</label>
                                    <select name="duracion" id="duracionSelector" class="form-control" required>
                                        @for ($i = 0; $i <= 24; $i +=12) @php $hours=floor($i / 24); $minutes=$i % 24; $hourLabel=($hours===1) ? 'día' : 'días' ; $minuteLabel=($minutes===1) ? 'mediodía' : 'mediodías' ; $durationText='' ; if ($hours> 0) {
                                            $durationText .= "$hours $hourLabel";
                                            }
                                            if ($hours > 0 && $minutes > 0) {
                                            $durationText .= ' y ';
                                            }
                                            if ($minutes > 0) {
                                            $durationText .= "$minuteLabel";
                                            }
                                            @endphp
                                            <option value="{{ $i }}">{{ $durationText }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asunto">Fraccionamiento:</label>
                                    <select name="asunto" id="asuntoSelector" class="form-control" required>
                                        <option value="">Seleccionar </option>
                                        <option value="Mañana">MAÑANA</option>
                                        <option value="Tarde">TARDE</option>
                                        <option value="Otro">DIA COMPLETO</option>
                                        <!-- Agrega más opciones según sea necesario -->
                                    </select>
                                </div>
                            </div>


                        </div>



                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Crear Registro</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')

<script>
    document.getElementById('duracionSelector').addEventListener('change', function() {
        var duracion = parseInt(this.value);
        var asuntoSelector = document.getElementById('asuntoSelector');

        if (duracion === 24) {
            asuntoSelector.value = 'Otro';
        } else {
            // Opcionalmente, puedes dejar el selector de asunto en blanco
            asuntoSelector.value = '';

            // Opcionalmente, puedes ocultar la opción "Otro" en el selector de asunto
            var optionOtro = asuntoSelector.querySelector('option[value="Otro"]');
            optionOtro.style.display = 'none';
        }
    });
</script>




@endsection
@endsection