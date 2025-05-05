@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRO DE CRONOGRAMA DE ENTREGA - BARRIOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.paquetes-barrio.partials.create')
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

            var cleave = new Cleave('#fecha_entrega', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_entrega").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $("#btn-proceso").hide();

            if($("#distrito_id >option:selected").val() != ''){
                var distrito_id = $("#distrito_id >option:selected").val();
                var paquete_id = $("#paquete_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getBarrios(distrito_id,paquete_id,CSRF_TOKEN);
            }
        });

        var barriosSeleccionados = [];

        $('#barrio_id').on('select2:open', function(e) {
            if($("#distrito_id >option:selected").val() == ""){
                Modal("Para continuar se debe seleccionar una <b>[DISTRITO]</b>.");
            }
        });

        $('#distrito_id').change(function() {
            var distrito_id = $(this).val();
            var paquete_id = $("#paquete_id").val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getBarrios(distrito_id,paquete_id,CSRF_TOKEN);
        });

        function getBarrios(distrito_id,paquete_id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/paquetes-barrio/get_barrios/' + paquete_id,
                data: {
                    _token: CSRF_TOKEN,
                    distrito_id: distrito_id
                },
                success: function(data){
                    if(data.barrios){
                        var arr = Object.values($.parseJSON(data.barrios));
                        $("#barrio_id").empty();
                        var select = $("#barrio_id");
                        select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));
                        $.each(arr, function(index, json) {
                            if (!barriosSeleccionados.includes(json.barrio_id)) {
                                var opcion = $("<option></option>").attr("value", json.barrio_id).text(json.nombre);
                                select.append(opcion);
                            }
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function registrar(){
            if(!validar_detalle()){
                return false;
            }
            if(duplicado()){
                Modal("El <b>[BARRIO]</b> seleccionado ya existe en el registro");
                return false;
            }
            registrar_detalle();
        }

        function validar_detalle(){
            if($("#barrio_id >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[BARRIO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#lugar_entrega").val() == ""){
                Modal("El campo <b>[LUGAR DE ENTREGA]</b> es un dato obligatorio...");
                return false;
            }

            if($("#fecha_entrega").val() == ""){
                Modal("El campo <b>[FECHA DE ENTREGA]</b> es un dato obligatorio...");
                return false;
            }

            if($("#hora_inicio").val() == ""){
                Modal("El campo <b>[HORA DE INICIO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#hora_final").val() == ""){
                Modal("El campo <b>[HORA FINAL]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function duplicado(){
            var barrios = $("#tabla_detalle tbody tr");
            if(barrios.length>0){
                var barrio = $("#barrio_id >option:selected").val();
                for(var i=0;i<barrios.length;i++){
                    var tr = barrios[i];
                    var barrio_id = $(tr).find(".barrio_id").val();
                    if(barrio == barrio_id){
                        return true;
                    }
                }
            }
            return false;
        }

        function registrar_detalle(){
            var table = document.getElementById("tabla_detalle");
            var rowCount = table.rows.length;
            var distrito_id = $("#distrito_id >option:selected").val();
            var distrito = $("#distrito_id >option:selected").text();
            var barrio_id = $("#barrio_id >option:selected").val();
            var barrio = $("#barrio_id >option:selected").text();
            var lugar_entrega = $("#lugar_entrega").val();
            var fecha_entrega = $("#fecha_entrega").val();
            var hora_inicio = $("#hora_inicio").val();
            var hora_final = $("#hora_final").val();
            barriosSeleccionados.push(barrio_id);
            var fila = "<tr class='font-roboto-11'>"+
                            "<td class='text-center p-1'>"+
                                    rowCount +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' name='distrito_id[]' value='" + distrito_id + "'>" +
                                    distrito +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' class='barrio_id' name='barrio_id[]' value='" + barrio_id + "'>" +
                                    barrio +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' name='lugar_entrega[]' value='" + lugar_entrega + "'>" +
                                    lugar_entrega +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' name='fecha_entrega[]' value='" + fecha_entrega + "'>" +
                                    fecha_entrega +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' name='hora_inicio[]' value='" + hora_inicio + "'>" +
                                    hora_inicio +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' name='hora_final[]' value='" + hora_final + "'>" +
                                    hora_final +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<span class='badge-with-padding badge badge-danger' onclick='eliminarItem(this, \"" + barrio_id + "\");'>" +
                                      "<i class='fas fa-trash fa-fw'></i>" +
                                 "</span>" +
                            "</td>"
                        "</tr>";

            $("#tabla_detalle").append(fila);
            $('#barrio_id').val('').trigger('change');
            document.getElementById('lugar_entrega').value = '';
            document.getElementById('fecha_entrega').value = '';
            document.getElementById('hora_inicio').value = '';
            document.getElementById('hora_final').value = '';
            contar_registros();

            $("#barrio_id option[value='" + barrio_id + "']").remove();
        }

        function contar_registros(){
            var table = document.getElementById("tabla_detalle");
            var registros = table.rows.length - 1;
            if(registros === 0){
                $("#distrito_id").prop('disabled', false);
                $("#btn-proceso").hide();
            }else{
                $("#btn-proceso").show();
                $("#distrito_id").prop('disabled', true);
            }
        }

        function eliminarItem(element, barrio_id){
            var barrioNombre = $(element).closest('tr').find('td:eq(2)').text().trim();
            $(element).closest('tr').remove();
            barriosSeleccionados = barriosSeleccionados.filter(function(id) {
                return id !== barrio_id;
            });
            $("#barrio_id").append($("<option></option>").attr("value", barrio_id).text(barrioNombre));
            contar_registros();
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.store', ':id') }}";
            url = url.replace(':id', paquete_id);
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function cancelar(){
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.index', ':id') }}";
            url = url.replace(':id', paquete_id);
            window.location.href = url;
        }
    </script>
@endsection
