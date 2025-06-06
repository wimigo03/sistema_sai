@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('categoria.programatica.index') }}"> Categoria Programaticas</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Listado de Partidas Presupuestarias</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-bars-staggered fa-fw"></i>&nbsp;<b class="title-size">PARTIDAS PRESUPUESTARIAS VINCULADAS : {{ $categoria_programatica->codigo . '-' . $categoria_programatica->nombre }}</b>
            </div>
        </div>

        <div class="card-body">
            <form action="#" method="post" id="form">
            @csrf
                <input type="hidden" name="categoria_programatica_id" value="{{ $categoria_programatica->id }}">
                <div class="row mb-2">
                    <div class="col-12 col-md-6 col-lg-7 mb-2">
                        <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control font-roboto-14">
                            <option value="">-</option>
                            @foreach ($partidas_presupuestarias as $index => $value)
                                <option value="{{ $index }}" @if(old('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 mb-2">
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <button class="btn btn-primary w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0" type="button" onclick="procesar();">
                                <i class="fas fa-paper-plane fa-fw"></i> Agregar
                            </button>
                            <button class="btn btn-danger w-100 w-md-auto btn-size" type="button" onclick="cancelar();">
                                <i class="fas fa-times fa-fw"></i> Ir a Categorias Programaticas
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row mb-3">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-hover display responsive hover-orange" id="dataTable">
                        <thead class="bg-dark text-white">
                            <tr class="font-roboto-14">
                                <td class="text-center p-2 text-nowrap"><b>CODIGO</b></td>
                                <td class="text-center p-2 text-nowrap"><b>PARTIDA PRESUPUESTARIA</b></td>
                                <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                                @can('categoria.programatica.create')
                                    <td class="text-center p-2 text-nowrap">
                                        <b><i class="fa-solid fa-bars fa.fw"></i></b>
                                    </td>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias_presupuestarias as $datos)
                                <tr class="font-roboto-14">
                                    <td class="text-center p-2 text-nowrap">{{ $datos->partida_presupuestaria->codigo . ' - ' . $datos->partida_presupuestaria->numeracion }}</td>
                                    <td class="text-justify p-2 text-nowrap">{{ $datos->partida_presupuestaria->nombre }}</td>
                                    <td class="text-center p-2 text-nowrap">
                                        <span class="{{ $datos->colorStatus }}">
                                            {{ $datos->status }}
                                        </span>
                                    </td>
                                    @can('categoria.programatica.create')
                                        <td class="text-center p-2 text-nowrap">
                                            <div class="d-flex justify-content-center gap-1">
                                                @if($datos->status == "HABILITADO")
                                                    <a href="{{ route('categoria.programatica.show.deshabilitar',$datos->id) }}" class="btn btn-sm btn-danger mr-1">
                                                        <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('categoria.programatica.show.habilitar',$datos->id) }}" class="btn btn-sm btn-success mr-1">
                                                        <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#partida_presupuestaria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar Partida Presupuestaria--",
                width: '100%'
            });

            $('#dataTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    searchPlaceholder: "Buscar"
                },
                order: [
                    [0, "asc"]
                ]
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            var url = "{{ route('categoria.programatica.show.procesar') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function validar() {
            if($("#partida_presupuestaria_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Partida Presupuestaria es un dato obligatorio.");
                return false;
            }
            return true;
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('categoria.programatica.index') }}";
            window.location.href = url;
        }
    </script>
@stop
