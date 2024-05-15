<br>
<div class="form-group row">
    <div class="col-md-6 pr-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pl-1 text-right">
        @if ($empleado->estado == '1')
            @can('empleados.retirar')
                <span class="btn btn-warning font-roboto-12" onclick="retirar();">
                    <i class="fas fa-user-times fa-fw"></i> Retirar
                </span>
            @endcan
        @else
            @can('empleados.recontratar')
                <span class="btn btn-primary font-roboto-12" onclick="recontratar();">
                    <i class="fas fa-address-card fa-fw"></i> Recontratar
                </span>
            @endcan
        @endif
        @can('empleados.show')
            <span class="btn btn-danger font-roboto-12" onclick="exportar();">
                <i class="fas fa-file-pdf fa-fw"></i> Exportar
            </span>
        @endcan
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
@foreach ($empleados_contratos as $empleado_contrato)
    <div class="card card-body">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <span class="{{ $empleado->color_status }}">
                    <i class="fas fa-user fa-fw"></i> {{ $empleado->status_completo }}
                </span>
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="area_id" class="d-inline"><b>Area:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                {{ $empleado->area->nombrearea }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="cargo_id" class="d-inline"><b>Cargo:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->file->nombrecargo }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="fecha_ingreso" class="d-inline"><b>Fecha de ingreso:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                {{ $empleado_contrato->fecha_ingreso != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_ingreso)->format('d/m/Y') : 'No corresponde' }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="tipo" class="d-inline"><b>Tipo:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->tipos }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="fecha_retiro" class="d-inline"><b>Fecha de retiro:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                {{ $empleado_contrato->fecha_retiro != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_retiro)->format('d/m/Y') : 'No corresponde' }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="obs_retiro" class="d-inline"><b>Causa del retiro:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->obs_retiro }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="n_contrato" class="d-inline"><b>N° contrato:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                {{ $empleado_contrato->ncontrato }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="n_preventivo" class="d-inline"><b>N° Preventivo:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->npreventivo }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="seguro_salud" class="d-inline"><b>Seguro Salud:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                {{ $empleado_contrato->segsalud }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="biometrico" class="d-inline"><b>Biometrico:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->biometrico }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="rejap" class="d-inline"><b>REJAP:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="checkbox" {{ $empleado_contrato->rejap == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                &nbsp;
            </div>
            <div class="col-md-2 pl-1">
                &nbsp;
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="poai" class="d-inline"><b>POAI:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="checkbox" {{ $empleado_contrato->poai == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="exppoai" class="d-inline"><b>Expiracion:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->exppoai != null ? \Carbon\Carbon::parse($empleado_contrato->exppoai)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="declaracion_jurada" class="d-inline"><b>Declaracion jurada:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="checkbox" {{ $empleado_contrato->decjurada == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="declaracion_jurada" class="d-inline"><b>Expiracion:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->expdecjurada != null ? \Carbon\Carbon::parse($empleado_contrato->expdecjurada)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="sippase" class="d-inline"><b>SIPPASE:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="checkbox" {{ $empleado_contrato->sippase == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="sippase" class="d-inline"><b>Expiracion:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->expsippase != null ? \Carbon\Carbon::parse($empleado_contrato->expsippase)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="induccion" class="d-inline"><b>Induccion:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="checkbox" {{ $empleado_contrato->induccion == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="induccion" class="d-inline"><b>Expiracion:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->expinduccion != null ? \Carbon\Carbon::parse($empleado_contrato->expinduccion)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-2 pr-1 text-right">
                <label for="progvacacion" class="d-inline"><b>Programacion vacacion:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="checkbox" {{ $empleado_contrato->progvacacion == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="progvacacion" class="d-inline"><b>Expiracion:</b></label>
            </div>
            <div class="col-md-2 pl-1">
                {{ $empleado_contrato->expprogvacacion != null ? \Carbon\Carbon::parse($empleado_contrato->expprogvacacion)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
    </div>
    <br>
@endforeach
