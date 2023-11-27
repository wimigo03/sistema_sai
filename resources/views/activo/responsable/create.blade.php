@extends('layouts.admin')

@section('content')
    <h2>Crear Responsable para la Oficina: {{ $oficina->nombrearea }}</h2>

    <form action="{{ route('activo.oficina.guardarResponsable') }}" method="POST">
        @csrf
        <input type="hidden" name="idarea" value="{{ $oficina->idarea }}">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="ap_pat">Apellido Paterno:</label>
        <input type="text" name="ap_pat" required>

        <label for="ap_mat">Apellido Materno:</label>
        <input type="text" name="ap_mat" required>

        <label for="cargo">Cargo:</label>
        <input type="text" name="cargo" required>

        <label for="ci">C.I.:</label>
        <input type="text" name="ci" required>

        <label for="expedido">Expedido:</label>
        <input type="text" name="expedido" required>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>

        <button type="submit">Guardar</button>
    </form>
@endsection
