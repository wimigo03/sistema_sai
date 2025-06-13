<form action="#" method="post" id="form">
    @csrf
    @isset($presupuesto)
        <input type="hidden" name="presupuesto_id" id="presupuesto_id" value="{{ $presupuesto->id }}">
    @endisset
    <div class="row mb-2">
        <div class="col-12 col-md-6 col-lg-12 mb-2">
            <label for="categoria_programatica_id" class="form-label d-inline font-roboto-14">Categoria Programatica</label>
            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                <option value="">--Seleccionar--</option>
                @foreach ($categorias_programaticas as $index => $value)
                    <option value="{{ $index }}"
                        @if (isset($presupuesto) && $presupuesto->categoria_programatica_id == $index)
                            selected
                        @elseif (old('categoria_programatica_id') == $index)
                            selected
                        @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-6 col-lg-12 mb-2">
            <label for="partida_presupuestaria_id" class="form-label d-inline font-roboto-14">Partida Presupuestaria</label>
            <select id="partida_presupuestaria_id" name="partida_presupuestaria_id" class="form-control select2">
                <option value="">--Seleccionar--</option>
            </select>
        </div>
        <div class="col-12 col-md-6 col-lg-6 mb-2">
            <label for="trimestre" class="form-label d-inline font-roboto-14">Trimestre</label>
            <select name="trimestre" id="trimestre" class="form-control select2">
                @empty($presupuesto)
                    <option value="">--Seleccionar--</option>
                @endempty
                @foreach ($trimestres as $index => $value)
                    <option value="{{ $index }}"
                        @if (isset($presupuesto) && $presupuesto->trimestres == $index)
                            selected
                        @elseif (old('trimestre') == $index)
                            selected
                        @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-6 col-lg-6 mb-2">
            <label for="monto" class="form-label d-inline font-roboto-14">Presupuesto</label>
            <input type="text" name="monto" id="monto" value="{{ isset($presupuesto) ? $presupuesto->monto : old('monto') }}" class="form-control font-roboto-14 intro">
        </div>
        <div class="col-12 col-md-6 col-lg-12 mb-2">
            <label for="gestion" class="form-label d-inline font-roboto-14">Gestion</label>
            <input type="text" name="gestion" id="gestion" value="{{ isset($presupuesto) ? $presupuesto->gestion : $gestion }}" class="form-control font-roboto-14 intro" disabled>
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
