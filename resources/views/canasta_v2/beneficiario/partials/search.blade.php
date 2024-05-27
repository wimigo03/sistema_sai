<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-1 pr-1 pl-1">
            <input type="text" name="codigo" placeholder="-- Codigo --" value="{{ request('codigo') }}" class="form-control font-roboto-12 intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="-- Nombres --" value="{{ request('nombre') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="ap" placeholder="-- Ap.Paterno --" value="{{ request('ap') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="am" placeholder="-- Ap.Materno --" value="{{ request('am') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ci" placeholder="--N° de carnet--" value="{{ request('ci') }}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pl-1">
            <select name="sexo" id="sexo" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($sexos as $index => $value)
                    <option value="{{ $index }}" @if(request('sexo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <select name="barrio"  id="idBarrio" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($barrios as $index => $value)
                    <option value="{{ $index }}" @if(request('barrio') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('canasta.beneficiarios.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('canasta.beneficiarios.excel')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a Excel" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                        <i class="fa-solid fa-file-excel fa-fw"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
