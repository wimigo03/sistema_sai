<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="dea_id" value="{{ $dea_id }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="area_id" class="d-inline"><b>Area</b></label>
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
            <label for="nro_file" class="d-inline"><b>Nro. File</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_file" value="{{ old('nro_file') }}" id="nro_file" class="form-control font-roboto-12 input-rojo">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="cargo" class="d-inline"><b>Cargo</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="cargo" value="{{ old('cargo') }}" id="cargo" class="form-control font-roboto-12 input-rojo" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="cargo_detalle" class="d-inline"><b>Nombre del cargo</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="cargo_detalle" value="{{ old('cargo_detalle') }}" id="cargo_detalle" class="form-control font-roboto-12 input-rojo" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="haber_basico" class="d-inline"><b>Haber Basico</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="haber_basico" value="{{ old('haber_basico') }}" id="haber_basico" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="categoria" class="d-inline"><b>Categoria</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <div class="select2-container-rojo">
                <select name="categoria" id="categoria" class="form-control font-roboto-12 select2">
                    <option value="">--Seleccionar--</option>
                    <option value="OPERATIVO" @if(old('categoria') == 'OPERATIVO') selected @endif >OPERATIVO</option>
                    <option value="ADMINISTRATIVO" @if(old('categoria') == 'ADMINISTRATIVO') selected @endif >ADMINISTRATIVO</option>
                    <option value="SUPERIOR" @if(old('categoria') == 'SUPERIOR') selected @endif >SUPERIOR</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="nivel_administrativo" class="d-inline"><b>Nivel Administrativo</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nivel_administrativo" value="{{ old('nivel_administrativo') }}" id="nivel_administrativo" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="clase" class="d-inline"><b>Clase</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="clase" value="{{ old('clase') }}" id="clase" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="nivel_salarial" class="d-inline"><b>Nivel Salarial</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nivel_salarial" value="{{ old('nivel_salarial') }}" id="nivel_salarial" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo</b></label>
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
