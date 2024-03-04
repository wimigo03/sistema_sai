@extends('layouts.admin')
@section('content')
    <br>
    <div class="row font-verdana-12">
        <div class="col-md-8 titulo">
            <b>RECEPCION VENTANILLA</b>
        </div>
        <div class="col-md-4 text-right titulo">


            
                <a href="{{ route('crear2.recepcion') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Recepcion">
                    <button class="btn btn-sm btn-success font-verdana" type="button">
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>

                <a href="{{ route('recepcion2.remitenteIndex') }}" class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar Persona">
                    <button class="btn btn-sm btn-warning font-verdana" type="button">REMITENTE

                    </button>
                </a>

                <a href="{{ route('recepcion2.unidadIndex') }}" class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar Area">
                    <button class="btn btn-sm btn-info font-verdana" type="button">AREA

                    </button>
                </a>
          





        </div>
        <div class="col-md-12">
            <hr color="red" size="10">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered  hoverTable  responsive  font-verdana" style="width:100%;" id="users-table">
                    <thead>
                        <tr>

                            <td class="text-justify p-1"><b>NOMBRES</b></td>
                            <td class="text-justify p-1"><b>APELLIDOS</b></td>
                            <td class="text-justify p-1"><b>UNIDAD</b></td>
                            <td class="text-justify p-1"><b>ASUNTO</b></td>
                            <td class="text-justify p-1"><b>FECHA</b></td>
                            <td class="text-justify p-1"><b>CODIGO</b></td>

                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>


                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </center>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#users-table').DataTable({
            bFilter: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,


            ajax: "{{ route('recepcion2.index') }}",
            columns: [{
                    data: 'nombres_remitente',
                    name: 're.nombres_remitente',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'apellidos_remitente',
                    name: 're.apellidos_remitente',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'nombre_unidad',
                    name: 'u.nombre_unidad',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'asunto',
                    name: 'r.asunto',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'fecha_recepcion',
                    name: 'r.fecha_recepcion',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'n_oficio',
                    name: 'r.n_oficio',
                    class: 'text-justify p-1 font-verdana'
                },


                {
                    data: 'btn',
                    name: 'btn',
                    class: 'text-center p-1 font-verdana',
                    orderable: false,
                    searchable: false
                }
                ,


                {
                    data: 'btn3',
                    name: 'btn3',
                    class: 'text-center p-1 font-verdana',
                    orderable: false,
                    searchable: false
                }


            ],




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
            }

        });
    </script>
@endsection
