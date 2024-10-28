<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-4 mb-2 pr-1 pl-1">
            <input type="text" name="nombre_completo" id="nombre_completo" placeholder="-- Nombre Completo --" value="{{ request('nombre_completo') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-4 mb-2 pr-1 pl-1">
            <input type="text" name="unidad" id="unidad" placeholder="-- Unidad --" value="{{ request('unidad') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-4 mb-2 pr-1 pl-1">
            <input type="text" name="asunto" id="asunto" placeholder="-- Asunto --" value="{{ request('asunto') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-2 mb-2 pr-1 pl-1">
            <input type="text" name="fecha_i" id="fecha_i" placeholder="-- Desde --" value="{{ request('fecha_i') }}" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 mb-2 pr-1 pl-1">
            <input type="text" name="fecha_f" id="fecha_f" placeholder="-- Hasta --" value="{{ request('fecha_f') }}" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 mb-2 pr-1 pl-1">
            <input type="text" name="codigo" id="codigo" placeholder="-- Codigo --" value="{{ request('codigo') }}" class="form-control font-roboto-12 intro" onkeypress="return valideNumberSinDecimal(event);">
        </div>
        <div class="col-md-12 pr-1 pl-1">
            @can('correspondencia_local.crear')
                <span class="tts:right tts-slideIn tts-custom root" aria-label="Registrar" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                        <i class="fa fa-plus fa-fw"></i>
                    </span>
                </span>
            @endcan
            <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a Excel" style="cursor: pointer;">
                <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                    <i class="fa fa-file-excel fa-fw"></i>
                </span>
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
            <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a Pdf" style="cursor: pointer;">
                <span class="btn btn-outline-danger font-roboto-12" onclick="pdf();">
                    <i class="fa fa-file-pdf fa-fw"></i>
                </span>
            </span>
            <span class="btn btn-outline-danger font-roboto-12  float-right" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="procesar();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
        </div>
    </div>
</form>
