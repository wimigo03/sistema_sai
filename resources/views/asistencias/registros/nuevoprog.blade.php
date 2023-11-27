@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">

        <div class="col-md-3 offset-md-3 titulo">
            <b>Modificar Registro</b>
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
                <form action="{{ route('asistencia.store') }}" method="POST">
                    @csrf

                    <div class="row">
 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{$fecha}}" readonly required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="area">Horario:</label>
                                <div id="area-select2">

                                    <select name="horario_id" id="horarios" aria-label="Selecion de Horario" required>
                                        <option value=""></option>
                                        @foreach ($horarios as $index => $value)
                                        <option value="{{ $value->id }}"> {{ $value->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descrip">Descripcion</label>
                                <input type="text" class="form-control" id="descrip" name="descrip" value="Progamado" required autofocus>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>

        </div>
    </div>
</div>

@section('scripts')
<script>
    var horario_select = new SlimSelect({
        select: '#horarios',
        placeholder: 'Seleccionar Horarios',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true
    });
</script>


@endsection
@endsection