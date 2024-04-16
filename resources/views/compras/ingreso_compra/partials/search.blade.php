<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="almacen_id" id="almacen_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($almacenes as $index => $value)
                    <option value="{{ $index }}" @if(request('almacen_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($proveedores as $index => $value)
                    <option value="{{ $index }}" @if(request('proveedor_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo_oc" value="{{ request('codigo_oc') }}" id="codigo_oc" placeholder="--Codigo O.C.--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4 pr-1 pl-1">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}" @if(request('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="programa_id" id="programa_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($programas as $index => $value)
                    <option value="{{ $index }}" @if(request('programa_id') == $index) selected @endif >{{ $value }}</option>
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
            {{--@can('solicitud.compra.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Registrar Proveedor" style="cursor: pointer;">
                    <button class="btn btn-sm btn-outline-success font-verdana" type="button" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </button>
                </span>
            @endcan--}}
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
