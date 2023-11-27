@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <b>DETALLE DE PERSONAL</b>
        </div>
        <div class="card-body">
            @include('rechumanos.planta.partials.form-show')
        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function() {
                
            });
        </script>
    @endsection
@endsection