@extends('layouts.dashboard')
@section('content')
    <style>
        .font-verdana-12 th {
            background-color: white !important;
            color: black;
        }
    </style>

    <div class="font-verdana-12 row mb-3">
        <div class="titulo col-md-12">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="javascript:void(0);" onclick="window.history.back()">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <b>{{ $activo->descrip }} - {{ $activo->codigo }}</b>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <center>
                <table class="table-bordered hoverTable" id="table-imagenes" style="width:100%;">
                    <thead class="font-courier">
                        <tr>
                            <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>Descripcion</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>Creado por</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>Fecha</b></td>
                            <th class="text-center"><i class="fa fa-bars" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </center>
        </div>
    </div>


    <div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="modalArchivo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_modal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="body-border ">
                        <form method="POST" action="#" enctype="multipart/form-data">
                            <div class="form-group row font-verdana-sm">
                                <input type="hidden" id="id">
                                <input type="hidden" id="activo_id" value="{{ $activo->id }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label style="color:black;font-weight: bold;">DESCRIPCION:</label>
                                        <input type="text" id="descripcion" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label style="color:black;font-weight: bold;">ARCHIVO ADJUNTO:</label>
                                        <input class="form-control" type="file" id="ruta" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="btn-group ml-auto">
                                    <button class="btn btn-primary btn-sm" id="btn_store_imagen" type="submit">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>REGISTRAR
                                    </button>
                                    <button class="btn btn-primary btn-sm" id="btn_update_imagen" type="submit">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>ACTUALIZAR
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-imagenes').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('activo.responsable.imagen.listado', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        class: 'text-justify p-1 font-verdana'
                    },
                ],
                language: {
                    // Configuración del idioma, si es necesario
                },
            });

            var imagenId = null;
            $('#table-imagenes').on('click', '#editar-imagen', function(e) {
                e.preventDefault();
                imagenId = $(this).data('id');
                var descripcion = $(this).data('descripcion');
                var created_at = $(this).data('created_at');
                $("#btn_store_imagen").hide();
                $("#btn_update_imagen").show();
                $('#titulo_modal').text('Actualizar imagen')
                $('#descripcion').val(descripcion);
                $('#modalArchivo').modal('show');
            });
            $('#crear-imagen').on('click', function() {
                $("#btn_store_imagen").show();
                $("#btn_update_imagen").hide();
                $('#titulo_modal').text('Registrar nuevo imagen')
                $('#descripcion').val("");
                $('#modalArchivo').modal('show');
            });

            $('#btn_store_imagen').on('click', function(e) {
                e.preventDefault();
                var activo_id = $('#activo_id').val();
                var descripcion = $('#descripcion').val();
                var rutaInput = $('#ruta')[0];
                var ruta = rutaInput.files[0];

                var formData = new FormData();
                formData.append('activo_id', activo_id);
                formData.append('ruta', ruta);
                formData.append('descripcion', descripcion);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('activo.responsable.imagen.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            var rutaInput = $('#ruta')[0];
                            rutaInput.value = '';
                            $('#table-imagenes').DataTable().ajax.reload();
                            $('#modalArchivo').modal('hide');
                        } else {
                            alert('Error al guardar el imagen adjunto');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $('#btn_update_imagen').on('click', function(e) {
                e.preventDefault();
                var activo_id = $('#activo_id').val();
                var descripcion = $('#descripcion').val();
                var rutaInput = $('#ruta')[0];
                var ruta = rutaInput.files[0];
                var formData = new FormData();
                formData.append('id', imagenId);
                formData.append('activo_id', activo_id);
                formData.append('descripcion', descripcion);
                formData.append('_token', '{{ csrf_token() }}');
                if (ruta) {
                    formData.append('ruta', ruta);
                }
                $.ajax({
                    url: "/Activo/responsable/update/" + imagenId + "/imagen",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            var rutaInput = $('#ruta')[0];
                            rutaInput.value = '';
                            $('#table-imagenes').DataTable().ajax.reload();
                            $('#modalArchivo').modal('hide');
                        } else {
                            alert('Error al actualizar el imagen adjunto');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });


        });
    </script>
@endsection
