@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>DISTRITOS</b>
    </div>
    <div class="card-body">
        @include('canasta_v2.distrito.partials.search')
        @include('canasta_v2.distrito.partials.table')
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dea').select2({
                placeholder: "--DEA--"
            });

            $('#estado').select2({
                placeholder: "--Estado--"
            });
        });

        function procesar(){
            var url = "{{ route('distritos.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('distritos.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('distritos.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('distritos.create') }}";
        }
    </script>
@endsection
