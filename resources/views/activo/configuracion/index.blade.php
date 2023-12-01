@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Configuración</h1>

        <div class="row">
            <div class="col-lg-3">
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('configuracion.index') }}">Configuración General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('configuracion.usuarios') }}">Administrar Usuarios</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="configuracion-general">
                        <h3>Configuración General</h3>

                        <form action="{{ route('configuracion.general.guardar') }}" method="POST">
                            @csrf

                            <!-- Campos de configuración general -->
                            <div class="form-group">
                                <label for="campo1">Campo 1</label>
                                <input type="text" class="form-control" id="campo1" name="campo1" value="{{ $configuracionGeneral->campo1 ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="campo2">Campo 2</label>
                                <input type="text" class="form-control" id="campo2" name="campo2" value="{{ $configuracionGeneral->campo2 ?? '' }}">
                            </div>

                            <!-- Otros campos de configuración general -->

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="administrar-usuarios">
                        <h3>Administrar Usuarios</h3>

                        <!-- Lógica y formulario para administrar usuarios -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
