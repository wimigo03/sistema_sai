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


        <div class="col-md-4 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ route('expochaco.index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>

        <div class="col-md-4 text-left titulo">
            <b>RUBROS</b>
        </div>
        <div class="col-md-4 text-right titulo">
            <a href="{{ route('expochaco.createrubro') }}" class="tts:left tts-slideIn tts-custom" aria-label="CREAR NUEVO">
                <button class="btn btn-sm btn-success font-verdana" type="button">Agregar
                    &nbsp;<i class="fa-solid fa-thumbs-up" style="font-size:14px"></i>&nbsp;
                </button>
            </a>
        </div>


    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="row">
        <div class="col-md-12">
            <center>
                <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:80%">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>Nro</b></td>
                            <td class="text-justify p-1"><b>NOMBRE RUBRO</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @forelse ($rubros as $key => $rubro)
                            <tr>
                                <td class="text-justify p-1">{{ $key + 1 }}</td>
                                <td class="text-justify p-1">{{ $rubro->nombrerubro }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

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
            if ($("#tipo >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[tipo de archivo]</b> es un dato obligatorio...");
                return false;
            }

            return true;
        }
    </script>
@endsection
