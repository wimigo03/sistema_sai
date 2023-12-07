@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">

        <div class="col-md-3 offset-md-3 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Registrar Asistencia</b>
            <i class=aria-hidden="true"></i>
        </div>
        <div class="col-md-3 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('registroasistencia.index')}}">
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
                <form action="{{ route('registroasistencia.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="pin">PIN</label>
                        <input type="password" class="form-control" id="pin" name="pin" maxlength="4" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="hora">Hora de Registro:</label>
                        <input type="time" class="form-control" id="hora" name="hora" value="{{ date('H:i:s') }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection