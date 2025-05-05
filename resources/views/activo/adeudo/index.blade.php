@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <b>LISTADO DE NO ADEUDO</b>
    </div>
    <div class="card-body">
        @include('activo.adeudo.partials.search')
        @include('activo.adeudo.partials.table')
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
    function create() {
        $(".btn").hide();
        $(".btn-importar").hide();
        $(".spinner-btn").show();
        window.location.href = "{{ route('activo.adeudo.create') }}";
    }

    function search() {
        var url = "{{ route('activo.adeudo.search') }}";
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
        window.location.href = "{{ route('activo.adeudo.index') }}";
    }
    </script>
@endsection
