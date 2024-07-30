<form action="#" method="post" id="form">
    @csrf
    @if ($partida_presupuestaria != null)
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-3 pr-1 pl-1 text-right">
                <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica: </b></label>
            </div>
            <div class="col-md-7 pr-1 pl-1">
                <input type="hidden" name="categoria_programatica_id" id="categoria_programatica_id" value="{{ $partida_presupuestaria->categoria_programatica_id }}" class="form-control font-roboto-12">
                <input type="text" value="{{ $partida_presupuestaria->categoria_programatica->codigo . ' - ' . $partida_presupuestaria->categoria_programatica->nombre }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-3 pr-1 pl-1 text-right">
                <label for="dependiente" class="d-inline"><b>Depende de: </b></label>
            </div>
            <div class="col-md-6 pr-1 pl-1">
                <input type="hidden" name="partida_dependiente_id" id="partida_dependiente_id" value="{{ $partida_presupuestaria->id }}">
                <input type="text" id="dependiente" value="{{ $partida_presupuestaria->numeracion . ' (' . $partida_presupuestaria->codigo . ') ' . $partida_presupuestaria->nombre }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
    @else
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-3 pr-1 pl-1 text-right">
                <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica: </b></label>
            </div>
            <div class="col-md-7 pr-1 pl-1">
                <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($categorias_programaticas as $index => $value)
                        <option value="{{ $index }}" @if(old('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="numeracion" class="d-inline"><b>Numeracion: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="numeracion" id="numeracion" value="{{ old('numeracion') }}" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Partida Presupuestaria: </b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="descripcion" class="d-inline"><b>Descripcion: </b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <textarea name="descripcion" rows="5" id="descripcion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ old('descripcion') }}</textarea>
        </div>
    </div>
    @if ($partida_presupuestaria != null)
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-3 pr-1 pl-1 text-right">
                <label for="detalle" class="d-inline"><b>¿Es Cuenta Detalle?</b></label>
            </div>
            <div class="col-md-1 pr-1 pl-1">
                <input type="checkbox" id="detalle" class="ml-2" name="detalle" {{ old('detalle') ? 'checked' : '' }}>
            </div>
        </div>
    @endif
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fas fa-paper-plane fa-fw"></i> Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
