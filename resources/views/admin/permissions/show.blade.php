@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLE PERMISO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-center font-roboto-20 text-danger">
                {{ $permission->title . ' - ' . $permission->name }}
            </div>
        </div>
        <div class="form-group row abs-center">
            <div class="col-md-4 pr-1 pl-1">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Ir atras">
                    <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="limpiar();">
                        <i class="fas fa-angle-double-left fa-fw"></i>
                    </button>
                </span>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                {{--@can('permissions.create')
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Crear">
                        <button class="btn btn-outline-success font-roboto-12" type="button" onclick="create();">
                            <i class="fa fa-plus"></i>
                        </button>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </span>
                @endcan--}}
            </div>
            <div class="col-md-4 pr-1 pl-1 text-right">
                {{--<button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                    <i class="fa fa-search" aria-hidden="true"></i> Buscar
                </button>--}}
                {{--<button class="btn btn-outline-danger font-roboto-12" type="button" onclick="limpiar();">
                    <i class="fa fa-eraser"></i> Limpiar
                </button>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>--}}
            </div>
        </div>
        <div class="form-group row abs-center">
            <div class="col-md-6 pr-1 pl-1 table-responsive">
                <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
                    <thead>
                        <tr class="font-verdana-11">
                            <td class="text-center p-1"><b>ROLE_ID</b></td>
                            <td class="text-center p-1"><b>ROLE_PERMISO</b></td>
                            <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles_permissions as $datos)
                            <tr class="font-verdana-11">
                                <td class="text-center p-1">{{ $datos->role_id }}</td>
                                <td class="text-center p-1">{{ $datos->title }}</td>
                                <td class="text-center p-1">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                        <a href="{{ route('permissions.delete',['role_id' => $datos->role_id, 'permission_id' => $datos->permission_id]) }}" class="badge-with-padding badge badge-danger">
                                            <i class="fa-solid fa-trash fa-fw"></i>
                                        </a>
                                    </span>
                                </td>
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
        $(document).ready( function () {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        /*function create(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('permissions.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function procesar(){
            var url = "{{ route('permissions.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }*/

        function limpiar(){
            var url = "{{ route('permissions.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
