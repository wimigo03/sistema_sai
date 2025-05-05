@extends('layouts.dashboard')
@section('content')
<style>
    .custom-autocomplete {
    font-size: 11px;
}
</style>
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('correspondencia-local.partials.form-create-recepcion')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $("#fecha").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('#emp').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{ route('correspondencia.local.remitente.buscar.crear') }}",
                    dataType : 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data){
                        response(data)
                    }
                });
            },
            open: function(event, ui) {
                $(this).autocomplete("widget").addClass("custom-autocomplete");
            }
        });

        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('correspondencia.local.index') }}";
            window.location.href = url;
        }

        function validar_detalle_material() {
            if ($("#fecha").val() == "") {
                Modal('[EL CAMPO FECHA ES OBLIGATORIO]');
                return false;
            }
            if ($("#emp").val() == "") {
                Modal('[EL CAMPO REMITENTE ES OBLIGATORIO]');
                return false;
            }
            if ($("#asunto").val() == "") {
                Modal('[EL CAMPO ASUNTO ES OBLIGATORIO]');
                return false;
            }
            if ($("#codigo").val() == "") {
                Modal('[EL CAMPO CODIGO ES OBLIGATORIO]');
                return false;
            }
            if ($("#tipo").val() == "") {
                Modal('[EL CAMPO TIPO CORRESPONDENCIA ES OBLIGATORIO]');
                return false;
            }

            return true;
        };



        function uploadFile() {console.log("ok");
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
