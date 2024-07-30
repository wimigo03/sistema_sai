<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Nombre.--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="detalle" value="{{ request('detalle') }}" placeholder="--Detalle--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="unidad_id" id="unidad_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($unidades as $index => $value)
                    <option value="{{ $index }}" @if(request('unidad_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        {{--<div class="col-md-1 pr-1 pl-1">
            <input type="text" name="precio" value="{{ request('precio') }}" placeholder="--Precio--" id="precio" class="form-control font-roboto-12 intro">
        </div>--}}
        {{--<div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>--}}
        <div class="col-md-5 pr-1 pl-1">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}" @if(request('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        {{--<div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_registro" value="{{ request('fecha_registro') }}" id="fecha_registro" placeholder="--Fecha Registro--" class="form-control font-roboto-12" data-language="es">
        </div>--}}
        <div class="col-md-5 pr-1 pl-1">
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if(request('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
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
        <div class="col-md-12 pr-1 pl-1">
            @can('partida.presupuestaria.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Registrar Item" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('unidad.medida.index')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Unidades de Medida" style="cursor: pointer;">
                    <span class="btn btn-outline-dark font-roboto-12" onclick="get_unidades();">
                        <i class="fas fa-balance-scale fa-fw"></i>
                    </span>
                </span>
            @endcan
            <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
