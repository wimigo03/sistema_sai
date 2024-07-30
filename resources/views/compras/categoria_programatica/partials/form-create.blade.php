<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-4 pr-1 pl-1 text-right">
                <label for="codigo" class="d-inline"><b>Codigo: </b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-4 pr-1 pl-1 text-right">
                <label for="nombre" class="d-inline"><b>Categoria Programatica: </b></label>
            </div>
            <div class="col-md-5 pr-1 pl-1">
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
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
</div>
