<form action="#" method="post" id="form">
    @csrf
    @isset($farmacia)
        <input type="hidden" name="farmacia_id" id="farmacia_id" value="{{ $farmacia->id }}">
    @endisset
    <div class="div_cabecera mb-4">
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-5 mb-2">
                <label for="dea_id" class="form-label d-inline font-roboto-14">Dirección Administrativa</label>
                <select name="dea_id" id="dea_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($deas as $index => $value)
                        <option value="{{ $index }}"
                            @if (isset($farmacia) && $farmacia->dea_id == $index)
                                selected
                            @elseif (old('dea_id') == $index)
                                selected
                            @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="nombre" class="form-label d-inline font-roboto-14">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ isset($farmacia) ? $farmacia->nombre : old('nombre') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-8 mb-2">
                <label for="direccion" class="form-label d-inline font-roboto-14">Direccion</label>
                <input type="text" name="direccion" id="direccion" value="{{ isset($farmacia) ? $farmacia->direccion : old('direccion') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="whatsapp" class="form-label d-inline font-roboto-14">Whatsapp</label>
                <input type="text" name="whatsapp" placeholder="+591XXXXXXXX" id="whatsapp" value="{{ isset($farmacia) ? $farmacia->whatsapp : old('whatsapp') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-5 mb-2">
                <label for="facebook" class="form-label d-inline font-roboto-14">Facebook</label>
                <input type="text" name="facebook" placeholder="Id Facebook" id="facebook" value="{{ isset($farmacia) ? $farmacia->facebook : old('facebook') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="latitud" class="form-label d-inline font-roboto-14">Coordenada Maps X</label>
                <input type="text" name="latitud" id="latitud" value="{{ isset($farmacia) ? $farmacia->lat: old('latitud') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="longitud" class="form-label d-inline font-roboto-14">Coordenada Maps Y</label>
                <input type="text" name="longitud" id="longitud" value="{{ isset($farmacia) ? $farmacia->lng : old('longitud') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-1">
                <br>
                <a href="https://www.google.com/maps"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-outline-danger w-100">
                    <i class="fa-solid fa-location-dot"></i>
                </a>
            </div>
        </div>
    </div>


    <div class="row" style="display: flex; justify-content: space-between;">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                <button class="btn btn-outline-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
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
