@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card responsive">
            <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse">
                LISTA GENERAL:  PERSONAL DE PLANTA
            </div>
            <div class="card-body">
                <div class="table-responsive font-verdana-sm">

                    <table id="example" class="table hoverTable table-bordered">
                        <thead>
                            <tr style="background-color:#F2F7F8">

                                <th class="text-justify p-1"><b>Id </th>
                                <th class="text-justify p-1"><b>File </th>
                                <th class="text-justify p-1"><b>AREA </th>
                                <th class="text-justify p-1"><b>Nombres </th>
                                <th class="text-justify p-1"><b>Ap.Paterno </th>
                                <th class="text-justify p-1"><b>Ap.Materno </th>
                                <th class="text-justify p-1"><b>Cargo </th>
                                <th class="text-justify p-1"><b>Nomb.Cargo </th>
                                <th class="text-justify p-1"><b>Hab.Basico </th>
                                <th class="text-justify p-1"><b>Categoria </th>
                                <th class="text-justify p-1"><b>Nivel Adm. </th>
                                <th class="text-justify p-1"><b>Clase </th>
                                <th class="text-justify p-1"><b>Nivelsal </th>
                                <th class="text-justify p-1"><b>F.Ingreso </th>
                                <th class="text-justify p-1"><b>Natalicio </th>
                                <th class="text-justify p-1"><b>Edad </th>
                                <th class="text-justify p-1"><b>Ci </th>
                                <th class="text-justify p-1"><b>Poai </th>
                                <th class="text-justify p-1"><b>Exp.Poai </th>
                                <th class="text-justify p-1"><b>Dec.Jurada </th>
                                <th class="text-justify p-1"><b>Exp.Decjurada </th>
                                <th class="text-justify p-1"><b>Sippase </th>
                                <th class="text-justify p-1"><b>Exp.Sippase </th>
                                <th class="text-justify p-1"><b>Serv.Milit. </th>
                                <th class="text-justify p-1"><b>Idioma </th>
                                <th class="text-justify p-1"><b>Induccion </th>
                                <th class="text-justify p-1"><b>Exp.Inducc. </th>
                                <th class="text-justify p-1"><b>Prog.Vacac. </th>
                                <th class="text-justify p-1"><b>Exp.Prog.Vacac. </th>
                                <th class="text-justify p-1"><b>Vac.Ganadas </th>
                                <th class="text-justify p-1"><b>Vac.Pend. </th>
                                <th class="text-justify p-1"><b>Vac.Usadas </th>
                                <th class="text-justify p-1"><b>Seg.Salud </th>
                                <th class="text-justify p-1"><b>Inamov. </th>
                                <th class="text-justify p-1"><b>Años Serv. </th>
                                <th class="text-justify p-1"><b>Curr.Vitae </th>
                                <th class="text-justify p-1"><b>Telefono </th>
                                <th class="text-justify p-1"><b>Biométrico </th>
                                <th class="text-justify p-1"><b>Drado Acad. </th>
                                <th class="text-justify p-1"><b>Rae </th>
                                <th class="text-justify p-1"><b>Reg.Prof. </th>
                                <th class="text-justify p-1"><b>Eval.Desemp. </th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $key => $empleado)
                            <tr>



                                <td class="text-justify p-1">{{$empleado -> idemp}}</td>
                                <td class="text-justify p-1">{{$empleado -> numfile}}</td>
                                <td class="text-justify p-1">{{$empleado -> nombrearea}}</td>
                                <td class="text-justify p-1">{{$empleado -> nombres}}</td>
                                <td class="text-justify p-1">{{$empleado -> ap_pat}}</td>
                                <td class="text-justify p-1">{{$empleado -> ap_mat}}</td>
                                <td class="text-justify p-1">{{$empleado -> cargo}}</td>
                                <td class="text-justify p-1">{{$empleado -> nombrecargo}}</td>
                                <td class="text-justify p-1">{{$empleado -> habbasico}}</td>
                                <td class="text-justify p-1">{{$empleado -> categoria}}</td>
                                <td class="text-justify p-1">{{$empleado -> niveladm}}</td>
                                <td class="text-justify p-1">{{$empleado -> clase}}</td>
                                <td class="text-justify p-1">{{$empleado -> nivelsal}}</td>
                                <td class="text-justify p-1">{{$empleado -> fechingreso}}</td>
                                <td class="text-justify p-1">{{$empleado -> natalicio}}</td>
                                <td class="text-justify p-1">{{$empleado -> edad}}</td>
                                <td class="text-justify p-1">{{$empleado -> ci}}</td>
                                <td class="text-justify p-1">{{$empleado -> poai}}</td>
                                <td class="text-justify p-1">{{$empleado -> exppoai}}</td>
                                <td class="text-justify p-1">{{$empleado -> decjurada}}</td>
                                <td class="text-justify p-1">{{$empleado -> expdecjurada}}</td>
                                <td class="text-justify p-1">{{$empleado -> sippase}}</td>
                                <td class="text-justify p-1">{{$empleado -> expsippase}}</td>
                                <td class="text-justify p-1">{{$empleado -> servmilitar}}</td>
                                <td class="text-justify p-1">{{$empleado -> idioma}}</td>
                                <td class="text-justify p-1">{{$empleado -> induccion}}</td>
                                <td class="text-justify p-1">{{$empleado -> expinduccion}}</td>
                                <td class="text-justify p-1">{{$empleado -> progvacacion}}</td>
                                <td class="text-justify p-1">{{$empleado -> expprogvacacion}}</td>
                                <td class="text-justify p-1">{{$empleado -> vacganadas}}</td>
                                <td class="text-justify p-1">{{$empleado -> vacpendientes}}</td>
                                <td class="text-justify p-1">{{$empleado -> vacusasdas}}</td>
                                <td class="text-justify p-1">{{$empleado -> segsalud}}</td>
                                <td class="text-justify p-1">{{$empleado -> inamovilidad}}</td>
                                <td class="text-justify p-1">{{$empleado -> aservicios}}</td>
                                <td class="text-justify p-1">{{$empleado -> cvitae}}</td>
                                <td class="text-justify p-1">{{$empleado -> telefono}}</td>
                                <td class="text-justify p-1">{{$empleado -> biometrico}}</td>
                                <td class="text-justify p-1">{{$empleado -> gradacademico}}</td>
                                <td class="text-justify p-1">{{$empleado -> rae}}</td>
                                <td class="text-justify p-1">{{$empleado -> regprofesional}}</td>
                                <td class="text-justify p-1">{{$empleado -> evdesempenio}}</td>




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
            dom: '<"top"Bf>lrtip',
            buttons: [{
                extend: 'collection',
                text: 'Información',
                className: 'custom-html-collection btn btn-sm btn-info',
                buttons: [
                    '<h2>Ver Información</h2>', {
                        extend: 'colvisGroup',
                        text: 'Inf Personal',
                        show: [3, 4, 5, 14, 15, 16, 36],
                        hide: [0, 1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 37, 38, 39, 40, 41],
                        // Aplica solo a las columnas después de la primera
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Laboral',
                        show: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                        hide: [0, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41],
                        columns: ':gt(0)'

                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Adicional',
                        show: [3, 4, 5, 27, 28, 29, 30, 31, 34, 41],
                        hide: [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 36, 32, 33, 35, 36, 37, 38, 39, 40],
                        columns: ':gt(0)' // Aplica solo a las columnas después de la primera
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Adicional',
                        show: [3, 4, 5, 17, 18, 19, 20, 21, 22, 23, 24, 26, 32, 33, 35, 37, 38, 39, 40],
                        hide: [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 25, 27, 28, 29, 30, 31, 34, 36, 41],
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


                    },

                ]
            }, {
                extend: 'spacer',
                style: 'bar',
            }, ],


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
                "sProcessing": "Procesando..."
            }

            //para cambiar el lenguaje a español

        })
        $('#example').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
        $('ul.pagination').addClass('pagination-sm');

    });
</script>

@endsection
@endsection