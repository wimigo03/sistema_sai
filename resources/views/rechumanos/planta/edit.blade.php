@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group row font-verdana-bg">
                 
                    <div class="col-md-4 titulo text-left">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                        <a href="{{url()->previous()}}" class="color-icon-1">
                            <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                        </a>
                    </span>
                    </div>
                    <div class="col-md-8 titulo text-right">
                        <b>GESTIONAR PERSONAL-P/{{strtoupper($areaactual->nombrearea)}}/REGISTRAR</b>
                    </div>
                </div>
                <hr class="hrr">

                <form method="POST" action="{{ route('planta.actualizar') }}">
                    @csrf
                    @method('POST')
                    <input name="idemp" hidden value="{{$empleados->idemp}}"></input>
                    <input name="idareaoriginal" hidden value="{{$empleados->idarea}}"></input>
                    <input name="idfileoriginal" hidden value="{{$empleados->idfile}}"></input>
                    <input name="nombreareaactual" hidden value="{{$areaactual->nombrearea}}"></input>
                    <div class="form-group row font-verdana-bg">
                        <div class="col-md-2">
                            <label for="nombres"><b>Nombre(s)</b></label>
                            <input required type="text" name="nombres" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" value="{{$empleados->nombres}}"></input>
                        </div>
                        <div class="col-md-2">
                            <label for="ap_paterno"><b>Ap. Paterno</b></label>
                            <input required type="text" name="ap_pat" class="form-control " onchange="javascript:this.value=this.value.toUpperCase();" value="{{$empleados->ap_pat}}"></input>
                        </div>
                        <div class="col-md-2">
                            <label for="ap_materno"><b>Ap. Materno</b></label>
                            <input type="text" name="ap_mat" class="form-control form-control-sm font-verdana-bg" onchange="javascript:this.value=this.value.toUpperCase();">
                        </div>
                        <div class="col-md-2">
                            <label for="nro_carnet"><b>N° Carnet</b></label>
                            <input type="text" name="ci" class="form-control" value="{{$empleados->ci}}">
                        </div>
                        <div class="col-md-2">
                            <label for="procedencia"><b>Procedencia</b></label><br>
                            <select name="procedencia" id="procedencia" class="form-control form-control-sm" required>
                                <option value="">-</option>
                                <option value="TJ" @if(request('procedencia')=='TJ' ) selected @endif>TARIJA</option>
                                <option value="CH" @if(request('procedencia')=='CH' ) selected @endif>CHUQUISACA</option>
                                <option value="LP" @if(request('procedencia')=='LP' ) selected @endif>LA PAZ</option>
                                <option value="CB" @if(request('procedencia')=='CB' ) selected @endif>COCHABAMBA</option>
                                <option value="OR" @if(request('procedencia')=='OR' ) selected @endif>ORURO</option>
                                <option value="PT" @if(request('procedencia')=='PT' ) selected @endif>POTOSI</option>
                                <option value="SC" @if(request('procedencia')=='SC' ) selected @endif>SANTA CRUZ</option>
                                <option value="BE" @if(request('procedencia')=='BE' ) selected @endif>BENI</option>
                                <option value="PD" @if(request('procedencia')=='PD' ) selected @endif>PANDO</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date"><b>Fecha Ingreso</b></label>
                            <input type="date" class="form-control" name="fechingreso" value="{{$empleados->fechingreso}}">
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
                            <input type="date" class="form-control" name="exppoai" value="{{$empleados->exppoai}}">
                        </div>


                        <div class="col-md-2">
                            <label for="poai"><b>POAI</b></label>
                            <input type="text" name="poai" class="form-control" value="{{$empleados->poai}}">
                        </div>
                        <div class="col-md-2">
                            <label for="exp_poai"><b>Exp. POAI</b></label>
                            <input type="date" class="form-control" name="exppoai" value="{{$empleados->exppoai}}">
                        </div>
                        <div class="col-md-2">
                            <label for="decjurada"><b>Dec. Jurada</b></label>
                            <input type="text" name="decjurada" class="form-control" value="{{$empleados->decjurada}}">
                        </div>
                        <div class="col-md-2">
                            <label for="exp_dec_jurada"><b>Exp. Dec. Jurada</b></label>
                            <input type="date" class="form-control" name="expdecjurada" value="{{$empleados->expdecjurada}}">
                        </div>
                        <div class="col-md-2">
                            <label for="rejap"><b>REJAP</b></label>
                            <input type="date" class="form-control" name="rejap" value="{{$empleados->rejap}}">
                        </div>
                    </div>
                    <div class="form-group row font-verdana-bg">
                        <div class="col-md-2">
                            <label for="sippase"><b>SIPPASE</b></label>
                            <input type="text" name="sippase" class="form-control" value="{{$empleados->sippase}}">
                        </div>
                        <div class="col-md-2">
                            <label for="exp_dec_jurada"><b>Exp. SIPPASE</b></label>
                            <input type="date" class="form-control" name="expsippase" value="{{$empleados->expsippase}}">
                        </div>
                        <div class="col-md-2">
                            <label for="ser_militar"><b>Serv. Militar</b></label>
                            <input type="text" name="servmilitar" class="form-control" value="{{$empleados->servmilitar}}">
                        </div>
                        <div class="col-md-2">
                            <label for="idioma"><b>Idioma</b></label>
                            <input type="text" name="idioma" class="form-control" value="{{$empleados->idioma}}">
                        </div>
                        <div class="col-md-2">
                            <label for="induccion"><b>Induccion</b></label>
                            <input type="text" name="induccion" class="form-control" value="{{$empleados->induccion}}">
                        </div>
                        <div class="col-md-2">
                            <label for="exp_induccion"><b>Exp. Induccion</b></label>
                            <input type="date" class="form-control" name="expinduccion" value="{{$empleados->expinduccion}}">
                        </div>
                    </div>
                    <div class="form-group row font-verdana-bg">
                        <div class="col-md-2">
                            <label for="progvacacion"><b>Prog. Vacacion</b></label>
                            <input type="text" name="progvacacion" class="form-control" value="{{$empleados->progvacacion}}">
                        </div>
                        <div class="col-md-2">
                            <label for="expprogvacacion"><b>Exp. Prog. Vacacion</b></label>
                            <input type="date" class="form-control" name="expprogvacacion" value="{{$empleados->expprogvacacion}}">
                        </div>
                        <div class="col-md-2">
                            <label for="vacganadas"><b>Vac. Ganadas</b></label>
                            <input required type="number" placeholder="0" name="vacganadas" class="form-control" placeholder="Ap.Pat...." value="{{$empleados->vacganadas}}"></input>
                        </div>
                        <div class="col-md-2">
                            <label for="vacpendientes"><b>Vac. Pendientes</b></label>
                            <input type="text" name="vacpendientes" class="form-control" value="{{$empleados->vacpendientes}}">
                        </div>
                        <div class="col-md-2">
                            <label for="vacusasdas"><b>Vac. Usadas</b></label>
                            <input type="text" name="vacusasdas" class="form-control" value="{{$empleados->vacusasdas}}">
                        </div>
                        <div class="col-md-2">
                            <label for="segsalud"><b>Seg. Salud</b></label>
                            <input type="text" name="segsalud" class="form-control" value="{{$empleados->segsalud}}">
                        </div>
                    </div>
                    <div class="form-group row font-verdana-bg">
                        <div class="col-md-2">
                            <label for="inamovilidad"><b>Inamovilidad</b></label>
                            <input type="text" name="inamovilidad" class="form-control" value="{{$empleados->inamovilidad}}">
                        </div>
                        <div class="col-md-2">
                            <label for="aservicios"><b>Años de Servicio</b></label>
                            <input type="text" name="aservicios" class="form-control" value="{{$empleados->aservicios}}">
                        </div>
                        <div class="col-md-2">
                            <label for="cvitae"><b>C.V.</b></label>
                            <input type="text" name="cvitae" class="form-control" value="{{$empleados->cvitae}}">
                        </div>
                        <div class="col-md-2">
                            <label for="telefono"><b>Telefono</b></label>
                            <input type="text" name="telefono" class="form-control" value="{{$empleados->telefono}}">
                        </div>
                        <div class="col-md-2">
                            <label for="biometrico"><b>Biometrico</b></label>
                            <input type="text" name="biometrico" class="form-control" value="{{$empleados->biometrico}}">
                        </div>
                        <div class="col-md-2">
                            <label for="gradacademico"><b>Grado Acad.</b></label>
                            <input type="text" name="gradacademico" class="form-control" value="{{$empleados->gradacademico}}">
                        </div>
                    </div>
                    <div class="form-group row font-verdana-bg">
                        <div class="col-md-2">
                            <label for="rae"><b>RAE</b></label>
                            <input type="text" name="rae" class="form-control" value="{{$empleados->rae}}">
                        </div>
                        <div class="col-md-2">
                            <label for="regprofesional"><b>Reg. Profesional</b></label>
                            <input type="text" name="regprofesional" class="form-control" value="{{$empleados->regprofesional}}">
                        </div>
                        <div class="col-md-2">
                            <label for="evdesempenio"><b>Eval. Desempeño</b></label>
                            <input type="number" placeholder="0" name="evdesempenio" class="form-control" value="{{$empleados->evdesempenio}}">
                        </div>
                        <div class="col-md-4">
                            <label for="idfile"><b>File</b></label><br>
                            <div id="permissions-select2">

                                <select name="idfile" id="permissions2" class=" form-control"">

                                        @foreach($area as $areas)
                                        <option disabled>
                                            <h1 color:blue;>{{$areas->nombrearea}}</H1>
                                        </option>
                                        @foreach($areas->iPais_all as $destino)
                                        @if ($destino->idfile==$empleados->idfile)
                                        <option value=" {{$destino->idfile}}" selected>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-FILE-{{$destino->numfile}}-{{$destino->cargo}}-{{$destino->nombrecargo}}-{{$destino->habbasico}}-{{$destino->categoria}}-{{$destino->niveladm}}-{{$destino->clase}}-{{$destino->nivelsal}}
                                    </option>
                                    @else

                                    @if ($destino->estadofile == 1 and $destino->tipofile == 1)

                                    <option style="color:red;" value="{{$destino->idfile}}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-FILE-{{$destino->numfile}}-{{$destino->cargo}}-{{$destino->nombrecargo}}-{{$destino->habbasico}}-{{$destino->categoria}}-{{$destino->niveladm}}-{{$destino->clase}}-{{$destino->nivelsal}}
                                    </option>

                                    @endif

                                    @endif

                                    @endforeach
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <label for="idfile"><b>Area</b></label><br>

                            <div id="permissions-select">

                                <select name="idarea">

                                    @foreach($area as $areas)
                                    @if ($areas->idarea==$empleados->idarea)
                                    <option value="{{$areas->idarea}}" selected>
                                        {{$areas->nombrearea}}
                                    </option>
                                    @else
                                    <option style="color:blue;" value="{{$areas->idarea}}">{{$areas->nombrearea}}
                                    </option>

                                    @endif

                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-outline-success font-verdana-bg" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>&nbsp; {{ __('Guardar') }}
                            </button>
                            <a href="{{route('planta.lista',$empleados->idarea)}}" class="btn btn-outline-danger font-verdana-bg">
                                <i class="fa fa-lg fa-reply" aria-hidden="true"></i>&nbsp;Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@section('scripts')
<script>
    var permission_select = new SlimSelect({
        select: '#permissions-select select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });
    $('#permissions2').select2({
        placeholder: "--Seleccionar--"
    });
</script>
@endsection
@endsection