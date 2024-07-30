<form action="#" method="get" id="form">
    <div class="form-group row abs-center">
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Nombre.--" class="form-control font-roboto-12 intro">
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
        <div class="col-md-5 pl-1">
            <span class="btn btn-outline-primary font-roboto-12 mr-1" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </span>
            @can('programa.create')
                <span class="tts:right tts-slideIn tts-custom float-right" aria-label="Registrar Proveedor" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
