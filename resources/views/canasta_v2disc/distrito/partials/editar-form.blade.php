<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="distrito_id" value="{{ $distrito->id }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Nombre: </b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" id="nombre" value="{{ $distrito->nombre }}" oninput="this.value = this.value.toUpperCase()" class="form-control font-verdana-12 intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-10 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Actualizar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
