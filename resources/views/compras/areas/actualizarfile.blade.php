@extends('layouts.dashboard')
@section('content')
    <div class="row font-verdana-12">
        <div class="col-md-12 text-center titulo">
            <b>MODIFICAR FILE-P/{{strtoupper($area->nombrearea)}}</b>
        </div>
        {{--<div class="col-md-12">
            <hr class="hrr">
        </div>--}}
    </div>
    <div class="body-border">
        <form method="POST" action="{{ route('file.update') }}">
            @csrf
            <input type="hidden" name="idfile" value="{{$file->idfile}}">
            <input type="hidden" name="idarea" value="{{$file->idarea}}">
            <div class="form-group row font-verdana-12">
                <div class="col-md-2">
                    <label for="numfile" class="d-inline">
                        <b>N° File</b>
                    </label>
                    <input type="number" value="{{$file->numfile}}" name="numfile" class="form-control form-control-sm font-verdana-12" required>
                </div>
                <div class="col-md-4">
                    <label for="cargo" class="d-inline">
                        <b>Cargo</b>
                    </label>
                    <input type="text" value="{{$file->cargo}}" name="cargo" class="form-control form-control-sm font-verdana-12" onchange="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="col-md-4">
                    <label for="nombrecargo" class="d-inline">
                        <b>Nombre de Cargo</b>
                    </label>
                    <input type="text" value="{{$file->nombrecargo}}" name="nombrecargo" class="form-control form-control-sm font-verdana-12" onchange="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="col-md-2">
                    <label for="habbasico" class="d-inline">
                        <b>Haber Basico</b>
                    </label>
                    <input type="number" value="{{$file->habbasico}}" step="0" name="habbasico" class="form-control form-control-sm font-verdana-12" required>
                </div>
            </div>
            <div class="form-group row font-verdana-12">
                <div class="col-md-2">
                    <label for="categoria" class="d-inline">
                        <b>Categoria</b>
                    </label><br>
                    <select name="categoria" id="#" class="form-control form-control-sm font-verdana-12 select2" required>
                        <option {{ ($file->categoria) == 'SUPERIOR' ? 'selected' : '' }} value="SUPERIOR">Superior</option>
                        <option {{ ($file->categoria) == 'EJECUTIVO' ? 'selected' : '' }} value="EJECUTIVO">Ejecutivo</option>
                        <option {{ ($file->categoria) == 'OPERATIVO' ? 'selected' : '' }} value="OPERATIVO">Operativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="niveladm" class="d-inline">
                        <b>Nivel Administrativo</b>
                    </label><br>
                    <select name="niveladm" id="#" class="form-control form-control-sm font-verdana-12 select2" required>
                        <option {{ ($file->niveladm) == 1 ? 'selected' : '' }} value="1">1</option>
                        <option {{ ($file->niveladm) == 2 ? 'selected' : '' }} value="2">2</option>
                        <option {{ ($file->niveladm) == 3 ? 'selected' : '' }} value="3">3</option>
                        <option {{ ($file->niveladm) == 4 ? 'selected' : '' }} value="4">4</option>
                        <option {{ ($file->niveladm) == 5 ? 'selected' : '' }} value="5">5</option>
                        <option {{ ($file->niveladm) == 6 ? 'selected' : '' }} value="6">6</option>
                        <option {{ ($file->niveladm) == 7 ? 'selected' : '' }} value="7">7</option>
                        <option {{ ($file->niveladm) == 8 ? 'selected' : '' }} value="8">8</option>
                        <option {{ ($file->niveladm) == 9 ? 'selected' : '' }} value="9">9</option>
                        <option {{ ($file->niveladm) == 10 ? 'selected' : '' }} value="10">10</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="clase" class="d-inline">
                        <b>Clase</b>
                    </label><br>
                    <select name="clase" id="#" class="form-control form-control-sm font-verdana-12 select2" required>
                        <option {{ ($file->clase) == 1 ? 'selected' : '' }} value="1">1</option>
                        <option {{ ($file->clase) == 2 ? 'selected' : '' }} value="2">2</option>
                        <option {{ ($file->clase) == 3 ? 'selected' : '' }} value="3">3</option>
                        <option {{ ($file->clase) == 4 ? 'selected' : '' }} value="4">4</option>
                        <option {{ ($file->clase) == 5 ? 'selected' : '' }} value="5">5</option>
                        <option {{ ($file->clase) == 6 ? 'selected' : '' }} value="6">6</option>
                        <option {{ ($file->clase) == 7 ? 'selected' : '' }} value="7">7</option>
                        <option {{ ($file->clase) == 8 ? 'selected' : '' }} value="8">8</option>
                        <option {{ ($file->clase) == 9 ? 'selected' : '' }} value="9">9</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="nivelsal" class="d-inline">
                        <b>Nivel Salarial</b>
                    </label><br>
                    <select name="nivelsal" id="#" class="form-control form-control-sm font-verdana-12 select2" required>
                        <option {{ ($file->nivelsal) == 1 ? 'selected' : '' }} value="1">1</option>
                        <option {{ ($file->nivelsal) == 2 ? 'selected' : '' }} value="2">2</option>
                        <option {{ ($file->nivelsal) == 3 ? 'selected' : '' }} value="3">3</option>
                        <option {{ ($file->nivelsal) == 4 ? 'selected' : '' }} value="4">4</option>
                        <option {{ ($file->nivelsal) == 5 ? 'selected' : '' }} value="5">5</option>
                        <option {{ ($file->nivelsal) == 6 ? 'selected' : '' }} value="6">6</option>
                        <option {{ ($file->nivelsal) == 7 ? 'selected' : '' }} value="7">7</option>
                        <option {{ ($file->nivelsal) == 8 ? 'selected' : '' }} value="8">8</option>
                        <option {{ ($file->nivelsal) == 9 ? 'selected' : '' }} value="9">9</option>
                        <option {{ ($file->nivelsal) == 10 ? 'selected' : '' }}value="10">10</option>
                        <option {{ ($file->nivelsal) == 11 ? 'selected' : '' }} value="11">11</option>
                        <option {{ ($file->nivelsal) == 12 ? 'selected' : '' }} value="12">12</option>
                        <option {{ ($file->nivelsal) == 13 ? 'selected' : '' }} value="13">13</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="nivelsal" class="d-inline">
                        <b>Area</b>
                    </label><br>
                    <select name="idarea2" id="#" class="form-control form-control-sm font-verdana-12 select2" required>
                        @foreach ($areas as $area)
                            @if ($area->idarea==$file->idarea)
                                <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                            @else
                                <option value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-outline-primary font-verdana-12" type="submit">
                        <i class="fa-solid fa-paper-plane"></i>&nbsp;Actualizar
                    </button>
                    <a href="{{route('areas.file',$file->idarea)}}" class="btn btn-outline-danger font-verdana-12">
                        <i class="fa fa-lg fa-reply" aria-hidden="true"></i>&nbsp;Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
