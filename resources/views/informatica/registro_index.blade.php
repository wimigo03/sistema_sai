@extends('layouts.dashboard')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <div class="row font-verdana-12">
        <div class="col-md-6 ">
            <b><h5>INFORMES TECNICOS</h5></b>


        </div>


        <div class="col-md-6 text-right">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar Nuevo Registro">
                <a  data-toggle="modal">
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

                                <th>N° Inf.</th>
                                <th>REFERENCIA</th>
                                <th>GLOSA</th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($informe as $informes)
                                <tr>
                                    <td WIDTH="5">{{ $informes->numero }}</td>
                                    <td WIDTH="10">{{ $informes->referencia }}</td>
                                    <td WIDTH="20">{{ $informes->glosa }}</td>

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

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

    </script>
@endsection
