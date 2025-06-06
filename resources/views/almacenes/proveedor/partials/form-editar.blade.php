<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="proveedor_id" value="{{ $proveedor->id }}">
    <input type="hidden" name="dea_id" value="{{ $proveedor->dea_id }}">
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="title" class="form-label d-inline">Nombre</label>
                <input type="text" name="nombre" value="{{ $proveedor->nombre }}" class="form-control font-roboto-14" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="title" class="form-label d-inline">Nro Carnet</label>
                <input type="text" name="nro_carnet" value="{{ $proveedor->nro_ci }}" id="nro_ci" class="form-control font-roboto-14">
            </div>
        </div>
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="title" class="form-label d-inline">Representante</label>
                <input type="text" name="representante" value="{{ $proveedor->representante }}" class="form-control font-roboto-14" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="title" class="form-label d-inline">NIT</label>
                <input type="text" name="nit" value="{{ $proveedor->nit }}" id="nit" class="form-control font-roboto-14">
            </div>
        </div>
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="title" class="form-label d-inline">Telefono</label>
                <input type="text" name="telefono" value="{{ $proveedor->telefono }}" id="telefono" class="form-control font-roboto-14">
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
