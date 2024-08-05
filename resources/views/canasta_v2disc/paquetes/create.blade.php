@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR PAQUETE DISC.</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2disc.paquetes.partials.create-form')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn-proceso").hide();
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        var periodosSeleccionados = [];

        function registrar(){
            if(!validar_detalle()){
                return false;
            }
            if(duplicado()){
                Modal("El <b>[PERIODO]</b> seleccionado ya existe en el registro");
                return false;
            }
            registrar_detalle();
        }

        function duplicado(){
            var periodos = $("#tabla_detalle tbody tr");
            if(periodos.length>0){
                var periodo = $("#periodo_id >option:selected").val();
                for(var i=0;i<periodos.length;i++){
                    var tr = periodos[i];
                    var periodo_id = $(tr).find(".periodo_id").val();
                    if(periodo == periodo_id){
                        return true;
                    }
                }
            }
            return false;
        }

        function registrar_detalle(){
            var table = document.getElementById("tabla_detalle");
            var rowCount = table.rows.length;
            var periodo_id = $("#periodo_id >option:selected").val();
            var periodo = $("#periodo_id >option:selected").text();
            periodosSeleccionados.push(periodo_id);
            var fila = "<tr class='font-roboto-11'>"+
                            "<td class='text-center p-1'>"+
                                    rowCount +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<input type='hidden' class='periodo_id' name='periodo_id[]' value='" + periodo_id + "'>" +
                                    periodo +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<span class='badge-with-padding badge badge-danger' onclick='eliminarItem(this, \"" + periodo_id + "\");'>" +
                                      "<i class='fas fa-trash fa-fw'></i>" +
                                 "</span>" +
                            "</td>"
                        "</tr>";

            $("#tabla_detalle").append(fila);
            $('#periodo_id').val('').trigger('change');
            contar_registros();
            $("#periodo_id option[value='" + periodo_id + "']").remove();
        }

        function contar_registros(){
            var table = document.getElementById("tabla_detalle");
            var registros = table.rows.length - 1;
            if(registros === 0){
                $("#btn-proceso").hide();
            }else{
                $("#btn-proceso").show();
            }
        }

        function eliminarItem(element, periodo_id){
            var periodoNombre = $(element).closest('tr').find('td:eq(1)').text().trim();
            $(element).closest('tr').remove();
            periodosSeleccionados = periodosSeleccionados.filter(function(id) {
                return id !== periodo_id;
            });
            $("#periodo_id").append($("<option></option>").attr("value", periodo_id).text(periodoNombre));
            contar_registros();
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('paquetesdisc.store') }}";
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
            window.location.href = "{{ route('paquetes.index') }}";
        }

        function validar_detalle() {
            if ($("#periodo_id >option:selected").val() == "") {
                Modal("El campo <b>[PERIODO]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validar() {
            if ($("#gestion >option:selected").val() == "") {
                Modal("El campo <b>[GESTION]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#numero >option:selected").val() == "") {
                Modal("El campo <b>[NUMERO DE ENTREGA]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#items").val() == "") {
                Modal("El campo <b>[ITEMS]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }
    </script>
@endsection
