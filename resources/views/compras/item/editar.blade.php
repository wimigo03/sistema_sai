@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>MODIFICAR MATERIAL</strong>
            </div>
        </div>
        @include('compras.item.partials.form-editar')
    </div>
@section('scripts')
    <script type="text/javascript">
        @if ($item->estado == '2')
            window.onload = function() {
                var elementos = document.querySelectorAll('.form-control');
                elementos.forEach(function(elemento) {
                    elemento.disabled = true;
                });
            };
        @endif

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
                var partida_presupuestaria_id = $("#old_partida_presupuestaria_id").val();
                getPartidasPresupuestarias(id,CSRF_TOKEN,partida_presupuestaria_id);
            }
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('#categoria_programatica_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var partida_presupuestaria_id = null;
            getPartidasPresupuestarias(id,CSRF_TOKEN,partida_presupuestaria_id);
        });

        function getPartidasPresupuestarias(id,CSRF_TOKEN,partida_presupuestaria_id){
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
                            if(json.id == partida_presupuestaria_id) {
                                opcion.attr("selected", "selected");
                            }
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
            var url = "{{ route('item.update') }}";
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
            var url = "{{ route('item.index') }}";
            window.location.href = url;
        }

        function habilitar(){
            var item_id = $("#item_id").val();
            var url = "{{ route('item.habilitar', ':id') }}";
            url = url.replace(':id', item_id);
            window.location.href = url;
        }

        function inhabilitar(){
            var item_id = $("#item_id").val();
            var url = "{{ route('item.inhabilitar', ':id') }}";
            url = url.replace(':id', item_id);
            window.location.href = url;
        }
    </script>
@endsection
@endsection
