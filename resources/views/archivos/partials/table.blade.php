<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1">
        <table class="table table-striped table-bordered hover-orange" style="width:100%;" id="dataTable">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1 font-roboto-11" width="12%"><b>OFICINA</b></td>
                    <td class="text-center p-1 font-roboto-11"><b>GESTION</b></td>
                    <td class="text-center p-1 font-roboto-11"><b>REC./ENV.</b></td>
                    <td class="text-left p-1 font-roboto-11"><b>N.&nbsp;DOC.</b></td>
                    <td class="text-left p-1 font-roboto-11"><b>REFERENCIA</b></td>
                    <td class="text-left p-1 font-roboto-11"><b>TIPO</b></td>
                    <td class="text-center p-1" width="6%">
                        @canany(['archivos.documentacion','archivos.editar','archivos.generar.qr'])
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        @endcanany
                    </td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
