@extends('layouts.admin')

@section('content')


<div class="row font-verdana-bg">
    <div class="col-md-10 titulo">
        <b>LISTADO DE PARTIDAS</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>

            <div class="row">
                <div class="col-md-12 table-responsive">
                <font size="2" face="Courier New" >
                    <center>
                       <table class="table table-bordered  yajra-datatable hoverTable">
                            <thead>
                               <tr>
                               <th style="color:black">N°</th>
                               <th style="color:black">CODIGO</th>
                               <th style="color:black">NOMBRE</th>
                               <th style="color:black">DETALLE</th>
                               </tr>
                            </thead>
                                    <tbody>
                                    </tbody>
                        </table>
                    </center>
                </font>
                </div>
            </div>

@section('scripts')

<script type="text/javascript">
$(function() {

    var table = $('.yajra-datatable').DataTable({
      

        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: "{{ route('partida.list') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false},

            { data: 'codigopartida', name: 'codigopartida' },

            { data: 'nombrepartida',  name: 'nombrepartida'},

            { data: 'detallepartida', name: 'detallepartida' },


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
},


    });

});
</script>

@endsection

@endsection