@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>BARRIOS</b>
    </div>
    <div class="card-body">
        @include('canasta_v2.barrio.partials.search')
        @include('canasta_v2.barrio.partials.table')

    </div>

    @foreach ($barrios as $datos)

    @include('canasta_v2.barrio.partials.barrio_edit_delete_create')
    @endforeach
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

            $('#distrito').select2({
                placeholder: "--Distrito--"
            });

            $('#estado').select2({
                placeholder: "--Estado--"
            });
        });

        function procesar(){
            var url = "{{ route('barrios.search') }}";
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
            window.location.href = "{{ route('barrios.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('barrios.create') }}";
        }
    </script>
@endsection
