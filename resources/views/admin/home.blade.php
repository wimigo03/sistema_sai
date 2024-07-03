@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BIENVENIDO / A</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>{{ $user->name }}</b>
            </div>
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>{{ $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat }}</b>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
