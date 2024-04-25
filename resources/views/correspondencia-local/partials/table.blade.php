<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="users-table">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">NOMBRES</th>
                    <th class="text-center p-1">APELLIDOS</th>
                    <th class="text-center p-1">UNIDAD</th>
                    <th class="text-center p-1">ASUNTO</th>
                    <th class="text-center p-1">FECHA</th>
                    <th class="text-center p-1">CODIGO</th>
                    @can('correspondencia_local.gestionar')
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    @endcan
                    @can('correspondencia_local.urlfile')
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
