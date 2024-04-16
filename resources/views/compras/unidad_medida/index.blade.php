@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>UNIDADES DE MEDIDA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('compras.unidad_medida.partials.search')
        @include('compras.unidad_medida.partials.table')
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('unidad.medida.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('unidad.medida.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
