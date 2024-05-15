<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="empleado_id" value="{{ $empleado->idemp }}">
    <div class="form-group row font-roboto-20 align-items-center">
        <div class="col-md-12 pr-1 text-center">
            <b>
                <u>
                    {{ $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat }}<br>
                    {{ $empleado->file_cargo }}
                </u>
            </b>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" value="{{ $empleado->ultimo_tipo_contrato_full}}" class="form-control font-roboto-12" data-language="es" disabled>
        </div>
    </div>
    @if ($empleado->ultimo_tipo_contrato == 'C')
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-5 pr-1 text-right">
                <label for="tipo" class="d-inline"><b>Conclusion de contrato:</b></label>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <input type="text" value="{{ $empleado->ultimo_contrato_conclusion}}" class="form-control font-roboto-12" data-language="es" disabled>
            </div>
        </div>
    @endif
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 text-right">
            <label for="fecha_ingreso" class="d-inline"><b>Fecha de ingreso</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" value="{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}" class="form-control font-roboto-12" data-language="es" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 text-right">
            <label for="fecha_retiro" class="d-inline"><b>Fecha de retiro</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_retiro" value="{{ old('fecha_retiro') }}" id="fecha_retiro" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 text-right">
            <label for="obs_retiro" class="d-inline"><b>Causa del retiro</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="obs_retiro" value="{{ old('obs_retiro') }}" id="obs_retiro" class="form-control font-roboto-12" data-language="es" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-6 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        <span class="btn btn-primary font-roboto-12" onclick="procesar();">
            <i class="fas fa-paper-plane fa-fw"></i> Procesar
        </span>
        <span class="btn btn-danger font-roboto-12" onclick="cancelar();">
            <i class="fas fa-times fa-fw"></i> Cancelar
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
