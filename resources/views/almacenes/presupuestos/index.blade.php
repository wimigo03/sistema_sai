<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Ejecuciones Presupuestarias</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-scale-balanced fa-fw"></i>&nbsp;<b class="title-size">PRESUPUESTOS</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.presupuestos.partials.search')
            @include('almacenes.presupuestos.partials.table')
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            var partidaPresupuestariaId = @json(request('partida_presupuestaria_id'));

            $(document).ready(function() {
                $('#categoria_programatica_id').select2({
                    theme: "bootstrap4",
                    placeholder: "--Categoria Programatica--",
                    width: '100%'
                });

                $('#partida_presupuestaria_id').select2({
                    theme: "bootstrap4",
                    placeholder: "--Partida Presupuestaria--",
                    width: '100%'
                });

                $('#trimestre').select2({
                    theme: "bootstrap4",
                    placeholder: "--Trimestre--",
                    width: '100%'
                });

                if($("#categoria_programatica_id >option:selected").val() != ""){
                    var id = $("#categoria_programatica_id >option:selected").val();
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    getPartidasPresupuestarias(id,CSRF_TOKEN);
                }
            });

            var Modal = function(mensaje){
                $("#modal-alert .modal-body").html(mensaje);
                $('#modal-alert').modal({keyboard: false});
            }

            $('.intro').on('keypress', function(event) {
                if (event.which === 13) {
                    procesar();
                    event.preventDefault();
                }
            });

            $('#partida_presupuestaria_id').on('select2:open', function(e) {
                if($("#categoria_programatica_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <br> <b>[CATEGORIA PROGRAMATICA]</b>.");
                }
            });

            $('#categoria_programatica_id').change(function() {
                var id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getPartidasPresupuestarias(id,CSRF_TOKEN);
            });

            function getPartidasPresupuestarias(id, CSRF_TOKEN){
                $.ajax({
                    type: 'GET',
                    url: '/presupuesto/get_partidas_presupuestarias',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        if (data.partidas_presupuestarias) {
                            var arr = Object.values($.parseJSON(data.partidas_presupuestarias));
                            var select = $("#partida_presupuestaria_id");

                            select.empty();
                            select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));

                            $.each(arr, function(index, json) {
                                var opcion = $("<option></option>")
                                    .attr("value", json.partida_presupuestaria_id)
                                    .text(json.data_completo);
                                select.append(opcion);
                            });

                            if (partidaPresupuestariaId) {
                                select.val(partidaPresupuestariaId);
                            }
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            function create(){
                var url = "{{ route('presupuesto.create') }}";
                window.location.href = url;
            }

            function search(){
                var url = "{{ route('presupuesto.search') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function limpiar(){
                var url = "{{ route('presupuesto.index') }}";
                window.location.href = url;
            }
        </script>
    @endsection
@endsection
