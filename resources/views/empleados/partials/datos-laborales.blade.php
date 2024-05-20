<br>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="tipo" class="d-inline"><b>Tipo</b></label>
        <div class="select2-container-rojo">
            <select name="tipo" id="tipo" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(old('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 pr-1 pl-1">
        <label for="area_id" class="d-inline"><b>Area</b></label>
        <div class="select2-container-rojo">
            <select id="area_id" name="area_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
            </select>
            {{--<select name="area_id" id="area_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($areas as $index => $value)
                    <option value="{{ $index }}" @if(old('area_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>--}}
        </div>
    </div>
    <div class="col-md-6 pl-1">
        <label for="cargo_id" class="d-inline"><b>Cargo</b></label>
        <div class="select2-container-rojo">
            <select id="cargo_id" name="cargo_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
            </select>
            {{--<select name="cargo_id" id="cargo_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($cargos as $index => $value)
                    <option value="{{ $index }}" @if(old('cargo_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>--}}
        </div>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="fecha_ingreso" class="d-inline"><b>Fecha de ingreso</b></label>
        <input type="text" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" id="fecha_ingreso" placeholder="dd/mm/aaaa" class="form-control font-roboto-12 input-rojo" data-language="es">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="fecha_conclusion_contrato" class="d-inline"><b>Conclusion de contrato</b></label>
        <input type="text" name="fecha_conclusion_contrato" value="{{ old('fecha_conclusion_contrato') }}" id="fecha_conclusion_contrato" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="n_contrato" class="d-inline"><b>N° contrato</b></label>
        <input type="text" name="n_contrato" value="{{ old('n_contrato') }}" id="n_contrato" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="n_preventivo" class="d-inline"><b>N° Preventivo</b></label>
        <input type="text" name="n_preventivo" value="{{ old('n_preventivo') }}" id="n_preventivo" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="seguro_salud" class="d-inline"><b>Seguro Salud</b></label>
        <input type="text" name="seguro_salud" value="{{ old('seguro_salud') }}" id="seguro_salud" class="form-control font-roboto-12" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="biometrico" class="d-inline"><b>Biometrico</b></label>
        <input type="text" name="biometrico" value="{{ old('biometrico') }}" id="biometrico" class="form-control font-roboto-12">
    </div>
    <div class="col-md-2 pr-1 pl-1 text-center">
        <br>
        <input type="checkbox" name="rejap" {{ old('rejap') == 'on' ? 'checked' : '' }}>
        <label for="rejap" class="d-inline"><b>REJAP</b></label>
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-2 pr-1">
        <label for="exp_poai" class="d-inline">
            <input type="checkbox" name="poai" id="poai" {{ old('poai') == 'on' ? 'checked' : '' }} onclick="check_poai()">
            <b>POAI</b>
        </label>
        <input type="text" name="exp_poai" value="{{ old('exp_poai') }}" id="exp_poai" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="exp_declaracion_jurada" class="d-inline">
            <input type="checkbox" name="declaracion_jurada" id="declaracion_jurada" {{ old('declaracion_jurada') == 'on' ? 'checked' : '' }} onclick="check_declaracion_jurada()">
            <b>Declaracion Jurada</b>
        </label>
        <input type="text" name="exp_declaracion_jurada" value="{{ old('exp_declaracion_jurada') }}" id="exp_declaracion_jurada" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="exp_sippase" class="d-inline">
            <input type="checkbox" name="sippase" id="sippase" {{ old('sippase') == 'on' ? 'checked' : '' }} onclick="check_sippase()">
            <b>SIPPASE</b>
        </label>
        <input type="text" name="exp_sippase" value="{{ old('exp_sippase') }}" id="exp_sippase" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="exp_induccion" class="d-inline">
            <input type="checkbox" name="induccion" id="induccion" {{ old('induccion') == 'on' ? 'checked' : '' }} onclick="check_induccion()">
            <b>Induccion</b>
        </label>
        <input type="text" name="exp_induccion" value="{{ old('exp_induccion') }}" id="exp_induccion" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
    <div class="col-md-2 pl-1">
        <label for="exp_progvacacion" class="d-inline">
            <input type="checkbox" name="progvacacion" id="progvacacion"  {{ old('progvacacion') == 'on' ? 'checked' : '' }} onclick="check_programacion_vacacion()" disabled>
            <b>Vacacion</b>
        </label>
        <input type="text" name="exp_progvacacion" value="{{ old('exp_progvacacion') }}" id="exp_progvacacion" placeholder="Expiracion" class="form-control font-roboto-12" data-language="es">
    </div>
</div>
