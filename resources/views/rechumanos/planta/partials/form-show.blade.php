<div class="form-group row font-verdana">
    <div class="col-md-5 pr-1">
        <label for="nombre_completo" class="d-inline">Nombre Completo</label>
        <input type="text" value="{{ $empleado->nombres .' '. $empleado->ap_pat .' '. $empleado->ap_mat }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="ci" class="d-inline">Ci</label>
        <input type="text" value="{{ $empleado->ci }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="natalicio" class="d-inline">Natalicio</label>
        <input type="text" value="{{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/y') : '' }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-1 pl-1">
        <label for="edad" class="d-inline">Edad</label>
        <input type="text" value="{{ $empleado->edad }}" class="form-control font-verdana" readonly>
    </div>
</div>
<div class="form-group row font-verdana">
    <div class="col-md-1 pr-1">
        <label for="n_file" class="d-inline">Nro. File</label>
        <input type="text" value="{{ $empleado->file->numfile }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="ingreso" class="d-inline">Ingreso</label>
        <input type="text" value="{{ $empleado->fechingreso != null ? \Carbon\Carbon::parse($empleado->fechingreso)->format('d/m/y') : '' }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-4 pr-1 pl-1">
        <label for="categoria" class="d-inline">Categoria</label>
        <input type="text" value="{{ $empleado->file->categoria }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-5 pl-1">
        <label for="area" class="d-inline">Area</label>
        <input type="text" value="{{ $empleado->area->nombrearea }}" class="form-control font-verdana" readonly>
    </div>
</div>
<div class="form-group row font-verdana">
    <div class="col-md-4 pr-1">
        <label for="cargo" class="d-inline">Cargo</label>
        <input type="text" value="{{ $empleado->file->cargo }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="nombre_cargo" class="d-inline">Nombre Cargo</label>
        <input type="text" value="{{ $empleado->file->nombrecargo }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="haber_basico" class="d-inline">Haber Basico</label>
        <input type="text" value="{{ number_format($empleado->file->habbasico,2,'.',',') }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-1 pr-1 pl-1">
        <label for="nivel" class="d-inline">Nivel</label>
        <input type="text" value="{{ $empleado->file->niveladm }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-1 pr-1 pl-1">
        <label for="clase" class="d-inline">Clase</label>
        <input type="text" value="{{ $empleado->file->clase }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-1 pl-1">
        <label for="escala" class="d-inline">Escala</label>
        <input type="text" value="{{ $empleado->file->nivelsal }}" class="form-control font-verdana" readonly>
    </div>
</div>
<div class="form-group row font-verdana">
    <div class="col-md-2 pr-1">
        <label for="poai" class="d-inline">POAI</label>
        <input type="text" value="{{ $empleado->poai }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="poai_exp" class="d-inline">EXP. POAI</label>
        <input type="text" value="{{ $empleado->exppoai != null ? \Carbon\Carbon::parse($empleado->exppoai)->format('d/m/y') : '' }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="dec_jurada" class="d-inline">DDJJ</label>
        <input type="text" value="{{ $empleado->decjurada }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="dec_jurada_exp" class="d-inline">EXP. DDJJ</label>
        <input type="text" value="{{ $empleado->expdecjurada != null ? \Carbon\Carbon::parse($empleado->expdecjurada)->format('d/m/y') : '' }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="sippase" class="d-inline">SIPPASE</label>
        <input type="text" value="{{ $empleado->sippase }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="sippase_exp" class="d-inline">EXP. SIPPASE</label>
        <input type="text" value="{{ $empleado->expsippase != null ? \Carbon\Carbon::parse($empleado->expsippase)->format('d/m/y') : '' }}" class="form-control font-verdana" readonly>
    </div>
</div>
<div class="form-group row font-verdana">
    <div class="col-md-3 pr-1">
        <label for="lib_militar" class="d-inline">N° LIB. MILITAR</label>
        <input type="text" value="{{ $empleado->sevmilitar }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="idioma" class="d-inline">IDIOMA</label>
        <input type="text" value="{{ $empleado->idioma }}" class="form-control font-verdana" readonly>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="induccion" class="d-inline">INDUCCION</label>
        <input type="text" value="{{ $empleado->induccion }}" class="form-control font-verdana" readonly>
    </div>
    {{--<div class="col-md-2 pl-1">
        <label for="poai_exp" class="d-inline">EXPIRACION</label>
        <input type="text" value="{{ $empleado->exppoai != null ? \Carbon\Carbon::parse($empleado->exppoai)->format('d/m/y') : '' }}" class="form-control font-verdana" readonly>
    </div>--}}
</div>
{{--<div class="form-group row">
    <div class="col-md-2 pr-1">
        <input type="text" name="role" value="{{request('role')}}" placeholder="--Role--" class="form-control font-verdana">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <select name="estado" id="estado" class="form-control">
            <option value="">-</option>
            <option value="1" @if(request('estado') == '1') selected @endif >HABILITADOS</option>
            <option value="0" @if(request('estado') == '0') selected @endif >NO HABILITADOS</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-6">
        @can('user_create')
            <span class="tts:right tts-slideIn tts-custom" aria-label="Crear Nuevo Usuario">
                <button class="btn btn-sm btn-success font-verdana" type="button" onclick="create();">
                    &nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </span>
            <span class="tts:right tts-slideIn tts-custom" aria-label="Exportar a Excel">
                <button class="btn btn-sm btn-success font-verdana" type="button" onclick="excel();">
                    &nbsp;<i class="fa fa-file-excel" aria-hidden="true"></i>&nbsp;
                </button>
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
        @endcan
    </div>
    <div class="col-md-6 text-right">
        <button class="btn btn-primary font-verdana" type="button" onclick="search();">
            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
        </button>
        <button class="btn btn-danger font-verdana text-white" type="button" onclick="limpiar();">
            &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
        </button>            
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>--}}