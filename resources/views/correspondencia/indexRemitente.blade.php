@extends('layouts.dashboard')
@section('content')


    <br>
    <div class="row font-verdana-12">

        <div class="titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/correspondencia/index')}}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>


        <div class="col-md-6 titulo">
            <b>MODULO REMITENTE</b>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="col-md-4 text-right titulo">


                <a href="{{ route('correspondencia.crear.remitente') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Remitente">
                    <button class="btn btn-sm btn-success font-verdana" type="button">
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>



        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>N°</b></td>
                            <td class="text-justify p-1"><b>NOMBRES</b></td>
                            <td class="text-justify p-1"><b>AP/PAT</b></td>
                            <td class="text-justify p-1"><b>AP/MAT</b></td>
                            <td class="text-justify p-1"><b>UNIDAD</b></td>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </center>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(function() {

            var table = $('.yajra-datatable').DataTable({


                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('correspondencia.remitenteIndex') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'nombres',
                        name: 'e.nombres',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ap_pat',
                        name: 'e.ap_pat',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ap_mat',
                        name: 'e.ap_mat',
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'nombre_unidad',
                        name: 'u.nombre_unidad',
                        class: 'text-justify p-1 font-verdana'
                    },





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
                },


            });



        });
    </script>
@endsection
@endsection
