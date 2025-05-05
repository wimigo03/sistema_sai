@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
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
       

        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('activo.oficina.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="unidad" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">unidad :</label>

                        <div class="col-md-6">
                            <input type="text" required name="unidad" class="form-control" placeholder="unidad..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="codigooficina" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">codigooficina:</label>

                        <div class="col-md-6">
                            <input type="text" required name="codigooficina" class="form-control" placeholder="codigo oficina..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>    
                    
                    <div class="form-group row">
                        <label for="nombreoficina" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">nombreoficina :</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombreoficina" class="form-control" placeholder="nombre oficina..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="observacion" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">observacion :</label>

                        <div class="col-md-6">
                            <input type="text" required name="observacion" class="form-control" placeholder="observacionacion..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fechaultima" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">fechaultima :</label>

                        <div class="col-md-6">
                            <input type="text" required name="fechaultima" class="form-control" placeholder="fecha ultima..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="empleados" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">empleados :</label>

                        <div class="col-md-6">
                            <input type="text" required name="empleados" class="form-control" placeholder="empleados..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="api_estado" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">api_estado :</label>

                        <div class="col-md-6">
                            <input type="text" required name="api_estado" class="form-control" placeholder="api_estado..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
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

