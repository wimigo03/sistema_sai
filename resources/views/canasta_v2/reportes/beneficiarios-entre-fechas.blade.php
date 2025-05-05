<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>HISTORIAL MODIFICACIONES DE BENEFICIARIOS POR FECHAS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form action="#" method="get" id="form">
            <div class="form-group row abs-center">
                <div class="col-md-2 pr-1 pl-1">
                    <input type="text" name="finicial" value="{{ request('finicial') }}" id="finicial" placeholder="--Desde--" class="form-control font-roboto-12 intro" data-language="es">
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <input type="text" name="ffinal" value="{{ request('ffinal') }}" id="ffinal" placeholder="--Hasta--" class="form-control font-roboto-12 intro" data-language="es">
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <select name="estado" id="estado" class="form-control font-roboto-12">
                        <option value="">-</option>
                        @foreach ($estados as $index => $value)
                            <option value="{{ $index }}" @if (request('estado') == $index) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 pl-1">
                    <span class="btn btn-success btn-block font-roboto-12" onclick="excel();">
                        <i class="fas fa-file-excel fa-fw"></i> Exportar
                    </span>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <span class="btn btn-danger btn-block font-roboto-12" onclick="limpiar();">
                        <i class="fas fa-eraser fa-fw"></i> Limpiar
                    </span>
                </div>
                <div class="col-md-8 pr-1 pl-1 text-center">
                    <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var cleave = new Cleave('#finicial', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#finicial").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            var cleave = new Cleave('#ffinal', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#ffinal").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Todos--",
                width: '100%'
            });
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar(){
            window.location.reload();
        }

        /* function excel(){
            var url = "{{ route('reportes.canasta.exportar.beneficiarios.entre.fechas') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        } */

        function excel() {
            var url = "{{ route('reportes.canasta.exportar.beneficiarios.entre.fechas') }}";
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
                    a.download = 'beneficiarios.xlsx';
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

        function limpiar(){
            window.location.href = "{{ route('reportes.canasta.beneficiarios.entre.fechas') }}";
        }
    </script>
@endsection
