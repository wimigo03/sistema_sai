<div class="modal fade" id="hoy1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($personashoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($expdecjuradahoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($rejaphoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($expsippasehoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($exppoaihoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Planta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($expprogvacacionhoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Contrato</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($expsippase2hoy as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title"><b>Personal de Contrato</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($rejaphoy2 as $persona)
                    <li class="list-group-item">{{ $persona->nombres }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer justify-content-center">
                <input class="btn btn-sm btn-danger font-verdana" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
