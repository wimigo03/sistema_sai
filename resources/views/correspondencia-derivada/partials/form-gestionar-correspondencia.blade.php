
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1 pl-1">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir atras" style="cursor: pointer;">
            <a href="{{ route('correspondencia.local.index') }}" class="btn btn-outline-primary font-roboto-12">
                <i class="fa fa-arrow-left fa-fw" aria-hidden="true"></i>
            </a>
        </span>
    </div>
    @canany(['correspondencia_local.cargarpdf', 'correspondencia_local.urlfile', 'correspondencia_local.actualizarpdf','correspondencia_local.edit','correspondencia_local.derivar'])
    <div class="col-md-10 pr-1 pl-1 text-right">
        @if ($data->estado_corresp == 0)
            @can('correspondencia_local.cargarpdf')
                <a href="{{ route('correspondencia.local.cargarpdf', $data->id_recepcion) }}" class="btn btn-outline-danger font-roboto-12">
                    <i class="fa fa-file-pdf fa-fw" aria-hidden="true"></i> Registrar en digital
                </a>
            @endcan
        @elseif ($data->estado_corresp == 1)
            @can('correspondencia_local.urlfile')
                <a href="{{ route('correspondencia.local.urlfile', $data->id_recepcion) }}" class="btn btn-outline-info font-roboto-12" target="blank_">
                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> Ir a digital
                </a>
            @endcan
            @can('correspondencia_local.actualizarpdf')
                <a href="{{ route('correspondencia.local.actualizarpdf', $data->id_recepcion) }}" class="btn btn-outline-secondary font-roboto-12">
                    <i class="fa fa-file fa-fw text-warning" aria-hidden="true"></i> Cambiar digital
                </a>
            @endcan
        @endif
        @can('correspondencia_local.edit')
            <a href="{{ route('correspondencia.local.edit', $data->id_recepcion) }}" class="btn btn-outline-warning font-roboto-12">
                <i class="fa fa-pencil fa-fw text-dark" aria-hidden="true"></i> Editar correspondencia
            </a>
        @endcan
        @can('correspondencia_local.derivar')
            @if ($data->estado_corresp == 0)
                <b class="text-danger font-roboto-12">--Sin digital--</b>
            @elseif ($data->estado_corresp == 1)
                <a href="{{ route('correspondencia.local.derivar', $data->id_recepcion) }}" class="btn btn-outline-success font-roboto-12">
                    <i class="fa fa-random fa-fw" aria-hidden="true"></i> Derivar correspondencia
                </a>
            @endif
        @endcan
    </div>
    @endcanany
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1 pl-1">
        <label for="fecha" class="d-inline"><b>Fecha de recepcion</b></label>
        <input id="fecha" type="text" class="form-control font-roboto-12" value="{{ \Carbon\Carbon::parse($data->fecha_recepcion)->format('d/m/Y') }}" readonly>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-10 pr-1 pl-1">
        <label for="remitente" class="d-inline"><b>Remintente</b></label>
        <input id="remitente" type="text" class="form-control font-roboto-12" value="{{ $data->nombres_remitente }} {{ $data->apellidos_remitente }}" readonly>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-10 pr-1 pl-1">
        <label for="asunto" class="d-inline"><b>Asunto</b></label>
        <textarea id="detalle" class="form-control font-roboto-12" required readonly>{{ $data->asunto }}</textarea>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1 pl-1">
        <label for="codigo" class="d-inline"><b>Codigo</b></label>
        <input id="codigo" type="text" class="form-control font-roboto-12" value="{{ $data->n_oficio }}" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="hoja_ruta" class="d-inline"><b>Hoja de ruta</b></label>
        <input type="text" class="form-control font-roboto-12" value="{{ $data->observaciones }}" readonly>
    </div>
    <div class="col-md-8">
        <label for="area" class="d-inline"><b>Area / Unidad</b></label>
        <input type="text" value="{{ $data->nombre_unidad }}" class="form-control font-roboto-12" readonly>
    </div>
</div>
