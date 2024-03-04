@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row font-verdana-12">
                <div class="col-md-4 titulo">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ URL::previous() }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>

                </div>

                <div class="col-md-8 text-right titulo">
                    <b>CARGAR PDF</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('evento2.storepdf') }}" enctype="multipart/form-data"
                        id="form">
                        @csrf
                        <input type="hidden" value="{{ $idevento2 }}" required name="idevento2" id="idevento2">
                        <br><br>

                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right"><b style="color: red">Limite 10 mb.(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" required name="documento" id="file">
                            </div>
                        </div>

                        <br>
                        <div align='center'>


                            <input type="button" id="cancelar" value="Cancelar">

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" value="Guardar" onclick="uploadFile()" id="insertar_item_material">

                            </br></br>
                            <progress id="progressBar" value="0" max="100"
                                style="width:300px;display:none"></progress>
                            <p id="loaded_n_total"></p>
                        </div>
                    </form>

                </font>


            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>


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
            window.location.href = "{{ URL::previous() }}";

        });



        function validar_detalle_material() {


            if ($("#file").val() == "") {
                alert('---SE DEBE CARGAR OBLIGATORIAMENTE UN ARCHIVO---');
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

            // calculate percentage
            var percent = (ev.loaded / ev.total) * 100;
            document.getElementById("progressBar").style.display = "";
            document.getElementById("progressBar").value = Math.round(percent);

        }
    </script>
@endsection
