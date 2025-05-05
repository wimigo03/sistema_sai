@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLE DE EVENTOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('evento.partials.search')
        @include('evento.partials.content')
    </div>
@endsection
@section('scripts')
    <script>
        function limpiar(){
            var url = "{{ route('agenda.ej.index') }}";
            window.location.href = url;
        }

        function create(){
            var date = $("#date").val()
            var url = "{{ route('agenda.ej.detalle',':date') }}";
            url = url.replace(':date',date);
            window.location.href = url;
        }

        function print(){
            var date = $("#date").val();
            var url = "{{ route('agenda.details2', ':date') }}";
            url = url.replace(':date', date);
            window.open(url, '_blank');
        }
    </script>
@endsection
