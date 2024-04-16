@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/archivos2/tipoarchivo')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>CREAR TIPO ARCHIVO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >

                <form method="POST" action="{{ route('archivos2.storecreatetipo') }}">
                    @csrf

                    <div class="form-group row">
                    <label for="role_id" style="color:black;font-weight: bold;"
                                class="required col-md-2 col-form-label text-md-right">{{ __('Nombre:') }}</label>

                        <div class="col-md-10">
                            <textarea type="text" name="nombretipo" required class="form-control " cols="50" rows="2"
                            onchange="javascript:this.value=this.value.toUpperCase();"  placeholder="Escriba el tipo archivo..."
                              ></textarea>
                        </div>
                    </div>

                    <br>

                    <div align='center'>

                        <button class="btn color-icon-2 font-verdana-12" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            &nbsp;Registrar
                        </button>
                    </div>
                </form>

            </font>




        </div>

    </div>
</div>

@endsection
