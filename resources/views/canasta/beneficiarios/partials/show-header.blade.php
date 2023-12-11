<div class="form-group row font-verdana mb-2">
    <div class="col-md-4 pr-1">
        <label for="nombre_completo" class="d-inline"><b>Nombre Completo</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->nombre_completo }}" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="nro_carnet" class="d-inline"><b>Nro. de Carnet</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->ci . '-' . $beneficiario->expedido }}" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="natalicio" class="d-inline"><b>Natalicio</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ \Carbon\Carbon::parse($beneficiario->fechaNac)->format('d/m/Y') }}" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="e_civil" class="d-inline"><b>Estado Civil</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ strtoupper($beneficiario->estadoCivil) }}" disabled>
    </div>
    <div class="col-md-2 pl-1">
        <label for="sexo" class="d-inline"><b>Sexo</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->sexo }}" disabled>
    </div>
</div>
<div class="form-group row font-verdana mb-2">
    <div class="col-md-4 pr-1">
        <label for="direccion" class="d-inline"><b>Direccion</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ strtoupper($beneficiario->direccion) }}" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="firma" class="d-inline"><b>Firma</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->firma }}" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="estado" class="d-inline"><b>Estado</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->estado }}" disabled>
    </div>
</div>
<div class="form-group row font-verdana mb-2">
    <div class="col-md-4 pr-1">
        <label for="barrio" class="d-inline"><b>Barrio</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->barrios != null ? strtoupper($beneficiario->barrios->barrio) : '#' }}" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="ocupacion" class="d-inline"><b>Ocupacion</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->ocupacion->ocupacion }}" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="registrado" class="d-inline"><b>F. Registro</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ \Carbon\Carbon::parse($beneficiario->registrado)->format('d/m/Y') }}" disabled>
    </div>
    <div class="col-md-3 pl-1">
        <label for="usuario" class="d-inline"><b>Usuario</b></label>
        <input type="text" class="form-control form-control-sm font-verdana input-sm" value="{{ $beneficiario->admin != null ? $beneficiario->admin->nombre_completo : '#' }}" disabled>
    </div>
</div>
<div class="form-group row font-verdana mb-2">
    <div class="col-md-12">
        <label for="obs" class="d-inline"><b>Observaciones</b></label>
        <textarea cols="1" rows="1" class="form-control form-control-sm font-verdana input-sm" disabled>{{ strtoupper($beneficiario->obs) }}</textarea>
    </div>
</div>