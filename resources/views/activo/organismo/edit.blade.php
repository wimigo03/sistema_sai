@extends('layouts.dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/activo/organismo/index')}}">
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
                    <form method="POST" action="{{ route('activo.organismo.update', $organismofin->idorganismo) }}">
                        @csrf
                        @method('POST')

                        <div class="form-group row">
                            <label for="gestion" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">gestion :</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="gestion" placeholder=""
                                    value="{{$organismofin->gestion}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="of" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">oficina:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="of" placeholder=""
                                    value="{{$organismofin->of}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sigla" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">sigla:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="sigla" placeholder=""
                                    value="{{$organismofin->sigla}}"
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
   