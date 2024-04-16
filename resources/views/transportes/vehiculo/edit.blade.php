@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/transportes/vehiculo/index')}}">
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
                    <form method="POST" action="{{ route('vehiculo.update', $vehiculos->idvehiculo) }}">
                        @csrf
                        @method('POST')

                        <div class="form-group row">
                            <label for="codigo" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">codigo vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="codigo" placeholder=""
                                    value="{{$vehiculos->codigovehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="detalle" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">detalle vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="detalle" placeholder=""
                                    value="{{$vehiculos->detvehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">tipo vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="tipo" placeholder=""
                                    value="{{$vehiculos->tipovehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marca" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">marca vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="marca" placeholder=""
                                    value="{{$vehiculos->marcavehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="model" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">model vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="model" placeholder=""
                                    value="{{$vehiculos->modelovehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="color" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">color vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="color" placeholder=""
                                    value="{{$vehiculos->colorvehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="placa" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">placa vehiculo:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="placa" placeholder=""
                                    value="{{$vehiculos->placavehiculo}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="klmtrajeact" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">klmtrajeact vehiculo:</label>
                            <div class="col-md-6">
                                <input type="number" required class="form-control" name="klmtrajeact" placeholder=""
                                    value="{{$vehiculos->klmtrajeactvehiculo}}"
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
   