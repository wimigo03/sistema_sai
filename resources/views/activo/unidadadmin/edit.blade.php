@extends('layouts.dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/Activo/unidadadmin/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>EDITAR UNIDAD</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>
       
    
    
       

        <div class="body-border">
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('activo.unidadadmin.update', $unidadadmin->idunidadadmin) }}">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="entidad" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">entidad:</label>
                                <select name="entidad" id="entidades" class="col-md-6" >
                                    <option value="{{$unidadadmin->entidad}}" > {{$unidadadmin->entidad}} </option>
                                    @foreach ($entidades as $entidad)
                                        <option value="{{ $entidad->entidad }}" >
                                            <h1 color:blue;>{{ $entidad->entidad }}</h1>
                                        </option>
                                    @endforeach
    
                                </select>
                        
                    </div>
                        <div class="form-group row">
                            <label for="unidad" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">unidad:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="unidad" placeholder=""
                                    value="{{$unidadadmin->unidad}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label for="descrip" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">descrip:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="descrip" placeholder=""
                                    value="{{$unidadadmin->descrip}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ciudad" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">ciudad:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="ciudad" placeholder=""
                                    value="{{$unidadadmin->ciudad}}"
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
   