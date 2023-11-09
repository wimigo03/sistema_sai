@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Crear Reporte</b>
        </div>
        <!-- Vista de retorno (por ejemplo, index.blade.php) -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Resto del contenido de la vista -->
        <!-- Vista de retorno (por ejemplo, index.blade.php) -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <!-- Mostrar mensaje de error -->
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
        @endif

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Ver Reportes Guardados" href="{{route('reportes.index')}}">
                <button class="btn btn-sm btn-info font-verdana" type="button">
                    &nbsp;<i class="fas fa-file-alt"></i>&nbsp;Mis Reportes
                </button>
            </a>
        </div>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
   
    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <div class="body-border">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_final">Fecha Final</label>
                            <input type="date" id="fecha_final" name="fecha_final" value="{{ old('fecha_final') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="fecha_final">Opciones</label>
                        <div class="row">
                            <div class="form-group">
                                <button class="btn btn-primary" id="verBtn">Ver</button>
                                <!-- Botón para guardar -->
                                <button class="btn btn-success" id="guardarBtn" disabled>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <table class="table-bordered  hoverTable table display responsive font-verdana" style="width:100%" id="empleados-reportes-table">
                <thead class="font-verdana">
                    <tr class="text-center">
                        <th>Nombres</th>
                        <th>Minutos de Retraso</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        var dataTable = $('#empleados-reportes-table').DataTable({
            processing: false,
            serverSide: false, // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{ route('reportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    d.fecha_inicio = $('#fecha_inicio').val();
                    d.fecha_final = $('#fecha_final').val();
                }
            },
            columns: [{
                    data: "empleado"
                },
                {
                    data: "total_retrasos"
                },
                {
                    data: "observaciones"
                }
            ]
        });

        // Apply filter on button click
        $('#verBtn').on('click', function() {
            // Reload the DataTable with new parameters
            dataTable.ajax.reload();
            $('#guardarBtn').prop('disabled', false);

        });
        $('#guardarBtn').click(function() {
            // Obtener los valores de fecha de inicio y fecha final
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFinal = $('#fecha_final').val();

            // Realizar la solicitud AJAX al servidor
            $.ajax({
                url: "{{ route('reportes.store') }}",
                type: "POST",
                data: {
                    fecha_inicio: fechaInicio,
                    fecha_final: fechaFinal,
                    _token: '{{ csrf_token() }}'
                },

                success: function(data) {
                    if (data.success) {
                        // Muestra el mensaje de éxito en un modal
                        $('#successMessage').text(data.success);
                        $('#successModal').modal('show');

                        // Cierra el modal después de 3 segundos (3000 milisegundos)
                        setTimeout(function() {
                            $('#successModal').modal('hide');
                        }, 1000);
                    } else {
                        // No hay mensaje de éxito, puedes manejarlo de otra manera si es necesario
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Manejar errores si es necesario
                    console.error(errorThrown);
                }
            });
        });

    });
</script>

@endsection
@endsection