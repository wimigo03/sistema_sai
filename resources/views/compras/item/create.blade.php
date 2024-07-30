@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>REGISTRAR MATERIAL</strong>
            </div>
        </div>
        @include('compras.item.partials.form-create')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('.input-numero-cleave').each(function() {
                new Cleave(this, {
                    numeral: true,
                    numeralDecimalScale: 2,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            $('#partida_presupuestaria_id').on('select2:open', function(e) {
                if($("#categoria_programatica_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <b>[CATEGORIA PROGRAMATICA]</b>.");
                }
            });

            if($("#categoria_programatica_id >option:selected").val() != ''){
                var id = $("#categoria_programatica_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getPartidasPresupuestarias(id,CSRF_TOKEN);
            }
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('#categoria_programatica_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getPartidasPresupuestarias(id,CSRF_TOKEN);
        });

        function getPartidasPresupuestarias(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/materiales/get_partidas_presupuestarias',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.partidas_presupuestarias){
                        var arr = Object.values($.parseJSON(data.partidas_presupuestarias));
                        $("#partida_presupuestaria_id").empty();
                        var select = $("#partida_presupuestaria_id");
                        select.append($("<option></option>").attr("value", '').text('--Partida Presupuestaria--'));
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.partida_presupuestaria);
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            var url = "{{ route('item.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function validar() {
            if($("#categoria_programatica_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Categoria Programatica es un dato obligatorio.");
                return false;
            }
            if($("#partida_presupuestaria_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Partida Presupuestaria es un dato obligatorio.");
                return false;
            }
            if($("#nombre").val() == ""){
                Modal("<b>[ERROR] . </b> El Nombre del material es un dato obligatorio.");
                return false;
            }
            if($("#unidad_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Unidad de Medida es un dato obligatorio.");
                return false;
            }
            if($("#precio").val() == ""){
                Modal("<b>[ERROR] . </b> La Precio es un dato obligatorio.");
                return false;
            }
            return true;
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('item.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
