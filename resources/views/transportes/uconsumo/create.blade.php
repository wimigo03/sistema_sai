@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{url('/uconsumo/index')}}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-8 text-right titulo">
        <b style='color:red'>{{$personalArea->nombrearea}}</b>- <b>NUEVO REGISTRO</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>


<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('uconsumo.store') }}" method="post" id="form" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="codigoc2" id="codigoc2">

        <div class="form-group row">


            <div class="col-md-3">
                <label  class="d-inline font-verdana-bg">
                    <b>Codigo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="codigoc"
                class="form-control form-control-sm font-verdana-bg" 
                id="codigoc" onchange="myFunction()"  >
            </div>
            <div class="col-md-3">
                <label for="nombreuconsumo" class="d-inline font-verdana-bg">
                    <b>Nombre</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text"  name="nombreuconsumo" 
                class="form-control form-control-sm font-verdana-bg" 
                id="nombreuconsumo"  onkeyup="convertirAMayusculas(this)">
            </div>
            <div class="col-md-3">
                <label for="idtipomovilidad" class="d-inline font-verdana-bg">
                    <b>Tipo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idtipomovilidad" id="idtipomovilidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($tipos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="col-md-2">
                <label for="idmarcamovilidad" class="d-inline font-verdana-bg">
                    <b>Marca</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idmarcamovilidad" id="idmarcamovilidad" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($marcas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div> --}}

          {{-- <div class="col-md-3">
                <label for="fechaingreso" class="d-inline font-verdana-bg">
                    <b> Fecha de ingreso</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fechaingreso" placeholder="dd/mm/aaaa"
                value="{{request('fechaingreso')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fechaingreso" data-language="es" autocomplete="off" >  
            </div> --}}
            <div class="col-md-3">
                <label for="placac" class="d-inline font-verdana-bg">
                    <b>Placa</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="placac" value="{{request('placac')}}" placeholder="Ejemplo: ABCD-1234" 
                class="form-control form-control-sm font-verdana-bg" id="placac" onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return validarPlaca(placa);">
            </div>
            
            <div class="col-md-4">
                <label for="desconsumo" class="d-inline font-verdana-bg">
                <b>Descripcion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <textarea name="desconsumo" cols="2" rows="4" 
                class="form-control form-control-sm font-verdana-bg" id="desconsumo"  onkeyup="convertirAMayusculas(this)">{{request('desconsumo')}}</textarea>
           
            </div>


            {{-- <div class="col-md-2">
                <label for="modeloc" class="d-inline font-verdana-bg">
                    <b>Modelo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="modeloc" value="{{request('modeloc')}}" 
                class="form-control form-control-sm font-verdana-bg" id="modeloc" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div> --}}

            <div class="col-md-2">
                <label for="colorc" class="d-inline font-verdana-bg">
                    <b>Color</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="colorc" value="{{request('colorc')}}" 
                class="form-control form-control-sm font-verdana-bg" id="colorc"  onkeyup="convertirAMayusculas(this)"  >

                
            </div>

            <div class="col-md-2">
                <label for="klminicialc" class="d-inline font-verdana-bg">
                    <b>klm inicial</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number" name="klminicialc" value="{{request('klminicialc')}}" 
                class="form-control form-control-sm font-verdana-bg" id="klminicialc">
            </div>


            <div class="col-md-2">
                <label for="klmfinal" class="d-inline font-verdana-bg">
                    <b>klm final</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number" name="klmfinal" value="{{request('klmfinal')}}" 
                class="form-control form-control-sm font-verdana-bg" id="klmfinal">
            </div>

            <div class="col-md-2">
                <label for="gasklm" class="d-inline font-verdana-bg">
                    <b>Gas por kilometro</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="number" name="gasklm" id="gasklm" value="{{request('gasklm')}}" 
                class="form-control form-control-sm font-verdana-bg" id="gasklm">
            </div>

            {{-- <div class="col-md-2">
                <label for="marcac" class="d-inline font-verdana-bg">
                    <b>Marca</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="marcac" value="{{request('marcac')}}" 
                class="form-control form-control-sm font-verdana-bg" id="marcac" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div> --}}

           

            {{-- <div class="col-md-5">
                <label for="idprograma" class="d-inline font-verdana-bg">
                    <b>Ubicacion Fisica</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idprograma" id="idprograma" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($programas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div> --}}

            {{-- <div class="col-md-6">
                <label for="idarea" class="d-inline font-verdana-bg">
                    <b>Area</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="idarea" id="idarea" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div> --}}
          
         

            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
            
            &nbsp;&nbsp;&nbsp;
            <div class="col-md-8">
                <label for="documento" class="d-inline font-verdana-bg" style="color:black;font-weight: bold; margin-left: 105px;">
                
                    <b style="color: red">Limite 80&nbsp;
                        mb.(solo.imagen):</b></label>

             
                    <input type="file" required name="documento" id="file" cols="2" rows="3"  >
                    <span style="margin-left: 15px; width: 480px;" class="custom-file-control"></span>

               
            </div>
        </div>
        
        <div class="col-md-12 text-right">
           

                <input class="btn btn-danger font-verdana-bg" type="button" id="cancelar" value="Cancelar">

                &nbsp;&nbsp;&nbsp;&nbsp;
                <input  class="btn color-icon-2 font-verdana-bg"  type="button" value="Guardar" onclick="uploadFile()" id="insertar_item_material">

                </br></br>
                <progress id="progressBar" value="0" max="100"
                    style="width:300px;display:none"></progress>
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
window.location.href = "{{url()->previous()}}";

});
         
        function validar_detalle_material() {
            var descripcion = $("#desconsumo").val();
            var filedos = document.getElementById("file").files[0];
         

            var maxSize = 8 * 1024 * 1024;

            if($("#nombreuconsumo").val() == ""){
                message_alert("El campo <b>[NOMBRE]</b> es un dato obligatorio...");
                return false;
            }
            if($("#codigoc").val() == ""){
                message_alert("El campo <b>[CODIGO]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#codigoc2").val() == "comunicacion") {
                $("#codigoc2").val('');
                $("#codigoc").val('');
                $("#nombreuconsumo").val('');
                message_alert("El numero de <b>[Codigo]</b> ya existe en nuestros registros...");
                return false;
            }
          
            if($("#desconsumo").val() == ""){
                message_alert("El campo <b>[DESCRIPCION]</b> es un dato obligatorio...");
                return false;
            }

            // if($("#modeloc").val() == ""){
            //     message_alert("El campo <b>[MODELO]</b> es un dato obligatorio...");
            //     return false;
            // }
            if(descripcion.length > 200){
                $("#descripcion").val('');
                $("#desconsumo").val('');
                message_alert("El campo <b>[DESCRIPCION]</b> tiene muchos caracteres...");
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
            if(!validarPlaca($("#placac").val())){
                $("#placac").val('');
               message_alert("El campo <b>[PLACA]</b> no es una placa valida...");
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
         
            if($("#idtipomovilidad >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }
        
         
            if($("#gasklm").val() == ""){
                message_alert("El campo <b>[Gas x Kml]</b> es un dato obligatorio...");
                return false;
            }
           if ($("#file").val() == "") {
                message_alert('---SE DEBE CARGAR OBLIGATORIAMENTE UN ARCHIVO---');
                return false;   
            }
            if (filedos.size > maxSize) {
                console.log(filedos.size,"verificar");
                $("#file").val('');
                message_alert('El tamaño del archivo no puede superar los 8 megabytes.');
                return false;
             }
             if (filedos.type == "application/pdf") {
                console.log(filedos.size,"verificar");
                $("#file").val('');
                message_alert('El archivo no es una imagen.');
                return false;
             }
            return true;
        };
        function myFunction() {
            respuesta();
        }
        function respuesta() {
            var ot_antigua = $("#cominterna").val();
            $.ajax({
                url: "{{ route('uconsumo.pregunta9') }}",
                data: 'ot_antigua=' + ot_antigua,
                dataType: "html",
                asycn: false,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function(data) {
                  
                    if (data.success == true) {
                        $("#codigoc2").val('comunicacion');
                    }
                }
            });
        }

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

            document.getElementById("loaded_n_total").innerHTML = "Cargado " + loadedSize + " bytes de " + totalSize +
                " bytes.";

          
            var percent = (ev.loaded / ev.total) * 100;
            document.getElementById("progressBar").style.display = "";
            document.getElementById("progressBar").value = Math.round(percent);

            

        }
        function convertirAMayusculas(input) {
    // Guarda la posición actual del cursor
    var inicioSeleccion = input.selectionStart;
    var finSeleccion = input.selectionEnd;
  
    // Convierte todo el texto a mayúsculas
    input.value = input.value.toUpperCase();
  
    // Restaura la posición del cursor
    input.setSelectionRange(inicioSeleccion, finSeleccion);
  }
        function valideNumber(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }else{
                return false;
            }
        } 
     
        function validarPlaca(placa) {

var regex =  /^[A-Z]{4}-\d{4}$/;
return regex.test(placa);

}
    </script>
@endsection
