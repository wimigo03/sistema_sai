@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="row font-verdana-bg">

            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/localidad/index') }}">
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
                <form method="POST" action="{{ route('localidad.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="codigo" class="required col-md-4  col-form-label text-md-right" required
                            style="color:black;font-weight: bold;">Codigo:</label>

                        <div class="col-md-6">
                            <input type="text" required name="codigo" class="form-control"
                                placeholder="Escriba el Codigo..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">Nombre:</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombre" class="form-control"
                                placeholder="Escriba el Nombre..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="distrito" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">Distrito:</label>

                        <div class="col-md-6">
                            <input type="text" required name="distrito" class="form-control"
                                placeholder="Escriba el distrito..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="distancia" class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">Distancia:</label>

                        <div class="col-md-6">
                            <input type="text" required name="distancia" class="form-control"
                                placeholder="Escriba la Distancia..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                   
                    <div class="form-group row">
                        <label for="idlocalidad" class="required col-md-4 col-form-label text-md-right"
                        style="color:black;font-weight: bold;">Medida:</label>
                        <div class="col-md-6">
                        <select name="idlocalidad" id="idlocalidad" placeholder="--Seleccionar--" 
                        class="form-control form-control-sm select2">
                            <option value="">-</option>
                            @foreach ($localidades as $index => $value)
                                <option value="{{ $index }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                    <div align='center'>
                               
                        <button class="btn color-icon-2 font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            &nbsp;Guardar
                        </button>
                    </div>

                </form>
            </font>

        </div>
       
    </div>
</div>

@endsection