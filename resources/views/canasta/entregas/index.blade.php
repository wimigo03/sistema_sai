@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="header">
    <div class="row font-verdana-12">
        <div class="col-md-12 titulo">
            <b>CANASTA - PERIODOS</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    {{--@include('canasta.entregas.partials.search')--}}
</div>
@include('canasta.entregas.partials.table')
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            /*$('#gestion').select2({
                placeholder: "--Gestion--"
            });
            $('#mes').select2({
                placeholder: "--Mes--"
            });
            $('#estado').select2({
                placeholder: "--Estado--"
            });*/
        });

        function search(){
            var url = "{{ route('canasta.periodos.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('canasta.periodos.index') }}";
        }

    </script>
@endsection
