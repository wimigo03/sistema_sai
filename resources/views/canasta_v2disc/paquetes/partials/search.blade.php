<form action="#" method="get" id="form">
    <div class="form-group row abs-center">
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="gestion" placeholder="-- Gestion --" value="{{request('gestion')}}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="periodo_id" id="periodo_id" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($periodos as $index => $value)
                    <option value="{{ $index }}" @if (request('periodo_id') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="entrega" id="entrega" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($entregas as $index => $value)
                    <option value="{{ $index }}" @if (request('entrega') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row abs-center">
        <div class="col-md-8 pr-1 pl-1">
            @can('canastadisc.paquetes.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar Paquete" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
            <span class="btn btn-outline-danger font-roboto-12 float-right mr-1" onclick="limpiar();">
                <i class="fa fa-eraser"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </span>
        </div>
    </div>
</form>
