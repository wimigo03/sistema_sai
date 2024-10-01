<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="codigo" placeholder="-- Codigo Interno --" value="{{ request('codigo') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="codigo_serie" placeholder="-- Codigo/Serie --" value="{{ request('codigo_serie') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-5 pr-1 pl-1 mb-2">
            <select name="area_id" id="area_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}"
                        @if(request('area_id') == $index ) selected @endif>{{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <select name="empleado_id" id="empleado_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($empleados as $index => $value)
                    <option value="{{ $index }}"
                        @if(request('empleado_id') == $index) selected @endif>{{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="clasificacion" id="clasificacion" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($clasificaciones as $index => $value)
                    <option value="{{ $index }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha" placeholder="-- Fecha de Recepcion --" id="fecha" value="{{ request('fecha') }}" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12 select2">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado_detalle" id="estado_detalle" class="form-control font-roboto-12 select2">
                <option value="">-</option>
                @foreach ($estados_detalles as $index => $value)
                    <option value="{{ $index }}" @if(request('estado_detalle') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="usuario" placeholder="-- Usuario --" value="{{ request('usuario') }}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1">
            @can('mantenimientos.index')
                <span onclick="create();" class="btn btn-outline-success font-roboto-12 tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <i class="fa fa-plus fa-fw"></i>
                </span>
            @endcan
            <span class="btn btn-outline-danger font-roboto-12  float-right" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
