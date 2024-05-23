<br>
<div class="form-group row font-roboto-12">
    <div class="col-md-4 pr-1">
        <label for="nombre" class="d-inline"><b>Nombre (s)</b></label>
        <input type="text" name="nombre" value="{{ $empleado->nombres }}" id="nombre" class="form-control font-roboto-12 input-rojo" oninput="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="apellido_paterno" class="d-inline"><b>Apellido Paterno</b></label>
        <input type="text" name="apellido_paterno" value="{{ $empleado->ap_pat }}" id="apellido_paterno" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="apellido_materno" class="d-inline"><b>Apellido Materno</b></label>
        <input type="text" name="apellido_materno" value="{{ $empleado->ap_mat }}" id="apellido_materno" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-5 pr-1">
        <label for="foto" class="d-inline"><b>Foto</b></label>
        <div id="imagePreview-prueba">
            {{--<img src="{{ asset($empleado->url_foto) }}" alt="logo" style="width: 65px; height: auto;">--}}
        </div>
        <input type="file" name="foto" id="fotoInput" class="form-control font-roboto-12" onchange="previewImage(event)">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="nro_carnet" class="d-inline"><b>Nro. Carnet</b></label>
        <input type="text" name="nro_carnet" value="{{ $empleado->ci }}" id="nro_carnet" class="form-control font-roboto-12 input-rojo" oninput="this.value = this.value.toUpperCase();eliminarEspaciosEnBlanco();">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="extension" class="d-inline"><b>Extension</b></label>
        <div class="select2-container-rojo">
            <select name="extension" id="extension" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($extensiones as $index => $value)
                    <option value="{{ $index }}" @if($empleado->extension == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="sexo" class="d-inline"><b>Sexo</b></label>
        <div class="select2-container-rojo">
            <select name="sexo" id="sexo" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($sexos as $index => $value)
                    <option value="{{ $index }}" @if($empleado->sexo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="natalicio" class="d-inline"><b>Natalicio</b></label>
        <input type="text" name="natalicio" value="{{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/Y') : '' }}" id="natalicio" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="libreta_militar" class="d-inline"><b>N° Libreta Militar</b></label>
        <input type="text" name="libreta_militar" value="{{ $empleado->servmilitar }}" id="libreta_militar" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();eliminarEspaciosEnBlanco();">
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="idioma" class="d-inline"><b>Idioma Principal</b></label>
        <input type="text" name="idioma" value="{{ $empleado->idioma }}"     id="idioma" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="anhos_servicio" class="d-inline"><b>Años de servicio</b></label>
        <input type="text" name="anhos_servicio" value="{{ $empleado->aservicios }}" id="anhos_servicio" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pl-1 text-center">
        <br>
        <input type="checkbox" name="inamovilidad" id="inamovilidad" {{ $empleado->inamovilidad == '1' ? 'checked' : '' }}>
        <label for="inamovilidad" class="d-inline"><b>Inamovilidad</b></label>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="telefono" class="d-inline"><b>Celular</b></label>
        <input type="text" name="telefono" value="{{ $empleado->telefono }}" id="telefono" class="form-control font-roboto-12">
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="grado_academico" class="d-inline"><b>Grado academico</b></label>
        <select name="grado_academico" id="grado_academico" class="form-control font-roboto-12 select2">
            <option value="">--Seleccionar--</option>
            @foreach ($grados_academicos as $index => $value)
                <option value="{{ $index }}" @if($empleado->gradacademico == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="rae" class="d-inline"><b>RAE</b></label>
        <input type="text" name="rae" value="{{ $empleado->rae }}" id="rae" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="registro_profesional" class="d-inline"><b>Registro Profesional</b></label>
        <input type="text" name="registro_profesional" value="{{ $empleado->regprofesional }}" id="registro_profesional" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="cuenta_banco" class="d-inline"><b>Cuenta Banco Union</b></label>
        <input type="text" name="cuenta_banco" value="{{ $empleado->cuentabanco }}" id="cuenta_banco" class="form-control font-roboto-12">
    </div>
    <div class="col-md-1 pl-1">
        <label for="file_contrato" class="d-inline"><b>N° File</b></label>
        <input type="text" name="file_contrato" value="{{ $empleado->filecontrato }}" id="file_contrato" class="form-control font-roboto-12">
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="nit" class="d-inline"><b>NIT</b></label>
        <input type="text" name="nit" value="{{ $empleado->nit }}" id="nit" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="kua" class="d-inline"><b>KUA</b></label>
        <input type="text" name="kua" value="{{ $empleado->kua }}" id="kua" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pr-1 pl-1 text-center">
        <br>
        <input type="checkbox" name="sigep" {{ $empleado->sigep == '1' ? 'checked' : '' }}>
        <label for="sigep" class="d-inline"><b>SIGEP</b></label>
    </div>
    <div class="col-md-2 pr-1 pl-1 text-center">
        <br>
        <input type="checkbox" name="cvitae" {{ $empleado->cvitae == '1' ? 'checked' : '' }}>
        <label for="cvitae" class="d-inline"><b>Curriculum Vitae</b></label>
    </div>
</div>
