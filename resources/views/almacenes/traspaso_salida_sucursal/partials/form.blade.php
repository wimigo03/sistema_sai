<form action="#" method="post" id="form">
    @csrf
    <div class="mb-4">
        <div class="card card-body">
            <div class="row mb-2">
                <div class="col-12 col-md-6 col-lg-6 mb-2">
                    <label for="almacen_origen_id" class="form-label d-inline font-roboto-14">Sucursal de origen</label>
                    <select name="almacen_origen_id" id="almacen_origen_id" class="form-control select2">
                        <option value="">--Seleccionar--</option>
                        @foreach ($almacenes_origenes as $index => $value)
                            <option value="{{ $index }}"
                                @if (old('almacen_origen_id') == $index)
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-6 mb-2">
                    <label for="almacen_destino_id" class="form-label d-inline font-roboto-14">Sucursal de destino</label>
                    <select name="almacen_destino_id" id="almacen_destino_id" class="form-control select2">
                        <option value="">--Seleccionar--</option>
                        @foreach ($almacenes_destinos as $index => $value)
                            <option value="{{ $index }}"
                                @if (old('almacen_destino_id') == $index)
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-12 mb-2">
                    <label for="ingreso_almacen_id" class="form-label d-inline font-roboto-14">Ingreso</label>
                    <select id="ingreso_almacen_id" name="ingreso_almacen_id" class="form-control select2">
                        <option value="">--Seleccionar--</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-12 mb-2">
                    <label for="obs" class="form-label d-inline font-roboto-14">Observaciones</label>
                    <textarea name="obs" id="obs" class="form-control font-roboto-14">{{ old('obs') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="display: flex; justify-content: space-between;">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                <button class="btn btn-outline-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Crear Comprobante de Traspaso
                </button>
                <button class="btn btn-outline-danger w-100 w-md-auto py-2 font-roboto-14 font-weight-bold" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
            </div>
            <div class="text-center mt-3">
                <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </div>
</form>
