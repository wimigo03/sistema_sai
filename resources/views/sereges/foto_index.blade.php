@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-12">
                <div class="col-md-12">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/sereges/registro_index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>HISTORIAL FOTOGRAFICO</b>{{ $idregistro }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <select onchange="window.location.href=this.options[this.selectedIndex].value;">
                        <option value="#">seleccione una opcion</option>
                        <option value="{{ route('sereges.foto_index', $idregistro) }}">Historial Fotografico</option>
                        <option value="{{ route('sereges.ingreso_index',$idregistro ) }}">Registros de Ingreso</option>
                        <option value="{{ route('sereges.albergue_index') }}">estado de Salud</option>
                        <option value="{{ route('sereges.albergue_index') }}">Estado Emocional</option>
                        <option value="{{ route('sereges.albergue_index') }}">Referencia Familiar</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar Nuevo Registro">
                        <a href="#create" data-toggle="modal">
                            <button class="btn btn-default btn-flat pull-left" type="button">Agregar
                                <i class="fa fa-plus-square" style="font-size:14px"></i>&nbsp;
                            </button>
                        </a>
                    </span>


                </div>



                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>
            <div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Log on to codeastro.com for more projects! -->
                            Niño(a): {{ $registro->nombres }}  {{ $registro->apellidos }}
                            <div >
                                <hr color="red">
                            </div>
                            <table id="datatable-buttons" class="table display table-bordered responsive font-verdana"
                                style="width:100%">

                                <thead>
                                    <tr>

                                        <th>Nombre</th>
                                        <th>ARCHIVO</th>
                                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>



                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($foto as $fotos)
                                        <tr>
                                            <td WIDTH="10">{{ $fotos->detalle }}</td>
                                            <td WIDTH="10">{{ $fotos->ruta }}</td>
                                            <td align="center" WIDTH="10">
                                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Archivo">
                                                    <a href="../fotos/{{ $fotos->ruta }}" target="blank_"><i
                                                            class='fa fa-eye fa-lg'></i></a>
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
    @include('sereges.archivos_edit_delete_create')
    @foreach ($foto as $fotos)
        @include('sereges.archivos_edit_delete_create')
    @endforeach
    </div>
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
