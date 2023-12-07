@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Regularizar Marcado de Asistencia por Orden de Servicio</b>
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
            <b>Empleado:</b>  {{$empleado->nombres}} {{$empleado->ap_pat}} {{$empleado->ap_mat}}
        </div>
        </div>
      

    </div>
    <div class="col-md-12">

        <hr class="hrr">
    </div>
    <div class="row font-verdana-sm">
        <div class="col-md-12  center">
            <table id="calendar" class="table-bordered  table display font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <th>Sem.</th>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mier</th>
                        <th>Jue</th>
                        <th>Vie</th>
                        <th>Sab</th>
                        <th>Dom</th>
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
            lengthChange: false,
            searching: false,
            ordering: false,
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
                console.log(data);
                let additionalInfo = '';

                // Verificar el tipo de additional_info
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
                            const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen  text-warning"></i></a>`;


                            // ... tu lógica aquí ...
                             
                            return `${link}<br>${item.observ}`;
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
                            const link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen  text-warning"></i></a>`;


                            // ... tu lógica aquí ...
                            return `${link}`;
                        }

                        // Crear el enlace normal
                        return createLink(item.id, item.descrip, item.estado);
                    }).join('<br>');
                }

                if (!additionalInfo) {
                    var fecha = data.date;
                    var empleado_id = data.empleado_id;

                    let routeUrl = "{{ route('fecha.crear', ['fecha' => ':fecha', 'id' => ':id']) }}";
                    // Reemplaza ':id' y ':otro_parametro' con los valores correspondientes
                    routeUrl = routeUrl.replace(':fecha', fecha).replace(':id', empleado_id);
                    var link = `<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Asistencia" href="${routeUrl}"><i class="fa-solid fa-2xl fa-plus text-primary"></i></a>`;

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
                return `<a class="tts:left tts-slideIn tts-custom" aria-label="Asistencia Registrada" ><i class="fa-solid fa-2xl fa-square-check text-success"></i></a>`;
            } else if (estado === 0) {
                return `<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horario Activo" href="${routeUrl}"><i class="fa-solid fa-2xl fa-square-pen text-warning"></i></a>`;

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


    });
</script>


@endsection

@endsection