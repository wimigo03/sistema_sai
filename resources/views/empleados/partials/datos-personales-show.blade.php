<br>
<div class="form-group row font-roboto-12">
    <div class="col-md-12 mb-4 text-center">
        <img src="{{ asset($empleado->url_foto) }}" alt="#" style="width-min: 100px; width: 150px; height: auto; border-radius: 10%;">
        <br>
        <br>
        <span class="{{ $empleado->color_status_sin_block }} font-roboto-12">
            <i class="fas fa-user fa-fw"></i> {{ $empleado->status_completo }}
        </span>
    </div>
    <div class="col-md-2 pr-1 mb-2">
        <label for="file_contrato" class="d-inline"><b>N° File</b></label>
        <input type="text" value="{{ $empleado->filecontrato }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 mb-2">
        <label for="apellido_paterno" class="d-inline"><b>Apellido Paterno</b></label>
        <input type="text" value="{{ $empleado->ap_pat }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 mb-2">
        <label for="apellido_materno" class="d-inline"><b>Apellido Materno</b></label>
        <input type="text" value="{{ $empleado->ap_mat }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-4 pl-1 mb-2">
        <label for="nombre" class="d-inline"><b>Nombre Completo</b></label>
        <input type="text" value="{{ $empleado->nombres }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-3 pr-1 mb-2">
        <label for="nro_carnet" class="d-inline"><b>Nro. Carnet</b></label>
        <input type="text" value="{{ $empleado->ci . ' ' . $empleado->extension }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 mb-2">
        <label for="natalicio" class="d-inline"><b>Natalicio</b></label>
        <input type="text" value="{{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/Y') : '' }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-5 pr-1 pl-1 mb-2">
        <label for="grado_academico" class="d-inline"><b>Grado academico</b></label>
        <input type="text" value="{{ $empleado->gradacademico }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 mb-2">
        <label for="rae" class="d-inline"><b>RAE</b></label>
        <input type="text" value="{{ $empleado->rae }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 mb-2">
        <label for="registro_profesional" class="d-inline"><b>Registro Profesional</b></label>
        <input type="text" value="{{ $empleado->regprofesional }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 mb-2">
        <label for="cuenta_banco" class="d-inline"><b>Cuenta Banco Union</b></label>
        <input type="text" value="{{ $empleado->cuentabanco }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-4 pl-1 mb-2">
        <label for="libreta_militar" class="d-inline"><b>N° Libreta Militar</b></label>
        <input type="text" value="{{ $empleado->servmilitar }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 mb-2">
        <label for="nit" class="d-inline"><b>NIT</b></label>
        <input type="text" value="{{ $empleado->nit }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1 mb-2">
        <label for="idioma" class="d-inline"><b>Idioma Principal</b></label>
        <input type="text" value="{{ $empleado->idioma }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1 mb-2">
        <label for="kua" class="d-inline"><b>KUA</b></label>
        <input type="text" value="{{ $empleado->kua }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1 mb-2">
        <label for="anhos_servicio" class="d-inline"><b>Años de servicio</b></label>
        <input type="text" value="{{ $empleado->aservicios }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1 mb-2">
        <label for="telefono" class="d-inline"><b>Celular</b></label>
        <input type="text" value="{{ $empleado->telefono }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pl-1 mb-2">
        <label for="sexo" class="d-inline"><b>Sexo</b></label>
        <input type="text" value="{{ $empleado->sexos }}" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 mb-2">
        <input type="checkbox" {{ $empleado->sigep == '1' ? 'checked' : '' }}>&nbsp;
        <label for="sigep" class="d-inline"><b>Sigep</b></label>
    </div>
    <div class="col-md-2 pr-1 pl-1 mb-2">
        <input type="checkbox" {{ $empleado->inamovilidad == '1' ? 'checked' : '' }}>&nbsp;
        <label for="inamovilidad" class="d-inline"><b>Inamovilidad</b></label>
    </div>
    <div class="col-md-2 pr-1 pl-1 mb-2">
        <input type="checkbox" {{ $empleado->cvitae == '1' ? 'checked' : '' }}>&nbsp;
        <label for="cvitae" class="d-inline"><b>Curriculum Vitae</b></label>
    </div>
</div>
