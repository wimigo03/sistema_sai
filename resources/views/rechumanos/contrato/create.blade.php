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
    <div class="col-md-9 text-right titulo">
        <b>GESTIONAR PERSONAL-C // REGISTRAR</b>

        <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
            <button class="btn btn-sm btn-danger font-verdana" type="button">
                &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
    </div>
    <div class="col-md-12">
        <hr>
        @if(Session::has('pendiente'))
        <div class="alert alert-danger font-verdana-bg">
            {{ Session::get('pendiente') }}
        </div>
        <hr>

        @endif

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        <hr>

        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger font-verdana-bg">
            {{ Session::get('error') }}
        </div>
        <hr>

        @endif
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
                <input  type="text" name="ap_pat" class="form-control " onchange="javascript:this.value=this.value.toUpperCase();"></input>
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>Ap.Materno:</b></label>
                <input required type="text" name="ap_mat" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();"></input>
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>N° CI:</b></label>
                <input required type="text" name="ci" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="nombres"><b>N° Telefono Cel.:</b></label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="col-md-2 ">
                <label for="nombres"><b>Fecha .Nacimiento:</b></label>
                <input required type="date" class="form-control" name="natalicio">
            </div>
        </div>



        <div class="form-group row font-verdana-bg">

            <div class="col-md-2">
                <label for="cvitae"><b>Currículum Vitae:</b></label>
                <input type="text" name="cvitae" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();">

            </div>
            <div class="col-md-2">
                <label for="idioma"><b>Certificado Idioma (opcional)</b></label>
                <input type="text" name="idioma" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();">
            </div>

            <div class="col-md-2">
                <label for="gradacademico"><b>Profesión (G. Acad.):</b></label>
                <input type="text" name="gradacademico" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();">

            </div>

            <div class="col-md-2">

                <label for="servmilitar"><b>Servicio Militar:</b></label>
                <input type="text" name="servmilitar" class="form-control">

            </div>

            <div class="col-md-2">

                <label for="cuentabanco"><b>N° Cuenta Banco:</b></label>
                <input type="text" name="cuentabanco" class="form-control">

            </div>
            <div class="col-md-2">
                <label for="aportesafp"><b>Fondo Pensiones<br>N° C.U.A:</b></label>
                <input type="text" name="aportesafp" class="form-control" value="">
            </div>
        </div>


        <div class="form-group row font-verdana-bg">
            <div class="col-md-2">
                <label for="ncontrato"><b>N° Contrato:</b></label>
                <input type="text" name="ncontrato" class="form-control">
            </div>

            <div class="col-md-2 ">
                <label for="fechingreso"><b>Fecha Ingreso:</b></label>
                <input required type="date" class="form-control" name="fechingreso">
            </div>

            <div class="col-md-2 ">
                <label for="fechafinal"><b>Fecha Finalización:</b></label>
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
                <label for="nit"><b>N° NIT:</b></label>
                <input type="text" name="nit" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="progproy"><b>SIPPASE:</b></label>
                <input type="text" name="sippase" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="progproy"><b>Exp. SIPPASE:</b></label>
                <input type="date" class="form-control" name="expsippase">
            </div>
            <div class="col-md-2 ">
                <label for="rejap"><b>REJAP:</b></label>
                <input type="date" class="form-control" name="rejap">
            </div>
            <div class="col-md-2">
                <label for="sigep"><b>SIGEP:</b></label>
                <select name="sigep" class="form-control">

                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>

                </select>
            </div>
            <div class="col-md-2">
                <label for="biometrico"><b>Biométrico:</b></label>
                <input disabled type="text" name="biometrico" class="form-control">
            </div>
        </div>



        <div class="form-group row font-verdana-bg">
            <div class="col-md-2">
                <label for="induccion"><b>Inducción</b></label>
                <input type="text" name="induccion" class="form-control form-control-sm font-verdana-bg">
            </div>
            <div class="col-md-2">
                <label for="exp_induccion"><b>Exp. Inducción</b></label>
                <input type="date" name="expinduccion" class="form-control form-control-sm font-verdana-bg">
            </div>
            <div class="col-md-6">
                <label style="color:black;font-weight: bold;">Contrato File:</label>
                <span id="mensajeError" style="color: red;"></span>

                <div id="permissions-select2">

                    <select name="idfile" id="permissions2"  required>
                        <option value=""></option>
                        @foreach($area as $areas)
                        <option disabled>
                            {{$areas->nombrearea}}
                        </option>
                        @foreach($areas->iPais_all as $destino)

                        @if ($destino->estadofile == 1 and $destino->tipofile == 2)

                        <option value="{{$destino->idfile}}">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-FILE-{{$destino->numfile}}-{{$destino->cargo}}-{{$destino->nombrecargo}}-{{$destino->habbasico}}-{{$destino->categoria}}-{{$destino->niveladm}}-{{$destino->clase}}-{{$destino->nivelsal}}
                        </option>

                        @endif

                        @endforeach
                        @endforeach

                    </select>
                </div>
            </div>

        </div>

        <hr class="hrr">
        </br>
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button id="botonGuardar" type="submit" class="btn btn-outline-success font-verdana-bg">
                    <i class="fa-solid fa-paper-plane"></i>&nbsp;GUARDAR
                </button>

            </div>
        </div>

    </form>

</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#permissions2').select2({
            placeholder: "--Seleccionar--"
        });

        $('#permissions2').on('select2:select', function (e) {
            $('#mensajeError').text('');
        });

        $('#botonGuardar').click(function() {
            var seleccion = $('#permissions2').val();
            if (seleccion === null) {
                $('#mensajeError').text('Por favor, selecciona una opción antes de guardar.');
                return;
            }
            // Aquí puedes realizar otras acciones relacionadas con el guardado.
        });
    });
</script>
@endsection

@endsection