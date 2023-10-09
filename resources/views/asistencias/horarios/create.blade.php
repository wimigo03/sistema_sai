@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Agregar Horario</b>
        </div>

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button" aria-label="Cerrar">
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
                <form method="POST" action="{{ route('horarios.store') }}">
                    @csrf

                    <div class="form-group row font-verdana-bg">
                        <!-- Campos del formulario -->
                        <div class="form-group col-md-6">
                            <label for="dia_semana">Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre del Horario" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="excepcion">Tiempo de Excepción</label>
                            <input type="time" name="excepcion" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="hora_entrada">Hora de entrada</label>
                            <input type="time" name="hora_entrada" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="hora_salida">Hora de salida</label>
                            <input type="time" name="hora_salida" class="form-control" required>
                        </div>


                    </div>

                    <div class="form-group row font-verdana-bg">

                        <div class="form-group col-md-6 form-check" >
                            <label for="asignado">Asignar a Todos</label>
                            <input type="checkbox" name="asignado" value="1" class="form-control">
                        </div>
                    </div>

                    <!-- Botón para guardar -->
                    <button type="submit" class="btn btn-success">Guardar</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection