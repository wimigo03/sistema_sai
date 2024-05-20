<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="fecha" class="d-inline"><b>Fecha</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha" value="{{ request('fecha') }}" id="fecha" placeholder="--dd/mm/aaaa--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Titulo</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="enlace" class="d-inline"><b>Enlace</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1">
            <textarea name="enlace" value="{{ old('enlace') }}" id="enlace" class="form-control font-roboto-12"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fas fa-paper-plane fa-fw"></i> Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
