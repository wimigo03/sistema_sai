@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLE DE EVENTOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('agenda-ejecutiva.partials.search')
        @include('agenda-ejecutiva.partials.content')
    </div>
@endsection
@section('scripts')
    <script>
        function limpiar(){
            var url = "{{ route('agenda.ejecutiva.index') }}";
            window.location.href = url;
        }

        function create(){
            var date = $("#date").val()
            var url = "{{ route('agenda.ejecutiva.form',':date') }}";
            url = url.replace(':date',date);
            window.location.href = url;
        }

        function print(){
            var date = $("#date").val();
            var url = "{{ route('agenda.ejecutiva.details2', ':date') }}";
            url = url.replace(':date', date);
            window.open(url, '_blank');
        }
    </script>
@endsection
