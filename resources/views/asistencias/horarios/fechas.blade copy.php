@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-4 titulo">
            <a href="{{ route('horarios.index') }}" class="color-icon-1">
                <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
            </a>
            Programar Horarios


        </div>

        <div class="col-md-8 text-right">
            MES :
            <div class="btn-group">
                <input type="month" id="selectedMonth" name="selected_month" class="form-control" value="{{$vistaselectedMonth}}">

            </div>

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>




        <div class="col-md-12">
            <hr class="hrr">
            @if(Session::has('pendiente'))
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('pendiente') }}
            </div>
            <hr>

            @endif

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            <hr>

            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('error') }}
            </div>
            <hr>

            @endif
        </div>



    </div>

    <div class="row font-verdana">
        <div class="col-md-6  center">
            <table id="calendar" class="table-bordered  font-verdana" style="width:45%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mier</th>
                        <th>Jue</th>
                        <th>Vier</th>
                        <th>S</th>
                        <th>D</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-md-6  center">
            <div id="infoHorario" class="alert alert-info mt-3" style="display: none;">
                <!-- Contenido de la información del horario -->
            </div>

        </div>


    </div>

    <div class="row font-verdana">
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <div class="col-md-4 text-left">
        </div>


        <div class="col-md-8 text-right">
        </div>

    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        var dataTable;
        dataTable = $('#calendar').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            searching: false,
            paging: false, // Deshabilita la paginación
            info: false, // Deshabilita la información
            ajax: {
                url: "{{ route('horarios.fechas') }}",
                data: function(d) {
                    // Enviar la fecha seleccionada al servidor
                    d.selected_month = $('#selectedMonth').val();
                }
            },
            columns: [{
                    data: 0,
                    name: 'Semana',

                    render: function(data, type, row) {
                        // Personaliza la visualización de la celda aquí
                        return '<strong>' + data + '</strong>';
                    }
                },
                {
                    data: 1,
                    name: 'Día 1',
                    render: renderCell

                },
                {
                    data: 2,
                    name: 'Día 2',
                    render: renderCell

                },
                {
                    data: 3,
                    name: 'Día 3',
                    render: renderCell

                },
                {
                    data: 4,
                    name: 'Día 4',
                    render: renderCell

                },
                {
                    data: 5,
                    name: 'Día 5',
                    render: renderCell

                },
                {
                    data: 6,
                    name: 'Día 6',
                    render: renderCell2

                },
                {
                    data: 7,
                    name: 'Día 7',
                    render: renderCell2

                },
            ],
        });

        // Manejar el cambio de mes
        $('#selectedMonth').change(function() {
            // Actualizar la tabla cuando cambie la fecha
            dataTable.ajax.reload();
        });
        // Función para personalizar la visualización de la celda
        function renderCell(data, type, row) {
            // Verificar si hay datos y personalizar la visualización
            if (data.actual) {
                let additionalInfo = '';
                var hora = data.horario;

                // Verificar el tipo de additional_info
                if (Array.isArray(data.additional_info)) {

                    // additional_info es un array
                    additionalInfo = data.additional_info.map(item => createLink(item.id, item.descrip, item.estado)).join('<br>');
                } else if (typeof data.additional_info === 'object') {


                    // additional_info es un objeto
                    additionalInfo = Object.values(data.additional_info).map(item => createLink(item.id, item.descrip, item.estado)).join('<br>');
                }
                if (!additionalInfo) {
                    var fecha = data.date;
                    var link = '<a aria-label="Programar Horario" href="' + " {{ route('asistencia.crear', ['fecha' => ':fecha']) }}".replace(':fecha', fecha) + '"><i class="fa fa-lg fa-plus text-success"></i></a>'; // Devolver el enlace personalizado 
                    return data.day + '<br>' + link + '<br>Sin Horario</br>';

                }
                return data.day + '<br>' + additionalInfo + '<br>';
            }
            return null;
        }

        function createLink(id, descrip, estado) {
            // Reemplaza 'nombre-de-ruta' con el nombre real de tu ruta

            let routeUrl = "{{ route('asistencia.edit', ['id' => ':id']) }}";

            // Reemplaza ':id' con el ID correspondiente
            routeUrl = routeUrl.replace(':id', id);

            // Retorna el enlace
            if (estado === 1) {
                return `<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horario Programado" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen text-warning"></i></a>`;
            } else if (estado === 0) {
                return `<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horario Activo" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen text-success"></i></a>`;

            }
        }

        function renderCell2(data, type, row) {
            // Verificar si hay datos y personalizar la visualización
            if (data.actual) {
                let additionalInfo = '';
                return data.day + '<br>' + additionalInfo;
            }
            return null;
        }
        $('#calendar').on('click', 'td', function() {
            // Obtener la información de la celda
            var cellData = dataTable.cell(this).data();

            // Verificar si hay información de horario
            if (cellData && cellData.actual) {
                // Mostrar la información del horario al lado de la tabla
                mostrarInformacionHorario(cellData);
            }
        });


    });


    function mostrarInformacionHorario(cellData) {
        // Aquí debes implementar la lógica para mostrar la información del horario al lado de la tabla
        // Puedes usar jQuery para manipular el DOM y agregar contenido al elemento deseado.
        // Por ejemplo, podrías agregar contenido a un div con un ID específico.

        // Supongamos que tienes un div con ID 'infoHorario' para mostrar la información del horario
        var infoHorarioDiv = $('#infoHorario');

        // Limpia el contenido anterior
        infoHorarioDiv.empty();

        // Agrega la información del horario al div
        infoHorarioDiv.append('<b>Información del Horario:</b><br>');
        infoHorarioDiv.append('<b>Fecha:</b> ' + cellData.date + '<br>');

        // Verifica si hay datos de horario y accede a ellos
        if (cellData.horario) {
            // Itera sobre los datos de horario y agrega la información al div
            cellData.horario.forEach(function(horario) {
                if (horario.tipo === 1) {
                    infoHorarioDiv.append('<b>________________ </b> <br>');

                    infoHorarioDiv.append('<b>Horario: </b> ' + horario.Nombre + '<br>');

                    infoHorarioDiv.append('<b>Mañana:</b><br>' + horario.hora_inicio + '');
                    infoHorarioDiv.append('-' + horario.hora_salida + '<br>');
                    infoHorarioDiv.append('<b>Tarde:</b><br>' + horario.hora_entrada + '');
                    infoHorarioDiv.append('-' + horario.hora_final + '<br>');

                } else {
                    infoHorarioDiv.append('<b>________________ </b> <br>');
                    infoHorarioDiv.append('<b>Horario: </b> ' + horario.Nombre + '<br>');

                    infoHorarioDiv.append('<b>Hora Entrada: </b> ' + horario.hora_inicio + '<br>');
                    infoHorarioDiv.append('<b>Hora Salida: </b> ' + horario.hora_final);
                }

                // Agrega más campos según sea necesario
            });
        } else {
            // Si no hay datos de horario
            infoHorarioDiv.append('<p>No hay información de horario disponible.</p>');
        }

        // Muestra el div (puedes ajustar esto según tus necesidades de diseño)
        infoHorarioDiv.show();
    }
</script>


@endsection

@endsection