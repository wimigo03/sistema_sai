@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-6 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{route('empleadoasistencias.index')}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b> Regularizar Asistencias </b>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('historial_asistencia.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Restaurar Regularizacion">
                <button class="btn btn-sm btn-primary font-verdana" type="button">
                    <i class="fa fa-clock" aria-hidden="true"></i>
                    &nbsp; Historial de Regularizaciones
                </button>
            </a>
            <b> MES: </b>
        
         
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
         </div>
    
        <div class="col-md-12">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Mostrar mensajes de error -->
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-12">
            <table class="table-bordered table-hover display hover compact font-verdana" id="retrasos-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Nombres y Apellidos</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="miModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Regularizar Asistencia</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body form">
                <div class="container">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="text" value="" name="registro_id" />
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label">Nombre y Apellido</label>
                                <input name="book_isbn" placeholder="Nombre y Apellido" class="form-control" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Fecha Asistencia</label>
                                <input name="Fecha" placeholder="Fecha Asistencia" class="form-control" type="text" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@section('scripts')
<script>
    var groupColumn = 0;
    var table = $(document).ready(function() {
        $('#retrasos-table').DataTable({
            responsive: true,
            serverSidez: true,
            processing: true,

            ajax: "{{ route('ausencias.index') }}",
            columns: [{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nombres_apellidos',
                    name: 'nombres',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'estado',
                    name: 'estado',
                    class: 'text-justify p-1 font-verdana-sm text-danger', // You can use text-danger for red text
                },
                {
                    data: 'opciones',
                    name: 'nombres',
                    class: 'text-justify p-1 font-verdana-sm'
                },
            ],
            order: [
                [0, 'desc']
            ],
            rowGroup: {
                dataSrc: 'fecha'
            },
             // cambiar lenguaje a español

        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
        });
    });
</script>

@endsection
@endsection