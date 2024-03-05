@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
  
    <div class="col-md-12">
    </br>
    <div style="color:black;font-weight: bold;font-size: 16px;">{{$nombrearea}}
        &nbsp;&nbsp;

    
        <a href="{{ route('activo.oficina.create',$idarea) }}" class="btn btn-outline-info btn-sm">Agregar</a>
      
    </div>
    </br>
       
            
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
                               

                               
                           
                                <th>NOMBRES </th>
                        
                                <th>CARGO</th>
                               
                               
                                <th>CI </th>
                                <th>ESTADO</th>
                                
                                <th>OPCIONES</th>
                                
                              
                               
                               
                              


                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $key => $empleado)
                            <tr>

                                <td>

                                   
                                    <a href="{{ route('contrato.editar', $empleado -> idemp)}}"
                                        class="btn btn-outline-info btn-sm">Editar</a>
                                    

                                </td>

                                
                              
                                <td>{{$empleado -> nombres}} {{$empleado -> ap_pat}} {{$empleado -> ap_mat}}</td>
                              
                                <td>{{$empleado -> cargo}}</td>
                               
                                <
                                <td>{{$empleado -> ci}}</td>
                              
                                <td>{{$empleado -> numfile}}</td>
                              

                                <
                                



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