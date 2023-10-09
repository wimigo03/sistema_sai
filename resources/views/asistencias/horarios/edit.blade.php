@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row  font-verdana">
        <div class="col-md-8 titulo">
            <b>Modificar Horario</b>
        </div>
        <div class="col-md-4 text-right">

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.index')}}">
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
        <div class="col-md-6 font-verdana">
            <div class="body-border">
                <form method="POST" action="{{ route('horarios.update', $horario->id) }} ">
                    @csrf
                    @method('PUT')

                    <!-- Campos del formulario -->
                    <div class="form-group col-md-12">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $horario->Nombre }}" required>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="hora_entrada">Hora de entrada</label>
                        <input type="time" name="hora_entrada" class="form-control" value="{{ $horario->hora_entrada }}" required>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="hora_salida">Hora de salida</label>
                        <input type="time" name="hora_salida" class="form-control" value="{{ $horario->hora_salida }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="excepcion">Tiempo de Excepción</label>
                        <input type="time" name="excepcion" class="form-control" value="{{ $horario->excepcion }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="asignado">Asignar a Todos{{$asignados}}</label>
                        <input type="checkbox" name="asignado" value="1" {{$asignados ? 'checked' : '' }} class="form-control">
                    </div>

                    <!-- Botón para actualizar -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
        <div class="col-md-6 text-right">
            Creado en : {{$horario->created_at}} por {{$horario->usuario_creacion}}
        </div>
    </div>
    @endsection