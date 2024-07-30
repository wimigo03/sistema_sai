<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="partida_presupuestaria_id" value="{{ $partida_presupuestaria->id }}">
        @if ($parent_presupuestaria != null)
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica: </b></label>
                </div>
                <div class="col-md-7 pr-1 pl-1">
                    <input type="text" value="{{ $parent_presupuestaria->categoria_programatica->codigo . ' - ' . $parent_presupuestaria->categoria_programatica->nombre }}" class="form-control font-roboto-12" disabled>
                </div>
            </div>
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="dependiente" class="d-inline"><b>Depende de: </b></label>
                </div>
                <div class="col-md-6 pr-1 pl-1">
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
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica: </b></label>
                </div>
                <div class="col-md-7 pr-1 pl-1">
                    <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                        @foreach ($categorias_programaticas as $categoria_programatica)
                            <option value="{{ $categoria_programatica->id }}"
                                @if($categoria_programatica->id == old('categoria_programatica_id') || (isset($partida_presupuestaria) && $partida_presupuestaria->categoria_programatica_id == $categoria_programatica->id))
                                    selected
                                @endif>
                                {{ $categoria_programatica->categoria_programatica }}
                            </option>
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
                <input type="text" name="numeracion" id="numeracion" value="{{ $partida_presupuestaria->numeracion }}" class="form-control font-roboto-12" @if($parent_presupuestaria == null) disabled @endif>
            </div>
        </div>
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-3 pr-1 pl-1 text-right">
                <label for="nombre" class="d-inline"><b>Partida Presupuestaria: </b></label>
            </div>
            <div class="col-md-5 pr-1 pl-1">
                <input type="text" name="nombre" value="{{ $partida_presupuestaria->nombre }}" id="nombre" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-3 pr-1 pl-1 text-right">
                <label for="descripcion" class="d-inline"><b>Descripcion: </b></label>
            </div>
            <div class="col-md-7 pr-1 pl-1">
                <textarea name="descripcion" rows="5" id="descripcion" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ $partida_presupuestaria->descripcion }}</textarea>
            </div>
        </div>
        @if ($parent_presupuestaria != null)
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="detalle" class="d-inline"><b>¿Es Cuenta Detalle?</b></label>
                </div>
                <div class="col-md-1 pr-1 pl-1">
                    <input type="checkbox" id="detalle" name="detalle" {{ $partida_presupuestaria->detalle == '1' ? 'checked' : '' }}>
                </div>
            </div>
        @endif
        @if ($partida_presupuestaria->detalle == '1')
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="habilitar" class="d-inline"><b>¿Habilitado?</b></label>
                </div>
                <div class="col-md-1 pr-1 pl-1">
                    <input type="checkbox" id="habilitar" name="estado" {{ $partida_presupuestaria->estado == '1' ? 'checked' : '' }}>
                </div>
            </div>
        @endif
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </button>
                <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>
