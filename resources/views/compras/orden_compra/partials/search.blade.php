<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_oc" value="{{ request('nro_oc') }}" id="nro_oc" placeholder="--N° O.C.--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_solicitud" value="{{ request('nro_solicitud') }}" id="nro_solicitud" placeholder="--N° Solicitud--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_preventivo" value="{{ request('nro_preventivo') }}" id="nro_preventivo" placeholder="--Preventivo--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        {{--<div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>--}}
        <div class="col-md-4 pr-1 pl-1">
            <select name="area_id" id="area_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('area_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_registro" value="{{ request('fecha_registro') }}" id="fecha_registro" placeholder="--Fecha Registro--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1">
            <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($proveedores as $index => $value)
                    <option value="{{ $index }}" @if(request('proveedor_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="solicitante_id" id="solicitante_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($users as $index => $value)
                    <option value="{{ $index }}" @if(request('solicitante_id') == $index) selected @endif >{{ $value }}</option>
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
            {{-- @can('orden.compra.create')
                <span class="btn btn-outline-success font-roboto-12 tts:right tts-slideIn tts-custom" onclick="create();" aria-label="Registrar" style="cursor: pointer;">
                    <i class="fas fa-plus fa-fw"></i>
                </span>
            @endcan --}}
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
