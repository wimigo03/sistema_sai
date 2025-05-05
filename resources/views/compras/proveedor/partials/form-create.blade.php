<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <div class="form-group row font-roboto-14">
            <div class="col-md-4 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control font-roboto-14" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_carnet" class="d-inline"><b>Nro Carnet</b></label>
                <input type="text" name="nro_carnet" value="{{ old('nro_carnet') }}" id="nro_ci" class="form-control font-roboto-14">
            </div>
        </div>
        <div class="form-group row font-roboto-14">
            <div class="col-md-4 pr-1 pl-1">
                <label for="representante" class="d-inline"><b>Representante</b></label>
                <input type="text" name="representante" value="{{ old('representante') }}" class="form-control font-roboto-14" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="nit" class="d-inline"><b>NIT</b></label>
                <input type="text" name="nit" value="{{ old('nit') }}" id="nit" class="form-control font-roboto-14">
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="telefono" class="d-inline"><b>Telefono</b></label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" id="telefono" class="form-control font-roboto-14">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-14" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </button>
                <button class="btn btn-outline-danger font-roboto-14" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>
