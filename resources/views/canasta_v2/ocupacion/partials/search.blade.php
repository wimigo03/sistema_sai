<form action="#" method="get" id="form">
    <div class="form-group row abs-center">
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="ocupacion" value="{{ request('ocupacion') }}" id="ocupacion" placeholder="--Profesion/Ocupacion--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row abs-center">
        <div class="col-md-8 pr-1 pl-1">
            @can('canasta.barrios.create')
                <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                    <i class="fa fa-plus fa-fw"></i>
                </span>
            @endcan
            <span class="btn btn-outline-danger font-roboto-12 float-right ml-1" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right" onclick="search();">
                <i class="fa fa-search fa-fw"></i>&nbsp;Buscar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
