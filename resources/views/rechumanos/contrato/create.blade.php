@extends('layouts.admin')

@section('content')



<div class="row font-verdana-bg">

    <div class="col-md-3 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
            <a href="{{url()->previous()}}" class="color-icon-1">
                <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
            </a>
        </span>
    </div>
    <div class="col-md-9 text-center titulo">
        <b>GESTIONAR PERSONAL-C//REGISTRAR</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="body-borderd">

    <form method="POST" action="{{ route('contrato.guardar') }}">
        @csrf
        @method('POST')
        <input type="hidden" name="idarea" value="{{$idarea}}">
        <div class="form-group row font-verdana-bg">

            <div class="col-md-2 ">
                <label for="nombres"><b>Nombre(s)</b></label>
                <input required type="text" name="nombres" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();"></input>
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>Ap.Paterno:</b></label>
                <input required type="text" name="ap_pat" class="form-control " onchange="javascript:this.value=this.value.toUpperCase();"></input>
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>Ap.Materno:</b></label>
                <input required type="text" name="ap_mat" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();"></input>
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>Ci:</b></label>
                <input type="text" name="ci" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="nombres"><b>Telefono:</b></label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>F.Nacimien:</b></label>
                <input type="date" class="form-control" name="natalicio">
            </div>
        </div>



        <div class="form-group row font-verdana-bg">

            <div class="col-md-2">
                <label for="cvitae"><b>Curr.Vitae:</b></label>
                <input type="text" name="cvitae" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();">

            </div>
            <div class="col-md-2">
                <label for="idioma"><b>Idioma:</b></label>
                <input type="text" name="idioma" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();">
            </div>

            <div class="col-md-2">
                <label for="gradacademico"><b>Grad.Acad.:</b></label>
                <input type="text" name="gradacademico" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();">

            </div>

            <div class="col-md-2">

                <label for="servmilitar"><b>Serv.Militar:</b></label>
                <input type="text" name="servmilitar" class="form-control">

            </div>

            <div class="col-md-2">

                <label for="cuentabanco"><b>Cuenta.Banco:</b></label>
                <input type="text" name="cuentabanco" class="form-control">

            </div>
            <div class="col-md-2">
                <label for="aportesafp"><b>Aportes.Afp:</b></label>

                <select name="aportesafp" class="form-control">

                    <option value="1">PREVISION AFP</option>
                    <option value="2">FUTURO DE BOLIVIA</option>
                    <option value="3">GESTORA PUBLICA</option>

                </select>
            </div>
        </div>


        <div class="form-group row font-verdana-bg">
            <div class="col-md-2">
                <label for="ncontrato"><b>N.Contrato:</b></label>
                <input type="text" name="ncontrato" class="form-control">
            </div>

            <div class="col-md-2 ">
                <label for="fechingreso"><b>F.Ingreso:</b></label>
                <input type="date" class="form-control" name="fechingreso">
            </div>

            <div class="col-md-2 ">
                <label for="fechafinal"><b>F.Final:</b></label>
                <input type="date" class="form-control" name="fechafinal">
            </div>

            <div class="col-md-2">
                <label for="npreventivo"><b>N.Preventivo:</b></label>
                <input type="number" name="npreventivo" class="form-control">

            </div>
            <div class="col-md-2">
                <label for="totalpresupuesto"><b>Tot.Presup.:</b></label>
                <input type="number" placeholder="0" name="totalpresupuesto" class="form-control">

            </div>

            <div class="col-md-2">
                <label for="progproy"><b>Prog.Proy.:</b></label>
                <input type="text" name="progproy" class="form-control">

            </div>
        </div>


        <div class="form-group row font-verdana-bg">

            <div class="col-md-2">
                <label for="nit"><b>Nit:</b></label>
                <input type="text" name="nit" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="progproy"><b>Sippase:</b></label>
                <input type="text" name="sippase" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="progproy"><b>Exp.Sipp:</b></label>
                <input type="date" class="form-control" name="expsippase">
            </div>
            <div class="col-md-2 ">
                <label for="rejap"><b>Rejap:</b></label>
                <input type="date" class="form-control" name="rejap">
            </div>
            <div class="col-md-2">
                <label for="sigep"><b>Sigep:</b></label>
                <select name="sigep" class="form-control">

                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>

                </select>
            </div>
            <div class="col-md-2">
                <label for="biometrico"><b>Biometrico:</b></label>
                <input type="text" name="biometrico" class="form-control">
            </div>
        </div>


        </br>
        <div class="form-group row font-verdana-bg">
        <label class="col-md-1" style="color:black;font-weight: bold;">File:</label>
            <div id="permissions-select2">

                <select name="idfile" id="permissions2" class="form-control" required>
                    <option value="">== Seleccione un File ==</option>
                    @foreach($area as $areas)
                    <option disabled>
                        <h1 color:blue;>{{$areas->nombrearea}}</H1>
                    </option>
                    @foreach($areas->iPais_all as $destino)

                    @if ($destino->estadofile == 1 and $destino->tipofile == 2)

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
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-outline-success font-verdana-bg" type="submit">
                    <i class="fa-solid fa-paper-plane"></i>&nbsp;Guardar
                </button>

            </div>
        </div>
         
    </form>

</div>

@section('scripts')
    <script>
  

        $('#permissions2').select2({
            placeholder: "--Seleccionar--"
        });
    </script>
    @endsection

@endsection