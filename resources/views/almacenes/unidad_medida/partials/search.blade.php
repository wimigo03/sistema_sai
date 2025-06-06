<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-2 font-roboto">
        <div class="col mb-2">
            <select name="tipo" id="tipo" class="form-control">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Nombre--" class="form-control font-roboto-14 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col mb-2">
            <input type="text" name="alias" value="{{ request('alias') }}" placeholder="--Alias--" class="form-control font-roboto-14 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col mb-2">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
        @can('producto.index')
            <button class="btn btn-outline-dark w-100 w-md-auto btn-size mr-2" type="button" onclick="get_productos();">
                <i class="fas fa-tags fa-fw"></i> Ir a Materiales
            </button>
        @endcan
        @can('unidad.medida.create')
            <button class="btn btn-outline-success w-100 w-md-auto mr-2" type="button" onclick="create();">
                <i class="fas fa-plus fa-fw"></i> Registrar
            </button>
        @endcan
        <button class="btn btn-outline-danger w-100 w-md-auto btn-size mr-2" type="button" onclick="limpiar();">
            <i class="fas fa-eraser fa-fw"></i> Limpiar
        </button>

        <button class="btn btn-outline-primary w-100 w-md-auto btn-size" type="button" onclick="search();">
            <i class="fas fa-search fa-fw"></i> Buscar
        </button>
    </div>
    <div class="col-12 text-center mt-2">
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
