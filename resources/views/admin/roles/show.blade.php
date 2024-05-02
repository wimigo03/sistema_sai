@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLE Y PERMISOS DEL ROL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12">
            <div class="col-md-1 pr-1 pl-1">
                <label for="id" class="d-inline"><b>ID</b></label>
                <input type="text" value="{{ $role->id }}" class="form-control font-roboto-12" id="role_id" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="dea" class="d-inline"><b>DIRECCION ADM.</b></label>
                <input type="text" value="{{ $role->dea != null ? $role->dea->descripcion : '[Error]'}}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="" class="d-inline"><b>TITULO</b></label>
                <input type="text" value="{{ $role->title }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>CODIGO</b></label>
                <input type="text" value="{{ $role->short_code }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>ESTADO</b></label>
                <input type="text" value="{{ $role->status }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 pr-1 pl-1">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Ir atras">
                    <button class="btn btn-primary font-roboto-12" type="button" onclick="cancelar();">
                        <i class="fas fa-angle-double-left fa-fw"></i>
                    </button>
                </span>
            </div>
            <div class="col-md-6 pr-1 pl-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="actualizar();">
                    <i class="fas fa-paper-plane fa-fw"></i>&nbsp;Actualizar permisos
                </button>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
        <div class="form-group row abs-center">
            <div class="col-md-8 pr-1 pl-1 table-responsive">
                <table class="table display table-striped table-bordered responsive hover-orange" id="tablaAjax" style="width:100%;">
                    <thead>
                        <tr class="font-roboto-11">
                            <td class="text-center p-1"><b>ID</b></td>
                            <td class="text-center p-1"><b>TITULO</b></td>
                            <td class="text-center p-1"><b>NOMBRE</b></td>
                            <td class="text-center p-1"><b>DESCRIPCION</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $datos)
                            <tr class="font-roboto-11">
                                <td class="text-center p-1">{{ $datos->permission_id }}</td>
                                <td class="text-center p-1">{{ $datos->title }}</td>
                                <td class="text-left p-1">{{ $datos->permission }}</td>
                                <td class="text-left p-1">{{ $datos->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tablaAjax').DataTable({
                "processing":true,
                "iDisplayLength": 10,
                "order": [[ 0, "asc" ]],
                language: {
                    "decimal": "",
                    "emptyTable": "<span class='font-roboto-12'>No hay información</span>",
                    "info": "<span class='font-roboto-12'>Mostrando _START_ a _END_ de _TOTAL_ Entradas</span>",
                    "infoEmpty": "<span class='font-roboto-12'>Mostrando 0 to 0 of 0 Entradas</span>",
                    "infoFiltered": "<span class='font-roboto-12'>(Filtrado de _MAX_ total entradas)</span>",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "<span class='font-roboto-12'>Mostrar _MENU_ entradas</span>",
                    "loadingRecords": "<span class='font-roboto-12'>Cargando...</span>",
                    "processing": "<span class='font-roboto-12'>Procesando...</span>",
                    "search": "<span class='font-roboto-12'>Buscar:</span>",
                    "zeroRecords": "<span class='font-roboto-12'>Sin resultados encontrados</span>",
                    "paginate": {
                        "first": "<span class='font-roboto-12'>Primero</span>",
                        "last": "<span class='font-roboto-12'>Ultimo</span>",
                        "next": "<span class='font-roboto-12'>Siguiente</span>",
                        "previous": "<span class='font-roboto-12'>Anterior</span>"
                    }
                }
            });
        });

        function cancelar(){
            var url = "{{ route('roles.index') }}";
            window.location.href = url;
        }

        function actualizar(){
            var id = $("#role_id").val();
            var url = "{{ route('roles.edit',':id') }}";
            url = url.replace(':id',id);
            window.open(url, '_blank');
        }
    </script>
@endsection
