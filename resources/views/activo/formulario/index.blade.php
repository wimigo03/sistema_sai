@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <b>FORMULARIO DE INVENTARIO FISICO</b>
    </div>
    <div class="card-body">
        @include('activo.formulario.partials.search')
        @include('activo.formulario.partials.table')
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
    function create() {
        $(".btn").hide();
        $(".btn-importar").hide();
        $(".spinner-btn").show();
        window.location.href = "{{ route('activo.formulario.create') }}";
    }

    function search() {
        var url = "{{ route('activo.formulario.search') }}";
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
        window.location.href = "{{ route('activo.formulario.index') }}";
    }
    </script>
@endsection
