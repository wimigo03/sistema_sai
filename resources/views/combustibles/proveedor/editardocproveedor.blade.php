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
                    <form method="POST" action="{{ route('proveedor.updatearchivoproveedor',$docproveedor->iddocproveedores) }}" id="form"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- <input type="hidden" class="form-control" name="proveedor" placeholder=""
                            value="{{$idproveedor}}"> --}}



                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Nombre:</label>

                            <div class="col-md-6">
                                <input type="text" name="nombredocumento" id="nombredocumento" class="form-control" placeholder="Nombre..."
                                onkeyup="convertirAMayusculas(this)" required value="{{ $docproveedor->nombredocumento}}">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right"><b style="color: red">Limite 8 mb.(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" required name="documento" id="file">
                            </div>
                        </div>


                        <div align='center'>
                            <div class="col-md-12 text-right">

                                <input class="btn btn-danger font-verdana-bg" type="button" id="cancelar" value="Cancelar">
                
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="btn color-icon-2 font-verdana-bg" type="button" value="Guardar" onclick="uploadFile()" id="insertar_item_material">
                
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
window.location.href =  "{{url()->previous()}}";

});
         
        function validar_detalle_material() {

            var filedos = document.getElementById("file").files[0];
            var maxSize = 8 * 1024 * 1024;

            if($("#nombredocumento").val() == ""){
                message_alert("El campo <b>[Nombre]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#file").val() == "") {
                return true;  
                message_alert('---SE DEBE CARGAR OBLIGATORIAMENTE UN ARCHIVO---');
                 
            } else
            if (filedos.size > maxSize) {
                console.log(filedos.size,"verificar");
                $("#file").val('');
                message_alert('El tamaño del archivo no puede superar los 8 megabytes.');
                return false;
             }
             if (filedos.type !== "application/pdf") {
                console.log(filedos.size,"verificar");
                $("#file").val('');
                message_alert('El archivo no es un pdf.');
                return false;
             }
            return true;
        };
        function convertirAMayusculas(input) {
    // Guarda la posición actual del cursor
    var inicioSeleccion = input.selectionStart;
    var finSeleccion = input.selectionEnd;
  
    // Convierte todo el texto a mayúsculas
    input.value = input.value.toUpperCase();
  
    // Restaura la posición del cursor
    input.setSelectionRange(inicioSeleccion, finSeleccion);
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
            let percentd = loadedSize/1048576;
            document.getElementById("loaded_n_total").innerHTML = "Uploaded " + percentd + " bytes of " + totalSize +
                " bytes.";

          
            var percent = (ev.loaded / ev.total) * 100;
            document.getElementById("progressBar").style.display = "";
            document.getElementById("progressBar").value = Math.round(percent);

            

        }
    
    </script>
@endsection
