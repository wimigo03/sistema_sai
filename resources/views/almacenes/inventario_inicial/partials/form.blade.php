<form action="#" method="post" id="form">
    @csrf
    <div class="row mb-2">
        <div class="col-12 col-md-6 col-lg-12 mb-2">
            <label for="almacen_id" class="form-label d-inline font-roboto-14">Sucursal</label>
            <select name="almacen_id" id="almacen_id" class="form-control select2">
                @foreach ($almacenes as $index => $value)
                    <option value="{{ $index }}"
                        @if (isset($ingreso_almacen) && $ingreso_almacen->almacen_id == $index)
                            selected
                        @elseif (old('almacen_id') == $index)
                            selected
                        @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 col-md-6 col-lg-12 mb-2">
            <label for="gestion" class="form-label d-inline font-roboto-14">Gestion</label>
            <input type="text" name="gestion" id="gestion" value="{{ old('gestion') }}" class="form-control font-roboto-14 intro">
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
