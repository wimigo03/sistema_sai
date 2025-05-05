@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>SOLICITUD DE COMPRA - {{ $compra->dea->descripcion }}</b>
    </div>
    <div class="card-body">
        <input type="hidden" id="compra_id" value="{{ $compra->idcompra }}">
        @include('compras.pedidoparcial.partials.show-header')
        <div class="row font-verdana-12">
            <div class="col-md-12 font-verdana-12 text-center">
                <br>
                <span class="text-dark"><b>DETALLE DE LA COMPRA</b></span>
            </div>
        </div>
        <div class="card card-body bg-light">
            @include('compras.pedidoparcial.partials.show-table')
            <div class="form-group row" id="seccion-especifica">
                <div class="col-md-6">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a Solicitudes" style="cursor: pointer;">
                        <button class="btn btn-outline-secondary font-verdana" type="button" onclick="cancelar();">
                            <i class="fa-solid fa-backward"></i>
                        </button>
                    </span>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
                <div class="col-md-6 text-right" id="btn-registro">
                    @if ($compra->estado == 'PENDIENTE')
                        @can('compras.pedido.parcial.aprobar')
                            <button class="btn btn-outline-success font-verdana" type="button" onclick="procesar();">
                                <i class="fa-solid fa-check"></i>&nbsp;Aprobar
                            </button>
                            <button class="btn btn-outline-danger font-verdana" type="button" onclick="no_procesar();">
                                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Rechazar
                            </button>
                        @endcan
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    @endif
                    @if ($compra->estado == 'APROBADO')
                        @can('orden.compras.create')
                            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar_compra();">
                                <i class="fa-solid fa-cart-shopping"></i>&nbsp;Crear Orden de Compra
                            </button>
                        @endcan
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @if(session('scroll_to'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var element = document.getElementById('{{ session('scroll_to') }}');
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {

        });

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function no_procesar() {
            $('#modal_no_confirmacion').modal({
                keyboard: false
            })
        }

        function procesar_compra() {
            $('#modal_confirmacion_compra').modal({
                keyboard: false
            })
        }

        function confirmar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#compra_id").val();
            var url = "{{ route('compras.pedidoparcial.aprobar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function rechazar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#compra_id").val();
            var url = "{{ route('compras.pedidoparcial.rechazar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function confirmar_compra(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#compra_id").val();
            var url = "{{ route('orden-compras.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('compras.pedidoparcial.index') }}";
        }
    </script>
@endsection
