@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-12">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/compras/productos/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>EDITAR REGISTRO</b>
            </div>
            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


            <div class="body-border">

            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('productos.update', $productos->idprodserv) }}">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label style="color:black;font-weight: bold;" for="name"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        <div class="col-md-7">
                            <textarea id="name" required type="text" name="nombre" placeholder="Nombre..." cols="50"
                                rows="2" class="form-control"
                                onchange="javascript:this.value=this.value.toUpperCase();">{{$productos->nombreprodserv}}</textarea>
                        </div>
                    </div>

            <div class="form-group row">
                <label style="color:black;font-weight: bold;" for="detalle"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                <div class="col-md-7">
                    <textarea id="detalle" required type="text" name="detalle" cols="51" rows="4"
                        placeholder="Detalle..." class="form-control"
                        onchange="javascript:this.value=this.value.toUpperCase();">{{$productos->detalleprodserv}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label style="color:black;font-weight: bold;" for="precio"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>
                <div class="col-md-2">
                    <input id="precio" required name="precio" type="number" placeholder="0.0" step="0.01" class="form-control"
                        placeholder="Precio..." value="{{$productos->precioprodserv}}">
                </div>
            </div>

            <div class="form-group row">
                <label style="color:black;font-weight: bold;"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Partida') }}</label>
                <div class="col-md-8" >
                    <select name="idpartida" id="permissions" class="col-md-10 form-control select2 ">
                        @foreach ($partidas as $par)
                        @if ($par->idpartida==$productos->partida_idpartida)
                        <option value="{{$par->idpartida}}" selected>{{$par->codigopartida}} - {{$par->nombrepartida}}</option>
                        @else
                        <option value="{{$par->idpartida}}">{{$par->codigopartida}} - {{$par->nombrepartida}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label style="color:black;font-weight: bold;"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Medida') }}</label>
                <div class="col-md-8" >

                    <select name="idmedida" id="permissions1" class="col-md-6 form-control select2">
                        @foreach ($medidas as $med)

                        @if ($med->idumedida==$productos->umedida_idumedida)
                        <option value="{{$med->idumedida}}" selected>{{$med->nombreumedida}}</option>
                        @else
                        <option value="{{$med->idumedida}}">{{$med->nombreumedida}}</option>
                        @endif


                        @endforeach
                    </select>
                </div>
            </div>



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
