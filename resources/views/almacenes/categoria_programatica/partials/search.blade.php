<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2 font-roboto-14">
        <div class="col mb-2">
            <input type="text" name="codigo" value="{{ request('codigo') }}" placeholder="--Codigo--" class="form-control font-roboto-14 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col mb-2">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Categoria Programatica--" class="form-control font-roboto-14 intro" oninput="this.value = this.value.toUpperCase()">
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
    <div class="row">
        <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
            @can('categoria.programatica.create')
                <span class="btn btn-outline-success w-100 w-md-auto btn-size mr-2 mb-2" onclick="create();">
                    <i class="fas fa-plus fa-fw"></i> Registrar
                </span>
            @endcan
            <span class="btn btn-outline-danger w-100 w-md-auto btn-size mr-2 mb-2" onclick="limpiar();">
                <i class="fas fa-eraser fa-fw"></i> Limpiar
            </span>
            <span class="btn btn-outline-primary w-100 w-md-auto btn-size mb-2" onclick="search();">
                <i class="fas fa-search fa-fw"></i> Buscar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
