@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('Activo/organismo/index')}}">
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
                <form method="POST" action="{{ route('activo.organismo.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="gestion" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">gestion :</label>

                        <div class="col-md-6">
                            <input type="text" required name="gestion" class="form-control" placeholder="gestion..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="of" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">oficina:</label>

                        <div class="col-md-6">
                            <input type="text" required name="of" class="form-control" placeholder="oficina..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>    
                    
                    <div class="form-group row">
                        <label for="sigla" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">sigla :</label>

                        <div class="col-md-6">
                            <input type="text" required name="sigla" class="form-control" placeholder="sigla..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                   
                    

                    <br>

                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-bg" type="submit">
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

