 <div class="modal fade" id="hoy">
     <div class="modal-dialog">
         <div class="modal-content">
             <!-- Log on to codeastro.com for more projects! -->

             <div class="modal-header">
                 <h5 class="modal-title"><b>Personal de Planta</b></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">


             </div>
             <div class="modal-body">

                 <ul class="list-group">
                     @foreach ($personashoy as $persona)
                         <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }}
                             {{ $persona->ap_mat }}</li>
                     @endforeach
                 </ul>
             </div>

             <div class="modal-footer justify-content-center">
                 <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">

             </div>
         </div>
         
     </div>

 </div>




 <div class="modal fade" id="mes">
     <div class="modal-dialog">
         <div class="modal-content">
             <!-- Log on to codeastro.com for more projects! -->

             <div class="modal-header">
                 <h5 class="modal-title"><b>Personal de Planta</b></h5>

             </div>
             <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm" id="empleados-fecha">
                        <thead class="text-center">
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha de Nacimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personasmes as $persona)
                                <tr>
                                    <td>{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</td>
                                    <td>{{ $persona->natalicio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                 <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">

             </div>
             <!-- Log on to codeastro.com for more projects! -->
         </div>

     </div>
 </div>
