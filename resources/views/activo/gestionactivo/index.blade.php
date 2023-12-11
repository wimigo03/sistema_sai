@extends('layouts.admin')
@section('styles')
    <style>
        .btn-bottom {
            position: fixed !important;
            bottom: 0 !important;
        }

        #modalFilter .modal-dialog {
            position: fixed;
            margin: auto;
            width: 320px;
            height: 100%;
            right: 0px;
        }

        #modalFilter .modal.fade.in .modal-dialog {
            right: 0;
        }

        #modalFilter .modal-content {
            min-height: 100vh !important;
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        #modalFilter.modal.fade .modal-dialog {
            animation: slideInLeft 0.5s forwards;
        }

        .modal-dialog .modal-dialog-scrollable {
            height: 100%;
        }

        .font-verdana-bg th {
            background-color: white !important;
            color: black;
        }

        .encabezadoCodigoBarras {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #000;
            padding: 5px;
        }

        .descripcionStyle {
            color: #000 !important;
            font-size: 16px;
            font-weight: 400;
            border: 2px solid #000;
            padding: 5px;
        }
    </style>
@endsection
@section('content')


    @include('activo.gestionactivo._filter')
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>LISTA DE ACTIVOS</b>
        </div>
        <div class="col-md-4 text-right">
          {{-- <a href="#" class="tts:left tts-slideIn tts-custom" aria-label="Filtrar activos" data-toggle="modal"
                data-target="#modalFilter">
                <button class="btn btn-sm btn-info font-verdana" type="button">
                    &nbsp;<i class="fa-solid fa-lg fa-sliders" aria-hidden="true"></i>&nbsp;
                </button>
            </a>  --}}
            @can('actual_create')
                <a href="{{ route('activo.gestionactivo.create') }}" class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar">
                    <button class="btn btn-sm btn-primary font-verdana" type="button">
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
            @endcan
        </div>

        <div class="col-md-12">
            <hr class="hrr">
            <b>UNIDAD: </b>{{ $unidad->descrip }}
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana-sm">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table-bordered hoverTable" id="table-activos" style="width:100%;">
                    <thead>
                        <tr class="font-verdana-bg">
                            <th class="text-center p-1 font-weight-bold bg-info"><b>N°</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>CODIGO</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>DESCRIPCION</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>GRUPO CONTABLE</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>AUXILIAR</b></th>
                           
                            <th class="text-center p-1 font-weight-bold bg-info"><b>OFICINA</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>EMPLEADO</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>CARGO</b></th>
                           
                            <th class="text-center p-1 font-weight-bold bg-info"><b>ESTADO</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><i class="fa fa-bars"
                                    aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('activo.gestionactivo._codigoBarras')
@section('scripts')
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="/js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('#table-activos').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                ajax: "{{ route('activo.gestionactivo.list') }}",
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
                        data: 'codconts',
                        name: 'codconts.nombre',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'auxiliars',
                        name: 'auxiliars.nomaux',
                        class: 'text-justify p-1 font-verdana',
                        orderable: false
                    },
                   
                    {
                        data: 'areas',
                        name: 'areas.nombrearea',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'empleados',
                        name: 'empleados.nombres',
                        class: 'text-justify p-1 font-verdana',
                        render: function(data, type, full, meta) {
                            return full.empleados;
                        },
                    },
                    {
                        data: 'cargo',
                        name: 'empleados.file.nombrecargo',
                        class: 'text-justify p-1 font-verdana'
                    },
                  
                    
                    {
                        data: 'estado_texto',
                        name: 'estado_texto',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        orderable: true,
                        searchable: true
                    }
                ],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            var codigoBarraActual = null;
            $('#table-activos').on('click', '#ver-codigo', function(e) {
                e.preventDefault();
                codigoBarraActual = $(this).data('codigo');
                $('#codigoActivo').html(codigoBarraActual);
                $('#description').html($(this).data('descripcion'));

                var svg = document.getElementById('codigoDeBarras');
                svg.setAttribute('width', '80%');
                JsBarcode(svg, codigoBarraActual, {
                    format: 'CODE128',
                    displayValue: false,
                    width: 3,
                    height: 100,
                    font: 'verdana',
                    textAlign: 'center',
                    fontOptions: "italic"
                });
                $('#modalArchivo').modal('show');
            });
            $('#imprimirEtiquetas').click(function() {
                var cantidad = $('#cantidad').val();

                if (cantidad > 0) {
                    var url = `/Activo/etiquetas/${codigoBarraActual}/imprimir/${cantidad}`;
                    window.open(url, '_blank');
                } else {
                    alert('La cantidad debe ser mayor a cero.');
                }
            });
        });
    </script>
@endsection
@endsection
