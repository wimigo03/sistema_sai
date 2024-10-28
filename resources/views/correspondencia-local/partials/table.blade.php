<div class="form-group row font-roboto-11   ">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="dataTable">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1" width="20%"><b>NOMBRE COMPLETO</b></td>
                    <td class="text-left p-1" width="26%"><b>UNIDAD</b></td>
                    <td class="text-left p-1" width="30%"><b>ASUNTO</b></td>
                    <td class="text-center p-1" width="8%"><b>FECHA</b></td>
                    <td class="text-center p-1" width="6%"><b>CODIGO</b></td>
                    <td class="text-center p-1" width="10%">
                        @canany(['correspondencia_local.gestionar', 'correspondencia_local.urlfile'])
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
