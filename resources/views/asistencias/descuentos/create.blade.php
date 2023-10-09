@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Agregar Descuentos por Haber Básico</b>
        </div>

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('descuentos.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <div class="body-border">
                <form method="POST" action="{{ route('descuentos.store') }}">
                    @csrf

                    <!-- Campos del formulario -->


                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <input type="text" name="descripcion" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tiempo_min">Tiempo de Retraso</label>
                        <input type="number" name="tiempo_min" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="dia">Cantidad de Días</label>
                        <input type="number" name="dia" class="form-control" step="0.01" required>
                    </div>


                    <!-- Botón para guardar -->
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection