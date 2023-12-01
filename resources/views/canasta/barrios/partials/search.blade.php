<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1">
            <input type="text" name="codigo" placeholder="--Codigo--" value="{{request('codigo')}}" class="form-control form-control-sm font-verdana-bg">
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="--Nombre--" value="{{request('nombre')}}" class="form-control form-control-sm font-verdana-bg">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($tipos_barrio as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="distrito" id="distrito" class="form-control form-control-sm">
                <option value="">-</option>
                @foreach ($distritos as $index => $value)
                    <option value="{{ $index }}" @if(request('distrito') == $index) selected @endif >{{ $value }}</option>
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
        <div class="col-md-12 text-right">
            <button class="btn btn-primary font-verdana" type="button" onclick="search();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-danger font-verdana text-white" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <button class="btn btn-success font-verdana" type="button" onclick="excel();">
                <i class="fa-solid fa-file-excel"></i>&nbsp;Exportar a Excel
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</div>
