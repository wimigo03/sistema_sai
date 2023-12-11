<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1">
            <input type="text" name="periodo" placeholder="--Periodo--" value="{{request('periodo')}}" class="form-control form-control-sm font-verdana-bg">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="gestion" id="gestion" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($gestiones as $index => $value)
                    <option value="{{ $index }}" @if(request('gestion') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="mes" id="mes" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($meses as $index => $value)
                    <option value="{{ $index }}" @if(request('mes') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_entrega" placeholder="--Nro. Entrega--" value="{{request('nro_entrega')}}" class="form-control form-control-sm font-verdana-bg">
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
        <div class="col-md-12 text-right">
            <button class="btn btn-primary font-verdana" type="button" onclick="search();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-danger font-verdana text-white" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
