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
                <a href="{{ url('/almacen/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>
        <div class="col-md-10 text-right titulo">
            <b>DETALLE INGRESO</b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>

    </div>
    <div>
        <hr class="hrr">
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>N</b></td>
                            <td class="text-justify p-1"><b>PRODUCTO</b></td>
                            <td class="text-right p-1"><b>INGRESOS</b></td>
                            <td class="text-right p-1"><b>SALIDAS</b></td>
                            <td class="text-right p-1"><b>SALDO</b></td>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @forelse ($prodserv as $key => $prod)
                            <tr>
                                <td class="text-justify p-1">{{ $key + 1 }}</td>
                                <td class="text-justify p-1">{{ $prod->nombreprodserv }}</td>
                                <td class="text-right p-1">{{ $prod->ingresos }}</td>
                                <td class="text-right p-1">{{ $prod->salidas }}</td>
                                <td class="text-right p-1">{{ $prod->saldo }}</td>

                            </tr>
                        @endforeach
                    </tbody>

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
    </script>
@endsection
