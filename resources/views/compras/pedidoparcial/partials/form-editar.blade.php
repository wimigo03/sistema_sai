<div class="card card-body bg-light">
    <input type="hidden" name="compra_id" value="{{ $compra->idcompra }}">
    <input type="hidden" name="idarea" value="{{ $empleado->empleadosareas->idarea }}">
    <input type="hidden" name="dea_id" value="{{ $dea->id }}">
    <div class="form-group row font-verdana-12">
        <div class="col-md-7 pr-1">
            <label for="idarea" class="d-inline">Area</label>
            <input type="text" value="{{ $empleado->empleadosareas->nombrearea }}" class="form-control form-control-sm font-verdana-12" disabled>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="controlinterno" class="d-inline">Control Interno <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <input type="text" name="controlinterno" value="{{ $compra->controlinterno }}" id="controlinterno" class="form-control form-control-sm font-verdana intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-3 pl-1">
            <label for="tipo" class="d-inline">Tipo <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <select name="tipo" id="tipo" class="form-control form-control-sm select2">
                <option value="">-</option>
                <option value="1" @if($compra->tipo == 1) selected @endif >Producto</option>
                <option value="2" @if($compra->tipo == 2) selected @endif >Servicio</option>
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-12">
        <div class="col-md-12">
            <label for="idprograma" class="d-inline">Programa <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2 {{ $errors->has('idprograma') ? 'is-invalid' : '' }}">
                @foreach ($programas as $programa)
                    <option value="{{ $programa->idprograma }}"
                        @if($programa->idprograma == request('idprograma') || (isset($compra) && $compra->idprograma == $programa->idprograma))
                            selected
                        @endif>
                        {{ $programa->nombreprograma }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-12">
        <div class="col-md-12">
            <label for="idcatprogramatica" class="d-inline">Categoria Programatica <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <select name="idcatprogramatica" id="idcatprogramatica" placeholder="--Seleccionar--" class="form-control form-control-sm select2 {{ $errors->has('idcatprogramatica') ? 'is-invalid' : '' }}">
                @foreach ($catprogramaticas as $catprogramatica)
                    <option value="{{ $catprogramatica->idcatprogramatica }}"
                        @if($catprogramatica->idcatprogramatica == request('idcatprogramatica') || (isset($compra) && $compra->idcatprogramatica == $catprogramatica->idcatprogramatica))
                            selected
                        @endif>
                        {{ $catprogramatica->programatica }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-12">
        <div class="col-md-3 pr-1">
            <label for="preventivo" class="d-inline">Preventivo</label>
            <input type="text" name="preventivo" value="{{ $compra->preventivo }}" class="form-control form-control-sm font-verdana-12" id="preventivo" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-2 pl-1">
            <label for="f_preventivo" class="d-inline">Fecha Preventivo</label>
            <input type="text" name="fecha_preventivo" value="{{ $compra->fecha_preventivo != null ? \Carbon\Carbon::parse($compra->fecha_preventivo)->format('d/m/Y') : '' }}" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-12" id="fecha_preventivo" data-language="es" autocomplete="off">
        </div>
    </div>
    <div class="form-group row font-verdana-12">
        <div class="col-md-12">
            <label for="objeto" class="d-inline">Objeto <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <textarea name="objeto" cols="1" rows="1" class="form-control form-control-sm font-verdana-12" id="objeto" oninput="this.value = this.value.toUpperCase()">{{ $compra->objeto }}</textarea>
        </div>
    </div>
    <div class="form-group row font-verdana-12">
        <div class="col-md-12">
            <label for="justificacion" class="d-inline">Justificacion <i class="fa-solid fa-xs fa-asterisk"></i></label>
            <textarea name="justificacion" cols="1" rows="1" class="form-control form-control-sm font-verdana-12" id="justificacion" oninput="this.value = this.value.toUpperCase()">{{ $compra->justificacion }}</textarea>
        </div>
    </div>
</div>