@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <div class="row">
            <div class="col-md-10">
                <b>ROL - DETALLE</b>
            </div>
            <div class="col-md-2 text-right">
                <span class="tts:left tts-slideIn tts-custom" aria-label="Retroceder" style="cursor: pointer;">
                    <a href="{{ route('roles.index') }}" class="btn btn-xs">
                        <i class="fa-solid fa-lg fa-chevron-left"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row font-verdana">
            <div class="col-md-4 pr-1">
                <label for="" class="d-inline"><b>DIRECCION ADM.</b></label>
                <input type="text" value="{{ $role->dea != null ? $role->dea->descripcion : '[Error]'}}" class="form-control form-control-sm font-verdana" disabled>
            </div>
            <div class="col-md-2 pl-1">
                <label for="" class="d-inline"><b>ID</b></label>
                <input type="text" value="{{ $role->id }}" class="form-control form-control-sm font-verdana" disabled>
            </div>
        </div>
        <div class="form-group row font-verdana">
            <div class="col-md-4 pr-1">
                <label for="" class="d-inline"><b>TITULO</b></label>
                <input type="text" value="{{ $role->title }}" class="form-control form-control-sm font-verdana" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="" class="d-inline"><b>CODIGO</b></label>
                <input type="text" value="{{ $role->short_code }}" class="form-control form-control-sm font-verdana" disabled>
            </div>
            <div class="col-md-2 pl-1">
                <label for="" class="d-inline"><b>ESTADO</b></label>
                <input type="text" value="{{ $role->status }}" class="form-control form-control-sm font-verdana" disabled>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <table id="datatable" class="table display table-bordered responsive" style="width:100%;">
                    <thead>
                        <tr class="font-verdana-11">
                            <td class="text-left p-1"><b>ID</b></td>
                            <td class="text-left p-1"><b>NOMBRE</b></td>
                            <td class="text-left p-1"><b>DESCRIPCION</b></td>
                            <td class="text-center p-1"><b>ESTADO</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $datos)
                            <tr class="font-verdana-11">
                                <td class="text-left p-1">{{ $datos->permission_id }}</td>
                                <td class="text-left p-1">{{ $datos->permission }}</td>
                                <td class="text-left p-1">{{ $datos->descripcion }}</td>
                                <td class="text-center p-1">{{ $datos->estado == 1 ? 'HABILITADO' : 'DESHABILITADO' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        
    </script>
@endsection