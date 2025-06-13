<form action="#" method="get" id="form">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-12 g-2">
        <div class="col mb-2">
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                <option value="">--Seleccionar--</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}"
                        @if (isset($presupuesto) && $presupuesto->categoria_programatica_id == $index)
                            selected
                        @elseif (request('categoria_programatica_id') == $index)
                            selected
                        @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <select id="partida_presupuestaria_id" name="partida_presupuestaria_id" class="form-control select2">
                <option value="">--Seleccionar--</option>
            </select>
        </div>
        <div class="col mb-2">
            <select name="trimestre" id="trimestre" class="form-control select2">
                <option value="">-</option>
                @foreach ($trimestres as $index => $value)
                    <option value="{{ $index }}" @if(request('trimestre') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <input type="text" name="gestion" value="{{ request('gestion') }}" id="gestion" placeholder="--Gestion--" class="form-control font-roboto-14 intro">
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-center justify-content-md-end">
        @can('presupuesto.create')
            <button class="btn btn-success w-100 w-md-auto btn-size mr-2 font-roboto-14" type="button" onclick="create();">
                <i class="fas fa-plus fa-fw"></i> Registrar
            </button>
        @endcan

        <button class="btn btn-outline-danger w-100 w-md-auto btn-size mr-2 font-roboto-14" type="button" onclick="limpiar();">
            <i class="fas fa-eraser fa-fw"></i> Limpiar
        </button>

        <button class="btn btn-outline-primary w-100 w-md-auto btn-size font-roboto-14" type="button" onclick="search();">
            <i class="fas fa-search fa-fw"></i> Buscar
        </button>
    </div>
    <div class="col-12 text-center mt-2">
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
