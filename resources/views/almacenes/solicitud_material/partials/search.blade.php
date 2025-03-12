<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="fecha" value="{{ request('fecha') }}" id="fecha" placeholder="--F. Solicitud--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-4 pr-1 pl-1 mb-2">
            <select name="area_id" id="area_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('area_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="solicitante_id" id="solicitante_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($users as $index => $value)
                    <option value="{{ $index }}" @if(request('solicitante_id') == $index) selected @endif >{{ strtoupper($value) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="programa_id" id="programa_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($programas as $index => $value)
                    <option value="{{ $index }}" @if(request('programa_id') == $index) selected @endif >{{ strtoupper($value) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="estado" id="estado" class="form-control select2">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ strtoupper($value) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 pr-1 pl-1">
            @can('solicitud.material.create')
                <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                    <i class="fas fa-plus fa-fw"></i>&nbsp;Solicitar Material
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
