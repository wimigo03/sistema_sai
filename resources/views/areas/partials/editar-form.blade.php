<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="area_id" value="{{ $area_actual->idarea }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="dea" class="d-inline"><b>Direccion Administrativa</b></label>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" value="{{ $area_actual->dea->descripcion }}" class="form-control font-roboto-12" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="dependiente_de" class="d-inline"><b>Dependiente de</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1">
            <div class="select2-container-rojo">
                @if ($area_actual->idarea != 1)
                    <select name="parent_id" id="parent_id" class="form-control font-roboto-12 select2">
                        <option value="">--Seleccionar--</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->idarea }}"
                                @if($area->idarea == old('parent_id') || (isset($area_actual) && $area_actual->parent_id == $area->idarea))
                                    selected
                                @endif>
                                {{ $area->nombrearea }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="text" value="#" class="form-control font-roboto-12 select2" disabled>
                @endif

            </div>
        </div>
    </div>
    <div class="form-group row font-roboto-12  align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="area" class="d-inline"><b>Nombre</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="nombre_area" id="nombre_area" value="{{ $area_actual->nombrearea }}" class="form-control font-roboto-12 input-rojo" data-language="es" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12  align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="area_alias" class="d-inline"><b>Alias</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="alias" id="alias" value="{{ $area_actual->alias }}" class="form-control font-roboto-12 input-rojo" data-language="es" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12  align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="nivel" class="d-inline"><b>Nivel</b></label>
        </div>
        <div class="col-md-1 pr-1 pl-1">
            <input type="text" id="nivel" value="{{ $area_actual->nivel }}" class="form-control font-roboto-12" data-language="es" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12  align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if($area_actual->tipo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12  align-items-center">
        <div class="col-md-4 pr-1 text-right">
            <label for="estado" class="d-inline"><b>Estado</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if($area_actual->estadoarea == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-6 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        <span class="btn btn-primary font-roboto-12" onclick="procesar();">
            <i class="fas fa-paper-plane fa-fw"></i> Actualizar
        </span>
        <span class="btn btn-danger font-roboto-12" onclick="cancelar();">
            <i class="fas fa-times fa-fw"></i> Cancelar
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
