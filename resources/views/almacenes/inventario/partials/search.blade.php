<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-2">
        <div class="col mb-2">
            <select name="almacen_id" id="almacen_id" class="form-control">
                <option value="">-</option>
                @foreach ($almacenes as $index => $value)
                    <option value="{{ $index }}" @if(request('almacen_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control">
                <option value="">-</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}" @if(request('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control">
                <option value="">-</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if(request('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col mb-2">
            <input type="text" name="item" value="{{ request('item') }}" id="item" placeholder="--Material--" class="form-control intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col mb-2">
            <select name="unidad_id" id="unidad_id" class="form-control">
                <option value="">-</option>
                @foreach ($unidades as $index => $value)
                    <option value="{{ $index }}" @if(request('unidad_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
        @can('sucursal.index')
            <button class="btn btn-outline-dark w-100 w-md-auto mr-2" type="button" onclick="sucursales();">
                <i class="fa fa-shop fa-fw"></i> Sucursales
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
