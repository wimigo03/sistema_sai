@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">

        <div class="col-md-3 offset-md-3 titulo">
            <b>Modificar Horario Programado</b>
            <i class=aria-hidden="true"></i>
        </div>
        <div class="col-md-3 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.fechas')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button" aria-label="Cerrar">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>


        <div class="col-md-6 offset-md-3">
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-6 offset-md-3">

            <div class="body-border">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Mostrar mensajes de error -->
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{ route('asistencia.update', $asistencia->id ) }}" method="POST" id="actualizarForm">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{$asistencia->fecha }}" readonly required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="area">Horario:</label>
                                <select name="horario_id" id="horarios" required class="form-control">
                                    <option value=""></option>

                                    @php
                                    // Ordenar la colección de horarios por hora de inicio
                                    $horarios = $horarios->sortBy('hora_inicio');
                                    @endphp

                                    @foreach ($horarios as $index => $value)
                                    <option value="{{ $value->id }}">

                                        @if ($value->hora_inicio)
                                        {{ date('h:i A', strtotime($value->hora_inicio)) }} -
                                        @else
                                        -
                                        @endif

                                        @if ($value->hora_salida)
                                        {{ date('h:i A', strtotime($value->hora_salida)) }} /
                                        @else
                                        /
                                        @endif

                                        @if ($value->hora_entrada)
                                        {{ date('h:i A', strtotime($value->hora_entrada)) }} -
                                        @else
                                        -
                                        @endif

                                        @if ($value->hora_final)
                                        {{ date('h:i A', strtotime($value->hora_final)) }}
                                        @else
                                        -
                                        @endif
                                        <span class="text-danger">{{ $value->Nombre }}</span>

                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descrip">Descripcion</label>
                                <input type="text" class="form-control" id="descrip" name="descrip" value="Programado" required autofocus>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>

        </div>
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
                ¿Estás seguro de que deseas actualizar el horario Programado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    SlimSelect({
        select: '#horarios',
        placeholder: 'Seleccionar Horarios',
        hideSelectedOption: true
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var confirmarBtn = document.getElementById('confirmarBtn');
        var confirmarModal = new bootstrap.Modal(document.getElementById('confirmarModal'));

        confirmarBtn.addEventListener('click', function() {
            // Simplemente envía el formulario cuando el usuario confirma
            document.forms['actualizarForm'].submit();
            confirmarModal.hide();
        });

        // Agrega un event listener al formulario para evitar el envío directo
        document.forms['actualizarForm'].addEventListener('submit', function(event) {
            event.preventDefault();
            confirmarModal.show();
        });
    });
</script>

@endsection
@endsection