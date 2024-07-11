<br>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="tipo" class="d-inline"><b>Tipo</b></label>
        <div class="select2-container-rojo">
            <select name="tipo" id="tipo" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if($empleado_contrato->tipo == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 pr-1 pl-1">
        <label for="area_id" class="d-inline"><b>Area-Item</b></label>
        <div class="select2-container-rojo">
            <select name="area_id" id="area_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->idarea }}"
                        @if($area->idarea == old('area_id') || (isset($empleado) && $empleado->idarea == $area->idarea))
                            selected
                        @endif>
                        {{ $area->nombrearea }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 pr-1 pl-1">
        <label for="area_id" class="d-inline"><b>Area-Asignada</b></label>
        <div class="select2-container-rojo">
            <select name="area_asignada" id="area_asignada" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($areas2 as $area2)
                    <option value="{{ $area2->idarea }}"
                        @if($area2->idarea == old('area_asignada') || (isset($empleado_contrato) && $empleado_contrato->idarea_asignada == $area2->idarea))
                            selected
                        @endif>
                        {{ $area2->nombrearea }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group row font-roboto-12">

    <div class="col-md-4 ">
        <label for="cargo_id" class="d-inline"><b>Cargo</b></label>
        <div class="select2-container-rojo">
            <select name="cargo_id" id="cargo_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($cargos as $cargo)
                    <option value="{{ $cargo->idfile }}"
                        @if($cargo->idfile == old('cargo_id') || (isset($empleado_contrato) && $empleado_contrato->idfile == $cargo->idfile))
                            selected
                        @endif>
                        {{ $cargo->numfile }} -
                        {{ $cargo->nombrecargo }} -
                        {{ $cargo->escala_salarial != null ? $cargo->escala_salarial->nombre : '#' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2 pr-1">
        <label for="fecha_ingreso" class="d-inline"><b>Fecha de ingreso</b></label>
        <input type="text" name="fecha_ingreso" value="{{ $empleado_contrato->fecha_ingreso != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_ingreso)->format('d/m/Y') : '' }}" id="fecha_ingreso" placeholder="dd/mm/aaaa" class="form-control font-roboto-12 input-rojo" data-language="es">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="fecha_conclusion_contrato" class="d-inline"><b>Conclusion de contrato</b></label>
        <input type="text" name="fecha_conclusion_contrato" value="{{ $empleado_contrato->fecha_conclusion_contrato != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_conclusion_contrato)->format('d/m/Y') : '' }}" id="fecha_conclusion_contrato" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="n_contrato" class="d-inline"><b>N° contrato</b></label>
        <input type="text" name="n_contrato" value="{{ $empleado_contrato->ncontrato }}" id="n_contrato" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="n_preventivo" class="d-inline"><b>N° Preventivo</b></label>
        <input type="text" name="n_preventivo" value="{{ $empleado_contrato->npreventivo }}" id="n_preventivo" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="seguro_salud" class="d-inline"><b>Seguro Salud</b></label>
        <input type="text" name="seguro_salud" value="{{ $empleado_contrato->segsalud }}" id="seguro_salud" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="biometrico" class="d-inline"><b>Biometrico</b></label>
        <input type="text" name="biometrico" value="{{ $empleado_contrato->biometrico }}" id="biometrico" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pl-1 text-center">
        <br>
        <input type="checkbox" name="rejap" {{ $empleado_contrato->rejap == '1' ? 'checked' : '' }}>
        <label for="rejap" class="d-inline"><b>REJAP</b></label>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="exp_poai" class="d-inline">
            <input type="checkbox" name="poai" id="poai" {{ $empleado_contrato->poai == '1' ? 'checked' : '' }} onclick="check_poai()">
            <b>POAI</b>
        </label>
        <input type="text" name="exp_poai" value="{{ $empleado_contrato->exppoai != null ? \Carbon\Carbon::parse($empleado_contrato->exppoai)->format('d/m/Y') : '' }}" id="exp_poai" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="exp_declaracion_jurada" class="d-inline">
            <input type="checkbox" name="declaracion_jurada" id="declaracion_jurada" {{ $empleado_contrato->decjurada == '1' ? 'checked' : '' }} onclick="check_declaracion_jurada()">
            <b>Declaracion Jurada</b>
        </label>
        <input type="text" name="exp_declaracion_jurada" value="{{ $empleado_contrato->expdecjurada != null ? \Carbon\Carbon::parse($empleado_contrato->expdecjurada)->format('d/m/Y') : '' }}" id="exp_declaracion_jurada" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="exp_sippase" class="d-inline">
            <input type="checkbox" name="sippase" id="sippase" {{ $empleado_contrato->sippase == '1' ? 'checked' : '' }} onclick="check_sippase()">
            <b>SIPPASE</b>
        </label>
        <input type="text" name="exp_sippase" value="{{ $empleado_contrato->expsippase != null ? \Carbon\Carbon::parse($empleado_contrato->expsippase)->format('d/m/Y') : '' }}" id="exp_sippase" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="exp_induccion" class="d-inline">
            <input type="checkbox" name="induccion" id="induccion" {{ $empleado_contrato->induccion == '1' ? 'checked' : '' }} onclick="check_induccion()">
            <b>Induccion</b>
        </label>
        <input type="text" name="exp_induccion" value="{{ $empleado_contrato->expinduccion != null ? \Carbon\Carbon::parse($empleado_contrato->expinduccion)->format('d/m/Y') : '' }}" id="exp_induccion" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-2 pl-1">
        <label for="exp_progvacacion" class="d-inline">
            <input type="checkbox" name="progvacacion" id="progvacacion"  {{ $empleado_contrato->progvacacion == '1' ? 'checked' : '' }} onclick="check_programacion_vacacion()">
            <b>Vacacion</b>
        </label>
        <input type="text" name="exp_progvacacion" value="{{ $empleado_contrato->expprogvacacion != null ? \Carbon\Carbon::parse($empleado_contrato->expprogvacacion)->format('d/m/Y') : '' }}" id="exp_progvacacion" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
</div>
