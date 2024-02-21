@extends('layouts.admin')

@section('content')
<div class="row font-verdana">
    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
            <a href="{{route('contrato.index')}}" class="color-icon-1">
                <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
            </a>
        </span>
    </div>
    <div class="col-md-8 titulo">
        <b>GESTIONAR PERSONAL-P/{{$nombrearea}}</b>
    </div>
    <div class="col-md-2 text-right">
        @can('empleado_contrato_create_access')
        <a href="{{route('contrato.crear',$idarea)}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
            <button class="btn btn-sm btn-outline-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        @endcan
    </div>
  
</div>
<div class="col-md-12">
        <hr class="hrr">
        <input type="hidden" value="{{$idarea}}">
    </div>
<div class="row font-verdana">
    <div class="col-md-12">
        <div class="table-responsive ">
            <table id="example" class="table table-bordered customers-table table-hover" style="width:100%">
                <thead class="table-light">
                    <tr class="font-verdana-sm" style="background-color:#F2F7F8">
                        <th>Opciones</th>


                        <th>File </th>
                        <th>Nombres </th>
                        <th>Apellido<br>Paterno </th>
                        <th>Apellido<br>Materno </th>
                        <th>Cargo </th>
                        <th>Nombre<br>Cargo </th>
                        <th>Haber<br>Básico </th>
                        <th>Categoría </th>
                        <th>Nivel<br> Adm. </th>
                        <th>Clase </th>
                        <th>Nivelsal </th>
                        <th>Fecha<br>Ingreso </th>
                        <th>Natalicio </th>
                        <th>Edad </th>
                        <th>Ci </th>
                        <th>Sippase </th>
                        <th>Exp.Sippase </th>
                        <th>Sippase </th>
                        <th>Exp.Sippase </th>
                        <th>Servicio<br>Militar</th>
                        <th>Idioma </th>
                        <th>Curriculum<br>.Vitae </th>
                        <th>Telef.<br>Celular</th>
                        <th>Biometrico </th>
                        <th>Grado<br> Académico</th>

                        <th>Total<br>Presup.</th>
                        <th>Fecha<br>Final</th>
                        <th>N.Contrato</th>
                        <th>N.Preventivo</th>
                        <th>Programa<br>Proyecto</th>
                        <th>Rejap</th>
                        <th>Ap.Afp.</th>
                        <th>Cuenta<br>Banco</th>
                        <th>File<br>Actual</th>
                        <th>Nit</th>
                        <th>Sigep</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($empleados as $key => $empleado)
                    <tr>

                        <td>

                            @can('empleado_contrato_edit_access')
                            <a href="{{ route('contrato.editar', $empleado -> idemp)}}" class="btn btn-outline-info btn-sm">Editar</a>
                            @endcan

                        </td>


                        <td class="text-center p-1">{{$empleado -> numfile}}</td>
                        <td class="text-center p-1">{{$empleado -> nombres}}</td>
                        <td class="text-center p-1">{{$empleado -> ap_pat}}</td>
                        <td class="text-center p-1">{{$empleado -> ap_mat}}</td>
                        <td class="text-justify p-1">{{$empleado -> cargo}}</td>
                        <td class="text-justify p-1">{{$empleado -> nombrecargo}}</td>
                        <td class="text-justify p-1">{{$empleado -> habbasico}}</td>
                        <td class="text-justify p-1">{{$empleado -> categoria}}</td>
                        <td class="text-justify p-1">{{$empleado -> niveladm}}</td>
                        <td class="text-justify p-1">{{$empleado -> clase}}</td>
                        <td class="text-justify p-1">{{$empleado -> nivelsal}}</td>
                        <td class="text-justify p-1">{{$empleado -> fechingreso}}</td>
                        <td class="text-justify p-1">{{$empleado -> natalicio}}</td>
                        <td class="text-justify p-1">{{$empleado -> edad}}</td>
                        <td class="text-justify p-1">{{$empleado -> ci}}</td>

                        <td class="text-justify p-1">{{$empleado -> induccion}}</td>
                        <td class="text-justify p-1">{{$empleado -> expinduccion}}</td>
                        <td class="text-justify p-1">{{$empleado -> sippase}}</td>
                        <td class="text-justify p-1">{{$empleado -> expsippase}}</td>
                        <td class="text-justify p-1">{{$empleado -> servmilitar}}</td>
                        <td class="text-justify p-1">{{$empleado -> idioma}}</td>

                        <td class="text-justify p-1">{{$empleado -> cvitae}}</td>
                        <td class="text-justify p-1">{{$empleado -> telefono}}</td>
                        <td class="text-justify p-1">{{$empleado -> biometrico}}</td>
                        <td class="text-justify p-1">{{$empleado -> gradacademico}}</td>

                        <td class="text-justify p-1">{{$empleado -> totalpresupuesto}}</td>
                        <td class="text-justify p-1">{{$empleado -> fechafinal}}</td>
                        <td class="text-justify p-1">{{$empleado -> ncontrato}}</td>
                        <td class="text-justify p-1">{{$empleado -> npreventivo}}</td>
                        <td class="text-justify p-1">{{$empleado -> progproy}}</td>
                        <td class="text-justify p-1">{{$empleado -> rejap}}</td>
                        <td class="text-justify p-1">{{$empleado -> aportesafp}}</td>
                        <td class="text-justify p-1">{{$empleado -> cuentabanco}}</td>
                        <td class="text-justify p-1">{{$empleado -> filecontrato}}</td>
                        <td class="text-justify p-1">{{$empleado -> nit}}</td>
                        <td class="text-justify p-1">{{$empleado -> sigep}}</td>




                    </tr>

                    @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>





<!-- datatables JS -->
@section('scripts')


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'collection',
                text: 'Mostrar',
                className: 'btn btn-sm btn-primary',
                buttons: [
                    '<h2>Ver Información</h2>', {
                        extend: 'colvisGroup',
                        text: 'Inf Personal',
                        show: [2, 3, 4, 13, 14, 15, 21],
                        hide: [1, 5, 6, 7, 8, 9, 10, 11, 12, 16, 17, 18, 19, 20, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34],
                        columns: ':gt(0)' // Aplica solo a las columnas después de la primera
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Laboral',
                        show: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 25],
                        hide: [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 26, 27, 28, 29, 30, 31, 32, 33, 34],
                        columns: ':gt(0)'

                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Inf Adicional',
                        show: [2, 3, 4, 17, 18, 19, 20, 21, 22, 23, 24, 26, 27, 28, 29, 30, 31, 32, 33, 34],
                        hide: [1, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 25],
                        columns: ':gt(0)' // Aplica solo a las columnas después de la primera
                    },

                    '<h2 class="not-top-heading">Personalizar Vista</h2>',
                    {
                        extend: 'colvisGroup',
                        text: 'Mostrar todo',
                        show: ':hidden'
                    },
                    {
                        extend: 'colvis',
                        text: 'Vista de Columnas',
                        collectionLayout: 'fixed columns',
                        collectionTitle: 'Control de visibilidad de columnas',

                    }
                ]
            }, {
                extend: 'spacer',
                style: 'bar',
            }, ],

            //para cambiar el lenguaje a español
            language: {
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                sSearch: "Buscar:",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                },
                sProcessing: "Procesando...",
            }
        });
    });
</script>

@endsection
@endsection