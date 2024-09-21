<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 mb-2 pr-1 pl-1">
            <input type="text" name="gestion" id="gestion" placeholder="-- gestion --" value="{{ request('gestion') }}" class="form-control font-roboto-12 intro" onkeypress="return valideNumberSinDecimal(event);">
        </div>
        <div class="col-md-2 mb-2 pr-1 pl-1">
            <input type="text" name="fecha" id="fecha" placeholder="-- Fecha --" value="{{ request('fecha') }}" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 mb-2 pr-1 pl-1">
            <input type="text" name="nro_documento" id="nro_documento" placeholder="-- Nro_documento --" value="{{ request('nro_documento') }}" class="form-control font-roboto-12 intro uppercase">
        </div>
        <div class="col-md-6 mb-2 pr-1 pl-1">
            <input type="text" name="referencia" id="referencia" placeholder="-- Referencia --" value="{{ request('referencia') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-5 mb-2 pr-1 pl-1">
            <select name="tipo_id" id="tipo_id" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 pr-1 pl-1">
            @can('archivos.create')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus fa-fw"></i>
                    </span>
                </span>
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a Excel" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                        <i class="fa fa-file-excel fa-fw"></i>
                    </span>
                </span>
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a Pdf" style="cursor: pointer;">
                    <span class="btn btn-outline-danger font-roboto-12" onclick="pdf();">
                        <i class="fa fa-file-pdf fa-fw"></i>
                    </span>
                </span>
            @endcan
            <span class="btn btn-outline-danger font-roboto-12  float-right" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
