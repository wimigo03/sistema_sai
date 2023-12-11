@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/transportes/uconsumo/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>EDITAR FORMULARIO </b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-border" style="background-color: #FFFFFF;">

     <form method="post" action="{{ route('transportes.uconsumo.update') }}" id="form"  enctype="multipart/form-data">
    
        @csrf
        {{--@method('PUT')--}}
        <input type="text" hidden name="idunidadconsumo" 
        value="{{$consumos->idunidadconsumo}}">
       
        <div class="form-group row">
            <div class="col-md-3">
                <label for="codigoc" class="d-inline font-verdana-bg">
                    <b>Codigo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="codigoc" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="codigoc">{{$consumos->codigoconsumo}}</textarea>
            </div>

            <div class="col-md-3">
                <label for="nombreuconsumo" class="d-inline font-verdana-bg">
                    <b>Nombre</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="nombreuconsumo" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="nombreuconsumo">{{$consumos->nombreuconsumo}}</textarea>
            </div>


            <div class="col-md-6">
                <label for="desconsumo" class="d-inline font-verdana-bg">
                    <b>Descripción</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="desconsumo" cols="1" rows="3" 
                class="form-control form-control-sm font-verdana-bg" id="desconsumo" 
                >{{$consumos->desconsumo}}</textarea>
            </div>


            <div class="col-md-2">
                <label for="modeloc" class="d-inline font-verdana-bg">
                    <b>Modelo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="modeloc" value="{{$consumos->modeloconsumo}}" 
                class="form-control form-control-sm font-verdana-bg" id="modeloc">
            </div>

            <div class="col-md-2">
                <label for="colorc" class="d-inline font-verdana-bg">
                    <b>Color</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="color" name="colorc" value="{{$consumos->colorconsumo}}" 
                class="form-control form-control-sm font-verdana-bg" id="colorc">
            </div>

            <div class="col-md-2">
                <label for="placac" class="d-inline font-verdana-bg">
                    <b>Placa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="placac" value="{{$consumos->placaconsumo}}" 
                class="form-control form-control-sm font-verdana-bg" id="placac">
            </div>


            <div class="col-md-2">
                <label for="marcac" class="d-inline font-verdana-bg">
                    <b>Marca</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="marcac" value="{{$consumos->marcaconsumo}}" 
                class="form-control form-control-sm font-verdana-bg" id="marcac" >
            </div>

            <div class="col-md-2">
                <label for="klminicialc" class="d-inline font-verdana-bg">
                    <b>klm inicial</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number" name="klminicialc" value="{{$consumos->kilometrajeinicialconsumo}}"
                 class="form-control form-control-sm font-verdana-bg" id="klminicialc">
            </div>

            <div class="col-md-2">
                <label for="klmfinal" class="d-inline font-verdana-bg">
                    <b>Klm final</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="klmfinal" value="{{$consumos->kilometrajefinalconsumo}}"
                 class="form-control form-control-sm font-verdana-bg" id="klmfinal">
            </div>


            <div class="col-md-7">
                <label  class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idarea" id="idarea"  
                class="form-control form-control-sm select2" placeholder="--Seleccionar--">
                <option value="">-</option>
                    @foreach ($areas as $area)

                    @if ($area->idarea==$consumos->idarea)
                    <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                    @else
                    <option  value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
 
            <div class="col-md-5">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Programa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
               
                <select name="idprograma" id="idprograma" class="col-md-10 form-control select2 " placeholder="--Seleccionar--">
                    <option value="">-</option>
                    @foreach ($programas as $programa)

                    @if ($programa->idprogramacomb==$consumos->idprogramacomb)
                    <option value="{{$programa->idprogramacomb}}" selected>{{$programa->nombreprograma}}</option>
                    @else
                    <option value="{{$programa->idprogramacomb}}">{{$programa->nombreprograma}}</option>
                    @endif

                    @endforeach
                </select>
           
            </div> 

         

            <div class="col-md-5">
                <label for="idtipomovilidad" class="d-inline font-verdana-bg">
                    <b>Tipo Movilidad</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idtipomovilidad" id="idtipomovilidad" 
                placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($tipos as $catprogramatica)

                   
                    @if ($catprogramatica->idtipomovilidad==$consumos->idtipomovilidad)
                    <option value="{{$catprogramatica->idtipomovilidad}}" selected>
                        {{$catprogramatica->nombremovilidad}}</option>
                    @else
                    <option value="{{$catprogramatica->idtipomovilidad}}">
                        {{$catprogramatica->nombremovilidad}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="gasklm" class="d-inline font-verdana-bg">
                    <b>Gas x klm</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number" name="gasklm" value="{{$consumos->gasporklm}}"
                 class="form-control form-control-sm font-verdana-bg" id="gasklm">
            </div>

         
                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right">
                                <b style="color: red">Limite 200 mb.(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" required name="documento" id="file">
                            </div>
                        </div>
        </div>
    
        <div align='center'>


            <input  type="button" id="cancelar" value="Cancelar">



            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="Guardar" onclick="uploadFile()" id="insertar_item_material">

        </br></br>
        <progress id="progressBar" value="0" max="100" style="width:300px;display:none"></progress>
        <p id="loaded_n_total"></p>
        </div>
    </form>



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
            window.location.href = "{{ url('transportes/uconsumo/index') }}";

        });



        function validar_detalle_material() {

            if($("#codigoc").val() == ""){
                message_alert("El campo <b>[CODIGO]</b> es un dato obligatorio...");
                return false;
            }

             if($("#nombreuconsumo").val() == ""){
                 message_alert("El campo <b>[NOMBRE]</b> es un dato obligatorio...");
                 return false;
             }

    //         if (!regex.test(nombreuconsumo)) {
    //     message_alert("Por favor, ingrese solo letras mayúsculas en el campo [nombreuconsumo]...");
    //     return false;
    // }

            if($("#desconsumo").val() == ""){
                message_alert("El campo <b>[DESCRIPCION]</b> es un dato obligatorio...");
                return false;
            }

            if($("#modeloc").val() == ""){
                message_alert("El campo <b>[MODELO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#colorc").val() == ""){
                message_alert("El campo <b>[COLOR]</b> es un dato obligatorio...");
                return false;
            }
            if($("#placac").val() == ""){
                message_alert("El campo <b>[PLACA]</b> es un dato obligatorio...");
                return false;
            }
            if($("#marcac").val() == ""){
                message_alert("El campo <b>[MARCA]</b> es un dato obligatorio...");
                return false;
            }

            if($("#klminicialc").val() == ""){
                message_alert("El campo <b>[KLM INICIAL]</b> es un dato obligatorio...");
                return false;
            }

            if($("#klmfinal").val() == ""){
                message_alert("El campo <b>[KLM FINAL]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idarea >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[AREA]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idprograma >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[PROGRAMA]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idtipomovilidad >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }
          

            if($("#gasklm").val() == ""){
                message_alert("El campo <b>[Gas x Kml]</b> es un dato obligatorio...");
                return false;
            }

            return true;
        };
        function uploadFile() {
        // get the file
        let file = document.getElementById("file").files[0];

        //print file details
        console.log("File Name : ",file.name);
        console.log("File size : ",file.size);
        console.log("File type : ",file.type);

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

        document.getElementById("loaded_n_total").innerHTML = "Uploaded " + loadedSize + " bytes of " + totalSize + " bytes.";

        // calculate percentage
        var percent = (ev.loaded / ev.total) * 100;
        document.getElementById("progressBar").style.display="";
        document.getElementById("progressBar").value = Math.round(percent);

      }


        var regex = /^[A-Z]+$/;
    </script>
@endsection