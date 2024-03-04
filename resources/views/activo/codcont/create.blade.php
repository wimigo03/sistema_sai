@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('Activo/codcont/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>

            <div class="col-md-8 text-right titulo">
                <b>CREAR NUEVO GRUPO CONTABLE</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>

        </div>



        <div class="body-border">
            <font size="2" face="Courier New">
                <form method="POST" action="{{ route('activo.codcont.store') }}">
                    @csrf

                    <div class="form-group row font-verdana-sm">
                        <div class="col-md-8 mb-3">
                            <label style="color:black;font-weight: bold;">NOMBRE DE GRUPO CONTABLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="codcont" value="{{$newcodigo}}" readonly="true" class="form-control" required>

                                    <span class="input-group-text">{{$newcodigo}}</span>
                                </div>
                                <input type="text" name="nombre" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label style="color:black;font-weight: bold;">FECHA :</label>
                            <div class="input-group">
                                <input type="date" required name="feult" readonly="true" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label style="color:black;font-weight: bold;">VIDA UTIL :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">


                                    <span class="input-group-text">AÑOS </span>
                                </div>
                                <input type="number" required name="vidautil" class="form-control" value=" " required>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="observ" style="color:black;font-weight: bold;">OBSERVACIONES :</label>
                            <textarea type="text" class="form-control" rows="3" name="observ" placeholder="observacion..." onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                        <div class="form-check-inline">
                            <label for="depreciar" style="color:black;font-weight: bold;" class="required col-md-12 col-form-label text-md-right">DEPRECIAR</label>
                            <input type="checkbox" name="depreciar" value="1" class="form-control">
                        </div>

                        <div class="form-check-inline">
                            <label for="actualizar" style="color:black;font-weight: bold;" class="required col-md-12 col-form-label text-md-right">ACTUALIZAR</label>
                            <input type="checkbox" name="actualizar" value="1" class="form-control">
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