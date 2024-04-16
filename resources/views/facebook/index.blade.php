@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
@if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
@include('facebook.edit_delete_create')
    <div class="row font-verdana-bg">
        <div class="col-md-6 titulo">
            <b >PUBLICACIONES</b>
        </div>
        <div class="col-md-6 text-right">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar Nuevo Registro">
            <a href="#create" data-toggle="modal" >
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
                        >

                        <thead >
                            <tr>

                                <th class="text-center p-1">FECHA</th>
                                <th class="text-center p-1">PUBLICACION</th>
                                 <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facebook as $face)
                                <tr>

                                    <td class="text-center p-1">{{ $face->fecha }}</td>
                                    <td class="text-center p-1">{{ $face->publicacion }}</td>

                                    <td align="center" style="width:3%">
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Compartido">
                                            <a  href="{{ route('facebook.editar',$face->id) }}"
                                                class="btn btn-sm edit btn-flat"><i class="fa-solid fa-arrow-up-right-from-square"></i>
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
