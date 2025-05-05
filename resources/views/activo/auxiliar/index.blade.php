@extends('layouts.dashboard')
@section('content')

<div class="row font-verdana-12">

    <div class="col-md-8 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('Activo/codcont/index')}}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
        <b>AUXILIAR</b>
    </div>

    <div class="col-md-4 text-right">

        
        <a href="{{route('activo.auxiliar.create',$id)}} " class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
            <button class="btn btn-sm btn-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>

        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        

    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>
<div class="row font-verdana-sm">
    <div class="col-md-12">
        <center>
            <table class="table-bordered yajra-datatable hoverTable" style="width:100%;">
                <thead class="font-courier">
                    <tr>
                        <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>ENTIDAD</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>UNIDAD</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>CODIGO CONTABLE</b></td>

                        <td class="text-center p-1 font-weight-bold"><b>CODIGO AUXILIAR</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>NOMBRE AUXILIAR</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>observ</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>FECHA ULTIMA</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>usuar</b></td>
                        <td class="text-center p-1 font-weight-bold"><i class="fa fa-bars" aria-hidden="true"></i></td>


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
    $(document).ready(function() {

        $('.yajra-datatable').DataTable({


            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('activo.auxiliar.listado', $id) }}",
            columns: [
                {
                    data: 'codaux',
                    name: 'codaux',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'entidad',
                    name: 'entidad',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'unidad',
                    name: 'unidad',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'codcont',
                    name: 'codcont',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'codaux',
                    name: 'codaux',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },

                {
                    data: 'nomaux',
                    name: 'nomaux',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'observ',
                    name: 'observ',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'feult',
                    name: 'feult',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'usuar',
                    name: 'usuar',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'btn',
                    name: 'btn',
                    orderable: true,
                    searchable: true
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
            },

        });

    });
</script>
@endsection
@endsection