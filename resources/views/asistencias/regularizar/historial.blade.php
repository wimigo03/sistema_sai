@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Historial Asistencias Regularizados</b>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('retrasos.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Horario">
                <button class="btn btn-sm btn-primary font-verdana" type="button">
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
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
                        <th>Datos anteriores</th>

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
                    data: 'datos_anteriores',
                    name: 'datos_anteriores',
                    render: function(data, type, row) {
                        var formattedData = '';

                        // Selecciona y renombra los datos que deseas mostrar
                        var selectedData = {
                            'Fecha de Asistencia': data.created_at,
                            'Empleado ID': data.empleado_id,
                            'Hora de Marcado Entrada': data.registro_inicio,
                            'Minutos de Retraso': data.minutos_retraso,
                            // Agrega más campos según sea necesario
                        };

                        // Muestra cada clave y valor en líneas separadas
                        for (var key in selectedData) {
                            formattedData += '<b>' + key + ':</b> ' + selectedData[key] + '<br>';
                        }

                        return formattedData;

                    }
                }
            ]
        });
    });
</script>

@endsection
@endsection