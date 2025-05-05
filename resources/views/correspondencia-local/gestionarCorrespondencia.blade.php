@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>GESTIONAR CORRESPONDENCIA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('correspondencia-local.partials.form-gestionar-correspondencia')
    </div>
@endsection
@section('scripts')
    <script>


    </script>
@endsection
