@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
        <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse" style="color:black;font-weight: bold;font-size: 16px;"><font >AGREGAR REGISTRO</font></div>
            <div class="row">
                <a href="{{url()->previous()}}" class="btn blue darken-4 text-black "><i
                        style="color:#55CE63;font-weight: bold;" class="fa fa-plus-square"></i> Volver atras</a>
            </div>

            <div class="card-body">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('planta.guardar') }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="idarea" value="{{$idarea}}">
                    <div class="form-group row">
                        <span class="input-group col-md-1" style="color:black;font-weight: bold;">Nombres:</span>

                        <div class="col-md-2 ">
                            <input required type="text" name="nombres" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"></input>
                        </div>



                        <span class="input-group offset-md-1 col-md-1"
                            style="color:black;font-weight: bold;">Ap.Paterno:</span>
                        <div class="col-md-2 ">
                            <input required type="text" name="ap_pat" class="form-control "
                                onkeyup="javascript:this.value=this.value.toUpperCase();"></input>
                        </div>


                        <span class="input-group offset-md-1 col-md-1"
                            style="color:black;font-weight: bold;">Ap.Materno:</span>
                        <div class="col-md-2 ">
                            <input required type="text" name="ap_mat" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"></input>
                        </div>



                    </div>



                    <div class="form-group row">


                        <span class="input-group col-md-1" style="color:black;font-weight: bold;">F.Ingreso:</span>
                        <div class="col-md-2 ">
                            <input type="date" class="form-control" name="fechingreso">
                        </div>

                        <span class="input-group offset-md-1 col-md-1"
                            style="color:black;font-weight: bold;">F.Nacimien:</span>

                        <div class="col-md-2 ">
                            <input type="date" class="form-control" name="natalicio">
                        </div>


                        


                    </div>



                    <div class="form-group row">

                        <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Ci:</span>
                        <div class="col-md-2 ">
                            <input type="text" name="ci" class="form-control">
                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Poai:</span>
                        <div class="col-md-2">
                            <input type="text" name="poai" class="form-control">
                        </div>


                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Exp.Poai:</span>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="exppoai">

                        </div>


                    </div>



                    <div class="form-group row">

                        <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Dec.Jur:</span>
                        <div class="col-md-2 ">
                            <input type="text" name="decjurada" class="form-control">

                        </div>


                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Exp.Dec.Jur.:</span>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="expdecjurada">

                        </div>


                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Sippase:</span>
                        <div class="col-md-2">
                            <input type="text" name="sippase" class="form-control">

                        </div>


                    </div>



                    <div class="form-group row">
                        <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Exp.Sipp:</span>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="expsippase">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Serv.Militar:</span>

                        <div class="col-md-2">
                            <input type="text" name="servmilitar" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Idioma:</span>

                        <div class="col-md-2">
                            <input type="text" name="idioma" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();">

                        </div>


                    </div>



                    <div class="form-group row">
                        <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Inducc:</span>

                        <div class="col-md-2">
                            <input type="text" name="induccion" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Exp.Inducc.:</span>

                        <div class="col-md-2">
                            <input type="date" class="form-control" name="expinduccion">

                        </div>


                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Prog.Vacac.:</span>

                        <div class="col-md-2">
                            <input type="text" name="progvacacion" class="form-control">

                        </div>


                    </div>




                    <div class="form-group row">
                        <span class="input-group col-md-1 "
                            style="color:black;font-weight: bold;">Exp.P.Vac:</span>

                        <div class="col-md-2">
                            <input type="date" class="form-control" name="expprogvacacion">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Vac.Ganadas:</span>

                        <div class="col-md-2">
                            <input  type="number" placeholder="0" name="vacganadas" class="form-control"
                                placeholder="Ap.Pat...."></input>
                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Vac.Pend.:</span>

                        <div class="col-md-2">
                            <input type="text" name="vacpendientes" class="form-control">

                        </div>

                    </div>





                    <div class="form-group row">

                        <span class="input-group col-md-1 "
                            style="color:black;font-weight: bold;">Vac.Usadas:</span>

                        <div class="col-md-2">
                            <input type="text" name="vacusasdas" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Seg.Salud:</span>

                        <div class="col-md-2">
                            <input type="text" name="segsalud" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Inamovilidad:</span>

                        <div class="col-md-2">
                            <input type="text" name="inamovilidad" class="form-control">

                        </div>


                    </div>





                    <div class="form-group row">

                        <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Años
                            Serv.:</span>

                        <div class="col-md-2">
                            <input type="text" name="aservicios" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Curr.Vitae:</span>

                        <div class="col-md-2">
                            <input type="text" name="cvitae" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Telefono:</span>

                        <div class="col-md-2">
                            <input type="text" name="telefono" class="form-control">

                        </div>


                    </div>





                    <div class="form-group row">

                        <span class="input-group col-md-1 "
                            style="color:black;font-weight: bold;">Biometrico:</span>

                        <div class="col-md-2">
                            <input type="text" name="biometrico" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Grad.Acad.:</span>

                        <div class="col-md-2">
                            <input type="text" name="gradacademico" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Rae:</span>

                        <div class="col-md-2">
                            <input type="text" name="rae" class="form-control">

                        </div>


                    </div>

                    <div class="form-group row">

                        <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Reg.Prof:</span>

                        <div class="col-md-2">
                            <input type="text" name="regprofesional" class="form-control">

                        </div>

                        <span class="input-group col-md-1 offset-md-1"
                            style="color:black;font-weight: bold;">Ev.Desemp.:</span>

                        <div class="col-md-2">
                            <input type="number" placeholder="0" name="evdesempenio" class="form-control">

                        </div>
                        <span class="input-group col-md-1 offset-md-1"
                                style="color:black;font-weight: bold;">Rejap:</span>

                            <div class="col-md-2 ">
                                <input type="date" class="form-control" name="rejap">
                            </div>



                    </div>
                    </br>

                    <div class="form-group " style="align:center">


                        <label class="col-md-1" style="color:black;font-weight: bold;">File:</label>
                        <div id="permissions-select2">

                            <select name="idfile" id="permissions2" class="col-md-6">
                                <option value="">== Seleccione un File ==</option>
                                @foreach($area as $areas)
                                <option disabled>
                                    <h1 color:blue;>{{$areas->nombrearea}}</H1>
                                </option>
                                @foreach($areas->iPais_all as $destino)

                                @if ($destino->estadofile == 1 and $destino->tipofile == 1)

                                <option style="color:red;" value="{{$destino->idfile}}">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-FILE-{{$destino->numfile}}-{{$destino->cargo}}-{{$destino->nombrecargo}}-{{$destino->habbasico}}-{{$destino->categoria}}-{{$destino->niveladm}}-{{$destino->clase}}-{{$destino->nivelsal}}
                                </option>

                                @endif

                                @endforeach
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

@endsection