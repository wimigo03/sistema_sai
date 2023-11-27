@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-4 titulo">
            <b>Programar Horarios</b>
        </div>


        <div class="col-md-8 text-right">
            <div class="btn-group">
                <input type="month" id="selectedMonth" name="selected_month" class="form-control" value="{{$selectedMonth}}">

            </div>

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>

    </div>
    <div class="col-md-12">

        <hr class="hrr">
    </div>
    <div class="row font-verdana">
        <div class="col-md-12  center">
            <table id="calendar" class="table-responsive">
                <thead>
                    <tr>
                        <th>Semana</th>
                        @for ($i = 0; $i < 7; $i++) <th>{{ now()->startOfWeek()->addDays($i)->formatLocalized('%a') }}</th>
                            @endfor


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
            if (data) {
                let additionalInfo = '';

                // Verificar el tipo de additional_info
                if (Array.isArray(data.additional_info)) {
                    // additional_info es un array
                    additionalInfo = data.additional_info.map(item => createLink(item.id, item.descrip)).join('<br>');
                } else if (typeof data.additional_info === 'object') {
                    // additional_info es un objeto
                    additionalInfo = Object.values(data.additional_info).map(item => createLink(item.id, item.descrip)).join('<br>');
                }
                if (!additionalInfo) {
                    var fecha = data.date;
                    var link = '<a aria-label="Asignar Horario" href="' + " {{ route('asistencia.crear', ['fecha' => ':fecha']) }}".replace(':fecha', fecha) + '"><i class="fa fa-lg fa-plus text-success"></i></a>'; // Devolver el enlace personalizado 
                    return data.day + '<br>' + link;

                }
                return data.day + '<br>' + additionalInfo;
            }
            return null;
        }

        function createLink(id, descrip) {
            // Reemplaza 'nombre-de-ruta' con el nombre real de tu ruta

            let routeUrl = "{{ route('asistencia.edit', ['id' => ':id']) }}";

            // Reemplaza ':id' con el ID correspondiente
            routeUrl = routeUrl.replace(':id', id);

            // Retorna el enlace
            return `<a href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen text-warning"></i></a>`;
        }

        function renderCell2(data, type, row) {
            // Verificar si hay datos y personalizar la visualización
            if (data) {
                let additionalInfo = '';



                return data.day + '<br>' + additionalInfo;
            }
            return null;
        }


    });
</script>


@endsection

@endsection