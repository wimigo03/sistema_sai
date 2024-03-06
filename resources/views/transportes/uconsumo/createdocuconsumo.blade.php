@extends('layouts.admin')

@section('content')

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
                <b>CARGAR DOCUMENTO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('UnidadConsumoController.insertar') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="form-control" name="consumo" placeholder=""
                            value="{{$idunidadconsumo}}">



                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Nombre:</label>

                            <div class="col-md-6">
                                <input type="text" name="nombredocumento" class="form-control" placeholder="Nombre..."
                                   required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right">El tamaño del archivo no debe superar los 10 mb. Archivo(solo.pdf):</label>

                            <div class="col-md-6">
                                <input type="file" name="documento" id="file" >
                            </div>
                        </div>

                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-bg" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>

                                &nbsp;
                                Guardar
                            </button>

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


</script>
@endsection