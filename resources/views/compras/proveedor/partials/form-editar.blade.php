<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="proveedor_id" value="{{ $proveedor->id }}">
        <input type="hidden" name="dea_id" value="{{ $proveedor->dea_id }}">
        <div class="form-group row font-roboto-12">
            <div class="col-md-4 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ $proveedor->nombre }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_carnet" class="d-inline"><b>Nro Carnet</b></label>
                <input type="text" name="nro_carnet" value="{{ $proveedor->nro_ci }}" id="nro_ci" class="form-control font-roboto-12">
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-4 pr-1 pl-1">
                <label for="representante" class="d-inline"><b>Representante</b></label>
                <input type="text" name="representante" value="{{ $proveedor->representante }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="nit" class="d-inline"><b>NIT</b></label>
                <input type="text" name="nit" value="{{ $proveedor->nit }}" id="nit" class="form-control font-roboto-12">
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="telefono" class="d-inline"><b>Telefono</b></label>
                <input type="text" name="telefono" value="{{ $proveedor->telefono }}" id="telefono" class="form-control font-roboto-12">
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
