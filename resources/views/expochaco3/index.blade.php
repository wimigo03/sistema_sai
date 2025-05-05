@extends('layouts.dashboard')
@section('content')
@include('expochaco3.flash')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <!-- Log on to codeastro.com for more projects! -->
                        <table id="datatable-buttons" class="table display table-bordered responsive font-verdana" style="width:100%">

                            <thead class="thead-dark">
                            <tr>
                                <th data-priority="1">ID</th>
                                <th data-priority="2">Nombre</th>
                                <th data-priority="3">Asociacion</th>
                                <th data-priority="4">Rubro</th>
                                <th data-priority="7">Actions</th>


                            </tr>
                            </thead>
                            <tbody>
                                @foreach( $solicitud as $solicitudes)

                                <tr>
                                    <td>{{$solicitudes->idsolicitud}}</td>
                                    <td>{{$solicitudes->nombresolicitud}}</td>
                                    <td>{{$solicitudes->asociacionsol}}</td>

                                    <td>
                                        @if(isset($solicitudes->schedules->nombrerubro))
                                        {{$solicitudes->schedules->nombrerubro}}
                                        @endif
                                    </td>
                                    <td>

                                        <a href="#edit{{$solicitudes->idsolicitud}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>

                                        <a href="#delete{{$solicitudes->idsolicitud}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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
@foreach( $solicitud as $solicitudes)
@include('expochaco3.edit_delete_employee')
@endforeach
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
                order: [[ 0, "asc" ]]
            });

            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });
    </script>
@endsection



