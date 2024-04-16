@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>BENEFICIARIOS  {{ $idpaquete }}</b>
    </div>
    <div class="card-body">
        @include('canasta_v2.entregas.partials.search_beneficiario')
        @include('canasta_v2.entregas.partials.table_beneficiario')
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                placeholder: "--Tipo--"
            });

            $('#dea').select2({
                placeholder: "--DEA--"
            });

            $('#idBarrio').select2({
                placeholder: "--Barrio--"
            });

            $('#estado').select2({
                placeholder: "--Estado--"
            });
        });

        function procesar(){
            var url = "{{ route('entregas.search_beneficiario',$idpaquete) }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('barrios.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('entregas.index_beneficiario') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('beneficiarios.create') }}";
        }
    </script>
@endsection
