@extends('layouts.admin')
@section('content')
<div class="card-header header">
    <div class="row">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <b>BARRIOS</b>
        </div>
    </div>
</div>
<div class="card-body body">
    @include('canasta_v2.barrio.partials.search')
    @include('canasta_v2.barrio.partials.table')
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
