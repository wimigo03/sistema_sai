<form action="#" method="post" id="form">
    @csrf
    <div class="div_cabecera mb-4">
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="fecha_i" class="form-label d-inline font-roboto-14">Fecha del turno</label>
                <input type="text" name="fecha_i" id="fecha_i" class="form-control font-roboto-14 intro">
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="cantidad" class="form-label d-inline font-roboto-14">Cantidad Registros</label>
                <input type="text" name="cantidad" id="cantidad" class="form-control font-roboto-14 intro">
            </div>
        </div>
    </div>

    <div class="row" style="display: flex; justify-content: space-between;">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                <button class="btn btn-outline-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Generar Registros
                </button>
                <button class="btn btn-outline-danger w-100 w-md-auto py-2 font-roboto-14 font-weight-bold" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
            </div>
            <div class="text-center mt-3">
                <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </div>
</form>
