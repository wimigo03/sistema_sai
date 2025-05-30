@extends('layouts.dashboard')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <br>
    <div class="row font-verdana-12">

        <div class="col-md-2 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/combustibles/pedidoparcial/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>

        <div class="col-md-10 text-right titulo">
            <b>COMPRA ENVIADA A ALMACEN</b>
        </div>

        <div class="col-md-12">
            <hr class="hrr">
        </div>

        <div class="col-md-12 text-right">


            <input type="hidden" value="{{ $idcompracomb }}" id="idcompracomb">

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>


        </div>

    </div>


    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>Nro</b></td>
                            <td class="text-justify p-1"><b>PRODUCTO</b></td>
                            <td class="text-right p-1"><b>CANTIDAD</b></td>
                            <td class="text-right p-1"><b>PRECIO</b></td>
                            <td class="text-right p-1"><b>SUBTOTAL</b></td>
                            {{-- <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @forelse ($prodserv as $key => $prod)
                            <tr>
                                <td class="text-justify p-1">{{ $key + 1 }}</td>
                                <td class="text-justify p-1">{{ $prod->nombreprodcomb }}</td>
                                <td class="text-right p-1">{{ $prod->cantidad }}</td>
                                <td class="text-right p-1">{{ $prod->precio }}</td>
                                <td class="text-right p-1">{{ $prod->subtotal }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if (count($prodserv) > 0)
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                                <td class="text-right p-1">
                                    <b>TOTAL:</b>
                                </td>

                                <td class="text-right p-1">
                                    <b>{{ $valor_total2 }}</b>
                                </td>

                            </tr>
                        @endif
                    </tfoot>
                </table>
            </center>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                order: [
                    [0, "asc"]
                ]
            });

            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }


        function save() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function validar_formulario() {
            if ($("#producto >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[Producto-Item]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#cantidad").val() == "") {
                message_alert("El campo <b>[Cantidad]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#cantidad").val() <= 0) {
                message_alert("El campo <b>[Cantidad]</b> no puede ser menor que cero...");
                return false;
            }

            return true;
        }

        function valideNumber(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code == 46) || (code >= 48 && code <= 57)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection
