@extends('layouts.admin')
@section('content')


    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>ARCHIVOS -- </b><b style='color:orange'>{{ $idd->nombrearea }} </b>--
        </div>
        <div class="col-md-4 text-right titulo">
      
            <a href="{{ route('archivos2.tipo') }}" class="tts:left tts-slideIn tts-custom"
                aria-label="Agregar Tipo Archivo">
                <button class="btn btn-sm btn-primary font-verdana" type="button">Agreg.Tipo
                    &nbsp;<i class="fa fa-lg fa-file" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
    
 {{-- EVENTO 2--}}
          
                <a href="{{ route('archivos2.create') }}"  class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar Archivo" >
                    <button class="btn btn-sm btn-success font-verdana" type="button">Agreg.Archivo.
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
         





        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered  hoverTable  responsive  font-verdana" style="width:100%;" id="users-table">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>N°</b></td>
                            <td class="text-justify p-1"><b>Gestion</b></td>
                            <td class="text-justify p-1"><b>Fecha Rec./Env.</b></td>
                            <td class="text-justify p-1"><b>NUM.DOC.</b></td>
                            <td class="text-justify p-1"><b>Referencia</b></td>
                            <td class="text-justify p-1"><b>Tipo</b></td>
                            <td class="text-center p-1 font-weight-bold">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </td>
                            <td class="text-center p-1 font-weight-bold">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr  >
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>


                    </tr>

                    </tfoot>
                </table>
            </center>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script type="text/javascript">

        $('#users-table').DataTable({

            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,


            ajax: "{{ route('archivos2.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'gestion',
                    name: 'a.gestion',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'fecha',
                    name: 'a.fecha',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'nombrearchivo',
                    name: 'a.nombrearchivo',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'referencia',
                    name: 'a.referencia',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'nombretipo',
                    name: 't.nombretipo',
                    class: 'text-justify p-1 font-verdana'
                },


                {
                    data: 'btn2',
                    name: 'btn2',
                    orderable: false,
                    searchable: false
                }

                ,

                {
                    data: 'btn',
                    name: 'btn',
                    orderable: false,
                    searchable: false
                }
            ],

            initComplete: function () {
            this.api().columns(1).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });


            this.api().columns(2).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });

            this.api().columns(3).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(4).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "400px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(5).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "200px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });

        }
,
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
    </script>
@endsection

