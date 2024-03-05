@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="header">
    <div class="row font-verdana-12">
        <div class="col-md-12 titulo">
            <b>CANASTA - BENEFICIARIOS</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    @include('canasta.beneficiarios.partials.search')    
</div>
@include('canasta.beneficiarios.partials.table')
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#expedido').select2({
                placeholder: "--Expedido--"
            });
            $('#distrito').select2({
                placeholder: "--Distrito--"
            });
            $('#barrio').select2({
                placeholder: "--Barrio--"
            });
            $('#estado').select2({
                placeholder: "--Estado--"
            });
            $('#sexo').select2({
                placeholder: "--Sexo--"
            });
            $("#natalicio").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true
            });
        });

        $('.search').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function search(){
            var url = "{{ route('canasta.beneficiarios.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('canasta.beneficiarios.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('canasta.beneficiarios.index') }}";
        }

    </script>
@endsection
