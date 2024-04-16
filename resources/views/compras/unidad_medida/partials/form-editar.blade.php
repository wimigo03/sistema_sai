<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="unidad_medida_id" value="{{ $unidad_medida->id }}" id="unidad_medida_id">
        <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <select name="tipo" id="tipo" class="form-control select2">
                    @foreach ($tipos as $index => $value)
                        <option value="{{ $index }}" @if($unidad_medida->tipo == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ $unidad_medida->nombre }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="alias" class="d-inline"><b>Alias</b></label>
                <input type="text" name="alias" value="{{ $unidad_medida->alias }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Actualizar
                </button>
                <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>
