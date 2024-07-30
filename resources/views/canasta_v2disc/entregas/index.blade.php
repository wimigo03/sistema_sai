<!DOCTYPE html>
@extends('layouts.admin')
<style>
    #modal-alert {
        z-index: 1080;
    }

    #entregaModal {
        z-index: 1060;
    }
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BENEFICIARIOS REGISTRADOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>
                    <u>
                        {{ $paquete_barrio->paquete->numero }} ENTREGA
                        /
                        {{ $paquete_barrio->periodos }} ({{ $paquete_barrio->paquete->gestion }})
                        /
                        {{ $paquete_barrio->distrito->nombre }}
                        -
                        {{ $paquete_barrio->barrio->nombre }}
                    </u>
                </b>
            </div>
        </div>
        @include('canasta_v2.entregas.partials.search')
        @include('canasta_v2.entregas.partials.table')
        @include('canasta_v2.entregas.partials.modal-resagado')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#extension').select2({
                theme: "bootstrap4",
                placeholder: "--Extension--",
                width: '100%'
            });

            $('#sexo').select2({
                theme: "bootstrap4",
                placeholder: "--Sexo--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_nac', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_nac").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $('#entregaModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var entregaId = button.data('entrega-id');
                var beneficiario = button.data('beneficiario');
                var modal = $(this);
                modal.find('#modalEntregaId').val(entregaId);
                modal.find('#modalBeneficiario').text(beneficiario);
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        $('.intro_entrega').on('keypress', function(event) {
            if (event.which === 13) {
                procesar_entrega();
                event.preventDefault();
            }
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function search() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.search', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function ir_atras() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.index', ':id') }}";
            url = url.replace(':id', paquete_id);
            window.location.href = url;
        }

        function limpiar() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.index', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }

        function create() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.create', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }

        function habilitar_todo() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.habilitar.todo', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }

        function deshabilitar_todo() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.deshabilitar.todo', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }

        function pdf_get_boletas_entrega() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.get.boletas.entrega', ':id') }}"+"?"+$('#form').serialize();
            url = url.replace(':id', paquete_barrio_id);
            window.open(url,"_blank")
        }

        function pdf_habilitados_sin_registro() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.pdf.habilitados.sin.registro', ':id') }}"+"?"+$('#form').serialize();
            url = url.replace(':id', paquete_barrio_id);
            window.open(url,"_blank")
        }

        function pdf_habilitados_con_registro() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.pdf.habilitados.con.registro', ':id') }}"+"?"+$('#form').serialize();
            url = url.replace(':id', paquete_barrio_id);
            window.open(url,"_blank")
        }

        function excel() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.excel', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var form = $("#form");
            var formData = form.serialize();
            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = 'entregas.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                },
                error: function(xhr, status, error) {
                    alert('Hubo un error al exportar el archivo: ' + xhr.responseText);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                }
            });
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function procesar_entrega() {
            if(!validar_entrega()){
                return false;
            }
            confirmar_entrega();
        }

        function confirmar_entrega(){
            var url = "{{ route('entregas.habilitar') }}";
            $("#form-resagado").attr('action', url);
            $("#form-resagado").submit();
        }

        function validar_entrega() {
            if ($("#observacion").val() == "") {
                Modal("[El campo observaciones es obligatorio]");
                return false;
            }
            return true;
        }

        function confirmar(){
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.finalizar', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }

        function restablecer(){
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.restablecer', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }
    </script>
@endsection
