<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="categoria_programatica_id" value="{{ $categoria_programatica->id }}">
    <div class="form-group row font-roboto-13">
        <div class="col-md-6 pr-1 pl-1">
            <label for="partida_presupuestaria_id" class="d-inline">Habilitar Partida Presupuestaria para esta Categoria Programatica</label>
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if(request('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            @can('categoria.presupuestaria.index')
                <br>
                <span class="btn btn-outline-success font-roboto-12 btn-block" onclick="procesar();">
                    <i class="fas fa-plus fa-fw"></i> Registrar
                </span>
            @endcan
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <br>
            <span class="btn btn-outline-danger font-roboto-12 btn-block" onclick="cancelar();">
                <i class="fas fa-close fa-fw"></i> Cancelar
            </span>
        </div>
    </div>
</form>
