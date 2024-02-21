<div class="modal fade" id="hoy1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE PLANTA - EXP. REJAP </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personashoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy2">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE PLANTA - EXP. DECLARACIÓN JURADA </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expdecjuradahoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
         
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy3">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. REJAP </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejaphoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy4">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. SIPPASE </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expsippasehoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy5">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. POAI </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exppoaihoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy6">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. PROGAMACIÓN DE VACACIONES </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expprogvacacionhoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
      
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy7">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. SIPPASE </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expsippase2hoy as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy8">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. REJAP </b></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejaphoy2 as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hoy9">
    <div class="modal-dialog modal-dialog-centered modal-lg font-verdana-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-verdana"><b>PERSONAL DE CONTRATO - EXP. INDUCCIÓN </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table id="empleados-fecha" class="table table-striped table-bordered font-verdana-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personashoy2 as $persona)
                        <tr>
                            <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>




            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>