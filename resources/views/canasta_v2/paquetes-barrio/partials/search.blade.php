<form action="#" method="get" id="form">
    <input type="hidden" value="{{ $paquete->id }}" id="paquete_id">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <select id="distrito_id" name="distrito_id" class="form-control">
                <option value="">-</option>
                @foreach ($distritos as $index => $value)
                    <option value="{{ $index }}" @if(request('distrito_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <select id="barrio_id" name="barrio_id" class="form-control">
                <option value="">-</option>
                @foreach ($barrios as $index => $value)
                    <option value="{{ $index }}" @if(request('barrio_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <select id="lugar_entrega" name="lugar_entrega" class="form-control">
                <option value="">-</option>
                @foreach ($lugares_entregas as $index => $value)
                    <option value="{{ $index }}" @if(request('lugar_entrega') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if (request('estado') == $index) selected @endif>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_inicial" value="{{ request('fecha_inicial') }}" id="fecha_inicial" placeholder="--Fecha Inicial--" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_final" value="{{ request('fecha_final') }}" id="fecha_final" placeholder="--Fecha Final--" class="form-control font-roboto-12" data-language="es">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Ir atras" style="cursor: pointer;">
                <span class="btn btn-outline-primary font-roboto-12" onclick="ir_atras();">
                    <i class="fas fa-angle-double-left fa-fw"></i>
                </span>
            </span>
            @can('canasta.paquetes.barrio.create')
                <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Registrar Barrio" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
            @can('canasta.paquetes.barrio.pdf')
                <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Exportar a Pdf" style="cursor: pointer;">
                    <span class="btn btn-outline-danger font-roboto-12" onclick="pdf();">
                        <i class="fa fa-file-pdf fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
            @can('canasta.paquetes.barrio.excel')
                <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Exportar a Excel" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                        <i class="fa fa-file-excel fa-fw" aria-hidden="true"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>

            <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="search();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
        </div>
    </div>
</form>
