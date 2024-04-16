@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PARTIDAS PRESUPUESTARIAS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('compras.partida.partials.search')
        @include('compras.partida.partials.table')
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#codigo', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#fecha_registro', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_registro").datepicker({
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
            $(".btn").hide();
            $(".spinner-btn").show();
            var dea_id = $("#dea_id").val()
            var url = "{{ route('partida.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function search(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('partida.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('partida.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
