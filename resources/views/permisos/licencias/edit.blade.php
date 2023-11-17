@extends('layouts.admin')

@section('content')
<div class="container font-verdana-bg">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Actualizar Registro de Licencia Cargo RIP</span>
                    @php
                    use Carbon\Carbon;

                    $fechaCarbon = Carbon::createFromFormat('Y', $licencia->licencia->licencia);
                    $fechaEnEspañol = mb_strtoupper($fechaCarbon->locale('es')->isoFormat('MMMM YYYY'), 'UTF-8');

                    @endphp
                    <span class="text-right">{{$fechaEnEspañol}}</span> &nbsp;


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
                    <form method="POST" action="{{ route('update.licencia', $licencia->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empleado_id">Nombre:</label>
                                    <input type="hidden" name="licencia_id" value="{{ $licencia->licencia->id }}" readonly class="form-control">

                                    <input type="hidden" name="empleado_id" id="empleado_id" value="{{ $licencia->empleado->idemp }}" readonly class="form-control">
                                    <input type="text" name="empleado" id="empleado" value="{{ $licencia->empleado->nombres }} {{ $licencia->empleado->ap_pat }} {{ $licencia->empleado->ap_mat }}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_solicitud">Fecha de Solicitud:</label>
                                    <input type="date" name="fecha_solicitud" id="fecha_solicitud" value="{{ $licencia->fecha_solicitud }}" required class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="licencia_id">Asunto:</label>
                                    <input type="text" name="asunto" value="Personal" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duracion">Dias por Utilizar:</label>
                                    <select name="duracion" id="duracion" class="form-control" required>
                                        @for ($i = 0; $i <= 24; $i +=12) @php $hours=floor($i / 24); $minutes=$i % 24; $hourLabel=($hours===1) ? 'día' : 'días' ; $minuteLabel=($minutes===1) ? 'mediodia' : 'mediodia' ; $durationText='' ; if ($hours> 0) {
                                            $durationText .= "$hours $hourLabel";
                                            }

                                            if ($hours > 0 && $minutes > 0) {
                                            $durationText .= ' y ';
                                            }

                                            if ($minutes > 0) {
                                            $durationText .= "$minuteLabel";
                                            }
                                            @endphp
                                            <option value="{{ $i }}" {{ (isset($licencia->dias_utilizados) && $i == $licencia->dias_utilizados) ? 'selected' : '' }}>
                                            {{ $durationText }}
                                            @endfor
                                       
                                            </option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-row">


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> Crear Registro</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>

@endsection