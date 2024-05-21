<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>GENERAR QR - ARCHIVOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-8 pr-1 pl-1 text-center">
                {{ $qr }}
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-8 pr-1 pl-1 text-center">
                <br>
                <button class="btn btn-primary font-roboto-12" type="submit">
                    <i class="fa-solid fa-paper-plane fa-fw"></i>&nbsp;Registrar
                </button>
                <a href="{{ route('archivos.index') }}" class="btn btn-danger font-roboto-12">
                    <i class="fas fa-times fa-fw"></i>&nbsp;Cancelar
                </a>
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
