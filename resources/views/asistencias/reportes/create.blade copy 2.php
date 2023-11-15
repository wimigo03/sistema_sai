@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Crear Reporte</b>
        </div>
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
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Retrasos Personales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Retrasos Por Area</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab3">Retrasos Area</a>
            </li>
        </ul>
    </div>
    <div class="tab-content font-verdana">
        <div class="tab-pane fade show active" id="tab1">
            <div class="body-border ">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="empleado">Nombre de Personal</label>
                            <select name="empleado" id="empleado" aria-label="Seleciona Permiso" class="form-control form-control-sm" required>
                                <option value="">-</option>
                                @foreach ($empleados as $index => $value)
                                <option value="{{ $value->idemp }}" @if(request('empleado')==$value->idemp) selected @endif> {{ $value->nombres }} {{ $value->ap_pat }} {{ $value->ap_mat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_final">Fecha Final</label>
                            <input type="date" id="fecha_final" name="fecha_final" value="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <label for="fecha_final">Opciones</label>
                        <div class="form-group">
                            <div class="">
                                <button class="btn btn-primary" id="verBtn">Ver</button>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 table-responsive center">
                <table class="table-bordered  hoverTable table display responsive" style="width:100%" id="personal-reportes-table">
                    <thead>
                        <tr class="text-center">
                            <th>Nombres</th>
                            <th>Minutos de Retraso</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2">
            <div class="body-border ">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="area">Area de Personal</label>
                            <div id="area-select2" class="col-md-12">

                                <select name="area_id" id="area_id" aria-label="Selecion de Área" required>
                                    <option value=""></option>
                                    @foreach ($data as $index => $value)
                                    <option value="{{ $value->idarea }}"> {{ $value->nombrearea }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_inicio2">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio2" name="fecha_inicio2" value="" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_final2">Fecha Final</label>
                            <input type="date" id="fecha_final2" name="fecha_final2" value="" class="form-control" required>
                        </div>
                    </div>


                    <div class="col-md-2">

                        <label for="fecha_final">Opciones</label>
                        <div class="form-group">
                            <div class="">
                                <button class="btn btn-primary" id="verBtn2">Ver</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 table-responsive center">
                <table class="table-bordered  hoverTable table display responsive" style="width:100%" id="area-personal-reportes-table">
                    <thead>
                        <tr class="text-center">
                            <th>Nombres</th>
                            <th>Minutos de Retraso</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
        <div class="tab-pane fade" id="tab3">

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

        $('#empleado').select2({
            placeholder: "--Seleccionar--"
        });

        var dataTable = $('#personal-reportes-table').DataTable({
            processing: false,
            serverSide: false, // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{ route('personalreportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    d.empleado = $('#empleado').val();
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



        });



    });
</script>
<script>
    $(document).ready(function() {
        var area_select = new SlimSelect({
            select: '#area-select2 select',
            //showSearch: false,
            placeholder: 'Select ',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        });

        var dataTable2 = $('#area-personal-reportes-table').DataTable({
            processing: false,
            serverSide: false, // Changed to false if you're not using server-side processing
            ajax: {
                url: "{{ route('areapersonalreportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    d.area_id = $('#area_id').val();
                    d.fecha_inicio2 = $('#fecha_inicio2').val();
                    d.fecha_final2 = $('#fecha_final2').val();
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

        $('#verBtn2').on('click', function() {
            // Reload the DataTable with new parameters
            dataTable2.ajax.reload();


        });

    });
</script>

@endsection
@endsection