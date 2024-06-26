<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Nombre.--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="detalle" value="{{ request('detalle') }}" placeholder="--Detalle--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_registro" value="{{ request('fecha_registro') }}" id="fecha_registro" placeholder="--Fecha Registro--" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
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
            @can('partida.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Registrar Partida" style="cursor: pointer;">
                    <button class="btn btn-sm btn-outline-success font-verdana" type="button" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </button>
                </span>
            @endcan
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </button>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
