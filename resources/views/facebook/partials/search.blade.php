<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            <input type="text" name="fecha" value="{{ request('fecha') }}" id="fecha" placeholder="--Fecha--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="titulo" value="{{ request('titulo') }}" id="titulo" placeholder="--Titulo--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
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
            @can('facebook.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Registrar Publicacion" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-success font-verdana" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('facebook.cargar.datos')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Entre fechas" style="cursor: pointer;">
                    <span class="btn btn-sm btn-outline-info font-verdana" onclick="entre_fechas();">
                        <i class="fas fa-calendar-alt fa-fw"></i>
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
