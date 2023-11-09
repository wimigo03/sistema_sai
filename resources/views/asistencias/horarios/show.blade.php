@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo mt-3">
            <b>Empleados Asignados</b>
        </div>

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <b>Horario: {{$horario->Nombre}}</b>

            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-6 table-responsive center">
            <table class="table-bordered display compact yajra-datatable hoverTable table display responsive font-verdana" style="width:100%" class="table text-center" id="registrosTable">
                <thead class="font-verdana">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Accion</th>
                    </tr>
                </thead>
            </table>
        </div>


    </div>

    <div class="row font-verdana">
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <div class="col-md-4 text-left">
            Creado en : {{$horario->created_at}} por {{$horario->usuario_creacion}}
        </div>


        <div class="col-md-8 text-right">
            Modificado por: {{$horario->usuario_modificacion }}
            en {{$horario->updated_at}}
        </div>

    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#registrosTable').DataTable({
            language: {
                info: "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
                search: '',
                searchPlaceholder: "Buscar",
                paginate: {
                    next: "<span class='font-verdana'><b>Siguiente</b></span>",
                    previous: "<span class='font-verdana'><b>Anterior</b></span>",
                },
                lengthMenu: "<span class='font-verdana'>Mostrar </span>" +
                    "<select class='form form-control-sm'>" +
                    "<option value='15'>15</option>" +
                    "<option value='50'>50</option>" +
                    "<option value='100'>100</option>" +
                    "<option value='-1'>Todos</option>" +
                    "</select> <span class='font-verdana'>Registros </span>",
                loadingRecords: "<span class='font-verdana'>...Cargando...</span>",
                processing: "<span class='font-verdana'>...Procesando...</span>",
                emptyTable: "<span class='font-verdana'>No hay datos</span>",
                zeroRecords: "<span class='font-verdana'>No hay resultados para mostrar</span>",
                infoEmpty: "<span class='font-verdana'>Ningun registro encontrado</span>",
                infoFiltered: "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('horarios.show', $horario->id) }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nombres',
                    name: 'nombres'
                },
                {
                    data: 'apellidos',
                    name: 'apellidos'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ]
        });
    });
</script>
@endsection
@endsection