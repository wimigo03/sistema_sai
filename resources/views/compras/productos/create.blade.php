@extends('layouts.dashboard')

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
                <form method="POST" action="{{ route('productos.store') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="name" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                        <div class="col-md-7">
                            <textarea id="name" required type="text" require name="nombre" placeholder="Nombre..."
                            class="form-control"  cols="50" rows="2" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detalle" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                        <div class="col-md-7">
                            <textarea id="detalle" required type="text" name="detalle" cols="50" rows="4"
                                placeholder="Detalle..." class="form-control"
                                onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precio" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>
                        <div class="col-md-2">
                            <input id="precio" class="form-control" required name="precio" type="number" placeholder="0.0" step="0.01"
                                placeholder="Precio...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="required  col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">{{ __('Partida') }}</label>
                        <div class="col-md-8" >
                            <select name="idpartida" id="permissions" class="col-md-6 form-control select2">
                                @foreach ($partidas as $par)

                                <option value="{{$par->idpartida}}">{{$par->codigopartida}} -
                                    {{$par->nombrepartida}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="required col-md-4 col-form-label text-md-right"
                            style="color:black;font-weight: bold;">{{ __('Medida') }}</label>
                        <div class="col-md-8" >

                            <select name="idmedida" id="permissions2" class="col-md-6 form-control select2">
                                @foreach ($medidas as $med)

                                <option value="{{$med->idumedida}}">{{$med->nombreumedida}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>


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
@section('scripts')
<script>
$(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

/*var permission_select = new SlimSelect({
    select: '#permissions-select select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
});
var permission_select2 = new SlimSelect({
    select: '#permissions-select2 select',
    //showSearch: false,
    placeholder: 'Select Permissions',
    deselectLabel: '<span>&times;</span>',
    hideSelectedOption: true,
});*/
</script>
@endsection
