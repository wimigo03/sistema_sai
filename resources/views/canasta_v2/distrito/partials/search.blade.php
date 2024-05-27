<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo" placeholder="--Codigo--" value="{{ request('codigo') }}" class="form-control font-roboto-12 intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="--Nombre--" value="{{ request('nombre') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="usuario" placeholder="--Usuario--" value="{{ request('usuario') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('canasta.distritos.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus"></i>
                    </span>
                </span>
            @endcan
            @can('canasta.distritos.excel')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a excel" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                        <i class="fa-solid fa-file-excel"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
