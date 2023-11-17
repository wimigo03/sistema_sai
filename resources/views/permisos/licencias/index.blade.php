@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Registro de Licencias Cargo RIP</b>
        </div>
        <div class="col-md-4 text-right">
            <div class="btn-group">
                <input type="month" name="fecha" id="fecha" class="form-control" value="{{ $añoActual }}" readonly>
                <input type="hidden" id="licencia" value="{{ $licencia->id }}">

            </div>
        </div>
        <div class="col-md-12">
            <!-- Dentro de tu vista -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
            @endif

            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-12">
            <table class="display compact hoverTable" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Días Disponibles</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>


@section('scripts')
<script id="details-template" type="text/x-handlebars-template">
    @verbatim
        <table class="display compact hoverTable" id="licencias-{{idemp}}" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha de Solicitud</th>
                        <th>Asunto</th>
                        <th>Días Utilizados</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
        </table>
    @endverbatim
</script>


<script>
    var template = Handlebars.compile($("#details-template").html());
    var licenciaInput = document.getElementById('licencia');
    $('#fecha').on('change', function() {
        var id = $(this).val();

        // Realizar una petición AJAX para obtener los empleados de la oficina seleccionada
        $.ajax({
            url: "{{ route('licenciaspersonales.getID') }}",
            type: 'GET',
            data: {
                fecha: id
            },
            success: function(data) {
                var licencia = data.id;
                // Limpiar el selector de empleados y agregar las nuevas opciones
                var licenciaInput = document.getElementById('licencia');
                licenciaInput.value = licencia;
                table.ajax.url("{{ route('licenciasempleados.get') }}?licencia_id=" + licencia).load();

                //$.each(cargo, function(index, cargo) {
                //});
            }
        });
    });

    var selectedLicenciaId = $('#licencia').val();
    $('#licencia').on('change', function() {
      selectedLicenciaId = $(this).val(); // Actualiza el valor del permiso seleccionado
        // Actualiza la URL de la solicitud AJAX con el nuevo permiso seleccionado
        table.ajax.url("{{ route('licenciasempleados.get') }}?licencia_id=" + selectedLicenciaId).load();
    });


    var table = $('#customers-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
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
        ajax: "{{ route('licenciasempleados.get') }}?licencia_id=" + selectedLicenciaId, // URL inicial

        columns: [{
                "className": 'details-control',
                "orderable": false,
                "searchable": false,
                "data": null,
                "defaultContent": ''
            },
            {
                data: 'nombres',
                name: 'nombres',
                class: 'text-justify p-1 font-verdana-sm'
            },
            {
                data: 'ap_pat',
                name: 'ap_pat',
                class: 'text-justify p-1 font-verdana-sm'
            },
            {
                data: 'total_dias_disponibles',
                name: 'total_dias_disponibles',
                class: 'text-justify p-1 font-verdana-sm'
            },
            {
                data: 'btn2',
                name: 'btn2',
                orderable: true,
                searchable: false,
                class: 'text-center p-1 font-verdana-sm'
            }
        ]
    });

    $('#customers-table').on('draw.dt', function() {
        $('ul.pagination').addClass('pagination-sm');
    }).DataTable();

    $('#customers-table tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'licencias-' + row.data().idemp;
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, row.data());
            console.log(row.data());
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
    });

    function initTable(tableId, data) {
        $('#' + tableId).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            lengthChange: false,
            searching: false, // Oculta la barra de búsqueda
            paging: false, // Desactiva la paginación
        
            ajax: data.details_url,
            columns: [{
                    data: 'fecha_solicitud',
                    name: 'fecha_solicitud'
                }
                ,
                {
                  
                    data: 'asunto',
                    name: 'asunto'
                },
                {
                  
                    data: 'dias_utilizados',
                    name: 'dias_utilizados'
                }
                ,
                {
                    
                    data: 'opciones',
                    name: 'opciones'
                }
            ]
        });
    };
</script>
@endsection
@endsection