<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-3 pr-1">
            <select name="tipo" id="tipo" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="--Nombre--" value="{{request('nombre')}}" class="form-control form-control-sm font-verdana-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="distrito_id" id="distrito" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($distritos as $index => $value)
                    <option value="{{ $index }}" @if(request('distrito_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pl-1">
            <select name="estado" id="estado" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1">
            @can('canasta.barrios.create')
                <a href="#create" data-toggle="modal" >
                    <button class="btn btn-outline-primary font-verdana-11" type="button" >
                        &nbsp;<i class="fa fa-plus"></i>&nbsp;Crear
                    </button>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
                </a>
            @endcan
        </div>
        <div class="col-md-6 pl-1 text-right">
            <button class="btn btn-outline-primary font-verdana-11" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-verdana-11" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
