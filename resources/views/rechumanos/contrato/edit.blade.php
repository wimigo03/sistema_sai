@extends('layouts.admin')

@section('content')

<div>
    <div>



        <div class="row font-verdana-bg">

            <div class="col-md-3 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                    <a href="{{url()->previous()}}" class="color-icon-1">
                        <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                    </a>
                </span>
            </div>
            <div class="col-md-9 text-right titulo">
                <b>GESTIONAR PERSONAL-C//MODIFICAR</b>
            </div>

            <div class="col-md-12">
                <hr class="hrr">
            </div>

        </div>
        <div class="body-borded font-verdana-bg">
            <form method="POST" action="{{ route('contrato.actualizar') }}">
                @csrf
                @method('POST')
                <input name="idemp" hidden value="{{$empleados->idemp}}"></input>
                <input name="idareaoriginal" hidden value="{{$empleados->idarea}}"></input>
                <input name="idfileoriginal" hidden value="{{$empleados->idfile}}"></input>
                <div class="form-group row">
                    <span class="input-group col-md-1" style="color:black;font-weight: bold;">Nombres:</span>

                    <div class="col-md-2 ">
                        <input required type="text" name="nombres" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" value="{{$empleados->nombres}}"></input>
                    </div>



                    <span class="input-group offset-md-1 col-md-1" style="color:black;font-weight: bold;">Apellidos<br>Paterno:</span>
                    <div class="col-md-2 ">
                        <input type="text" name="ap_pat" class="form-control " onchange="javascript:this.value=this.value.toUpperCase();" value="{{$empleados->ap_pat}}"></input>
                    </div>


                    <span class="input-group offset-md-1 col-md-1" style="color:black;font-weight: bold;">Apellidos<br>Materno:</span>
                    <div class="col-md-2 ">
                        <input required type="text" name="ap_mat" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" value="{{$empleados->ap_mat}}"></input>
                    </div>



                </div>

                <div class="form-group row">

                    <span class="input-group col-md-1 " style="color:black;font-weight: bold;">N°<br>Cédula <br>Identidad</span>
                    <div class="col-md-2 ">
                        <input type="text" name="ci" class="form-control" value="{{$empleados->ci}}">
                    </div>


                    <span class="input-group offset-md-1 col-md-1" style="color:black;font-weight: bold;">Fecha<br>Nacimiento:</span>

                    <div class="col-md-2 ">
                        <input required type="date" class="form-control" name="natalicio" value="{{$empleados->natalicio}}">
                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">N°<br>Contrato:</span>

                    <div class="col-md-2">
                        <input type="text" name="ncontrato" class="form-control" value="{{$empleados->ncontrato}}">

                    </div>



                </div>

                <div class="form-group row">


                    <span class="input-group  col-md-1" style="color:black;font-weight: bold;">Fecha<br>Ingreso:</span>
                    <div class="col-md-2 ">
                        <input required type="date" class="form-control" name="fechingreso" value="{{$empleados->fechingreso}}">
                    </div>


                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Fecha<br>Finalización:</span>

                    <div class="col-md-2 ">
                        <input type="date" class="form-control" name="fechafinal" value="{{$empleados->fechafinal}}">
                    </div>


                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">N°<br>Preventivo:</span>

                    <div class="col-md-2">
                        <input type="number" name="npreventivo" class="form-control" value="{{$empleados->npreventivo}}">

                    </div>


                </div>

                <div class="form-group row">


                    <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Total<br>Presupuesto.:</span>

                    <div class="col-md-2">
                        <input type="number" placeholder="0" name="totalpresupuesto" class="form-control" value="{{$empleados->totalpresupuesto}}">

                    </div>


                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Programa<br>Proyecto:</span>

                    <div class="col-md-2">
                        <input type="text" name="progproy" class="form-control" value="{{$empleados->progproy}}">

                    </div>



                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Curriculum<br>Vitae:</span>

                    <div class="col-md-2">
                        <input type="text" name="cvitae" class="form-control" value="{{$empleados->cvitae}}" onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>


                </div>

                <div class="form-group row">


                    <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Telefono:</span>

                    <div class="col-md-2">
                        <input type="text" name="telefono" class="form-control" value="{{$empleados->telefono}}">

                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Biometrico:</span>

                    <div class="col-md-2">
                        <input disabled type="text" name="biometrico" class="form-control" value="{{$empleados->biometrico}}">

                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Grado<br>Académico:</span>

                    <div class="col-md-2">
                        <input type="text" name="gradacademico" class="form-control" value="{{$empleados->gradacademico}}" onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>



                </div>

                <div class="form-group row">

                    <span class="input-group col-md-1 " style="color:black;font-weight: bold;">SIPPASE:</span>
                    <div class="col-md-2">
                        <input type="text" name="sippase" class="form-control" value="{{$empleados->sippase}}">

                    </div>


                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Expiración<br>SIPPASE:</span>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="expsippase" value="{{$empleados->expsippase}}">

                    </div>



                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Fecha<br>REJAP:</span>

                    <div class="col-md-2 ">
                        <input type="date" class="form-control" name="rejap" value="{{$empleados->rejap}}">
                    </div>



                </div>

                <div class="form-group row">

                    <span class="input-group col-md-1 " aria-label="Código Único de Asegurado" style="color:black;font-weight: bold;">Fondo Pensiones<br>N° C.U.A:</span>
                    <div class="col-md-2">
                        <input type="text" name="aportesafp" class="form-control" value="{{$empleados->aportesafp}}">
                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Cuenta<br>Banco:</span>

                    <div class="col-md-2">
                        <input type="text" name="cuentabanco" class="form-control" value="{{$empleados->cuentabanco}}">
                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Certificado<br>Idioma:</span>

                    <div class="col-md-2">
                        <input type="text" name="idioma" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" value="{{$empleados->idioma}}">

                    </div>

                </div>

                <div class="form-group row">


                    <span class="input-group col-md-1 " style="color:black;font-weight: bold;">N° NIT:</span>

                    <div class="col-md-2">
                        <input type="text" name="nit" class="form-control" value="{{$empleados->nit}}">

                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">SIGEP:</span>

                    <div class="col-md-2">


                        <select name="sigep" class="form-control" value="{{$empleados->sigep}}">

                            <option {{ ($empleados->sigep) == 'ACTIVO' ? 'selected' : '' }} value="ACTIVO">ACTIVO</option>
                            <option {{ ($empleados->sigep) == 'INACTIVO' ? 'selected' : '' }} value="INACTIVO">INACTIVO</option>
                        </select>

                    </div>

                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Servicio<br>Militar:</span>

                    <div class="col-md-2">
                        <input type="text" name="servmilitar" class="form-control" value="{{$empleados->servmilitar}}">

                    </div>


                </div>

                <div class="form-group row">





                    <span class="input-group col-md-1" style="color:black;font-weight: bold;">File<br>Contrato:</span>

                    <div class="col-md-2">
                        <input type="number" disabled name="filecontrato" class="form-control" value="{{$empleados->filecontrato}}">

                    </div>
                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">FILE:</span>

                    <div class="col-md-6">
                        <div id="permissions-select2">

                            <select name="idfile" id="permissions2" class="col-md-10" class="form-control">

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

                                @if ($destino->estadofile == 1 and $destino->tipofile == 2)

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



                </div>


                <div class="form-group row">

                    <span class="input-group col-md-1 " style="color:black;font-weight: bold;">Inducción:</span>

                    <div class="col-md-2">

                        <input type="text" name="induccion" class="form-control" value="{{$empleados->induccion}}">
                    </div>
                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Presentación<br>Inducción:</span>


                    <div class="col-md-2">
                        <input type="date" name="expinduccion" class="form-control" value="{{$empleados->expinduccion}}">
                    </div>


                    <span class="input-group col-md-1 offset-md-1" style="color:black;font-weight: bold;">Area :</span>

                    <div class="col-md-2" id="permissions-select">
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
                <hr class="hrr">
                <div class="form-group row">
                    <div class="col-md-12 text-right">

                        <button type="submit" class="btn btn-outline-primary font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>&nbsp;Guardar
                        </button>

                    </div>
                </div>

                </br>


            </form>
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