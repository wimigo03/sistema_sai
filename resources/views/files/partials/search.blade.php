<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_file" value="{{ request('nro_file') }}" id="nro_file" placeholder="--Nro. File--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            <select name="area_id" id="area_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('area_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <select name="cargo_id" id="cargo_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($cargos as $index => $value)
                    <option value="{{ $index }}" @if(request('cargo_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4 pr-1 pl-1">
            <select name="escala_salarial_id" id="escala_salarial_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($escalas_salariales as $index => $value)
                    <option value="{{ $index }}" @if(request('escala_salarial_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control select2">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('files.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-success font-verdana" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('files.excel')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a excel" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-success font-verdana" onclick="excel();">
                        <i class="fas fa-file-excel fa-fw"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
