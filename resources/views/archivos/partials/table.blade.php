<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="users-table">
                <thead>
                    <tr>
                        <th class="text-justify p-1"><b>N°</b></th>
                        <th class="text-center p-1"><b>GESTION</b></th>
                        <th class="text-center p-1"><b>REC./ENV.</b></th>
                        <th class="text-center p-1"><b>N. DOC.</b></th>
                        <th class="text-center p-1"><b>REFERENCIA</b></th>
                        <th class="text-center p-1"><b>TIPO</b></th>
                        <th class="text-center p-1">
                            @canany(['archivos.documentacion','archivos.editar','archivos.generar.qr'])
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            @endcanany
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    </div>
</div>
