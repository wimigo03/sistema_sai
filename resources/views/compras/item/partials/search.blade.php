<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Nombre.--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="detalle" value="{{ request('detalle') }}" placeholder="--Detalle--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="precio" value="{{ request('precio') }}" placeholder="--Precio--" id="precio" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <select name="unidad_id" id="unidad_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($unidades as $index => $value)
                    <option value="{{ $index }}" @if(request('unidad_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo_partida" value="{{ request('codigo_partida') }}" id="codigo_partida" placeholder="--Codigo Partida P.--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="partida_presupuestaria" value="{{ request('partida_presupuestaria') }}" id="partida_presupuestaria" placeholder="--Partida Presupuestaria--" class="form-control font-roboto-12 intro">
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
                <span class="tts:right tts-slideIn tts-custom" aria-label="Registrar Item" style="cursor: pointer;">
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
