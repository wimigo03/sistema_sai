@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DISTRITOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.distrito.partials.search')
        @include('canasta_v2.distrito.partials.table')
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
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
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
