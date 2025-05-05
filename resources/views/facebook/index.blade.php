@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PUBLICACIONES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('facebook.partials.search')
        @include('facebook.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
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
            var url = "{{ route('facebook.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('facebook.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('facebook.index') }}";
            window.location.href = url;
        }

        function entre_fechas(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('facebook.entre.fechas',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }
    </script>
@endsection
