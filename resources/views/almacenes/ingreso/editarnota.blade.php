@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{url()->previous()}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

            </div>

            <div class="col-md-8 text-right titulo">
                <b>EDITAR DOCUMENTO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('IngresoController.updatearchivonota',$docproveedor->idnotaingreso) }}" id="form"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- <input type="hidden" class="form-control" name="proveedor" placeholder=""
                            value="{{$idproveedor}}"> --}}



                        <div class="form-group row">

                            <div class="col-md-2">
                                <label for="numcompra" class="d-inline font-verdana-bg">
                                    <b>Nro. Compra</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text" disabled name="numcompra" id="numcompra" onchange="myFunctiondos()" value="{{$docproveedor->numcompra}}" class="form-control form-control-sm font-verdana-bg" id="numcompra" onkeypress="return valideNumber(event);">
                            </div>
                            <div class="col-md-2">
                                <label for="numsolicitud" class="d-inline font-verdana-bg">
                                    <b>N solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text" disabled name="numsolicitud" value="{{$docproveedor->numsolicitud}}" class="form-control form-control-sm font-verdana-bg" id="numsolicitud" onkeypress="return valideNumber(event);">
                            </div>
                            <div class="col-md-3">
                                <label for="codigoproducto" class="d-inline font-verdana-bg">
                                    <b>Codigo Producto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input disabled name="codigoproducto"  class="form-control form-control-sm font-verdana-bg" id="codigoproducto" value="{{$docproveedor->codigoproducto}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="col-md-4">
                                <label for="nombreproducto" class="d-inline font-verdana-bg">
                                    <b>Nombre Producto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input disabled name="nombreproducto" cols="1" rows="4" class="form-control form-control-sm font-verdana-bg" id="nombreproducto" value="{{$docproveedor->nombreproducto}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="col-md-2">
                                <label for="ingreso" class="d-inline font-verdana-bg">
                                    <b>Ingreso</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text" disabled  name="ingreso" id="ingreso" onchange="myFunction()" value="{{$docproveedor->ingreso}}" class="form-control form-control-sm font-verdana-bg" id="ingreso" onkeypress="return valideNumber(event);">
                            </div>
                            <div class="col-md-2">
                                <label for="precio" class="d-inline font-verdana-bg">
                                    <b>Precio</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text"  disabled name="precio" id="precio" onchange="myFunction()" value="{{$docproveedor->precio}}" class="form-control form-control-sm font-verdana-bg" id="precio" onkeypress="return valideNumber(event);">
                            </div>
                            <div class="col-md-2">
                                <label for="subtotal" class="d-inline font-verdana-bg">
                                    <b>Subtotal</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text"  disabled name="subtotal" id="subtotal" onchange="myFunction()" value="{{$docproveedor->subtotal}}" class="form-control form-control-sm font-verdana-bg" id="subtotal" onkeypress="return valideNumber(event);">
                            </div>
                            <div class="col-md-3">
                                <label for="nombreproveedor" class="d-inline font-verdana-bg">
                                    <b>Proveedor</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input  disabled name="nombreproveedor"  class="form-control form-control-sm font-verdana-bg" id="nombreproveedor" value="{{$docproveedor->nombreprobeedor}}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="col-md-2">
                                <label for="factura_comprobante" class="d-inline font-verdana-bg">
                                    <b>Factura</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text"  disabled name="factura_comprobante" id="factura_comprobante" onchange="myFunction()" value="{{$docproveedor->factura_comprobante}}" class="form-control form-control-sm font-verdana-bg" id="subtotal" onkeypress="return valideNumber(event);">
                            </div>
                            <div class="col-md-6">
                                <label for="detalleingreso" class="d-inline font-verdana-bg">
                                    <b>Justificacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <textarea  name="detalleingreso" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg" id="justificacion" onkeyup="javascript:this.value=this.value.toUpperCase();">{{$docproveedor->detalleingreso}}</textarea>
                            </div>
                         
                            {{-- <div class="col-md-5">
                                <label for="idarea" class="d-inline font-verdana-bg">
                                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <select disabled name="idarea" id="idarea"  class="form-control form-control-sm select2">
                                   
                                    @foreach ($areas as $areas)
                                    @if ($areas->idarea==$docproveedor->idarea)
                                    <option value="{{$areas->idarea}}" selected>{{$areas->idarea}} - {{$areas->nombrearea}}</option>
                                    @else
                                    <option value="{{$areas->idarea}}">{{$areas->idarea}} - {{$areas->nombrearea}}</option>
                                    @endif
                                    @endforeach
                                </select>
                
                            </div> --}}

                        </div>



                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right"><b style="color: red">Limite 200 mb.(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" required name="documento" id="file">
                            </div>
                        </div>


                        <div align='center'>
                            <div class="col-md-12 text-right">

                                <input type="button" id="cancelar" value="Cancelar">
                
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="button" value="Guardar" onclick="uploadFile()" id="insertar_item_material">
                
                                </br></br>
                                <progress id="progressBar" value="0" max="100"
                                    style="width:300px;display:none"></progress>
                                <p id="loaded_n_total"></p>
                            </div>

                        </div>
                    </form>

                </font>

            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });


        function message_alert(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {

                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });

        $("#cancelar").click(function() {
$(".btn").hide();
$(".spinner-btn-send").show();
window.location.href = "{{ url('almacenes/ingreso/index') }}";

});
         
        function validar_detalle_material() {

            if($("#detalleingreso").val() == ""){
                message_alert("El campo <b>[Justificacion]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        };

        function uploadFile() {
            // get the file
            let file = document.getElementById("file").files[0];

            //print file details
            console.log("File Name : ", file.name);
            console.log("File size : ", file.size);
            console.log("File type : ", file.type);

            // create form data to send via XHR request
            var formdata = new FormData();
            formdata.append("file1", file);

            //create XHR object to send request
            var ajax = new XMLHttpRequest();

            // add progress event to find the progress of file upload
            ajax.upload.addEventListener("progress", progressHandler);

            // initializes a newly-created request
            ajax.open("POST", "your_upload_url"); // replace with your file URL

            // send request to the server
            ajax.send(formdata);
        }

        function progressHandler(ev) {

            let totalSize = ev.total; // total size of the file in bytes
            let loadedSize = ev.loaded; // loaded size of the file in bytes

            document.getElementById("loaded_n_total").innerHTML = "Uploaded " + loadedSize + " bytes of " + totalSize +
                " bytes.";

          
            var percent = (ev.loaded / ev.total) * 100;
            document.getElementById("progressBar").style.display = "";
            document.getElementById("progressBar").value = Math.round(percent);

            

        }
    
    </script>
@endsection
