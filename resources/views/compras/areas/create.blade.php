@extends('layouts.admin')
@section('content')
{{--<div class="row justify-content-center">
    <div class="col-md-8">--}}
        <div class="row font-verdana-bg">
            <div class="col-md-3 titulo">
                &nbsp;
            </div>
            <div class="col-md-6 text-center titulo">
                <b>REGISTRO DE AREA</b>
            </div>
            <div class="col-md-3">
                &nbsp;
            </div>
            {{--<div class="col-md-12">
                <hr class="hrr">
            </div>--}}
        </div>
        <div class="body-border">
            <form method="POST" action="{{ route('areas.store') }}">
                @csrf
                <div class="form-group row font-verdana-bg">
                    <div class="col-md-4">
                        <label for="nombre" class="d-inline">
                            <b>Nombre</b>
                        </label>
                        <input type="text" name="nombre" class="form-control form-control-sm font-verdana-bg" onchange="javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                    <div class="col-md-8">
                        <label for="idnivel" class="d-inline">
                            <b>Nivel</b>
                        </label><br>
                        <select name="idnivel" id="permissions" class="form-control form-control-sm font-verdana-bg select2" required>
                            @foreach ($niveles as $nivel)
                                <option value="{{$nivel->idnivel}}">{{$nivel->nivel}} - {{$nivel->nombrenivel}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row font-courier-bg">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-outline-primary font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>&nbsp;Registrar
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
@section('scripts')
<script>
$(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });
</script>
@endsection
