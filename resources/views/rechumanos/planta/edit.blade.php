@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
        <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse" style="color:black;font-weight: bold;font-size: 16px;"><font >{{$areaactual->nombrearea}}</font></div>

            <div class="row">

               
                <a href="{{url()->previous()}}" class="btn blue darken-4 text-black "><i
                        style="color:#55CE63;font-weight: bold;" class="fa fa-plus-square"></i> Volver atras</a>

                     
            </div>

            <div class="card-body">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('planta.actualizar') }}">
                        @csrf
                        @method('POST')
                        <input name="idemp" hidden value="{{$empleados->idemp}}"></input>
                        <input name="idareaoriginal" hidden value="{{$empleados->idarea}}"></input>
                        <input name="idfileoriginal" hidden value="{{$empleados->idfile}}"></input>
                        <input name="nombreareaactual" hidden value="{{$areaactual->nombrearea}}"></input>

                        <div class="form-group row">
                            <span class="input-group col-md-1" style="color:#0186C2;font-weight: bold;">Nombres:</span>

                            <div class="col-md-2 ">
                                <input required type="text" name="nombres" class="form-control"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{$empleados->nombres}}"></input>
                            </div>



                            <span class="input-group offset-md-1 col-md-1"
                                style="color:#0186C2;font-weight: bold;">Ap.Paterno:</span>
                            <div class="col-md-2 ">
                                <input required type="text" name="ap_pat" class="form-control "
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{$empleados->ap_pat}}"></input>
                            </div>


                            <span class="input-group offset-md-1 col-md-1"
                                style="color:#0186C2;font-weight: bold;">Ap.Materno:</span>
                            <div class="col-md-2 ">
                                <input required type="text" name="ap_mat" class="form-control"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{$empleados->ap_mat}}"></input>
                            </div>



                        </div>



                        <div class="form-group row">


                            <span class="input-group col-md-1"
                                style="color:#0186C2;font-weight: bold;">F.Ingreso:</span>
                            <div class="col-md-2 ">
                                <input type="date" class="form-control" name="fechingreso"
                                    value="{{$empleados->fechingreso}}">
                            </div>

                            <span class="input-group offset-md-1 col-md-1"
                                style="color:#0186C2;font-weight: bold;">F.Nacimien:</span>

                            <div class="col-md-2 ">
                                <input type="date" class="form-control" name="natalicio"
                                    value="{{$empleados->natalicio}}">
                            </div>





                        </div>



                        <div class="form-group row">

                            <span class="input-group col-md-1 " style="color:#0186C2;font-weight: bold;">Ci:</span>
                            <div class="col-md-2 ">
                                <input type="text" name="ci" class="form-control" value="{{$empleados->ci}}">
                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Poai:</span>
                            <div class="col-md-2">
                                <input type="text" name="poai" class="form-control" value="{{$empleados->poai}}">
                            </div>


                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Exp.Poai:</span>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="exppoai" value="{{$empleados->exppoai}}">

                            </div>


                        </div>



                        <div class="form-group row">

                            <span class="input-group col-md-1 " style="color:#0186C2;font-weight: bold;">Dec.Jur:</span>
                            <div class="col-md-2 ">
                                <input type="text" name="decjurada" class="form-control"
                                    value="{{$empleados->decjurada}}">

                            </div>


                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Exp.Dec.Jur.:</span>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="expdecjurada"
                                    value="{{$empleados->expdecjurada}}">

                            </div>


                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Sippase:</span>
                            <div class="col-md-2">
                                <input type="text" name="sippase" class="form-control" value="{{$empleados->sippase}}">

                            </div>


                        </div>



                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:#0186C2;font-weight: bold;">Exp.Sipp:</span>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="expsippase"
                                    value="{{$empleados->expsippase}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Serv.Militar:</span>

                            <div class="col-md-2">
                                <input type="text" name="servmilitar" class="form-control"
                                    value="{{$empleados->servmilitar}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Idioma:</span>

                            <div class="col-md-2">
                                <input type="text" name="idioma" class="form-control" value="{{$empleados->idioma}}">

                            </div>


                        </div>



                        <div class="form-group row">
                            <span class="input-group col-md-1 " style="color:#0186C2;font-weight: bold;">Inducc:</span>

                            <div class="col-md-2">
                                <input type="text" name="induccion" class="form-control"
                                    value="{{$empleados->induccion}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Exp.Inducc.:</span>

                            <div class="col-md-2">
                                <input type="date" class="form-control" name="expinduccion"
                                    value="{{$empleados->expinduccion}}">

                            </div>


                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Prog.Vacac.:</span>

                            <div class="col-md-2">
                                <input type="text" name="progvacacion" class="form-control"
                                    value="{{$empleados->progvacacion}}">

                            </div>


                        </div>




                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:#0186C2;font-weight: bold;">Exp.P.Vac:</span>

                            <div class="col-md-2">
                                <input type="date" class="form-control" name="expprogvacacion"
                                    value="{{$empleados->expprogvacacion}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Vac.Ganadas:</span>

                            <div class="col-md-2">
                                <input required type="number" placeholder="0" name="vacganadas" class="form-control"
                                    placeholder="Ap.Pat...." value="{{$empleados->vacganadas}}"></input>
                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Vac.Pend.:</span>

                            <div class="col-md-2">
                                <input type="text" name="vacpendientes" class="form-control"
                                    value="{{$empleados->vacpendientes}}">

                            </div>

                        </div>





                        <div class="form-group row">

                            <span class="input-group col-md-1 "
                                style="color:#0186C2;font-weight: bold;">Vac.Usadas:</span>

                            <div class="col-md-2">
                                <input type="text" name="vacusasdas" class="form-control"
                                    value="{{$empleados->vacusasdas}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Seg.Salud:</span>

                            <div class="col-md-2">
                                <input type="text" name="segsalud" class="form-control"
                                    value="{{$empleados->segsalud}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Inamovilidad:</span>

                            <div class="col-md-2">
                                <input type="text" name="inamovilidad" class="form-control"
                                    value="{{$empleados->inamovilidad}}">

                            </div>


                        </div>





                        <div class="form-group row">

                            <span class="input-group col-md-1 " style="color:#0186C2;font-weight: bold;">Años
                                Serv.:</span>

                            <div class="col-md-2">
                                <input type="text" name="aservicios" class="form-control"
                                    value="{{$empleados->aservicios}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Curr.Vitae:</span>

                            <div class="col-md-2">
                                <input type="text" name="cvitae" class="form-control" value="{{$empleados->cvitae}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Telefono:</span>

                            <div class="col-md-2">
                                <input type="text" name="telefono" class="form-control"
                                    value="{{$empleados->telefono}}">

                            </div>


                        </div>



                        <div class="form-group row">

                            <span class="input-group col-md-1 "
                                style="color:#0186C2;font-weight: bold;">Biometrico:</span>

                            <div class="col-md-2">
                                <input type="text" name="biometrico" class="form-control"
                                    value="{{$empleados->biometrico}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Grad.Acad.:</span>

                            <div class="col-md-2">
                                <input type="text" name="gradacademico" class="form-control"
                                    value="{{$empleados->gradacademico}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Rae:</span>

                            <div class="col-md-2">
                                <input type="text" name="rae" class="form-control" value="{{$empleados->rae}}">

                            </div>


                        </div>

                        <div class="form-group row">

                            <span class="input-group col-md-1 "
                                style="color:#0186C2;font-weight: bold;">Reg.Prof:</span>

                            <div class="col-md-2">
                                <input type="text" name="regprofesional" class="form-control"
                                    value="{{$empleados->regprofesional}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Ev.Desemp.:</span>

                            <div class="col-md-2">
                                <input type="number" placeholder="0" name="evdesempenio" class="form-control"
                                    value="{{$empleados->evdesempenio}}">

                            </div>

                            <span class="input-group col-md-1 offset-md-1"
                                style="color:#0186C2;font-weight: bold;">Rejap:</span>

                            <div class="col-md-2 ">
                                <input type="date" class="form-control" name="rejap" value="{{$empleados->rejap}}">
                            </div>


                        </div>
                        </br>

                        <div class="form-group " style="align:center">


                            <label class="col-md-1" style="color:#0186C2;font-weight: bold;">File:</label>
                            <div id="permissions-select2">

                                <select name="idfile" id="permissions2" class="col-md-6">

                                    @foreach($area as $areas)
                                    <option disabled>
                                        <h1 color:blue;>{{$areas->nombrearea}}</H1>
                                    </option>
                                    @foreach($areas->iPais_all as $destino)
                                    @if ($destino->idfile==$empleados->idfile)
                                    <option value="{{$destino->idfile}}" selected>
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




                        <div class="form-group " style="align:center">


                            <label class="col-md-1" style="color:#0186C2;font-weight: bold;">Area:</label>
                            <div id="permissions-select">

                                <select name="idarea" class="col-md-6">



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






                        </br>






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-success">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </font>


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
</script>
@endsection
@endsection