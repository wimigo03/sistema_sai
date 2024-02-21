@extends('layouts.admin')

@section('content')

<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
            <a href="{{route('empleadoasistencias.index')}}" class="color-icon-1">
                <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
            </a>

        </span>
        <b>Regularizar Marcado de Asistencia</b>
    </div>
    <div class="col-md-4 text-right">
        <div class="btn-group">
            <input type="hidden" id="id" name="id" class="form-control" value="{{$empleado->idemp}}">
            <input type="month" id="selectedMonth" name="selected_month" class="form-control" value="{{$vistaselectedMonth}}">
        </div>
        <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
            <button class="btn btn-sm btn-danger font-verdana" type="button">
                &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
            </button>
        </a>

    </div>

    <div class="col-md-12">
        <hr>
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
    <div class="col-md-8  text-left">
        <div class="btn-group">
            <b>Nombres y Apellidos :</b> {{$empleado->nombres}} {{$empleado->ap_pat}} {{$empleado->ap_mat}}
        </div>
    </div>


</div>
<div class="col-md-12">

    <hr class="hrr">
</div>
<div class="row font-verdana-sm">
    <div class="col-md-6">
        <table id="calendar" class="table-bordered  table display font-verdana-sm" style="width:70%">
            <thead>
                <tr>
                    <th>S°</th>
                    <th>Lun</th>
                    <th>Mar</th>
                    <th>Mier</th>
                    <th>Jue</th>
                    <th>Vie</th>
                    <th>Sa</th>
                    <th>Do</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-6">
        <row class="row font-verdana-sm">
            <div class="col-md-12 titulo">
                <b>Historial de Cambios</b>
            </div>
        </row>
        <div class="row font-verdana-sm">
            <div class="col-md-12">
                <table class="table-responsive table-hover responsive display hover compact font-verdana-sm" id="historial-table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Regularizado</th>
                            <th>Nombres <br>Apellidos</th>
                            <th>Datos anteriores</th>
                            <th>Usuario</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                </table>
            </div>
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


@section('scripts')
<script>
    $(document).ready(function() {
        var dataTable;
        var dataTable2;
        dataTable = $('#calendar').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            searching: false,
            ordering: false,
            paging: false, // Deshabilita la paginación
            info: false,
            ajax: {
                url: "{{ route('regularizarCrear') }}",
                data: function(d) {
                    // Enviar la fecha seleccionada al servidor
                    d.selected_month = $('#selectedMonth').val();
                    d.id = $('#id').val();
                }
            },
            columns: [{
                    data: 0,
                    name: 'Semana',
                    visible: false, // Oculta la columna 0

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
            dataTable2.ajax.reload();

        });
        // Función para personalizar la visualización de la celda
        function renderCell(data, type, row) {
            // Verificar si hay datos y personalizar la visualización
            if (data.actual) {
                console.log(data);
                let additionalInfo = '';

                // Verificar el tipo de additional_info
                if (Array.isArray(data.additional_info)) {
                    // additional_info es un array
                    additionalInfo = data.additional_info.map(item => {
                        // Verificar si la fecha actual es igual a la fecha en additional_info
                        const isFechaIgual = data.date === item.fecha;

                        // Hacer algo si las fechas son iguales
                        if (isFechaIgual) {

                            let routeUrl = "{{ route('regularizar.ausencia', ['id' => ':id']) }}";
                            // Reemplaza ':id' y ':otro_parametro' con los valores correspondientes
                            routeUrl = routeUrl.replace(':id', item.id);
                            const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar  2 Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen  text-warning"></i></a>`;
                            // ... tu lógica aquí ...
                            if (item.estado === 1) {

                                const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Asistencia  2 Registrada" ><i class="fa-solid fa-2xl fa-square-check text-success"></i></a>`;

                                return `${link}<br>Registrado<br>`;
                            } else if (item.estado === 0) {
                                const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar  2 Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen  text-danger"></i></a>`;
                                return `${link}<br>Falta`;

                            }
                            return `${link}<br>Pendiente`;
                        }
                        // Crear el enlace normal
                        return createLink(item.id, item.descrip, item.estado);
                    }).join('<br>');
                } else if (typeof data.additional_info === 'object') {
                    // additional_info es un objeto
                    additionalInfo = Object.values(data.additional_info).map(item => {
                        // Verificar si la fecha actual es igual a la fecha en additional_info
                        const estadoDiferenteDeUno = item.estado !== 1;
                        // Hacer algo si el estado es diferente de 1
                        if (estadoDiferenteDeUno) {
                            let routeUrl = "{{ route('regularizar.ausencia', ['id' => ':id']) }}";
                            // Reemplaza ':id' y ':otro_parametro' con los valores correspondientes
                            routeUrl = routeUrl.replace(':id', item.id);
                            const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar 2 Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen  text-warning"></i></a>`;
                            // ... tu lógica aquí ...
                            if (item.estado === 0) {
                                const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar 0 Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen  text-danger"></i></a>`;
                                return `${link}<br>Falta`;

                            }
                            return `${link}<br>Pendiente`;
                        }
                        // Crear el enlace normal
                        return createLink(item.id, item.observ, item.estado);
                    }).join('<br>');
                }

                if (!additionalInfo) {
                    var fecha = data.date;
                    var empleado_id = data.empleado_id;
                    let routeUrl = "{{ route('fecha.crear', ['fecha' => ':fecha', 'id' => ':id']) }}";
                    // Reemplaza ':id' y ':otro_parametro' con los valores correspondientes
                    routeUrl = routeUrl.replace(':fecha', fecha).replace(':id', empleado_id);
                    var link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar 22 Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-plus text-primary"></i></a>`;
                    return data.day + '<br>' + link;
                }
                return data.day + '<br>' + additionalInfo;
            }
            return null;
        }

        function createLink(id, descrip, estado) {
            // Reemplaza 'nombre-de-ruta' con el nombre real de tu ruta

            let routeUrl = "{{ route('regularizar.ausencia', ['id' => ':id']) }}";

            // Reemplaza ':id' con el ID correspondiente
            routeUrl = routeUrl.replace(':id', id);

            // Retorna el enlace
            if (estado === 1) {
                const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Asistencia Completa" ><i class="fa-solid fa-2xl fa-square-check text-success"></i></a>`;
                return `${link}<br>Registrado<br>`;
            } else if (estado === 0) {
                return `<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horario Activo" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen text-danger"></i></a>`;
            }
        }

        function renderCell2(data, type, row) {
            // Verificar si hay datos y personalizar la visualización
            if (data.actual) {
                let additionalInfo = '';
                // Si necesitas agregar información adicional, puedes hacerlo aquí

                return '<span class="text-danger">' + data.day + '</span>' + '<br>' + additionalInfo;
            }

            return null;
        }

        dataTable2 = $('#historial-table').DataTable({
            lengthChange: false,
            processing: true,
            serverSide: true,
            pageLength: 1,
            info: false,

            ajax: {
                url: "{{ route('personalHistorial') }}",
                data: function(d) {
                    // Enviar la fecha seleccionada al servidor
                    d.selected_month = $('#selectedMonth').val();
                    d.id = $('#id').val();
                }
            },
            columns: [{
                    data: 'created_at_formatted',
                    name: 'created_at',

                },
                {
                    data: 'nombre_empleado',
                    name: 'nombre_empleado',

                },
                {
                    data: 'datos_anteriores',
                    name: 'datos_anteriores',
                    render: function(data, type, row) {
                        var formattedData = '';

                        // Selecciona y renombra los datos que deseas mostrar
                        if (data.tipo === 0) {
                            selectedData = {
                                'Fecha': data.fecha,
                                'Entrada': data.registro_inicio,
                                'Salida': data.registro_final,
                                'Total (min)': data.minutos_retraso,
                                // 'tipo': data.tipo,
                                'Observacion': data.observ,
                                // 'estado': data.estado,

                                // Agrega más campos según sea necesario
                            };
                        } else {
                            selectedData = {
                                'Fecha': data.fecha,
                                'Entrada': data.registro_inicio,
                                'Salida': data.registro_salida,
                                'Retrasos': data.retraso1,
                                'Retorno': data.registro_entrada,
                                'Salida': data.registro_final,
                                'Retraso': data.retraso2,
                                'Total (min)': data.minutos_retraso,
                                //   'tipo': data.tipo,
                                'Observacion': data.observ,
                                //'estado': data.estado,
                                // Agrega más campos según sea necesario
                            };
                        }

                        // Muestra cada clave y valor en líneas separadas
                        for (var key in selectedData) {
                            var value = selectedData[key];

                            // Verifica si el valor es nulo o vacío y muestra un guion en su lugar
                            value = (value === null || value === '') ? '-' : value;

                            formattedData += '<b>' + key + ':</b> ' + value + '<br>';

                        }

                        return formattedData;

                    }
                },
                {
                    data: 'usuario_mod',
                    name: 'usuario_mod',

                },
                {
                    data: 'boton_html',
                    name: 'boton_html',
                    orderable: false,
                    searchable: false,

                }
            ], // cambiar lenguaje a español
            order: [
                [0, 'desc'] // Ordenar por la primera columna ('created_at') de manera ascendente
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });

    });
</script>


@endsection

@endsection