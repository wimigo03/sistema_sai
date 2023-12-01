@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style="color: #333; font-weight: bold; text-align: center; margin-bottom: 20px;">Editar Dirección Administrativa</h1>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('activo.DireccionAdministrativa.update', $direccionAdministrativa->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="ciudad" style="color: #666; font-weight: bold;">Ciudad:</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{ $direccionAdministrativa->ciudad }}" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion" style="color: #666; font-weight: bold;">Descripción:</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ $direccionAdministrativa->descripcion }}" required>
                        </div>

                        <div class="form-group">
                            <label for="tipo_dea" style="color: #666; font-weight: bold;">Prefijo de la Dirección Administrativa:</label>
                            <input type="text" name="tipo_dea" id="tipo_dea" class="form-control" value="{{ $direccionAdministrativa->tipo_dea }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
