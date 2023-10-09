@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Editar Descuentos</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('descuentos.index')}}">
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
                <form method="POST" action="{{ route('descuentos.update', $descuento->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Campos del formulario -->
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <input type="text" name="descripcion" value="{{ $descuento->descripcion }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tiempo_min">Tiempo de Retraso</label>
                        <input type="number" name="tiempo_min" value="{{$descuento->retraso_max }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="dia">Cantidad de Días</label>
                        <input type="number" name="dia" class="form-control" value="{{ $descuento->cantidad_dia  }}" step="0.01" required>
                    </div>

                    <!-- Botón para actualizar -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection