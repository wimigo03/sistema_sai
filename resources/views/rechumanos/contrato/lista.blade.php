@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
  
    <div class="col-md-12">
    </br>
    <div style="color:black;font-weight: bold;font-size: 16px;">{{$nombrearea}}
        &nbsp;&nbsp;

        <a href="{{ route('contrato.crear',$idarea) }}" class="btn btn-outline-info btn-sm">Agregar</a>
    </div>
    </br>
        <div class="card">
            
            <div class="row">
                <a href="{{ url('rechumanos/planta/index') }}" class="btn blue darken-4 text-black "><i
                        class="fa fa-plus-square" style="color:#55CE63;font-weight: bold;"></i> Volver atras</a>
            </div>
            <input type="hidden" value="{{$idarea}}">
            <div class="card-body">
                <div class="table-responsive">
                <font size="2" face="Courier New" >
                    <table id="example" class="table hoverTable table-bordered" style="width:100%">
                        <thead>
                            <tr style="background-color:#F2F7F8">
                                <th>Opciones</th>

                               
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
                                
                                <th>Sippase </th>
                                <th>Exp.Sippase </th>
                                <th>Seerv.Milit. </th>
                                <th>Idioma </th>
                                
                                <th>Curr.Vitae </th>
                                <th>Telefono </th>
                                <th>Biometrico </th>
                                <th>Drado Acad. </th>

                                <th>Total.Presup.</th>
                                <th>Fecha.Fin.</th>
                                <th>N.Contrato</th>
                                <th>N.Preventivo</th>
                                <th>Prog.Proy.</th>
                                <th>Rejap</th>
                                <th>Ap.Afp.</th>
                                <th>C.Banco</th>
                                <th>File-Actual</th>
                                <th>Nit</th>
                                <th>Sigep</th>
                               
                              


                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $key => $empleado)
                            <tr>

                                <td>

                                    <a href="{{ route('contrato.editar', $empleado -> idemp)}}"
                                        class="btn btn-outline-info btn-sm">Editar</a>

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
                                
                                <td>{{$empleado -> sippase}}</td>
                                <td>{{$empleado -> expsippase}}</td>
                                <td>{{$empleado -> servmilitar}}</td>
                                <td>{{$empleado -> idioma}}</td>
                               
                                <td>{{$empleado -> cvitae}}</td>
                                <td>{{$empleado -> telefono}}</td>
                                <td>{{$empleado -> biometrico}}</td>
                                <td>{{$empleado -> gradacademico}}</td>

                                <td>{{$empleado -> totalpresupuesto}}</td>
                                <td>{{$empleado -> fechafinal}}</td>
                                <td>{{$empleado -> ncontrato}}</td>
                                <td>{{$empleado -> npreventivo}}</td>
                                <td>{{$empleado -> progproy}}</td>
                                <td>{{$empleado -> rejap}}</td>
                                <td>{{$empleado -> aportesafp}}</td>
                                <td>{{$empleado -> cuentabanco}}</td>
                                <td>{{$empleado -> filecontrato}}</td>
                                <td>{{$empleado -> nit}}</td>
                                <td>{{$empleado -> sigep}}</td>
                                



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