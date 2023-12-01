@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #17a2b8; color: white; font-weight: bold; font-size: 24px; text-align: center; margin-bottom: 20px;">Direcciones Administrativas</div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="text-right" style="margin-bottom: 10px;">
                        <a href="{{ route('activo.DireccionAdministrativa.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Dirección Administrativa">
                            <button class="btn btn-sm btn-primary font-verdana" type="button">
                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                            </button>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ciudad</th>
                                    <th>Descripción</th>
                                    <th>Prefijo</th>
                                    <th></th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($direccionesAdministrativas as $direccionAdministrativa)
                                <tr>
                                    <td>{{ $direccionAdministrativa->id }}</td>
                                    <td>{{ $direccionAdministrativa->ciudad }}</td>
                                    <td>{{ $direccionAdministrativa->descripcion }}</td>
                                    <td>{{ $direccionAdministrativa->tipo_dea }}</td>
                                    <td>
                                        <form action="{{ route('activo.DireccionAdministrativa.index', $direccionAdministrativa->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-success font-verdana" type="submit" onclick="toggleCheckbox('checkbox-{{ $direccionAdministrativa->id }}')" class="tts:left tts-slideIn tts-custom" aria-label="Seleccionar">
                                                &nbsp;<i class="fa fa-check" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </form>
                                        <a href="{{ route('activo.DireccionAdministrativa.edit', $direccionAdministrativa->id) }}" class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                            <button class="btn btn-sm btn-primary font-verdana" type="button">
                                                &nbsp;<i class="fa fa-xl fa-edit" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </a>
                                        <form action="{{ route('activo.DireccionAdministrativa.destroy', $direccionAdministrativa->id) }}" method="POST" style="display: inline-block;" class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger font-verdana" onclick="return confirm('¿Estás seguro de eliminar esta dirección administrativa?')">&nbsp;<i class="fa fa-trash" aria-hidden="true"></i>&nbsp;</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .container-fluid {
        margin-top: 20px;
    }

    .btn-outline-info {
        color: #17a2b8;
        border-color: #17a2b8;
    }

    .label-info {
        background-color: #17a2b8;
        color: white;
    }

    .table .label {
        font-size: 14px;
        padding: 5px 8px;
        border-radius: 3px;
    }

    .card-title {
        color: #333;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 4px 10px;
    }

    .font-verdana {
        font-family: 'Verdana', sans-serif;
    }

    .text-right {
        text-align: right;
        margin-bottom: 10px;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection

@section('scripts')
<script>
    // Función para controlar la selección de checkboxes
    function toggleCheckbox(checkboxId) {
        var checkbox = document.getElementById(checkboxId);
        var checkboxes = document.getElementsByClassName('direccion-administrativa-checkbox');

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] !== checkbox) {
                checkboxes[i].checked = false;
            }
        }
    }
</script>
@endsection
