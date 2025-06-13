<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('presupuesto.index') }}"> Presupuestos</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Modificar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="title-size">MODIFICAR REGISTRO EJECUCION PRESUPUESTARIA</b>
            </div>
        </div>

        <div class="row abs-center">
            <div class="col-md-6">
                <div class="card-body">
                    @include('almacenes.presupuestos.partials.form')
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            var partidaPresupuestariaId = @json($presupuesto->partida_presupuestaria_id);

            $(document).ready(function() {
                $('.select2').select2({
                    theme: "bootstrap4",
                    placeholder: "--Seleccionar--",
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

            new Cleave("#monto", {
                numeral: true,
                numeralDecimalMark: '.',
                delimiter: ',',
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand',
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

            function getPartidasPresupuestarias(id,CSRF_TOKEN){
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

            async function procesar() {
                if(!validar()){
                    return false;
                }

                document.querySelector('#gestion').disabled = false;
                var url = "{{ route('presupuesto.update') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();

                /*$('#modal_confirmacion').modal({
                    keyboard: false
                });*/
            }

            /*function confirmar(){
                document.querySelector('#gestion').disabled = false;
                var url = "{{ route('presupuesto.store') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }*/

            function cancelar(){
                var url = "{{ route('presupuesto.index') }}";
                window.location.href = url;
            }

            function validar(){
                if($("#categoria_programatica_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[CATEGORIA PROGRAMATICA]</b> para continuar");
                    return false;
                }
                if($("#partida_presupuestaria_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[PARTIDA PRESUPUESTARIA]</b> para continuar");
                    return false;
                }
                if($("#trimestre >option:selected").val() == ""){
                    Modal("Se debe seleccionar un <b>[TRIMESTRE]</b> para continuar");
                    return false;
                }
                if($("#monto").val() == ""){
                    Modal("Se debe seleccionar una <b>[SUCURSAL]</b> para continuar");
                    return false;
                }

                return true;
            }
        </script>
    @endsection
@endsection
