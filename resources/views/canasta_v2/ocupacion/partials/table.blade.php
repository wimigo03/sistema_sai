<div class="form-group row font-roboto-12 abs-center">
    <div class="col-md-8 pr-1 pl-1">
        <table class="table display table-striped table-bordered hover-orange" style="width:100%;" id="dataTable">
            <thead>
                <tr class="font-roboto-12">
                    <td class="text-center p-1"><b>DETALLE</b></td>
                    <td class="text-center p-1"><b>TIPO</b></td>
                    <td class="text-center p-1" width="10%"><b>ESTADO</b></td>
                    @canany(['canasta.barrios.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars fa-fw"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot class="font-roboto-12">
                <tr>
                    <th>DETALLE</th>
                    <th>TIPO</th>
                    <th>ESTADO</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
