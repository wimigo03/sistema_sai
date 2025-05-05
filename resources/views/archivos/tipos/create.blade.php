@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR TIPO DE ARCHIVO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1">
                <a href="{{ route('tipos.archivos.index') }}" class="btn btn-outline-primary font-roboto-12">
                    <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
                </a>
            </div>
        </div>
        <form method="POST" action="{{ route('tipos.archivos.store') }}">
            @csrf
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-5 pr-1 pl-1 text-right">
                    <label for="nombre" class="d-inline"><b>Nombre: </b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <input type="text" id="nombretipo" value="{{ old('nombretipo') }}" name="nombretipo" class="form-control font-roboto-12" onchange="javascript:this.value=this.value.toUpperCase();" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 pr-1 pl-1 text-right">
                    <button class="btn btn-primary font-roboto-12" type="submit">
                        <i class="fa-solid fa-paper-plane fa-fw"></i>&nbsp;Registrar
                    </button>
                    <a href="{{ route('tipos.archivos.index') }}" class="btn btn-danger font-roboto-12">
                        <i class="fas fa-times fa-fw"></i>&nbsp;Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
