@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">

    <div class="col-md-12">
        </br>
        <div style="color:black;font-weight: bold;font-size: 16px;">{{$nombrearea}}
            &nbsp;&nbsp;

            @can('planta_create_access')
            <a href="{{ route('planta.crear',$idarea) }}" class="btn btn-outline-info btn-sm">Agregar</a>
            @endcan
        </div>
        </br>
        <div class="card">

            <div class="row">
                <a href="{{ url('rechumanos/planta/index') }}" class="btn blue darken-4 text-black "><i
                        class="fa fa-plus-square" style="color:#55CE63;font-weight: bold;"></i> Volver atras</a>
            </div>
            <input type="hidden" value="{{$idarea}}">
            <div class="card-body">
                <div class="table-responsive" >
                    <font size="2" face="Courier New">
                        <table id="example" class="table hoverTable table-bordered" style="width:100%">
                            <thead>
                                <tr style="background-color:#F2F7F8">
                                    <th></th>
                                    <th></th>

                                    <th>File </th>
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
                                    <th>Poai </th>
                                    <th>Exp.Poai </th>
                                    <th>Dec.Jurada </th>
                                    <th>Exp.Decjurada </th>
                                    <th>Rejap </th>
                                    <th>Sippase </th>
                                    <th>Exp.Sippase </th>
                                    <th>Seerv.Milit. </th>
                                    <th>Idioma </th>
                                    <th>Induccion </th>
                                    <th>Exp.Inducc. </th>
                                    <th>Prog.Vacac. </th>
                                    <th>Exp.Prog.Vacac. </th>
                                    <th>Vac.Ganadas </th>
                                    <th>Vac.Pend. </th>
                                    <th>Vac.Usadas </th>
                                    <th>Seg.Salud </th>
                                    <th>Inamov. </th>
                                    <th>A??os Serv. </th>
                                    <th>Curr.Vitae </th>
                                    <th>Telefono </th>
                                    <th>Biometrico </th>
                                    <th>Drado Acad. </th>
                                    <th>Rae </th>
                                    <th>Reg.Prof. </th>
                                    <th>Eval.Desemp. </th>


                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($empleados as $key => $empleado)
                                <tr>

                                    <td>

                                        @can('planta_edit_access')
                                        <a href="{{ route('planta.editar', $empleado -> idemp)}}" style="color:blue;"
                                            class="fas fa-pencil-alt fa-lg" title="Editar Empleado"></a>
                                        @endcan
                                      

                                    </td>
                                    <td>

                                      
                                        @can('planta_edit_access')
                                        <a href="{{ route('planta.editar2', $empleado -> idemp)}}" style="color:orange"
                                            class="fa fa-minus-circle fa-lg" title="Activar-Inactivar Empleado"></a>
                                        @endcan


                                    </td>




                                    <td>{{$empleado -> numfile}}</td>
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
                                    <td>{{$empleado -> poai}}</td>
                                    <td>{{$empleado -> exppoai}}</td>
                                    <td>{{$empleado -> decjurada}}</td>
                                    <td>{{$empleado -> expdecjurada}}</td>
                                    <td>{{$empleado -> rejap}}</td>
                                    <td>{{$empleado -> sippase}}</td>
                                    <td>{{$empleado -> expsippase}}</td>
                                    <td>{{$empleado -> servmilitar}}</td>
                                    <td>{{$empleado -> idioma}}</td>
                                    <td>{{$empleado -> induccion}}</td>
                                    <td>{{$empleado -> expinduccion}}</td>
                                    <td>{{$empleado -> progvacacion}}</td>
                                    <td>{{$empleado -> expprogvacacion}}</td>
                                    <td>{{$empleado -> vacganadas}}</td>
                                    <td>{{$empleado -> vacpendientes}}</td>
                                    <td>{{$empleado -> vacusasdas}}</td>
                                    <td>{{$empleado -> segsalud}}</td>
                                    <td>{{$empleado -> inamovilidad}}</td>
                                    <td>{{$empleado -> aservicios}}</td>
                                    <td>{{$empleado -> cvitae}}</td>
                                    <td>{{$empleado -> telefono}}</td>
                                    <td>{{$empleado -> biometrico}}</td>
                                    <td>{{$empleado -> gradacademico}}</td>
                                    <td>{{$empleado -> rae}}</td>
                                    <td>{{$empleado -> regprofesional}}</td>
                                    <td>{{$empleado -> evdesempenio}}</td>




                                </tr>

                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </font>
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

        //para cambiar el lenguaje a espa??ol
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "??ltimo",
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