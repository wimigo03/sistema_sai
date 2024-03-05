@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <div class="row font-verdana-12">
        <div class="col-md-6 ">
            <b><h5>REGISTRO NIÑO(A)--{{ $nombre_tipo }}--{{ $nombre_albergue }}</h5></b>


        </div>


        <div class="col-md-6 text-right">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar Nuevo Registro">
                <a href="#create" data-toggle="modal">
                    <button class="btn btn-default btn-flat pull-left" type="button">Agregar
                        <i class="fa fa-plus-square" style="font-size:14px"></i>&nbsp;
                    </button>
                </a>
            </span>


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

                                <th>NCODIGO</th>
                                <th>NUREJ</th>
                                <th>CUD</th>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>NACIONALIDAD</th>
                                <th>EDAD</th>
                                <th>SEXO</th>
                                <th>F.INGRESO</th>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sereges as $serege)
                                <tr>
                                    <td WIDTH="10">{{ $serege->ncodigo }}</td>
                                    <td WIDTH="10">{{ $serege->nurej }}</td>
                                    <td WIDTH="10">{{ $serege->cud }}</td>
                                    <td>{{ $serege->nombres }}</td>
                                    <td>{{ $serege->apellidos }}</td>
                                    <td>{{ $serege->nacionalidad }}</td>
                                    <td>{{ $serege->edad }}</td>
                                    <td>{{ $serege->sexo }}</td>
                                    <td>{{ $serege->fingreso }}</td>
                                    <td align="center">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Actualizar Registro">
                                            <a href="#edit{{ $serege->id }}" data-toggle="modal"
                                                class="btn btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                        </span>
                                    </td>
                                    <td align="center">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Historial">
                                            <a  href="{{ route('sereges.foto_index',$serege->id ) }}"
                                                class="btn btn-sm edit btn-flat"><i class='fa fa-id-card'></i></a>
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

    @foreach ($sereges as $serege)
    @include('sereges.registro_edit_delete_create')
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

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

    </script>
@endsection
