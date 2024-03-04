@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/activo/imagenes/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>CREAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>
       
    
    
       

        <div class="body-border">
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('activo.imagenes.update', $imagen->idimagen) }}">
                        @csrf
                        @method('POST')

                        <div class="form-group row">
                            <label for="imagenactivos" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">imagenactivos:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="imagenactivos" placeholder=""
                                    value="{{$imagen->imagenactivos}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombreimagen" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">nombreimagen:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="nombreimagen" placeholder=""
                                    value="{{$imagen->nombreimagen}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rutaimagen" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">rutaimagen:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="rutaimagen" placeholder=""
                                    value="{{$imagen->rutaimagen}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        

                        <br>


                            <div align='center'>

                                <button class="btn color-icon-2 font-verdana-12" type="submit">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    &nbsp;Actualizar
                                </button>
                            </div>



                    </form>
                </font>




            </div>

        </div>
    </div>


    @endsection
   