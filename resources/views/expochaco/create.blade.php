@extends('layouts.admin3')
@section('content')
    @include('layouts.message_alert')

    <div class="row font-verdana-12">

        <div class="col-md-12 text-right titulo">
            <b style="color: green">SOLICITUD DE STAND PABELLON GRAN CHACO</b>
            <hr class="hrr">
        </div>

    </div>

    <form action="{{ route('expochaco.store') }}" method="post" id="form">
        @csrf

        <input type="hidden" name="pabellon" id="pabellon" value="GRAN CHACO">

        <input type="hidden" name="superficie" id="superficie" value="3x3">

        <input type="hidden" name="precio" id="precio" value="250">
        <input type="hidden" name="ci2" id="ci2">
        <label for="representante" class="d-inline font-verdana-12">
            <b style="color: green">DATOS DEL PABELLON</b>
        </label>
        <div class="body-border" style="background-color: #FFFFFF;">

            <div class="form-group row">
                <div class="col-md-4">
                    <label for="pabellon2" class="d-inline font-verdana-12">
                        <b>PABELLON</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="pabellon2" disabled class="form-control form-control-sm font-verdana-12"
                        id="pabellon2" value="GRAN CHACO">
                </div>

                <div class="col-md-4">
                    <label for="superficie2" class="d-inline font-verdana-12">
                        <b>SUPERFICIE POR STAND</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="superficie2" disabled class="form-control form-control-sm font-verdana-12"
                        id="superficie2" value="3x3">
                </div>

                <div class="col-md-4">
                    <label for="superficie" class="d-inline font-verdana-12">
                        <b>PRECIO POR STAND (En Bs.)</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="precio2" disabled class="form-control form-control-sm font-verdana-12"
                        id="precio2" value="250">
                </div>

            </div>
        </div>
        <label for="representante" class="d-inline font-verdana-12">
            <b style="color: green">DATOS DEL SOLICITANTE</b>
        </label>
        <div class="body-border" style="background-color: #FFFFFF;">

            <div class="form-group row">


                <div class="col-md-4">
                    <label for="nombresolicitud" class="d-inline font-verdana-12">
                        <b>NOMBRES Y APELLIDOS DEL SOLICITANTE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="nombresolicitud" cols="1" rows="1" class="form-control form-control-sm font-verdana-12"
                        id="nombresolicitud" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>

                <div class="col-md-4">
                    <label for="ci" class="d-inline font-verdana-12">
                        <b>N° C.I.</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="ci" class="form-control form-control-sm font-verdana-12" id="ci"
                        onchange="myFunction()">
                </div>



                <div class="col-md-4">
                    <label for="asociacionsol" class="d-inline font-verdana-12">
                        <b>ASOCIACION/FEDERACION</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <select name="asociacionsol" id="asociacionsol" placeholder="--Seleccionar--"
                        class="form-control form-control-sm select">
                        <option value="">-</option>
                        <option value="FEREMYPE">FEREMYPE</option>
                        <option value="CAPPIA">CAPPIA</option>
                        <option value="COORDINADORA FERIAS">COORDINADORA FERIAS</option>
                        <option value="APICULTORES">APICULTORES</option>
                        <option value="ARTESANOS">ARTESANOS</option>
                        <option value="ASOVIT">ASOVIT</option>
                        <option value="OTROS">OTROS(Especifique el campo siguiente..)</option>

                    </select>
                </div>

                <div class="col-md-6">
                    <label for="cirepresentante" class="d-inline font-verdana-12">
                        <b>OTROS ASOCIACION/ FEDERACION(En caso que selecciono otros en el campo anterior)</b>&nbsp;<span
                            style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="otros" class="form-control form-control-sm font-verdana-12"
                        id="otros" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>





                <div class="col-md-6">
                    <label for="direccionsol" class="d-inline font-verdana-12">
                        <b>DIRECCION DEL TALLER/NEGOCIO O EMPRENDIMIENTO</b>&nbsp;<span
                            style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="direccionsol" cols="1" rows="3" class="form-control form-control-sm font-verdana-12"
                        id="direccionsol" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>

                <div class="col-md-6">
                    <label for="ciudad" class="d-inline font-verdana-12">
                        <b>DISTRITO/CIUDAD</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="ciudad" cols="1" rows="2" class="form-control form-control-sm font-verdana-12"
                        id="ciudad" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>


                <div class="col-md-4">
                    <label for="telefonosol" class="d-inline font-verdana-12">
                        <b>TELEFONO/CELULAR:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="telefonosol" class="form-control form-control-sm font-verdana-12"
                        id="telefonosol">
                </div>



                <div class="col-md-6">
                    <label for="correosol" class="d-inline font-verdana-12">
                        <b>E-MAIL</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>



                    <input id="correosol" type="text" class="form-control form-control-sm font-verdana-12"
                        name="correosol">




                </div>

                <div class="col-md-4">
                    <label for="idrubro" class="d-inline font-verdana-12">
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
                    <label for="cantidad" class="d-inline font-verdana-12">
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
                    <label for="unidsep" class="d-inline font-verdana-12">
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
        <label for="representante" class="d-inline font-verdana-12">
            <b style="color: green">DATOS DEL REPRESENTANTE</b>
        </label>
        <div class="body-border" style="background-color: #FFFFFF;">

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="representante" class="d-inline font-verdana-12">
                        <b>NOMBRE DEL REPRESENTANTE LEGAL ASOCIACION O INSTITUCION</b>&nbsp;<span
                            style="font-size:10px; color: red;">*</span>
                    </label>
                    <textarea name="representante" cols="1" rows="2" class="form-control form-control-sm font-verdana-12"
                        id="representante" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>

                <div class="col-md-4">
                    <label for="cirepresentante" class="d-inline font-verdana-12">
                        <b>C.I. DELREPRESENTANTE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                    </label>
                    <input type="text" name="cirepresentante" class="form-control form-control-sm font-verdana-12"
                        id="cirepresentante" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>


            </div>
        </div>

        <div align='center'>

            <div class="body-border col-md-4" style="background-color: #FFFFFF;">

                <div class="form-group row">
                    <div class="col-md-12    text-right">
                        <button class="btn btn-danger font-verdana-12" type="button" onclick="cancelar();">

                            <a style="color:white">Cancelar</a>
                        </button>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send"
                            style="display: none;"></i>

                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                        <button class="btn color-icon-2 font-verdana-12" type="button" onclick="save();">
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

        function validar_formulario() {


            if ($("#nombresolicitud").val() == "") {
                message_alert("El campo <b>[NOMBRES Y APELLIDOS]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#ci").val() == "") {
                message_alert("El campo <b>[C.I No]</b> es un dato obligatorio...");
                return false;
            }


            if ($("#ci2").val() == "alexis") {
                $("#ci2").val('');
                $("#ci").val('');
                $("#nombresolicitud").val('');

                message_alert("La persona con este <b>[CI]</b> ya existe en nuestros registros...");
                return false;

            }

            if ($("#asociacionsol>option:selected").val() == "") {
                message_alert("El campo <b>[ASOCIACION/FEDERACION]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#asociacionsol>option:selected").val() == "OTROS") {


                if ($("#otros").val() == "") {
                    message_alert("Especifique en <b>[OTROS ASOCIACION/ FEDERACION]</b> a la cual pertenece...");
                    return false;
                }

            }







            if ($("#direccionsol").val() == "") {
                message_alert("El campo <b>[DIRECCION]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#ciudad").val() == "") {
                message_alert("El campo <b>[DISTRITO/CIUDAD]</b> es un dato obligatorio...");
                return false;
            }



            if ($("#telefonosol").val() == "") {
                message_alert("El campo <b>[TELEFONO]</b> es un dato obligatorio...");
                return false;
            }



borrar de abajo
function valideNumber(evt) {
    var code = (evt.which) ? evt.which : evt.keyCode;


            if ($("#idrubro >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[RUBRO]</b> es un dato obligatorio...");
                return false;
            }



            if ($("#representante").val() == "") {
                message_alert("El campo <b>[REPRESENTANTE LEGAL ASOCIACION O INSTITUCION]</b> es un dato obligatorio...");
                return false;
            }




            return true;
        }




        function myFunction() {
            respuesta();
        }

        function respuesta() {
            var ot_antigua = $("#ci").val();

            $.ajax({
                url: "{{ route('pregunta2') }}",

                data: 'ot_antigua=' + ot_antigua,
                //url:"{{ route('pregunta2') }}/"+id,
                //url: '/ruta2/' + id,
                dataType: "html",
                asycn: false,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                dataType: 'JSON',
                success: function(data) {
                    // console.log(data); //Try to log the data and check the response
                    if (data.success == true) {

                        // iiii='345';

                        // hola();
                        //respuesta = 1;
                        $("#ci2").val('alexis');
                        //console.log(alex2);
                        //respuesta(iii);
                        //return (data.success);
                        // return alex2;
                        //return regex.test(data)
                        //alert('success :  user logged in');
                        //notifyMe();
                        //return true;

                    }

                }



            });



        }
    </script>
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
