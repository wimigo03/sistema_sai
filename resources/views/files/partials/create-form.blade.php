<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="dea_id" value="{{ $dea_id }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <div class="select2-container-rojo">
                <select name="tipo" id="tipo" class="form-control font-roboto-12 select2">
                    <option value="">--Seleccionar--</option>
                    @foreach ($tipos as $index => $value)
                        <option value="{{ $index }}" @if(old('tipo') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="area_id" class="d-inline"><b>Area: </b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <div class="select2-container-rojo">
                <select name="area_id" id="area_id" class="form-control font-roboto-12 select2">
                    <option value="">--Seleccionar--</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}" @if(old('area_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="cargo" class="d-inline"><b>Nombre del cargo: </b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="cargo" value="{{ old('cargo') }}" id="cargo" class="form-control font-roboto-12 input-rojo" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="escala_salarial_id" class="d-inline"><b>Escala Salarial: </b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <div class="select2-container-rojo">
                <select name="escala_salarial_id" id="escala_salarial_id" class="form-control font-roboto-12 select2">
                    <option value="">--Seleccionar--</option>
                    @foreach ($escalas_salariales as $index => $value)
                        <option value="{{ $index }}" @if(old('escala_salarial_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="nro_file" class="d-inline"><b>Nro. File: </b></label>
        </div>
        <div class="col-md-1 pr-1 pl-1">
            <input type="text" name="nro_file" value="{{ old('nro_file') }}" id="nro_file" class="form-control font-roboto-12 input-rojo">
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-6 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        <span class="btn btn-primary font-roboto-12" onclick="procesar();">
            <i class="fas fa-paper-plane fa-fw"></i> Procesar
        </span>
        <span class="btn btn-danger font-roboto-12" onclick="cancelar();">
            <i class="fas fa-times fa-fw"></i> Cancelar
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
