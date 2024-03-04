@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-12">
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
                    <form method="POST" action="{{ route('archivos.insertar') }}"
                        enctype="multipart/form-data">
                        @csrf



                          <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Gestion:</label>

                            <div class="col-md-3" >

                                <select name="anio" id="permissions" class="col-md-10 form-control select2 ">
                                    @foreach ($anio as $an)
                                    @if ($an->anio==$date)
                                    <option value="{{$an->anio}}" selected>{{$an->anio}}</option>
                                    @else
                                    <option value="{{$an->anio}}" >{{$an->anio}}</option>                                    @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Nombre Documento:</label>

                            <div class="col-md-6">
                                <textarea type="text" name="nombredocumento" class="form-control" placeholder="Nombre del Doc..."
                                   required onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Referencia:</label>

                            <div class="col-md-6">
                                <textarea type="text" name="referencia" class="form-control" placeholder="Referencia..."
                                   required onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="2"></textarea>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label class="required  col-md-4 col-form-label text-md-right"
                                style="color:black;font-weight: bold;">Tipo Documento</label>
                                <div class="col-md-6">
                                <select name="tipodocumento" id="permissions2" class="col-md-6 form-control select2">
                                    @foreach ($tipos as $tipo)

                                    <option value="{{$tipo->idtipo}}">{{$tipo->nombretipo}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="documento" style="color:black;font-weight: bold;"
                                class=" required col-md-4 col-form-label text-md-right"><b style="color: red">El tamaño del archivo no debe superar los 10 mb. Archivo(solo.pdf):</b></label>

                            <div class="col-md-6">
                                <input type="file" name="documento" id="file" >
                            </div>
                        </div>


                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-12" type="submit">
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
