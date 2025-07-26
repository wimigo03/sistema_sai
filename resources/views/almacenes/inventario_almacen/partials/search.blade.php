<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2 font-roboto-14">
        <div class="col mb-2">
            <select name="almacen_id" id="almacen_id" class="form-control">
                <option value="-1">--Todas las Sucursales--</option>
                @foreach ($almacenes as $index => $value)
                    <option value="{{ $index }}" @if(request('almacen_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control">
                <option value="-1">--Todos las Categorias Programaticas--</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}" @if(request('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control">
                <option value="-1">--Todas las Partidas Presupuestarias--</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if(request('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <select name="producto_id" id="producto_id" class="form-control">
                <option value="-1">--Todas los Productos--</option>
                @foreach ($productos as $index => $value)
                    <option value="{{ $index }}" @if(request('producto_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <button class="btn btn-primary w-100 w-md-auto btn-size" type="button" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </button>
        </div>
        <div class="col mb-2">
            <button class="btn btn-danger w-100 w-md-auto btn-size mr-2" type="button" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-12 text-center mt-2">
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
