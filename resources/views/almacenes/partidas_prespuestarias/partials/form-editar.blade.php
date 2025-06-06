<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="partida_presupuestaria_id" value="{{ $partida_presupuestaria->id }}">
        @if ($parent_presupuestaria != null)
            <div class="row mb-2 font-roboto-14">
                <div class="col-12 col-md-6 col-lg-10 mb-2">
                    <label for="dependiente" class="form-label d-inline">Depende de</label>
                    <select name="dependiente_id" id="dependiente_id" class="form-control select2" @if($hijos != 0) disabled @endif>
                        @foreach ($partidas_presupuestarias as $old_partida_presupuestaria)
                            <option value="{{ $old_partida_presupuestaria->id }}"
                                @if($old_partida_presupuestaria->id == old('dependiente_id') || (isset($partida_presupuestaria) && $partida_presupuestaria->parent_id == $old_partida_presupuestaria->id))
                                    selected
                                @endif>
                                {{ $old_partida_presupuestaria->partida_presupuestaria }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" id="dependiente_id">
        @endif
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="numeracion" class="form-label d-inline">Numeracion</label>
                <input type="text" name="numeracion" id="numeracion" value="{{ $partida_presupuestaria->numeracion }}" class="form-control font-roboto-12" {{-- @if($parent_presupuestaria == null) disabled @endif --}}>
            </div>
        </div>
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-6 mb-2">
                <label for="nombre" class="form-label d-inline">Nombre</label>
                <input type="text" name="nombre" value="{{ $partida_presupuestaria->nombre }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-10 mb-2">
                <label for="detalle" class="form-label d-inline">Detalle</label>
                <textarea name="descripcion" rows="4" id="descripcion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ $partida_presupuestaria->descripcion }}</textarea>
            </div>
        </div>
        @if ($parent_presupuestaria != null)
            <div class="row mb-2 font-roboto-14">
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <label for="detalle" class="form-label d-inline">¿Es detalle?</label>
                    <input type="checkbox" id="detalle" name="detalle" {{ $partida_presupuestaria->detalle == '1' ? 'checked' : '' }}>
                </div>
            </div>
        @endif
        <div class="row mb-2 font-roboto-14">
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="habilitar" class="form-label d-inline">¿Habilitado?</label>
                <input type="hidden" name="estado" value="2">
                <input type="checkbox" id="habilitar" name="estado" value="1" {{ $partida_presupuestaria->estado == '1' ? 'checked' : '' }} @if($hijos != 0) disabled @endif>
            </div>
        </div>
    </form>
</div>
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
