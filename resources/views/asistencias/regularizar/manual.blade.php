@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Regularizar Registro de Asistencia</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('ausencias.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>

    <!-- Campos del formulario -->
    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <div class="body-border">
          
                <form method="POST" action="{{ route('regularizar_asistencia.update', $registroAsistencia->id) }}">
                    @csrf
                    @method('PUT')
               
                    <div class="form-group row font-verdana-bg">
                        <div class="form-group col-md-6">
                            <label for="descripcion">Nombres y Apellidos</label>
                            <input type="text" name="descripcion" value="{{ $registroAsistencia->empleado->nombres }}" class="form-control" readonly required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" class="form-control" value="{{ $registroAsistencia->asistencia->fecha }}" readonly required>
                        </div>
                    </div>

                    <div class="form-group row font-verdana-bg">
                        @if($registroAsistencia->registro_inicio)
                        <div class="form-group col-md-6">
                            <label for="registro_inicio">Hora de Inicio</label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control" value="{{ $registroAsistencia->registro_inicio }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_inicio">Hora de Inicio</label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control" value="{{ $registroAsistencia->horario->horario_inicio }}" readonly required>
                        </div>
                        @endif
                        @if($registroAsistencia->registro_final)
                        <div class="form-group col-md-6">
                            <label for="registro_final">Hora Final</label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control" value="{{ $registroAsistencia->registro_final }}" required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_final">Hora Final</label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control" value="{{ $registroAsistencia->horario->hora_final }}" required>
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
                            <input type="time" id="registro_salida" name="registro_salida" class="form-control" value="{{ $registroAsistencia->registro_salida }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_salida">Hora de salida</label>
                            <input type="time" id="registro_salida" name="registro_salida" class="form-control" value="{{ $registroAsistencia->horario->hora_salida }}" required>
                        </div>
                        @endif
                        @if($registroAsistencia->registro_entrada)
                        <div class="form-group col-md-6">
                            <label for="registro_entrada">Hora de retorno</label>
                            <input type="time" id="registro_entrada" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->registro_entrada }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_entrada">Hora de retorno</label>
                            <input type="time" id="registro_entrada" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_entrada }}" required>
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

</div>

@endsection