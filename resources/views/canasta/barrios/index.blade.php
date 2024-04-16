@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="header">
    <div class="row font-verdana-12">
        <div class="col-md-12 titulo">
            <b>CANASTA - BARRIOS</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    @include('canasta.barrios.partials.search')
</div>
@include('canasta.barrios.partials.table')
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                placeholder: "--Tipo--"
            });
            $('#distrito').select2({
                placeholder: "--Distrito--"
            });
            $('#estado').select2({
                placeholder: "--Estado--"
            });
        });

        function search(){
            var url = "{{ route('canasta.barrios.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('canasta.barrios.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('canasta.barrios.index') }}";
        }

    </script>
@endsection
