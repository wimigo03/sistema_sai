<form action="#" method="get" id="form">
    <div class="row font-roboto-11">
        <div class="col-md-3 pr-1 pl-1 mb-2">
            <select name="almacen_id" id="almacen_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($almacenes as $index => $value)
                    <option value="{{ $index }}" @if(request('almacen_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 pr-1 pl-1 mb-2">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}" @if(request('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1 mb-2">
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if(request('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-4 pr-1 pl-1 mb-2">
            <input type="text" name="item" value="{{ request('item') }}" id="item" placeholder="--Material--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1 mb-2">
            <select name="unidad_id" id="unidad_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($unidades as $index => $value)
                    <option value="{{ $index }}" @if(request('unidad_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="row abs-center">
    <div class="col-md-12 pr-1 pl-1 mb-2">
        <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="limpiar();">
            <i class="fas fa-eraser fa-fw"></i> Limpiar
        </span>
        <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="search();">
            <i class="fas fa-search fa-fw"></i> Buscar
        </span>
    </div>
</div>
