<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BENEFICIARIOS</b>
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
                    </u>
                </b>
            </div>
        </div>
        @include('canasta_v2.paquetes.partials.beneficiarios-search')
        @include('canasta_v2.paquetes.partials.beneficiarios-table')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#distrito_id').select2({
                theme: "bootstrap4",
                placeholder: "--Distrito--",
                width: '100%'
            });

            $('#barrio_id').select2({
                theme: "bootstrap4",
                placeholder: "--Barrio--",
                width: '100%'
            });

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
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
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
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.beneficiarios.search', ':id') }}";
            url = url.replace(':id', paquete_id);
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function ir_atras() {
            var url = "{{ route('paquetes.index') }}";
            window.location.href = url;
        }

        function limpiar() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.beneficiarios', ':id') }}";
            url = url.replace(':id', paquete_id);
            window.location.href = url;
        }

        function pdf() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.beneficiarios.pdf', ':id') }}"+"?"+$('#form').serialize();
            url = url.replace(':id', paquete_id);
            window.open(url,"_blank")
        }

        function excel() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.beneficiarios.excel', ':id') }}";
            url = url.replace(':id', paquete_id);
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
                    a.download = 'paquetes_beneficiarios.xlsx';
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
    </script>
@endsection
