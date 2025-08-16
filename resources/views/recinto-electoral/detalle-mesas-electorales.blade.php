<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .div_detalle, .div_cabecera {
        padding: 15px;
        border-radius: 8px;
        background-color: #f1f1f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .div_cabecera {
        margin-bottom: 20px;
    }

    .div_detalle {
        margin-top: 20px;
    }
</style>
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Detalle Mesas Electorales</li>
@endsection
@section('content')
    <div id="loadingOverlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
        <div style="background-color: white; padding: 20px; border-radius: 8px; text-align: center;">
            <p>Por favor, espere mientras se cargan los datos...</p>
            <div class="spinner"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="title-size">DETALLE MESAS ELECTORALES</b>
            </div>
        </div>

        <div class="card-body">
            <div class="div_detalle mb-4">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <a href="{{ route('recintos.show.mesas.electorales', $mesaElectoral->recinto_id) }}" class="btn btn-outline-secondary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold">
                                <i class="fas fa-random fa-fw"></i> Cambiar de Mesa
                            </a>

                            <a href="{{ route('recintos.index') }}" class="btn btn-outline-secondary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold">
                                <i class="fas fa-exchange-alt fa-fw"></i> Cambiar de Reciento Electoral
                            </a>
                        </div>
                        <div class="text-center mt-3">
                            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                </div>

                <div class="row abs-center">
                    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
                        <h4><b>{{ $mesaElectoral->recinto->nombre }}</b></h4>
                    </div>
                </div>
                <div class="row abs-center">
                    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
                        <h3><b>MESA N° {{ $mesaElectoral->numero }}</b></h3>
                    </div>
                </div>
                <div class="row mb-3 abs-center">
                    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
                        <h7><b>AREA {{ $mesaElectoral->recinto->zone }}</b></h7>
                    </div>
                </div>
                <div class="row mb-3 abs-center">
                    <div class="col-12 col-md-6 col-lg-3" style="display: flex;" id="custom-search">
                        <input type="search" id="_detalle_tabla_filter" class="form-control font-roboto-14 border-dark" placeholder="Buscar" aria-controls="detalle_tabla">
                    </div>
                </div>
                <div class="row mb-3 abs-center">
                    <div class="col-12 table-responsive">
                        <table id="detalle_tabla" class="table table-striped table-hover display responsive hover-orange">
                            <thead class="bg-dark text-white">
                                <tr class="font-roboto-13">
                                    @if (Auth::user()->id == 102)
                                        <th class="text-center p-2 text-nowrap">
                                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                                        </th>
                                        <th class="text-center p-2 text-nowrap"><b>&nbsp;&nbsp;COD.&nbsp;&nbsp;</b></th>
                                    @endif
                                    <th class="text-center p-2 text-nowrap"><b>&nbsp;&nbsp;ESTADO&nbsp;&nbsp;</b></th>
                                    <th class="text-center p-2 text-nowrap"><b>&nbsp;&nbsp;ENTIDAD&nbsp;&nbsp;</b></th>
                                    <th class="text-center p-2 text-nowrap"><b>&nbsp;&nbsp;SIGLA&nbsp;&nbsp;</b></th>
                                    <th class="text-center p-2 text-nowrap"><b>&nbsp;&nbsp;CARGO&nbsp;&nbsp;</b></th>
                                    <th class="text-center p-2 text-nowrap"><b>&nbsp;&nbsp;CONTEO&nbsp;&nbsp;</b></th>
                                    @can(['recintos.index'])
                                        <th class="text-center p-2 text-nowrap">
                                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                                        </th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalleMesasElectorales as $datos)
                                    <tr class="font-roboto-14">
                                        @if (Auth::user()->id == 102)
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">
                                            @if ($datos->estado == 1)
                                                <a href="{{ route('recintos.mesas.detalle.deshabilitar',$datos->id) }}" class="btn btn-outline-danger">
                                                    <i class="fas fa-ban fa-fw"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('recintos.mesas.detalle.habilitar',$datos->id) }}" class="btn btn-outline-success">
                                                    <i class="fas fa-check fa-fw"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">{{ $datos->id }}</td>
                                        @endif
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">
                                            <span class="{{ $datos->colorStatus }}">
                                                {{ $datos->status }}
                                            </span>
                                        </td>
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">{{ $datos->partido->nombre }}</td>
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">{{ $datos->partido->alias }}</td>
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">{{ $datos->tipo_votacion->nombre }}</td>
                                        <td class="text-right p-2 text-nowrap" width='100px'>
                                            <input
                                                type='text'
                                                value="{{ ($datos->cantidad == 0) ? '' : $datos->cantidad }}"
                                                placeholder='0'
                                                data-id="{{ $datos->id }}"
                                                class='form-control font-roboto-14 text-right input-cantidad {{ ($datos->cantidad == 0 || $datos->cantidad == null) ? 'is-invalid' : '' }}'
                                                @if($datos->estado == 2) readonly @endif
                                            >
                                        </td>
                                        <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">
                                            <div class="d-flex justify-content-center">
                                                @can('recintos.index')
                                                    <button class="btn btn-outline-primary btn-guardar-fila mr-2" type="button" data-id="{{ $datos->id }}">
                                                        <i class="fas fa-cloud-upload-alt fa-fw"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.card').find('input, select, textarea, button').prop('disabled', true);

                var table = $('#detalle_tabla').DataTable({
                    "responsive": false,
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "_MENU_",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sSearch": "",
                        "sSearchPlaceholder": "Buscar",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sPrevious": "Anterior",
                            "sNext": "Siguiente",
                            "sLast": "Último"
                        }
                    },
                    "paging": false,
                    "dom": '<"top">rt<"bottom"p><"clear">',
                    "pageLength": 10000,
                    "lengthChange": false,
                    "order": [[1, 'asc']],
                    "initComplete": function() {
                        $(".dataTables_info").addClass("font-roboto-13");
                        $(".dataTables_length").find("label").addClass("font-roboto-13");
                        $(".dataTables_filter").find("label").addClass("font-roboto-13");
                        $(".dataTables_paginate").find("a").addClass("font-roboto-13");

                        $('#loadingOverlay').hide();
                        $('.card').find('input, select, textarea, button').prop('disabled', false);
                    }
                });

                $('#custom-search input').on('input', function() {
                    table.search(this.value).draw();
                });

                $('#estado').select2({
                    theme: "bootstrap4",
                    placeholder: "--Estado--",
                    width: '100%'
                });

                $(".input-cantidad").each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'none',
                        numeralDecimalScale: 0,
                    });
                });
            });

            /*document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                if (event.target && event.target.classList.contains('input-cantidad')) {
                    const idRegistro = event.target.getAttribute('data-id');
                    const valorCantidad = event.target.value;

                    updateRegistroCantidad(idRegistro, valorCantidad);
                }
            }, true);*/

            document.getElementById('detalle_tabla').addEventListener('keyup', function(event) {
                // Verificamos si la tecla presionada es "Enter" (código 13)
                if (event.key === 'Enter' || event.keyCode === 13) {
                    // Nos aseguramos de que el evento provenga de un input de cantidad
                    if (event.target && event.target.classList.contains('input-cantidad')) {
                        const idRegistro = event.target.getAttribute('data-id');
                        const valorCantidad = event.target.value;
                        // Llamamos a la función para actualizar el registro
                        updateRegistroCantidad(idRegistro, valorCantidad);
                        // Opcional: Para evitar que el formulario se envíe si está dentro de uno
                        event.preventDefault();
                    }
                }
            });

            // Agrega este nuevo código para manejar el evento clic en el botón de guardar.
            document.getElementById('detalle_tabla').addEventListener('click', function(event) {
                // Verificamos si el clic se hizo en un botón que contenga la clase 'btn-guardar-fila'.
                if (event.target && event.target.closest('.btn-guardar-fila')) {
                    // Encontramos el botón y su atributo 'data-id'.
                    const btnGuardar = event.target.closest('.btn-guardar-fila');
                    const idRegistro = btnGuardar.getAttribute('data-id');

                    // Encontramos el 'input' de la misma fila para obtener el valor.
                    // Usamos 'closest("tr")' para subir a la fila, y luego 'querySelector' para encontrar el input.
                    const fila = btnGuardar.closest('tr');
                    const inputCantidad = fila.querySelector('.input-cantidad');
                    const valorCantidad = inputCantidad.value;

                    // Llamamos a la función de guardado con el id y el valor correctos.
                    updateRegistroCantidad(idRegistro, valorCantidad);
                }
            });

            function updateRegistroCantidad(idRegistro, valorCantidad) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('recintos.update.registro.cantidad') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            id: idRegistro,
                            cantidad: valorCantidad,
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    // window.location.href = "{{ route('recintos.index') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Ocurrió un error inesperado.',
                                });
                            }
                            resolve(response);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de Conexión',
                                text: 'No se pudo contactar al servidor. Intenta de nuevo.'
                            });
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                if (event.target && (event.target.classList.contains('input-cantidad'))) {
                    const valor = event.target.value;
                    if (valor === '0' || valor === 0 || valor === '') {
                        event.target.classList.add('is-invalid');
                    } else {
                        event.target.classList.remove('is-invalid');
                    }
                }
            }, true);
        </script>
    @endsection
@endsection
