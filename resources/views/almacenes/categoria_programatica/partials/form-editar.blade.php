<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="dea_id" value="{{ $categoria_programatica->dea_id }}">
    <input type="hidden" name="categoria_programatica_id" value="{{ $categoria_programatica->id }}">
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-2 mb-2">
            <label for="" class="form-label d-inline">Codigo</label>
            <input type="text" name="codigo" value="{{ $categoria_programatica->codigo }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="row mb-2 font-roboto-14">
        <div class="col-12 col-md-6 col-lg-5 mb-2">
            <label for="" class="form-label d-inline">Categoria Programatica</label>
            <input type="text" name="nombre" value="{{ $categoria_programatica->nombre }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
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
