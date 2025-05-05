@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR DISTRITO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.distrito.partials.create-form')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                confirmar();
                event.preventDefault();
            }
        });

        function confirmar(){
            var url = "{{ route('distritos.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('distritos.index') }}";
        }
    </script>
@endsection
