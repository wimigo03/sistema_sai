@extends('layouts.admin3')
@section('content')
    @include('layouts.message_alert')

    <div class="row font-verdana-bg"  >

        <div class="col-md-12 text-right titulo">
            <b>CREAR NUEVA SOLICITUD DE PABELLON</b>
        </div>

    </div>
    <form action="{{ route('expochaco.store') }}" method="post" id="form">
        @csrf

        <input type="hidden" name="pabellon"  id="pabellon" value="GRAN CHACO">

        <input type="hidden" name="superficie"  id="superficie" value="3x3">

        <input type="hidden" name="precio" id="precio" value="250">

        <div class="body-border" style="background-color: #FFFFFF;">

            <div class="form-group row">
                <div class="col-md-4">
                    <label for="pabellon2" class="d-inline font-verdana-bg">
                        <b>PABELLON</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="pabellon2" disabled class="form-control form-control-sm font-verdana-bg"
                        id="pabellon2" value="GRAN CHACO">
                </div>

                <div class="col-md-4">
                    <label for="superficie2" class="d-inline font-verdana-bg">
                        <b>SUPERFICIE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="superficie2" disabled class="form-control form-control-sm font-verdana-bg"
                        id="superficie2" value="3x3">
                </div>

                <div class="col-md-2">
                    <label for="superficie" class="d-inline font-verdana-bg">
                        <b>PRECIO EN Bs.</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="precio2" disabled class="form-control form-control-sm font-verdana-bg"
                        id="precio2" value="250">
                </div>

            </div>
        </div>
        <label for="representante" class="d-inline font-verdana-bg">
            <b>DATOS DEL SOLICITANTE</b>&nbsp;<span style="font-size:10px; color: red;"></span>
        </label>
        <div class="body-border" style="background-color: #FFFFFF;">

            <div class="form-group row">


                <div class="col-md-6">
                    <label for="nombresolicitud" class="d-inline font-verdana-bg">
                        <b>NOMBRES Y APELLIDOS DEL SOLICITANTE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="nombresolicitud" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg"
                        id="nombresolicitud" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>


                <div class="col-md-4">
                    <label for="asociacionsol" class="d-inline font-verdana-bg">
                        <b>ASOCIACION/FEDERACION</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="asociacionsol" id="asociacionsol" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select">
                        <option value="">-</option>
                        <option value="FEREMIPE">FEREMIPE</option>
                        <option value="CAPIA">CAPIA</option>
                        <option value="COORDINADORA FERIAS">COORDINADORA FERIAS</option>
                        <option value="APICULTORES">APICULTORES</option>
                        <option value="ARTESANOS">ARTESANOS</option>

                    </select>
                </div>


                <div class="col-md-2">
                    <label for="ci" class="d-inline font-verdana-bg">
                        <b>N° C.I.</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="ci" class="form-control form-control-sm font-verdana-bg" id="ci"
                        onchange="javascript:this.value=this.value.toUpperCase();">
                </div>

                <div class="col-md-6">
                    <label for="direccionsol" class="d-inline font-verdana-bg">
                        <b>DIRECCION DEL TALLER/NEGOCIO</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="direccionsol" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg"
                        id="direccionsol" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>


                <div class="col-md-4">
                    <label for="telefonosol" class="d-inline font-verdana-bg">
                        <b>TELEFONO/CELULAR:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="telefonosol" class="form-control form-control-sm font-verdana-bg"
                        id="telefonosol">
                </div>



                <div class="col-md-6">
                    <label for="correosol" class="d-inline font-verdana-bg">
                        <b>E-MAIL</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>



                        <input id="correosol" type="text"
                        class="form-control form-control-sm font-verdana-bg"
                            name="correosol" value="{{ old('correosol') }}"
                            required autocomplete="correosol"
                             onkeypress="return validarCorreo(correo);">




                </div>

                <div class="col-md-6">
                    <label for="idrubro" class="d-inline font-verdana-bg">
                        <b>RUBRO:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="idrubro" id="idrubro" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select">
                        <option value="">-</option>
                        @foreach ($rubros as $rub)
                            <option value="{{ $rub->idrubro }}">{{ $rub->nombrerubro }}</option>
                        @endforeach
                    </select>
                </div>





                <div class="col-md-3">
                    <label for="cantidad" class="d-inline font-verdana-bg">
                        <b>CANTIDAD DE STANDS</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="cantidad" id="cantidad" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>

                    </select>
                </div>

                <div class="col-md-3">
                    <label for="unidsep" class="d-inline font-verdana-bg">
                        <b>SEPARADOS O UNIDOS</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="unidsep" id="unidsep" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select">
                        <option value="1">UNIDOS</option>
                        <option value="2">SEPARADOS</option>



                    </select>
                </div>

            </div>


        </div>
        <label for="representante" class="d-inline font-verdana-bg">
            <b>DATOS DEL REPRESENTANTE</b>&nbsp;<span style="font-size:10px; color: red;"></span>
        </label>
        <div class="body-border" style="background-color: #FFFFFF;">

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="representante" class="d-inline font-verdana-bg">
                        <b>REPRESENTANTE LEGAL ASOCIACION O INSTITUCION</b>&nbsp;<span
                            style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="representante" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg"
                        id="representante" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>

                <div class="col-md-4">
                    <label for="cirepresentante" class="d-inline font-verdana-bg">
                        <b>C.I. DELREPRESENTANTE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="cirepresentante" class="form-control form-control-sm font-verdana-bg"
                        id="cirepresentante" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
        </div>

        <div align='center'>

            <div class="body-border col-md-3" style="background-color: #FFFFFF;">

                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-danger font-verdana-bg" type="button" onclick="cancelar();">

                            <a  style="color:white">Cancelar</a>
                        </button>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send"
                            style="display: none;"></i>

                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                        <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                            <i class="fa-solid fa-paper-plane"></i>
                            Registrar
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function save() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function cancelar() {
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('https://granchaco.gob.bo/') }}";
        }

        function validar_formulario(){


if($("#nombresol").val() == ""){
    message_alert("El campo <b>[NOMBRES Y APELLIDOS]</b> es un dato obligatorio...");
    return false;
}
if($("#asociacionsol>option:selected").val() == ""){
    message_alert("El campo <b>[ASOCIACION]</b> es un dato obligatorio...");
    return false;
}

if($("#ci").val() == ""){
    message_alert("El campo <b>[C.I No]</b> es un dato obligatorio...");
    return false;
}

if($("#direccionsol").val() == ""){
    message_alert("El campo <b>[DIRECCION]</b> es un dato obligatorio...");
    return false;
}

if($("#telefonosol").val() == ""){
    message_alert("El campo <b>[TELEFONO]</b> es un dato obligatorio...");
    return false;
}

     if($("#correosol").val() == "" ){
       message_alert("El campo <b>[CORREO]</b> es un dato obligatorio...");
       return false;
   }

if(!validarCorreo($("#correosol").val())){

      message_alert("El campo <b>[CORREO]</b> no es un correo valido...");
      return false;
  }



if($("#idrubro >option:selected").val() == ""){
    message_alert("El campo de seleccion <b>[RUBRO]</b> es un dato obligatorio...");
    return false;
}



if($("#representante").val() == ""){
    message_alert("El campo <b>[REPRESENTANTE LEGAL ASOCIACION O INSTITUCION]</b> es un dato obligatorio...");
    return false;
}



if($("#cirepresentante").val() == ""){
    message_alert("El campo <b>[CI REPRESENTANTE]</b> es un dato obligatorio...");
    return false;
}
return true;
}


function validarCorreo(correo) {

var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[c-o-m]{3,}$/;
return regex.test(correo);

}

borrar de abajo
function valideNumber(evt) {
    var code = (evt.which) ? evt.which : evt.keyCode;

    // Permitir solo dígitos y teclas de control
    if ((code >= 48 && code <= 57) || (code >= 37 && code <= 40) || code == 8 || code == 9) {
        return true;
    } else {
        return false;
    }
}

function validarValor() {
    var inputElement = document.getElementById("tuInput"); // Reemplaza "tuInput" con el ID de tu input
    var valor = parseInt(inputElement.value);

    // Verificar si el valor es mayor o igual a 1
    if (valor >= 1) {
        console.log("Número válido: " + valor);
        // Aquí puedes realizar otras acciones si el número es válido
    } else {
        console.log("Número inválido");
        // Aquí puedes realizar otras acciones si el número es inválido
    }
}


if($detallito->isEmpty()){


if ($Cantidadrest >= 0) {
   
    $detalle->save();

    $request->session()->flash('message', 'Registro Agregado',);
} else {
    
    $request->session()->flash('message', 'La cantidad debe ser menor o igual que: '.$Cantidadsalidados.' Litros'  );
}       
// $request->session()->flash('message', 'Registro Agregado',);
}else{
$request->session()->flash('message', 'El Item Ya existe en la Planilla');
}
return redirect()->route('combustibles.detalle.index');
}


hasta aqui
</script>
@endsection
