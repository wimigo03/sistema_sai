@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/combustibles/localidad/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>

            <div class="col-md-8 text-right titulo">
                <b>MODIFICAR REGISTRO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>

        </div>

        
        <div class="body-border">

            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('localidad.update', $localidads->idlocalidad) }}">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label for="codigo" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Codigo:</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" name="codigo" placeholder=""
                                value="{{$localidads->codlocalidad}}"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nombre:</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" name="nombre" placeholder=""
                                value="{{$localidads->nombrelocalidad}}"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <label for="distancia" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Distancia:</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" name="distancia" placeholder=""
                                value="{{$localidads->distancialocalidad}}"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>



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

@endsection