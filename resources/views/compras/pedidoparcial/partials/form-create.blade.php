<div class="card card-body bg-light">
    <input type="hidden" name="idarea" value="{{ $empleado->empleadosareas->idarea }}">
    <input type="hidden" name="dea_id" value="{{ $dea->id }}">
    <div class="form-group row font-verdana-bg">
        <div class="col-md-7 pr-1">
            <label for="idarea" class="d-inline">Area</label>
            <input type="text" value="{{ $empleado->empleadosareas->nombrearea }}" class="form-control form-control-sm font-verdana-bg" disabled>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="controlinterno" class="d-inline">Control Interno <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <input type="text" name="controlinterno" value="{{ old('controlinterno') }}" id="controlinterno" class="form-control form-control-sm font-verdana intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-3 pl-1">
            <label for="tipo" class="d-inline">Tipo <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <select name="tipo" id="tipo" class="form-control form-control-sm select2">
                <option value="">-</option>
                <option value="1" @if(old('tipo') == 1) selected @endif >Producto</option>
                <option value="2" @if(old('tipo') == 2) selected @endif >Servicio</option>
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12">
            <label for="idprograma" class="d-inline">Programa <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($programas as $index => $value)
                    <option value="{{ $index }}" @if(old('idprograma') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12">
            <label for="idcatprogramatica" class="d-inline">Categoria Programatica <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <select name="idcatprogramatica" id="idcatprogramatica" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($catprogramaticas as $index => $value)
                <option value="{{ $index }}" @if(old('idcatprogramatica') == $index) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="preventivo" class="d-inline">Preventivo</label>
            <input type="text" name="preventivo" value="{{ old('preventivo') }}" class="form-control form-control-sm font-verdana-bg" id="preventivo" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-2 pl-1">
            <label for="f_preventivo" class="d-inline">Fecha Preventivo</label>
            <input type="text" name="fecha_preventivo" value="{{ old('fecha_preventivo') }}" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fecha_preventivo" data-language="es" autocomplete="off">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12">
            <label for="objeto" class="d-inline">Objeto <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <textarea name="objeto" cols="1" rows="1" class="form-control form-control-sm font-verdana-bg" id="objeto" oninput="this.value = this.value.toUpperCase()">{{old('objeto')}}</textarea>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12">
            <label for="justificacion" class="d-inline">Justificacion <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <textarea name="justificacion" cols="1" rows="1" class="form-control form-control-sm font-verdana-bg" id="justificacion" oninput="this.value = this.value.toUpperCase()">{{old('justificacion')}}</textarea>
        </div>
    </div>
</div>