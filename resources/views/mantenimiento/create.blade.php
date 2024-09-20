@extends('layouts.admin')
@section('content')
    <div class="form-group row font-roboto-16">
        <div class="col-md-12 text-center">
            <strong>REGISTRAR MANTENIMIENTO</strong>
        </div>
    </div>
    @include('mantenimiento.partials.form')
@endsection
@section('scripts')
    <script>
        $("#btn-proceso").hide();
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function cancelar(){
            window.location.href = "{{ route('mantenimientos.index') }}";
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            var url = "{{ route('mantenimientos.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function insertar(){
            if(!validar_detalle()){
                return false;
            }
            insertar_detalle();
        }

        function validar_detalle() {
            if ($("#codigo_serie").val() == "") {
                Modal("<b>[ERROR. CODIGO/SERIE]</b>");
                return false;
            }
            if ($("#clasificacion >option:selected").val() == "") {
                Modal("<b>[ERROR. CLASIFICACION]</b>");
                return false;
            }
            if ($("#problema").val() == "") {
                Modal("<b>[ERROR. PROBLEMA]</b>");
                return false;
            }
            return true;
        }

        function insertar_detalle(){
            var table = document.getElementById("tabla_detalle");
            var rowCount = table.rows.length;
            var codigo_serie = $("#codigo_serie").val();
            var clasificacion_id = $("#clasificacion >option:selected").val();
            var clasificacion = $("#clasificacion >option:selected").text();
            var problema = $("#problema").val();
            var fila = "<tr class='font-roboto-11'>"+
                            "<td class='text-justify p-1'>"+
                                    rowCount +
                            "</td>"+
                            "<td class='text-justify p-1'>"+
                                "<input type='hidden' name='codigo_serie[]' value='" + codigo_serie + "'>" +
                                    codigo_serie +
                            "</td>"+
                            "<td class='text-justify p-1'>"+
                                "<input type='hidden' name='clasificacion[]' value='" + clasificacion_id + "'>" +
                                    clasificacion +
                            "</td>"+
                            "<td class='text-justify p-1'>"+
                                "<input type='hidden' name='problema[]' value='" + problema + "'>" +
                                    problema +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<span class='badge-with-padding badge badge-danger' onclick='eliminarItem(this);'>" +
                                      "<i class='fas fa-trash fa-fw'></i>" +
                                 "</span>" +
                            "</td>"
                        "</tr>";

            $("#tabla_detalle").append(fila);
            //document.getElementById("tfoot").style.display = "table-footer-group";
            document.getElementById('codigo_serie').value = '';
            $('#clasificacion').val('').trigger('change');
            document.getElementById('problema').value = '';
            contar_registros();
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

        function eliminarItem(thiss){
            var tr = $(thiss).parents("tr:eq(0)");
            tr.remove();
            contar_registros();
        }

        function validar() {
            if ($("#area_id >option:selected").val() == "") {
                Modal("<b>[ERROR. LA PROCEDENCIA ES UN CAMPO OBLIGATORIO]</b>");
                return false;
            }
            if ($("#empleado_id >option:selected").val() == "") {
                Modal("<b>[ERROR. EL CAMPO FUNCIONARIO ES OBLIGATORIO]</b>");
                return false;
            }
            if ($("#nro_comunicacion_interna").val() == "") {
                Modal("<b>[ERROR. LA COMUNICACION INTERNA ES CAMPO OBLIGATORIO]</b>");
                return false;
            }
            return true;
        }
    </script>
@endsection
