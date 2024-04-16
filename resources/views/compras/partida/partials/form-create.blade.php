<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-3 pr-1 pl-1">
                <label for="codigo" class="d-inline"><b>Codigo</b></label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" id="codigo" class="form-control font-roboto-12">
            </div>
            <div class="col-md-5 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-8 pr-1 pl-1">
                <label for="detalle" class="d-inline"><b>Descripcion</b></label>
                <textarea name="detalle" id="detalle" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ old('detalle') }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </button>
                <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>
