@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

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
                <b>CREAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>

        
        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('areas.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label class="required  col-md-2 col-form-label text-md-right"
                            style="font-weight: bold;">Nombre:</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombre" class="form-control" placeholder="Nombre..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="required  col-md-2 col-form-label text-md-right"
                            style="font-weight: bold;">Nivel:</label>
                        <div class="col-md-10" id="permissions-select">
                            <select name="idnivel" required id="permissions" class="form-control select2    ">
                                @foreach ($niveles as $nivel)

                                <option value="{{$nivel->idnivel}}">{{$nivel->nivel}} - {{$nivel->nombrenivel}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>


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
@section('scripts')
<script>
$(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });
</script>
@endsection