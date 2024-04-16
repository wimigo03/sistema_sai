<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="almacen_id" value="{{ $almacen->id }}" id="almacen_id">
        <input type="hidden" name="dea_id" value="{{ $dea->id }}" id="dea_id">
        <div class="form-group row font-roboto-12">
            <div class="col-md-4 pr-1 pl-1">
                <label for="nombre" class="d-inline"><b>Nombre</b></label>
                <input type="text" name="nombre" value="{{ $almacen->nombre }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-6 pr-1 pl-1">
                <label for="direccion" class="d-inline"><b>Direccion</b></label>
                <input type="text" name="direccion" value="{{ $almacen->direccion }}" id="direccion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-3 pr-1 pl-1">
                <label for="user_id" class="d-inline"><b>Encargado</b></label>
                <select name="user_id" id="user_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($encargados as $encargado)
                        <option value="{{ $encargado->id }}"
                            @if($encargado->id == old('user_id') || (isset($almacen) && $almacen->user_id == $encargado->id))
                                selected
                            @endif>
                            {{ strtoupper($encargado->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" id="btn-registro" type="button" onclick="procesar();">
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
