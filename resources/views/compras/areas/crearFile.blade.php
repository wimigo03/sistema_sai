@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-bg">
        <div class="col-md-12 text-center titulo">
            <b>REGISTRAR FILE-P/{{strtoupper($area->nombrearea)}}</b>
        </div>
        {{--<div class="col-md-12">
            <hr class="hrr">
        </div>--}}
    </div>
    <div class="body-border">
        <form method="POST" action="{{ route('areas.guardarfile') }}">
            @csrf
            <input type="hidden" class="form-control" name="idarea" placeholder="" value="{{$idarea}}">
            <div class="form-group row font-verdana-bg">
                <div class="col-md-2">
                    <label for="numfile" class="d-inline">
                        <b>N° File</b>
                    </label>
                    <input type="number" name="numfile" class="form-control form-control-sm font-courier-bg" required>
                </div>
                <div class="col-md-4">
                    <label for="cargo" class="d-inline">
                        <b>Cargo</b>
                    </label>
                    <input type="text" name="cargo" class="form-control form-control-sm font-courier-bg" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="col-md-4">
                    <label for="nombrecargo" class="d-inline">
                        <b>Nombre de Cargo</b>
                    </label>
                    <input type="text" name="nombrecargo" class="form-control form-control-sm font-courier-bg" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                </div>
                <div class="col-md-2">
                    <label for="habbasico" class="d-inline">
                        <b>Haber Basico</b>
                    </label>
                    <input type="number" step="0" name="habbasico" class="form-control form-control-sm font-courier-bg" required>
                </div>
            </div>
            <div class="form-group row font-verdana-bg">
                <div class="col-md-3">
                    <label for="categoria" class="d-inline">
                        <b>Categoria</b>
                    </label><br>
                    <select name="categoria" id="#" class="form-control form-control-sm select2" required>
                        <option value="">--Seleccionar--</option>
                        <option value="SUPERIOR">Superior</option>
                        <option value="EJECUTIVO">Ejecutivo</option>
                        <option value="OPERATIVO">Operativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="niveladm" class="d-inline">
                        <b>Nivel Administrativo</b>
                    </label><br>
                    <select name="niveladm" id="#" class="form-control form-control-sm select2" required>
                        <option value="">--Seleccionar--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="clase" class="d-inline">
                        <b>Clase</b>
                    </label><br>
                    <select name="clase" id="#" class="form-control form-control-sm select2" required>
                        <option value="">--Seleccionar--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="nivelsal" class="d-inline">
                        <b>Nivel Salarial</b>
                    </label><br>
                    <select name="nivelsal" id="#" class="form-control form-control-sm select2" required>
                        <option value="">--Seleccionar--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-outline-primary font-verdana-bg" type="submit">
                        <i class="fa-solid fa-paper-plane"></i>&nbsp;Registrar
                    </button>
                    <a href="{{route('areas.file',$idarea)}}" class="btn btn-outline-danger font-verdana-bg">
                        <i class="fa fa-lg fa-reply" aria-hidden="true"></i>&nbsp;Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection