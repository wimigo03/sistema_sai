@extends('layouts.admin')

@section('content')


<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url()->previous() }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>EDITAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


            <div class="body-border">

            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('areas.update', $areas->idarea) }}">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label for="nombre"
                            class="required col-md-2 col-form-label text-md-right" style="font-weight: bold;">Nombre:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre" placeholder=""
                                value="{{$areas->nombrearea}}"
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
</div>
</div>    
@endsection