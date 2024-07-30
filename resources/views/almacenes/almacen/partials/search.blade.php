<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ request('nombre') }}" id="nombre" placeholder="--Almacen--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="direccion" value="{{ request('direccion') }}" id="direccion" placeholder="--Direccion--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="user_id" id="user_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($users as $index => $value)
                    <option value="{{ $index }}" @if(request('user_id') == $index) selected @endif >{{ $value }}</option>
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
            @can('almacen.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            @can('inventario.index')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Inventario General" style="cursor: pointer;">
                    <span class="btn btn-outline-dark font-roboto-12" onclick="inventarioGeneral();">
                        <i class="fas fa-warehouse fa-fw"></i>
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
