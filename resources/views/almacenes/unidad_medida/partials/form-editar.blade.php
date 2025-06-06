<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="unidad_medida_id" value="{{ $unidad_medida->id }}" id="unidad_medida_id">
    <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-3 mb-2">
            <label for="title" class="form-label d-inline">Tipo</label>
            <select name="tipo" id="tipo" class="form-control select2">
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if($unidad_medida->tipo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <label for="title" class="form-label d-inline">Nombre</label>
            <input type="text" name="nombre" value="{{ $unidad_medida->nombre }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-2 mb-2">
            <label for="title" class="form-label d-inline">Alias</label>
            <input type="text" name="alias" value="{{ $unidad_medida->alias }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12 col-md-6 col-lg-12 mb-2">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
            <button class="btn btn-primary w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0" type="button" onclick="procesar();">
                <i class="fas fa-paper-plane fa-fw"></i> Procesar
            </button>
            <button class="btn btn-danger w-100 w-md-auto btn-size" type="button" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </button>
        </div>
        <div class="text-center mt-3">
            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
        </div>
    </div>
</div>
