@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <b>LISTADO DE VEHICULOS</b>
    </div>
    <div class="card-body">
        @include('activo.vehiculo.partials.search')
        @include('activo.vehiculo.partials.table')
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function create() {
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('activo.vehiculo.create') }}";
        }

        function search() {
            var url = "{{ route('activo.vehiculo.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function limpiar() {
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('activo.vehiculo.index') }}";
        }
    </script>
@endsection
