@extends('layouts.dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('Activo/auxiliar/index', $auxiliar->codcont)}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>EDITAR AUXILIAR</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>





        <div class="body-border">
            <font size="2" face="Courier New">
                <form method="POST" action="{{ route('activo.auxiliar.update', $auxiliar->idauxiliar) }}">
                    @csrf
                    @method('POST')
                    <br>


                    <div class="form-group row font-verdana-sm">

                        <div class="col-md-4">
                            <label style="color:black;font-weight: bold;">ENTIDAD:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="entidad" value="{{$entidad->entidad}}" readonly="true" class="form-control">

                                    <span class="input-group-text">{{$entidad->entidad}}</span>
                                </div>
                                <input type="text" name="sigla" readonly="true" class="form-control" value="{{$entidad->sigla_ent}}">
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label style="color:black;font-weight: bold;">UNIDAD :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="unidad" value="{{$unidad->unidad}}" readonly="true" class="form-control" required>

                                    <span class="input-group-text">{{$unidad->unidad}}</span>
                                </div>
                                <input type="text" name="unidad-nombre" readonly="true" class="form-control" value="{{$unidad->descrip}}" required>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label style="color:black;font-weight: bold;">FECHA :</label>
                            <div class="input-group">
                                <input type="date" required name="feult" readonly="true" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label style="color:black;font-weight: bold;">GRUPO CONTABLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="codcont" value="{{$codigo->codcont}}" readonly="true" class="form-control" required>

                                    <span class="input-group-text">{{$codigo->codcont}}</span>
                                </div>
                                <input type="text" name="cod-nombre" readonly="true" value="{{$codigo->nombre}}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color:black;font-weight: bold;">AUXILIAR :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="hidden" required name="codaux" value="{{$auxiliar->codaux}}" class="form-control" required>

                                    <span class="input-group-text"> {{$auxiliar->codaux}}</span>
                                </div>
                                <input type="text" name="nomaux" class="form-control" value="{{$auxiliar->nomaux}}" required placeholder="nombre de auxiliar..."  onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="observ" style="color:black;font-weight: bold;">OBSERVACIONES :</label>
                            <textarea type="text" name="observ" class="form-control" rows="3" value="" placeholder="Observaciones..." onkeyup="javascript:this.value=this.value.toUpperCase();">{{$auxiliar->observ}}</textarea>
                        </div>
                    </div>
                    <div>

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