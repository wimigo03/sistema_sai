<form action="#" method="get" id="form">
    <input type="hidden" value="{{ $paquete_barrio->id_paquete }}" id="paquete_id">
    <input type="hidden" value="{{ $paquete_barrio->id }}" id="paquete_barrio_id">
    <div class="form-group row">
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" value="{{ request('nombre') }}" id="nombre" placeholder="--Nombres--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="ap_paterno" value="{{ request('ap_paterno') }}" id="ap_paterno" placeholder="--Apellido Paterno--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="ap_materno" value="{{ request('ap_materno') }}" id="ap_materno" placeholder="--Apellido Materno--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="nro_carnet" value="{{ request('nro_carnet') }}" id="nro_carnet" placeholder="--N° de carnet--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="extension" id="extension" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($extensiones as $index => $value)
                    <option value="{{ $index }}" @if (request('extension') == $index) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_nac" value="{{ request('fecha_nac') }}" id="fecha_nac" placeholder="--Fecha Nac.--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="edad_inicial" value="{{ request('edad_inicial') }}" id="edad_inicial" placeholder="--Edad Inicial--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="edad_final" value="{{ request('edad_final') }}" id="edad_final" placeholder="--Edad Final--" class="form-control font-roboto-12 intro" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="sexo" id="sexo" class="form-control font-roboto-12">
                <option value="">-</option>
                @foreach ($sexos as $index => $value)
                    <option value="{{ $index }}" @if (request('sexo') == $index) selected @endif>
                        {{ $value }}</option>
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
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Ir atras" style="cursor: pointer;">
                <span class="btn btn-outline-primary font-roboto-12" onclick="ir_atras();">
                    <i class="fas fa-angle-double-left fa-fw"></i>
                </span>
            </span>
            @if ($paquete_barrio->estado == '1')
                @can('canasta.entregas.create')
                    <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Registrar Beneficiarios" style="cursor: pointer;">
                        <span class="btn btn-outline-success font-roboto-12" onclick="create();">
                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                        </span>
                    </span>
                @endcan
                @can('canasta.entregas.get.boletas')
                    <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Generar boletas de entrega" style="cursor: pointer;">
                        <span class="btn btn-outline-danger font-roboto-12" onclick="pdf_get_boletas_entrega();">
                            <i class="fas fa-address-card fa-fw"></i>
                        </span>
                    </span>
                @endcan
                @can('canasta.entregas.pdf.habilitados.sin')
                    <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Generar listado de beneficiarios registrados (1)" style="cursor: pointer;">
                        <span class="btn btn-outline-warning font-roboto-12" onclick="pdf_habilitados_sin_registro();">
                            <i class="fas fa-users-slash fa-fw"></i>
                        </span>
                    </span>
                @endcan
                @can('canasta.entregas.pdf.habilitados.con')
                    <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Generar listado de beneficiarios registrados (2)" style="cursor: pointer;">
                        <span class="btn btn-outline-warning font-roboto-12" onclick="pdf_habilitados_con_registro();">
                            <i class="fas fa-users fa-fw"></i>
                        </span>
                    </span>
                @endcan
            @endif
            @can('canasta.entregas.excel')
                <span class="tts:right tts-slideIn tts-custom root float-left mr-1" aria-label="Exportar a Excel" style="cursor: pointer;">
                    <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                        <i class="fas fa-file-excel fa-fw"></i>
                    </span>
                </span>
            @endcan
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>

            @if ($paquete_barrio->estado == '1')
                @can('canasta.entregas.habilitar.todo')
                    {{--<span class="btn btn-danger font-roboto-12" onclick="deshabilitar_todo();">
                        <i class="fas fa-arrow-left fa-fw"></i> Restablecer Todo
                    </span>--}}
                    <span class="btn btn-success font-roboto-12" onclick="habilitar_todo();">
                        <i class="fas fa-arrow-right fa-fw"></i> Procesar Entrega
                    </span>
                @endcan
                @can('canasta.entregas.finalizar')
                    @if ($paquete_barrio->total_no_registrados >= 0)
                        <span class="btn btn-primary font-roboto-12" onclick="procesar();">
                            <i class="fas fa-paper-plane fa-fw"></i> Finalizar Entrega
                        </span>
                    @else
                        <span class="tts:left tts-slideIn tts-custom" aria-label="No permitido" style="cursor: pointer;">
                            <span class="btn btn-secondary font-roboto-12">
                                <i class="fas fa-paper-plane fa-fw"></i> Finalizar Entrega ({{ $paquete_barrio->total_no_registrados }})
                            </span>
                        </span>
                    @endif
                @endcan
            @else
                @can('canasta.entregas.restablecer')
                    <span class="btn btn-primary font-roboto-12 float-left" onclick="restablecer();">
                        <i class="far fa-folder-open fa-fw"></i> Habilitar Entrega
                    </span>
                @endcan
            @endif
            <span class="btn btn-outline-danger font-roboto-12 float-right" onclick="limpiar();">
                <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
            </span>
            <span class="btn btn-outline-primary font-roboto-12 float-right mr-1" onclick="search();">
                <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
            </span>
        </div>
    </div>
</form>
