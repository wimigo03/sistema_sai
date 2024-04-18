@extends('layouts.admin')

@section('content')
<div class="container">
   
  

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
            <form action="{{route('descuentos.store')}}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header titulo">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <b>Editar Descuentos</b>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('descuentos.index')}}">
                                    <button class="btn btn-sm btn-danger font-verdana" type="button">
                                        &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                                    </button>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">

                        <!-- Campos del formulario -->
                        <div class="form-group row font-verdana-sm ">
                            <div class="col-md-12 table-responsive center">
                                <label for="descripcion"><b>Descripcion:</b></label>
                                <input type="text" name="descripcion" value="{{ old('descripcion')}}" class="form-control" required>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Agregar descripcion o nombre del descuento.</small>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row font-verdana-sm ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tiempo_min"><b>Tiempo de Retraso:</b></label>
                                    <input type="number" name="tiempo_min" value="{{old('tiempo_min')}}" class="form-control" required>
                                    @error('tiempo_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tiempo de retraso acumulado mensual de asistencias registradas.</small>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dia"><b>Cantidad de Días:</b></label>
                                    <select id="dia" name="dia" class="form-control" required>
                                        <option value="0" {{  old('dia') == 0 ? 'selected' : '' }}>Ningun descuento</option>
                                        <option value="0.5" {{  old('dia') == 0.5 ? 'selected' : '' }}>Medio día</option>
                                        <option value="1" {{ old('dia') == 1? 'selected' : '' }}>Un dia</option>
                                        <option value="2" {{ old('dia') == 2 ? 'selected' : '' }}>Dos días</option>
                                        <option value="3" {{ old('dia') == 3 ? 'selected' : '' }}>Tres días</option>
                                    </select>
                                    @error('dia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Cantidad de equivalente de descuento según RIP.</small>

                                </div>
                            </div>
                        </div>
                        <!-- Botón para actualizar -->
                        <div class="form-group row font-verdana-sm ">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection