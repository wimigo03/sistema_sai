@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b> Historial Asistencias Regularizados</b>
        </div>
        <div class="col-md-4  text-right">

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>


        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-12">
            <table class="table-bordered table-hover display hover compact font-verdana" id="historial-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Fecha de Cambio</th>
                        <th>Nombres y Apellidos</th>
                        <th>Datos anteriores</th>
                        <th>Usuario</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



@section('scripts')

<script>
    $(document).ready(function() {
        // Mapeo de nombres de claves

        $('#historial-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('historial_asistencia.index') }}",
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
                        var selectedData = {
                            'Fecha de Asistencia': data.fecha,
                            'Marcado Entrada': data.registro_inicio,
                            'Marcado Salida': data.registro_salida,
                            'Marcado Retorno': data.registro_entrada,
                            'Marcado salida': data.registro_final,
                            'Minutos de Retraso': data.minutos_retraso,
                            'Observacion': data.observ,
                            // Agrega más campos según sea necesario
                        };

                        // Muestra cada clave y valor en líneas separadas
                        for (var key in selectedData) {
                            formattedData += '<b>' + key + ':</b> ' + selectedData[key] + '<br>';
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
            ]
        });
    });
</script>

@endsection
@endsection