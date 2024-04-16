@extends('layouts.admin')

@section('content')
<div class="row ">
    <div class="col-md-12">
        <div class="row font-verdana-sm">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('Activo/formulario/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>
            <div class="col-md-8 text-right titulo">
                <b>REGISTRO NUEVO FORMULARIO FISICO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
                <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
            </div>

        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="body-border ">
            <form method="POST" action="{{ route('activo.formulario.update', $formulario->id) }}">
                @csrf
                <div class="form-group row font-verdana-sm">
                    <div class="col-md-4 form-group">
                        <label class="font-label">FECHA:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input type="date" name="fecha" class="form-control"
                            value="{{ old('fecha', $formulario->fecha) }}">
                        </div>
                        @error('fecha')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-label">CI:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input type="text" id="ci" class="form-control"
                            value="{{ old('ci', $formulario->empleado->ci) }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" onclick="buscarPorCi()"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>

                            @error('ci')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Responsable:</label>
                            <div class="mr-4" id="nombres">{{ $formulario->empleado->full_name }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Cargo:</label>
                            <div id="cargo">{{ $formulario->empleado->file->nombrecargo }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="font-label">Oficina:</label>
                            <div id="oficina">{{ $formulario->empleado->empleadosareas->nombrearea }}</div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn color-icon-2 font-verdana-bg" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            &nbsp;ACTUALIZAR
                        </button>
                    </div>
                </form>
                <div class="row">
                    <div class="cold-md-12">
                        <button type="button" class="btn btn-sm btn-primary font-verdana ml-3" onclick="abrirModal()">
                            &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                    <div class="col-md-12 mt-3">
                        <table class="table-bordered hoverTable" id="table-activos" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <th class="text-center p-1 font-weight-bold"><b>N°</b></th>
                                    <th class="text-center p-1 font-weight-bold"><b>CODIGO</b></th>
                                    <th class="text-center p-1 font-weight-bold"><b>DESCRIPCION</b></th>
                                    <th class="text-center p-1 font-weight-bold"><b>ESTADO</b></th>
                                    <th class="text-center"><i class="fa fa-bars" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('activo.formulario.modal')
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
    var activo_id = null;
    var token = $('meta[name="csrf-token"]').attr('content');
    function buscarPorCodigo(){
        var codigo = $('#codigo').val();
        event.preventDefault();
        $.ajax({
            url: '/Activo/vehiculo/getCodigo',
            method: 'GET',
            data: {
                codigo: codigo
            },
            success: function(res) {
                if (res.response && res.response.codigo) {
                    $('#activo_id').val(res.response.id);
                    activo_id = res.response.id;
                    $('#descripcion').val(res.response.descrip);
                    switch (res.response.codestado) {
                        case 1:
                        $('#estado').val('BUENO');
                        break;
                        case 2:
                        $('#estado').val('REGULAR');
                        break;
                        case 3:
                        $('#estado').val('MALO');
                        break;
                        default:
                        $('#estado').val('');
                        break;
                    }
                } else {
                    $('#descripcion').val("No se ha encontrado ese codigo");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function abrirModal(){
        $("#btn_store_imagen").show();
        $("#btn_update_imagen").hide();
        $('#titulo_modal').text('Agregar activo')
        $('#codigo').val("");
        $('#descripcion').val("");
        $('#estado').val("");
        $('#modalArchivo').modal('show');
    }
    $('#table-activos').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: "{{ route('activo.formulario.activo.listado', $formulario->id) }}",
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            class: 'text-justify p-1 font-verdana'
        },
        {
            data: 'codigo',
            name: 'codigo',
            class: 'text-justify p-1 font-verdana'
        },
        {
            data: 'descrip',
            name: 'descrip',
            class: 'text-justify p-1 font-verdana'
        },
        {
            data: 'estado',
            name: 'estado',
            class: 'text-justify p-1 font-verdana'
        },
        {
            data: 'btn_activos',
            name: 'btn_activos',
            class: 'text-justify p-1 font-verdana'
        },
    ],
    language: {
        // Configuración del idioma, si es necesario
    },
});

var id = null;
var activo_id = null;
$('#table-activos').on('click', '#editar-archivo', function(e) {
    e.preventDefault();
    id = $(this).data('id');
    activo_id = $(this).data('activo_id');
    var descripcion = $(this).data('descripcion');
    var codigo = $(this).data('codigo');
    var estado = $(this).data('estado');
    $("#btn_store_imagen").hide();
    $("#btn_update_imagen").show();
    $('#titulo_modal').text('Actualizar archivo')
    $('#descripcion').val(descripcion);
    $('#codigo').val(codigo);
    $('#estado').val(estado);
    $('#modalArchivo').modal('show');
});
$('#crear-archivo').on('click', function() {
    $("#btn_store_imagen").show();
    $("#btn_update_imagen").hide();
    $('#titulo_modal').text('Registrar nuevo archivo')
    $('#descripcion').val("");
    $('#modalArchivo').modal('show');
});

$('#btn_store_imagen').on('click', function(e) {
    e.preventDefault();
    var activo_id = $('#activo_id').val();
    var formulario_id= "{{ $formulario->id }}"
    var formData = new FormData();
    formData.append('activo_id', activo_id);
    formData.append('formulario_id', formulario_id);
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
        url: "{{ route('activo.formulario.activo.store') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#table-activos').DataTable().ajax.reload();
                $('#modalArchivo').modal('hide');
            } else {
                alert('Error al guardar el imagen adjunto');
            }
        },
        error: function(xhr, status, error) {
            var errorMessage = "";
        if (xhr.status == 422) {
            var errors = JSON.parse(xhr.responseText).errors;
            // Construir el mensaje de error
            for (var key in errors) {
                if (errors.hasOwnProperty(key)) {
                    errorMessage +=  errors[key][0] + "<br>";
                }
            }
        } else {
            errorMessage = "Error: " + xhr.responseText;
        }
        // Mostrar el mensaje de error en el elemento HTML con el id "error_codigo"
        $('#error_codigo').html(errorMessage);
        }
    });
});

$('#btn_update_imagen').on('click', function(e) {
    e.preventDefault();
    var formulario_id = "{{ $formulario->id }}"
    var formData = new FormData();
    formData.append('id', id);
    formData.append('activo_id', activo_id);
    formData.append('formulario_id', formulario_id);
    formData.append('_token', '{{ csrf_token() }}');
    $.ajax({
        url: "/Activo/update/" + id + "/formulario",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#table-activos').DataTable().ajax.reload();
                $('#modalArchivo').modal('hide');
            } else {
                alert('Error al actualizar el imagen adjunto');
            }
        },
        error: function(xhr, status, error) {
            var errorMessage = "";
        if (xhr.status == 422) {
            var errors = JSON.parse(xhr.responseText).errors;
            // Construir el mensaje de error
            for (var key in errors) {
                if (errors.hasOwnProperty(key)) {
                    errorMessage +=  errors[key][0] + "<br>";
                }
            }
        } else {
            errorMessage = "Error: " + xhr.responseText;
        }
        // Mostrar el mensaje de error en el elemento HTML con el id "error_codigo"
        $('#error_codigo').html(errorMessage);
        }
    });
});

$(document).on('click', '.eliminar-activo', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
        url: "/Activo/destroy/" + id + "/formulario",
        type: 'POST',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#table-activos').DataTable().ajax.reload();
                $('#modalArchivo').modal('hide');
            } else {
                alert('Error al eliminar el activo');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});
</script>
@endsection
