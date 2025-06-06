<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="almacen_id" value="{{ $almacen->id }}" id="almacen_id">
    <div class="row mb-2">
        <div class="col-12 col-md-6 col-lg-3 mb-2">
            <label for="title" class="form-label d-inline">Nombre</label>
            <input type="text" name="nombre" value="{{ $almacen->nombre }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 col-md-6 col-lg-7 mb-2">
            <label for="direccion" class="form-label d-inline">Direccion</label>
            <input type="text" name="direccion" value="{{ $almacen->direccion }}" id="direccion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <label for="encargado" class="form-label d-inline">Encargado</label>
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
