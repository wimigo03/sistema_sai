<form action="{{ route('beneficiarios.store') }}" method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-12">
        <div class="col-md-4 pr-1 pl-1">
            <label for="nombres" class="d-inline"><b>Nombres</b></label>
            <input type="text" name="nombres" value="{{ old('nombres') }}" id="nombres" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="ap" class="d-inline"><b>Apellido Paterno</b></label>
            <input type="text" name="ap" value="{{ old('ap') }}" id="ap" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="am" class="d-inline"><b>Apellido Materno</b></label>
            <input type="text" name="am" value="{{ old('am') }}" id="am" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="fnac" class="d-inline"><b>Fecha de Nacimiento</b></label>
            <input type="text" name="fnac" value="{{ old('fnac') }}" id="fnac" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="estado_civil" class="d-inline"><b>Estado Civil</b></label>
            <select name="estado_civil" id="estado_civil" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="Soltero(a)" @if (old('estado_civil') == 'Soltero(a)') selected @endif>Soltero(a)</option>
                <option value="Casado(a)" @if (old('estado_civil') == 'Casado(a)') selected @endif>Casado(a)</option>
                <option value="Viudo(a)" @if (old('estado_civil') == 'Viudo(a)') selected @endif>Viudo(a)</option>
                <option value="Divorciado(a)" @if (old('estado_civil') == 'Divorciado(a)') selected @endif>Divorciado(a)</option>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="sexo" class="d-inline"><b>Sexo</b></label>
            <select name="sexo" id="sexo" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="H" @if (old('sexo') == 'H') selected @endif>Masculino</option>
                <option value="M" @if (old('sexo') == 'M') selected @endif>Femenino</option>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="ci" class="d-inline"><b>Nro. de Carnet</b></label>
            <input type="text" name="ci" id="ci" class="form-control font-roboto-12">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="expedido" class="d-inline"><b>Expedido</b></label>
            <select name="expedido" id="expedido" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="BN" @if (old('sexo') == 'BN') selected @endif>Beni</option>
                <option value="CBBA" @if (old('expedido') == 'CBBA') selected @endif>Cochabamba</option>
                <option value="LPZ" @if (old('expedido') == 'LPZ') selected @endif>La Paz</option>
                <option value="ORU" @if (old('expedido') == 'ORU') selected @endif>Oruro</option>
                <option value="PND" @if (old('expedido') == 'PND') selected @endif>Pando</option>
                <option value="PTS" @if (old('expedido') == 'PTS') selected @endif>Potosi</option>
                <option value="SC" @if (old('expedido') == 'SC') selected @endif>Sucre</option>
                <option value="SCZ" @if (old('expedido') == 'SCZ') selected @endif>Santa Cruz</option>
                <option value="TJA" @if (old('expedido') == 'TJA') selected @endif>Tarija</option>
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="firma" class="d-inline"><b>Firma</b></label>
            <select name="firma" id="firma" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="SI" @if (old('firma') == 'SI') selected @endif>Si</option>
                <option value="NO" @if (old('firma') == 'NO') selected @endif>No</option>
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 mb-2">
        <div class="col-md-2 pr-1 pl-1">
            <label for="estado" class="d-inline"><b>Estado</b></label>
            <select name="estado" id="estado" class="form-control select2 font-roboto-12">
                <option value="">-</option>
                <option value="A" @if (old('estado') == 'A') selected @endif>HABILITADO</option>
                <option value="X" @if (old('estado') == 'X') selected @endif>PENDIENTE</option>
            </select>
        </div>
        <div class="col-md-8 pr-1 pl-1">
            <label for="direccion" class="d-inline"><b>Direccion</b></label>
            <input type="text" name="direccion" id="direccion"  class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-4 pr-1 pl-1">
            <label for="barrio" class="d-inline"><b>Barrio</b></label>
            <select name="barrio" id="barrio" class=" form-control select2">
                @foreach ($barrios as $barrio)
                    <option value="">-</option>
                    <option value="{{ $barrio->id }}">{{ $barrio->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <label for="ocupacion" class="d-inline"><b>Ocupacion</b></label>
            <select name="ocupacion" id="ocupacion" class=" form-control select2">
                @foreach ($ocupaciones as $ocupacion)
                    <option value="">-</option>
                    <option value="{{ $ocupacion->id }}">{{ $ocupacion->ocupacion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="latitud" class="d-inline"><b>Latitud</b></label>
            <input type="text" name="latitud" id="latitud"  class="form-control font-roboto-12" disabled>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="longitud" class="d-inline"><b>Longitud</b></label>
            <input type="text" name="longitud" id="longitud"  class="form-control font-roboto-12" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1">
            <label for="observacion" class="d-inline"><b>Observacion</b></label>
            <textarea name="observacion" id="observacion" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1">
            <div id="map"></div>
            <p id="coordinates"></p>
            <span class="locate-btn"><i class="fa-solid fa-location-crosshairs fa-2x"></i></span>
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
