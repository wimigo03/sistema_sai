@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>SOLICITUD COMPRA</b>
    </div>
    <div class="card-body">
        @include('compras.pedidoparcial.partials.search')
        @include('compras.pedidoparcial.partials.table')
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#estado').select2({
            placeholder: "--Estado--"
        });
        $('#area_id').select2({
            placeholder: "--Area--"
        });
        $('#programa_id').select2({
            placeholder: "--Programa--"
        });
        $('#programatica_id').select2({
            placeholder: "--Categoria Programatica--"
        });
        $("#fecha").datepicker({
            inline: false, 
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    });

    function create(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        window.location.href = "{{route('compras.pedidoparcial.create')}}";
    }

    function responsables(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        window.location.href = "{{route('compras.pedidoparcial.listadoResponsables')}}";
    }

    function procesar(){
        var url = "{{ route('compras.pedidoparcial.search') }}";
        $("#form").attr('action', url);
        $(".btn").hide();
        $(".spinner-btn-send").show();
        $("#form").submit();
    }

    function limpiar(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        window.location.href = "{{ route('compras.pedidoparcial.index') }}";
    }
</script>
@endsection
@endsection
