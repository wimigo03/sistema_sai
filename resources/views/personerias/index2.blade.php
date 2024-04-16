@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <div class="row font-verdana-12">
        <div class="col-md-6 titulo">
            <b>P.J. ANTIGUAS (SI.RE.PE.JU.)</b>
        </div>
        <div class="col-md-6 text-right">




            <a href="{{ route('personerias.index') }}" class="tts:left tts-slideIn tts-custom"
                aria-label="Personerias Actualizadas">
                <button class="btn btn-default btn-flat pull-left" type="button">Volver
                    <i class="fa fa-backward" style="font-size:14px"></i>&nbsp;
                </button>
            </a>




            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>


        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Log on to codeastro.com for more projects! -->
                    <table id="datatable-buttons" class="table display table-bordered responsive font-verdana"
                        style="width:100%">

                        <thead>
                            <tr>

                                <th>RESOLUCION</th>
                                <th>SOLICITANTE</th>
                                <th>OBSERVACION</th>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personerias as $personeria)
                                <tr>

                                    <td>{{ $personeria->resoladmin }}</td>
                                    <td>{{ $personeria->solicitante }}</td>
                                    <td>{{ $personeria->observacion }}</td>

                                    <td align="center">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Actualizar Registro">
                                            <a href="#edit{{ $personeria->idpersoneria }}" data-toggle="modal"
                                                class="btn btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                        </span>
                                    </td>
                                    <td align="center">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar Registro">
                                            <a href="#delete{{ $personeria->idpersoneria }}" data-toggle="modal"
                                                class="btn  btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                        </span>
                                    </td>
                                    <td align="center">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Archivo">
                                            <a href="../{{ $personeria->schedules->nombrearchivo }}" target="blank_"><i
                                                    class='fa fa-eye fa-lg'></i></a>
                                        </span>
                                    </td>
                                    <td align="center">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Actualizar Nueva Personeria">
                                            <a href="#edit2{{ $personeria->idpersoneria }}" data-toggle="modal"
                                                class="btn btn-sm edit btn-flat"><i class='fa fa-wrench'></i></a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Log on to codeastro.com for more projects! -->
    </div>
    </div> <!-- end col -->
    </div> <!-- end row -->

    @foreach ($personerias as $personeria)
        @include('personerias.edit_delete_create')
    @endforeach
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable-buttons').DataTable({
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
