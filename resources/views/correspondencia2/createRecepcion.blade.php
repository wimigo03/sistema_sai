@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/correspondencia2/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>

                <div class="col-md-8 text-right titulo">
                    <b>REGISTRAR RECEPCION</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>

            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('guardar2.recepcion') }}" id="form" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="fecha" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Fecha Recepcion:</label>

                            <div class="col-md-3">

                                <input type="text" name="fecha" placeholder="dd/mm/aaaa"
                                    class="form-control form-control-sm font-verdana-bg" id="fecha" data-language="es"
                                    autocomplete="off" value="{{ $fechaActual }}" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">{{ __('Remintente') }}</label>
                            <div class="col-md-8">
                                <select name="emp" id="emp" class="col-md-10 form-control select2">
                                    @foreach ($remitentes as $remitente)
                                    <option value="">-</option>
                                        <option value="{{ $remitente->id_remitente }}">
                                            {{ $remitente->nombres_remitente}}
                                            {{ $remitente->apellidos_remitente}}
                                            --
                                            {{ $remitente->nombre_unidad}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Asunto:</label>

                            <div class="col-md-6">
                                <textarea type="text" name="asunto" class="form-control" placeholder="Asunto..." required id="asunto"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="2"></textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Codigo:</label>

                            <div class="col-md-2">
                                <input type="text" required name="codigo" class="form-control" placeholder="Codigo..." id="codigo"
                                value="{{ $maxId2 }}" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Hoja de ruta:</label>

                            <div class="col-md-2">
                                <input type="text" required name="oficio" class="form-control"
                                    placeholder="Hoja de ruta..."
                                    value="{{ $hojaderuta }}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">{{ __('Tipo Correspondencia') }}</label>
                            <div class="col-md-8">
                                <select name="tipo" id="tipo" class="col-md-10 form-control select2">
                                    @foreach ($tipos as $tipo)
                                    <option value="">-</option>
                                        <option value="{{$tipo->idtipo_corresp}}">
                                            {{ $tipo->nombre_tipo}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right"><b style="color: red">Limite 20
                                    mb.(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" required name="documento" id="file">
                            </div>
                        </div>


                        <br>

                        <div align='center'>
                            <a href="{{ route('crear2.tipo') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar tipo">
                                <button class="btn btn-sm btn-warning font-verdana" type="button">
                                    &nbsp;<i class="fa fa-lg fa-align-justify" aria-hidden="true"></i>&nbsp;
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('crear2.remitente') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Remitente">
                                <button class="btn btn-sm btn-primary font-verdana" type="button">
                                    &nbsp;<i class="fa fa-lg fa-user" aria-hidden="true"></i>&nbsp;
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;

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
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });


        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });


        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {

                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });

        $("#cancelar    ").click(function() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('correspondencia2/index') }}";

        });

        function validar_detalle_material() {



            if ($("#fecha").val() == "") {
                alert('---EL CAMPO FECHA ES OBLIGATORIO--');
                return false;
            }

            if ($("#emp").val() == "") {
                alert('---EL CAMPO REMITENTE ES OBLIGATORIO--');
                return false;
            }

            if ($("#asunto").val() == "") {
                alert('---EL CAMPO ASUNTO ES OBLIGATORIO--');
                return false;
            }

            if ($("#codigo").val() == "") {
                alert('---EL CAMPO CODIGO ES OBLIGATORIO--');
                return false;
            }

            if ($("#tipo").val() == "") {
                alert('---EL CAMPO TIPO CORRESPONDENCIA ES OBLIGATORIO--');
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
