<form action="#" method="post" id="form">
    @csrf
    @if ($partida_presupuestaria != null)
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-10 mb-2">
                <label for="dependiente" class="form-label d-inline">Depende de</label>
                <input type="hidden" name="partida_dependiente_id" id="partida_dependiente_id" value="{{ $partida_presupuestaria->id }}">
                <input type="text" id="dependiente" class="form-control font-roboto-12" disabled value="{{ $partida_presupuestaria->numeracion . ' (' . $partida_presupuestaria->codigo . ') ' . $partida_presupuestaria->nombre }}">
            </div>
        </div>
    @endif
    <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="numeracion" class="form-label d-inline">Numeracion</label>
                <input type="text" name="numeracion" id="numeracion" value="{{ old('numeracion') }}" class="form-control font-roboto-12">
            </div>
    </div>
    <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-6 mb-2">
                <label for="nombre" class="form-label d-inline">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
    </div>
    <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-10 mb-2">
                <label for="detalle" class="form-label d-inline">Detalle</label>
                <textarea name="descripcion" rows="5" id="descripcion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ old('descripcion') }}</textarea>
            </div>
    </div>
    @if ($partida_presupuestaria != null)
        <div class="row mb-2 font-roboto-14">
                <div class="col-12 col-md-6 col-lg-10 mb-2">
                    <label for="es_detalle" class="form-label d-inline">¿Es detalle?</label>
                    <input type="checkbox" id="detalle" class="ml-2" name="detalle" {{ old('detalle') ? 'checked' : '' }}>
                </div>
        </div>
    @endif
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
