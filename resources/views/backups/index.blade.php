@extends('layouts.admin')



@section('content')
<div class="container">

    <div class="row justify-content-right font-verdana-bg">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-left">
                    <form action="{{ route('backup.create') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Realizar Copia de Seguridad</button>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalRestaurarDB">
                        Restaurar
                    </button>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <hr>
            @if (session()->has('process_summary'))
            <div class="alert alert-info">
                {{ session('process_summary') }}
            </div>
            @endif
            @if (session()->has('process_DB'))
            <div class="alert alert-info">
                {{ session('process_DB') }}
            </div>
            @endif

            @if(Session::has('pendiente'))
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('pendiente') }}
            </div>
            <hr>

            @endif

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            <hr>

            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('error') }}
            </div>
            <hr>

            @endif
        </div>

    </div>
    <div class="row justify-content-center font-verdana-bg">

        @foreach ($tableData as $data)
        <div class="col-md-3 ">
            <div class="card">
                <div class="card-header">{{ $data['Name'] }}</div>
                <div class="card-body">
                    <h6 class="card-subtitle text-muted"></h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Disco:</strong><br> {{ $data['Disk'] }}</li>
                        <li class="list-group-item"><strong>Accesible:</strong> {{ $data['Reachable'] }}</li>
                        <li class="list-group-item"><strong>Estado:</strong> {{ $data['Healthy'] }}</li>
                        <li class="list-group-item"><strong>Copias de Seguridad:</strong><br> {{ $data['# of backups'] }}</li>
                        <li class="list-group-item"><strong>Última Copia de Seguridad:</strong><br> {{ $data['Newest backup'] }}</li>
                        <li class="list-group-item"><strong>Almacenamiento Utilizado:</strong> <br>{{ $data['Used storage'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-md-9">

            <div class="card">
                <div class="card-header">Lista de Copias de Seguridad</div>
                <div class="card-body">

                    <table id="backup-table" class="table-bordered compact yajra-datatable hoverTable table display responsive font-verdana" style="width:100%">

                        <thead>
                            <tr>
                                <th>Archivo</th>

                                <th>Creado</th>
                                <th>Tamaño </th>
                                <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i> </th>
                                <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-2">


        </div>
    </div>
    <div class="modal fade" id="modalRestaurarDB" tabindex="-1" role="dialog" aria-labelledby="modalRestaurarDBLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="modalRestaurarDBLabel">Restaurar Base de Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de restauración de la base de datos -->
                    <row>
                        <div class="card">
                            <div class="card-header">Restaurar Archivos</div>

                            <div class="card-body">
                                <form action="{{ route('backup.cargar') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="backup">Seleccione el Archivo ZIP:</label>
                                        <input type="file" name="zip_file" id="backup" class="form-control-file" accept=".zip">
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm">Restaurar Archivos</button>
                                </form>
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
                           
                        </div>
                        <div class="card">
                                <div class="card-header">Restaurar</div>

                                <div class="card-body">
                                    <form action="{{ route('backup.cargarBackup') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="backup">Seleccione el Archivo Backup</label>
                                            <input type="file" name="backup_file" id="backup" class="form-control-file" accept=".backup">
                                        </div>

                                        <button type="submit" class="btn btn-primary  btn-sm">Restaurar  Database</button>
                                    </form>
                                </div>
                            </div>
                    </row>

                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        $('#backup-table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "Todos"]
            ], // Mostrar opciones de selección

            order: [
                [1, 'desc']
            ], // Ordenar por fecha de creación en orden descendente


            ajax: {
                url: "{{ route('database.backups') }}",
                type: 'GET'
            },
            columns: [
    {
        data: 'nombre_archivo',
        name: 'nombre_archivo'
    },
    {
        data: 'fecha_creacion',
        name: 'fecha_creacion'
    },
    {
        data: 'tamaño',
        name: 'tamaño'
    },
    {
        data: 'nombre_archivo',
        name: 'nombre_archivo',
        render: function(data, type, row) {
            return '<form method="POST" action="{{ route("descargar_backup") }}">' +
                '@csrf' +
                '<input type="hidden" name="nombre_archivo" value="' + data + '">' +
                '<div class="text-center">' + // Alineación al centro
                '<button type="submit" class="btn btn-primary btn-sm font-verdana-sm">DESCARGAR</button>' +
                '</div>' +
                '</form>';
        }
    },
    {
        data: 'ruta',
        name: 'ruta',
        render: function(data, type, row) {
            return '<form method="POST" action="{{ route("backup.restoreStorage") }}">' +
                '@csrf' +
                '<input type="hidden" name="ruta" value="' + data + '">' +
                '<div class="text-center">' + // Alineación al centro
                '<button type="submit" class="btn btn-success btn-sm font-verdana-sm">RESTAURAR</button>' +
                '</div>' +
                '</form>';
        }
    }
    // Puedes agregar más columnas aquí según sea necesario
]

        });
    });
</script>


@endsection
@endsection