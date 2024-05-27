<form action="{{ route('beneficiarios.update') }}" method="post" id="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="idBeneficiario" id="idBeneficiario" value="{{ $beneficiario->id }}">

    <div class="form-group row font-roboto-12">
        <div class="col-md-4 pr-1 pl-1">
            <label for="nombres" class="d-inline"><b>Nombres</b></label>
            <input type="text" name="nombres" id="nombres" value="{{ $beneficiario->nombres }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="ap" class="d-inline"><b>Apellido Paterno</b></label>
            <input type="text" name="ap" id="ap" value="{{ $beneficiario->ap }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="ap" class="d-inline"><b>Apellido Paterno</b></label>
            <input type="text" name="am" id="am" value="{{ $beneficiario->am }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="fnac" class="d-inline"><b>Fecha de Nacimiento</b></label>
            <input type="text" name="fnac" value="{{ $beneficiario->fechaNac != null ? \Carbon\Carbon::parse($beneficiario->fechaNac)->format('d/m/Y') : '' }}" id="fnac" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="estadoCivil" class="d-inline"><b>Estado Civil</b></label>
            <select name="estadoCivil" id="estadoCivil" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="Soltero(a)" @if ($beneficiario->estadoCivil == 'Soltero(a)') selected @endif>Soltero(a)</option>
                <option value="Casado(a)" @if ($beneficiario->estadoCivil == 'Casado(a)') selected @endif>Casado(a)</option>
                <option value="Viudo(a)" @if ($beneficiario->estadoCivil == 'Viudo(a)') selected @endif>Viudo(a)</option>
                <option value="Divorciado(a)" @if ($beneficiario->estadoCivil == 'Divorciado(a)') selected @endif>Divorciado(a)</option>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="sexo" class="d-inline"><b>Sexo</b></label>
            <select name="sexo" id="sexo" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="H" @if ($beneficiario->sexo == 'H') selected @endif>Masculino</option>
                <option value="M" @if ($beneficiario->sexo == 'M') selected @endif>Femenino</option>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="ci" class="d-inline"><b>Nro. de Carnet</b></label>
            <input type="text" name="ci" id="ci" value="{{ $beneficiario->ci }}" class="form-control font-roboto-12">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="expedido" class="d-inline"><b>Expedido</b></label>
            <select name="expedido" id="expedido" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="BN" @if ($beneficiario->expedido == 'BN') selected @endif>Beni</option>
                <option value="CBBA" @if ($beneficiario->expedido == 'CBBA') selected @endif>Cochabamba</option>
                <option value="LPZ" @if ($beneficiario->expedido == 'LPZ') selected @endif>La Paz</option>
                <option value="ORU" @if ($beneficiario->expedido == 'ORU') selected @endif>Oruro</option>
                <option value="PND" @if ($beneficiario->expedido == 'PND') selected @endif>Pando</option>
                <option value="PTS" @if ($beneficiario->expedido == 'PTS') selected @endif>Potosi</option>
                <option value="SC" @if ($beneficiario->expedido == 'SC') selected @endif>Sucre</option>
                <option value="SCZ" @if ($beneficiario->expedido == 'SCZ') selected @endif>Santa Cruz</option>
                <option value="TJA" @if ($beneficiario->expedido == 'TJA') selected @endif>Tarija</option>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="firma" class="d-inline"><b>Firma</b></label>
            <select name="firma" id="firma" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="SI" @if ($beneficiario->firma == 'SI') selected @endif>Si</option>
                <option value="NO" @if ($beneficiario->firma == 'NO') selected @endif>No</option>
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="estado" class="d-inline"><b>Estado</b></label>
            <select name="estado" id="estado" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="A" @if ($beneficiario->estado == 'A') selected @endif>HABILITADO</option>
                <option value="X" @if ($beneficiario->estado == 'X') selected @endif>PENDIENTE</option>
                <option value="F" @if ($beneficiario->estado == 'F') selected @endif>FALLECIDO</option>
                <option value="B" @if ($beneficiario->estado == 'B') selected @endif>BAJA</option>
            </select>
        </div>
        <div class="col-md-8 pr-1 pl-1">
            <label for="direccion" class="d-inline"><b>Direccion</b></label>
            <input type="text" name="direccion" id="direccion" value="{{ $beneficiario->direccion }}" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-4 pr-1 pl-1">
            <label for="barrio" class="d-inline"><b>Barrio</b></label>
            <select name="barrio" id="barrio" class=" form-control select2">
                @foreach ($barrios as $barrio)
                    <option value="">-</option>
                    <option value="{{ $barrio->id }}"
                            @if ($beneficiario->idBarrio == $barrio->id) selected @endif
                        >
                        {{ $barrio->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <label for="ocupacion" class="d-inline"><b>Ocupacion</b></label>
            <select name="ocupacion" id="ocupacion" class=" form-control select2">
                @foreach ($ocupaciones as $ocupacion)
                    <option value="">-</option>
                    <option value="{{ $ocupacion->id }}"
                            @if ($beneficiario->idOcupacion == $ocupacion->id) selected @endif
                        >
                        {{ $ocupacion->ocupacion }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="fregistro" class="d-inline"><b>Fecha de Registro</b></label>
            <input type="text" name="fregistro" id="fregistro" value="{{ \Carbon\Carbon::parse($beneficiario->created_att)->format('d/m/Y H:i:s') }}" class="form-control font-roboto-12" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1">
            <label for="observacion" class="d-inline"><b>Observacion</b></label>
            <textarea name="observacion" id="observacion" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">{{ $beneficiario->obs }}</textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <img src="{{ asset(substr($beneficiario->dirFoto, 2)) }}" width="150" />
        </div>
    </div>
    <div class="form-group row font-roboto-12 abs-center">
        <div class="col-md-6 pr-1 pl-1 text-center">
            <label for="fregistro" class="d-inline"><b>Agregar / Modificar Foto</b></label>
            <input type="file" name="documento" id="file" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="save();">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
