<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="almacen_id" value="{{ $almacen->id }}">
    <div class="form-group row abs-center">
        <div class="col-md-8 pr-1 pl-1">
            <select name="area_id" id="area_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(request('area_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            @can('almacen.asignar')
                <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="cancelar();">
                    <i class="fas fa-close fa-fw"></i> Cancelar
                </span>
                <span class="btn btn-outline-success font-roboto-12 float-right mr-1" onclick="procesar();">
                    <i class="fas fa-plus fa-fw"></i> Registrar
                </span>
            @endcan
        </div>
    </div>
</form>
