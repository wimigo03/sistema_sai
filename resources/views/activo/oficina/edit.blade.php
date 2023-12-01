@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/activo/oficina/index')}}">
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
       
    
    
       

        <div class="body-border">codigooficina
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('activo.oficina.update', $oficina->idoficina) }}">
                        @csrf
                        @method('POST')

                        <div class="form-group row">
                            <label for="unidad" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">unidad:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="unidad" placeholder=""
                                    value="{{$oficina->unidad}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigooficina" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">codigooficina:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="codigooficina" placeholder=""
                                    value="{{$oficina->codigooficina}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombreoficina" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">nombreoficina:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="nombreoficina" placeholder=""
                                    value="{{$oficina->nombreoficina}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="observacion" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">observacion:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="observacion" placeholder=""
                                    value="{{$oficina->observacion}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fechaultima" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">fechaultima:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="fechaultima" placeholder=""
                                    value="{{$oficina->fechaultima}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="empleados" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">empleados:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="codigooficina" placeholder=""
                                    value="{{$oficina->empleados}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="api_estado" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">api_estado:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="api_estado" placeholder=""
                                    value="{{$oficina->api_estado}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                       
                        

                        <br>


                            <div align='center'>

                                <button class="btn color-icon-2 font-verdana-bg" type="submit">
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
   