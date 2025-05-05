@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ACTUALIZAR PDF</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form method="post" action="{{ route('correspondencia.local.updatepdf') }}" enctype="multipart/form-data" id="form">
            @csrf
            <input type="hidden" value="{{ $idrecepcion }}" name="idrecepcion" id="idrecepcion" required>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-4 pr-1 pl-1 text-center">
                    <label for="fecha" class="d-inline text-danger"><b>Limite 10 MB. (Solo pdf)</b></label><br>
                    <input type="file" name="documento" id="file" class="form-control font-roboto-12" required>
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-8 text-right">
                    <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="uploadFile()" id="insertar_item_material">
                        <i class="fa-solid fa-paper-plane fa-fw"></i> Guardar
                    </button>
                    <button class="btn btn-outline-danger font-roboto-12" type="button" id="cancelar">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                    <progress id="progressBar" value="0" max="100" style="width:300px;display:none"></progress>
                    <p id="loaded_n_total"></p>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        var Modal = function(mensaje){
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
            window.location.href = "{{ route('correspondencia.local.gestionar', $idrecepcion) }}";

        });

        function validar_detalle_material() {
            if ($("#file").val() == "") {
                Modal('[SE DEBE CARGAR OBLIGATORIAMENTE UN ARCHIVO]');
                return false;
            }
            return true;
        };

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

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
            ajax.open("post", "your_upload_url"); // replace with your file URL

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
