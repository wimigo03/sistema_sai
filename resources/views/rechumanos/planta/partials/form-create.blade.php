<input type="hidden" name="idarea" value="{{$idarea}}">
<div class="form-group row font-verdana-bg">
    <div class="col-md-2">
        <label for="nombres"><b>Nombre(s)</b></label>
        <input type="text" name="nombres" class="form-control form-control-sm font-verdana-bg" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="ap_paterno"><b>Ap. Paterno</b></label>
        <input type="text" name="ap_pat" class="form-control form-control-sm font-verdana-bg" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="ap_materno"><b>Ap. Materno</b></label>
        <input type="text" name="ap_mat" class="form-control form-control-sm font-verdana-bg" onkeyup="javascript:this.value=this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="nro_carnet"><b>N° Carnet</b></label>
        <input type="text" name="ci" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="procedencia"><b>Procedencia</b></label><br>
        <select name="procedencia" id="procedencia" class="form-control form-control-sm">
            <option value="">-</option>
            <option value="TJ" @if(request('procedencia') == 'TJ') selected @endif >TARIJA</option>
            <option value="CH" @if(request('procedencia') == 'CH') selected @endif >CHUQUISACA</option>
            <option value="LP" @if(request('procedencia') == 'LP') selected @endif >LA PAZ</option>
            <option value="CB" @if(request('procedencia') == 'CB') selected @endif >COCHABAMBA</option>
            <option value="OR" @if(request('procedencia') == 'OR') selected @endif >ORURO</option>
            <option value="PT" @if(request('procedencia') == 'PT') selected @endif >POTOSI</option>
            <option value="SC" @if(request('procedencia') == 'SC') selected @endif >SANTA CRUZ</option>
            <option value="BE" @if(request('procedencia') == 'BE') selected @endif >BENI</option>
            <option value="PD" @if(request('procedencia') == 'PD') selected @endif >PANDO</option>
        </select>
    </div>
    <div class="col-md-2">
        <label for="date"><b>Fecha Ingreso</b></label>
        <input type="date" name="natalicio" class="form-control form-control-sm font-verdana-bg">
    </div>
</div>
<div class="form-group row font-verdana-bg"> 
    <div class="col-md-2">
        <div class="row">
            <div class="col-md-6">
                <label for="factura"><b>POAI</b></label>
            </div>
            <div class="col-md-6 text-right">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Seleccionar solo si tiene">
                    <input type="checkbox" name="poai" {{--class="form-check-input"--}} id="poai" onclick="checkPoai();">
                </span>
            </div>
        </div>
        <input type="date" name="exppoai" id="exppoai" class="form-control form-control-sm font-verdana-bg">
    </div>


    <div class="col-md-2">
        <label for="poai"><b>POAI</b></label>
        <input type="text" name="poai" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="exp_poai"><b>Exp. POAI</b></label>
        <input type="date" name="exppoai" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="decjurada"><b>Dec. Jurada</b></label>
        <input type="text" name="decjurada" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="exp_dec_jurada"><b>Exp. Dec. Jurada</b></label>
        <input type="date" name="expdecjurada" class="form-control form-control-sm font-verdana-bg">
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-2">
        <label for="sippase"><b>SIPPASE</b></label>
        <input type="text" name="sippase" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="exp_dec_jurada"><b>Exp. SIPPASE</b></label>
        <input type="date" name="expsippase" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="ser_militar"><b>Serv. Militar</b></label>
        <input type="text" name="servmilitar" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="idioma"><b>Idioma</b></label>
        <input type="text" name="idioma" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="induccion"><b>Induccion</b></label>
        <input type="text" name="induccion" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="exp_induccion"><b>Exp. Induccion</b></label>
        <input type="date" name="expinduccion" class="form-control form-control-sm font-verdana-bg">
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-2">
        <label for="progvacacion"><b>Prog. Vacacion</b></label>
        <input type="text" name="progvacacion" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="expprogvacacion"><b>Exp. Prog. Vacacion</b></label>
        <input type="date" name="expprogvacacion" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="vacganadas"><b>Vac. Ganadas</b></label>
        <input type="number" name="vacganadas" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="vacpendientes"><b>Vac. Pendientes</b></label>
        <input type="text" name="vacpendientes" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="vacusasdas"><b>Vac. Usadas</b></label>
        <input type="text" name="vacusasdas" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="segsalud"><b>Seg. Salud</b></label>
        <input type="text" name="segsalud" class="form-control form-control-sm font-verdana-bg">
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-2">
        <label for="inamovilidad"><b>Inamovilidad</b></label>
        <input type="text" name="inamovilidad" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="aservicios"><b>Años de Servicio</b></label>
        <input type="text" name="aservicios" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="cvitae"><b>C.V.</b></label>
        <input type="text" name="cvitae" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="telefono"><b>Telefono</b></label>
        <input type="text" name="telefono" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="biometrico"><b>Biometrico</b></label>
        <input type="text" name="biometrico" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="gradacademico"><b>Grado Acad.</b></label>
        <input type="text" name="gradacademico" class="form-control form-control-sm font-verdana-bg">
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-2">
        <label for="rae"><b>RAE</b></label>
        <input type="text" name="rae" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="regprofesional"><b>Reg. Profesional</b></label>
        <input type="text" name="regprofesional" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="evdesempenio"><b>Eval. Desempeño</b></label>
        <input type="number" name="evdesempenio" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <label for="rejap"><b>REJAP</b></label>
        <input type="date" name="rejap" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-4">
        <label for="idfile"><b>File</b></label><br>
        <select name="idfile" id="idfile" class="form-control form-control-sm">
            <option value="">-</option>
            @foreach ($files as $index => $value)
                <option value="{{ $index }}" @if(request('idfile') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 text-right">
        <button class="btn btn-outline-primary font-verdana-bg" type="submit">
            <i class="fa-solid fa-paper-plane"></i>&nbsp;Registrar
        </button>
        <a href="{{route('planta.lista',$idarea)}}" class="btn btn-outline-danger font-verdana-bg">
            <i class="fa fa-lg fa-reply" aria-hidden="true"></i>&nbsp;Cancelar
        </a>
    </div>
</div>