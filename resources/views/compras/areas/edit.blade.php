@extends('layouts.admin')
@section('content')
{{--<div class="row justify-content-center">
    <div class="col-md-10">--}}
        <div class="row font-verdana-bg">
            <div class="col-md-3 titulo">
                &nbsp;
            </div>
            <div class="col-md-6 text-center titulo">
                <b>EDITAR REGISTRO DE AREA</b>
            </div>
            <div class="col-md-3 titulo">
                &nbsp;
            </div>
            {{--<div class="col-md-12">
                <hr class="hrr">
            </div>--}}
        </div>
        <div class="body-border">
            <form method="POST" action="{{ route('areas.update', $areas->idarea) }}">
                @csrf
                @method('POST')
                <div class="form-group row font-verdana-bg justify-content-center">
                    <div class="col-md-4">
                        <label for="nombre" class="d-inline">
                            <b>Nombre</b>
                        </label>
                        <input type="text" name="nombre" value="{{$areas->nombrearea}}" class="form-control form-control-sm font-verdana-bg" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                </div>
                <div class="form-group row font-courier-bg justify-content-center">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-outline-primary font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>&nbsp;Actualizar
                        </button>
                        <a href="{{route('areas.index')}}" class="btn btn-outline-danger font-verdana-bg">
                            <i class="fa fa-lg fa-reply" aria-hidden="true"></i>&nbsp;Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    {{--</div>
</div>--}}    
@endsection