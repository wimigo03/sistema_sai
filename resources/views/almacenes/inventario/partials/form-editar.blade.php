<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="almacen_id" value="{{ $almacen->id }}" id="almacen_id">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Nombre del almacen: </b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ $almacen->nombre }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="direccion" class="d-inline"><b>Direccion o Ubicacion</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1">
            <input type="text" name="direccion" value="{{ $almacen->direccion }}" id="direccion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="user_id" class="d-inline"><b>Encargado</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <select name="user_id" id="user_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($encargados as $encargado)
                    <option value="{{ $encargado->id }}"
                        @if($encargado->id == old('user_id') || (isset($almacen) && $almacen->user_id == $encargado->id))
                            selected
                        @endif>
                        {{ strtoupper($encargado->empleado) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" id="btn-registro" onclick="procesar();">
                <i class="fas fa-paper-plane fa-fw"></i> Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
