@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLE DE EVENTO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('agenda-ejecutiva.partials.search-show')
        @include('agenda-ejecutiva.partials.content-show')
    </div>
@endsection
@section('scripts')
    <script>
        function limpiar(){
            var url = "{{ route('agenda.ejecutiva.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
