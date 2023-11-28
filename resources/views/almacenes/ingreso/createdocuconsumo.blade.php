@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{url()->previous()}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

            </div>

            <div class="col-md-8 text-right titulo">
                <b>CREAR NOTA INGRESO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >

                    <form method="POST" action="{{ route('IngresoController.insertar') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="form-control" name="notaingreso" placeholder=""
                            value="{{$idingreso}}">



                        <div class="form-group row">
                            <label for="numcompra" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Numcompra:</label>

                            <div class="col-md-6">
                                <input type="text" name="numcompra" class="form-control" placeholder="Nombre..."
                                   required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="numsolicitud" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Numsolicitud:</label>

                            <div class="col-md-6">
                                <input type="text" name="numsolicitud" class="form-control" placeholder="Nombre..."
                                   required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="comprobante" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">comprobante:</label>

                            <div class="col-md-6">
                                <input type="text" name="comprobante" class="form-control" placeholder="comprobante..."
                                   required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="factura" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">factura:</label>

                            <div class="col-md-6">
                                <input type="text" name="factura" class="form-control" placeholder="factura..."
                                   required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>


                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-bg" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>

                                &nbsp;
                                Guardar
                            </button>

                        </div>
                    </form>

                </font>

            </div>

        </div>
    </div>

@endsection
