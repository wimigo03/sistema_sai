<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REPORTES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="row abs-center font-roboto-20">
            <div class="col-md-5 pr-1 pl-1 mb-2">
                <button type="button" class="btn btn-dark btn-block" onclick="BeneficiariosPorFechas();">
                    REPORTE DE BENEFICIARIOS POR FECHAS
                </button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var table = $("#dataTable");
        $(document).ready(function() {

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

        function BeneficiariosPorFechas(){
            window.location.href = "{{ route('reportes.canasta.beneficiarios.entre.fechas') }}";
        }
    </script>
@endsection
