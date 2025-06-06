<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="categoria_programatica_id" value="{{ $categoria_programatica->id }}">
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            <br>
            <select name="idarea" id="area_id" class="form-control">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('idarea') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            @can('area.categoria.index')
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
