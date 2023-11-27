@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse">
                LISTA GENERAL EMPLEADOS CONTRATO
            </div>
            <div class="card-body">
                <div class="table-responsive font-verdana-sm">

                    <table id="example" class="table hoverTable table-bordered" style="width:100%">
                        <thead>
                            <tr style="background-color:#F2F7F8">

                                <th>Id </th>
                                <th>File </th>
                                <th>AREA </th>
                                <th>Nombres </th>
                                <th>Ap.Paterno </th>
                                <th>Ap.Materno </th>
                                <th>Cargo </th>
                                <th>Nomb.Cargo </th>
                                <th>Hab.Basico </th>
                                <th>Categoria </th>
                                <th>Nivel Adm. </th>
                                <th>Clase </th>
                                <th>Nivelsal </th>
                                <th>F.Ingreso </th>
                                <th>Natalicio </th>
                                <th>Edad </th>
                                <th>Ci </th>
                                <th>Sippase </th>
                                <th>Exp.Sippase </th>
                                <th>Seerv.Milit. </th>
                                <th>Idioma </th>
                                <th>Curr.Vitae </th>
                                <th>Telefono </th>
                                <th>Biometrico </th>
                                <th>Drado Acad. </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $key => $empleado)
                            <tr>



                                <td>{{$empleado -> idemp}}</td>

                                <td>{{$empleado -> numfile}}</td>
                                <td>{{$empleado -> nombrearea}}</td>
                                <td>{{$empleado -> nombres}}</td>
                                <td>{{$empleado -> ap_pat}}</td>
                                <td>{{$empleado -> ap_mat}}</td>

                                <td>{{$empleado -> cargo}}</td>
                                <td>{{$empleado -> nombrecargo}}</td>
                                <td>{{$empleado -> habbasico}}</td>
                                <td>{{$empleado -> categoria}}</td>
                                <td>{{$empleado -> niveladm}}</td>

                                <td>{{$empleado -> clase}}</td>
                                <td>{{$empleado -> nivelsal}}</td>
                                <td>{{$empleado -> fechingreso}}</td>

                                <td>{{$empleado -> natalicio}}</td>
                                <td>{{$empleado -> edad}}</td>
                                <td>{{$empleado -> ci}}</td>

                                <td>{{$empleado -> sippase}}</td>
                                <td>{{$empleado -> expsippase}}</td>
                                <td>{{$empleado -> servmilitar}}</td>
                                <td>{{$empleado -> idioma}}</td>

                                <td>{{$empleado -> cvitae}}</td>
                                <td>{{$empleado -> telefono}}</td>
                                <td>{{$empleado -> biometrico}}</td>
                                <td>{{$empleado -> gradacademico}}</td>





                            </tr>

                            @empty
                            <tr>
                                <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>




<!-- datatables JS -->
@section('scripts')


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "dom": '<"top"Bf>lrtip',
            buttons: [{
                extend: 'collection',
                text: 'Información',
                className: 'custom-html-collection btn btn-sm btn-info',
                buttons: [
                    '<h2>Ver Información</h2>', {
                        extend: 'colvisGroup',
                        text: 'Inf Personal',
                        show: [3, 4, 5, 14, 15, 16, 22],
                        hide: [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 17, 18, 19, 20, 21, 23, 24],
                        columns: ':gt(0)' // Aplica solo a las columnas después de la primera
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Laboral',
                        show: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        hide: [14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                        columns: ':gt(0)'

                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Adicional',
                        show: [3, 4, 5, 17, 18, 19, 20, 21, 23, 24],
                        hide: [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 22],
                        columns: ':gt(0)' // Aplica solo a las columnas después de la primera
                    },

                    '<h2 class="not-top-heading">Personalizar Vista</h2>',
                    {
                        extend: 'colvisGroup',
                        text: 'Mostrar todo',
                        show: ':hidden'
                    },
                    {
                        extend: 'colvis',
                        text: 'Vista de Columnas',
                        collectionLayout: 'fixed columns',
                        collectionTitle: 'Control de visibilidad de columnas',

                    }
                ]
            }, {
                extend: 'spacer',
                style: 'bar',
            }, ],

            //para cambiar el lenguaje a español
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Procesando...",
            }
        });
    });
</script>

@endsection
@endsection