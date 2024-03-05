@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/Activo/entidad/index')}}">
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
                    <form method="POST" action="{{ route('activo.entidad.update', $entidades->identidades) }}">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="gestion" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">gestion:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="gestion" placeholder=""
                                    value="{{$entidades->gestion}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="entidad" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">entidad :</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="entidad" placeholder=""
                                    value="{{$entidades->entidad}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="desc_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">desc_ent:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="desc_ent" placeholder=""
                                    value="{{$entidades->desc_ent}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sigla_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">sigla_ent:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="sigla_ent" placeholder=""
                                    value="{{$entidades->sigla_ent}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sector_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">sector_ent:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="sector_ent" placeholder=""
                                    value="{{$entidades->sector_ent}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subsector_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">subsector_ent:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="subsector_ent" placeholder=""
                                    value="{{$entidades->subsec_ent}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="area_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">area_ent:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="area_ent" placeholder=""
                                    value="{{$entidades->area_ent}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subarea_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">subarea_ent:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="subarea_ent" placeholder=""
                                    value="{{$entidades->subareaent}}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nivel_inst" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">nivel_inst:</label>
                            <div class="col-md-6">
                                <input type="text" required class="form-control" name="nivel_inst" placeholder=""
                                    value="{{$entidades->nivel_inst}}"
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
   