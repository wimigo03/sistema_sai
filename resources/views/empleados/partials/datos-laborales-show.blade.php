<br>
@foreach ($empleados_contratos as $empleado_contrato)
    <div class="card card-body">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <span class="{{ $empleado_contrato->color_status }} font-roboto-12">
                    <i class="fas fa-user fa-fw"></i> {{ $empleado_contrato->status }}
                </span>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-5 pr-1 mb-2">
                <label for="area_id" class="d-inline"><b>Area de Trabajo</b></label>
                <input type="text" value="{{ $empleado->area->nombrearea }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-5 pr-1 pl-1 mb-2">
                <label for="cargo_id" class="d-inline"><b>Cargo</b></label>
                <input type="text" value=
                "{{ $empleado_contrato->file != null ? $empleado_contrato->file->nombrecargo : '#' }} - {{ $empleado_contrato->escala_salarial != null ? $empleado_contrato->escala_salarial->nombre : '#' }}"
                class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pl-1 mb-2">
                <label for="fecha_ingreso" class="d-inline"><b>Fecha de ingreso</b></label>
                <input type="text" value="{{ $empleado_contrato->fecha_ingreso != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_ingreso)->format('d/m/Y') : 'No corresponde' }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 mb-2">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <input type="text" value="{{ $empleado_contrato->tipos }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="fecha_retiro" class="d-inline"><b>Fecha de retiro</b></label>
                <input type="text" value="{{ $empleado_contrato->fecha_retiro != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_retiro)->format('d/m/Y') : 'No corresponde' }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1 mb-2">
                <label for="obs_retiro" class="d-inline"><b>Causa del retiro</b></label>
                <input type="text" value="{{ $empleado_contrato->obs_retiro }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1  pl-1 mb-2">
                <label for="n_contrato" class="d-inline"><b>N° contrato</b></label>
                <input type="text" value="{{ $empleado_contrato->ncontrato }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pl-1 mb-2">
                <label for="n_preventivo" class="d-inline"><b>N° Preventivo</b></label>
                <input type="text" value="{{ $empleado_contrato->npreventivo }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 mb-2">
                <label for="seguro_salud" class="d-inline"><b>Seguro Salud</b></label>
                <input type="text" value="{{ $empleado_contrato->segsalud }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="biometrico" class="d-inline"><b>Biometrico:</b></label>
                <input type="text" value="{{ $empleado_contrato->biometrico }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 text-right">
                <label for="rejap" class="d-inline"><b>REJAP:</b></label>
                <input type="checkbox" {{ $empleado_contrato->rejap == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                &nbsp;
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="declaracion_jurada" class="d-inline"><b>Declaracion jurada:</b></label>
                <input type="checkbox" {{ $empleado_contrato->decjurada == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="declaracion_jurada" class="d-inline"><b>Exp.</b></label>
                {{ $empleado_contrato->expdecjurada != null ? \Carbon\Carbon::parse($empleado_contrato->expdecjurada)->format('d/m/Y') : 'No corresponde' }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="induccion" class="d-inline"><b>Induccion:</b></label>
                <input type="checkbox" {{ $empleado_contrato->induccion == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pl-1">
                <label for="induccion" class="d-inline"><b>Exp.</b></label>
                {{ $empleado_contrato->expinduccion != null ? \Carbon\Carbon::parse($empleado_contrato->expinduccion)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
        <div class="row font-roboto-12">
            <div class="col-md-2 pr-1 text-right">
                <label for="poai" class="d-inline"><b>POAI:</b></label>
                <input type="checkbox" {{ $empleado_contrato->poai == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="exppoai" class="d-inline"><b>Exp.</b></label>
                {{ $empleado_contrato->exppoai != null ? \Carbon\Carbon::parse($empleado_contrato->exppoai)->format('d/m/Y') : 'No corresponde' }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="sippase" class="d-inline"><b>SIPPASE:</b></label>
                <input type="checkbox" {{ $empleado_contrato->sippase == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="sippase" class="d-inline"><b>Exp.</b></label>
                {{ $empleado_contrato->expsippase != null ? \Carbon\Carbon::parse($empleado_contrato->expsippase)->format('d/m/Y') : 'No corresponde' }}
            </div>
            <div class="col-md-2 pr-1 pl-1 text-right">
                <label for="progvacacion" class="d-inline"><b>Programacion vacacion:</b></label>
                <input type="checkbox" {{ $empleado_contrato->progvacacion == '1' ? 'checked' : '' }}>
            </div>
            <div class="col-md-2 pl-1">
                <label for="progvacacion" class="d-inline"><b>Exp.</b></label>
                {{ $empleado_contrato->expprogvacacion != null ? \Carbon\Carbon::parse($empleado_contrato->expprogvacacion)->format('d/m/Y') : 'No corresponde' }}
            </div>
        </div>
    </div>
    <br>
@endforeach
