 


<div class="modal fade" id="mes">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
               
                <ul>
                    @foreach ($personasmes as $persona)
                        <li>{{ $persona->ap_pat }}</li>
                    @endforeach
                </ul>
                </div>
                
            </div>
            <div class="modal-footer">
                <input class="btn btn-" data-dismiss="modal" value="Cerrar">
                
              </div>
            <!-- Log on to codeastro.com for more projects! -->
        </div>

    </div>
</div>




<div class="modal fade" id="mostrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div class="card-body text-left ">
                    
                    @foreach ($personashoy as $persona)
                    <p >Nombre: {{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</p>
                    <p>Fecha de natalicio: {{ $persona->natalicio }}</p>
                    <!-- Agrega aquí más detalles que desees mostrar -->
                @endforeach


                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-" data-dismiss="modal" value="Cerrar">
                
              </div>
            <!-- Log on to codeastro.com for more projects! -->
        </div>

    </div>
</div>
