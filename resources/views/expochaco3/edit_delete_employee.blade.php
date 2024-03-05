<!-- Edit -->
<div class="modal fade" id="edit{{ $solicitudes->idsolicitud }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Employee Details</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('employees.update', $solicitudes->idsolicitud) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name</label>


                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $solicitudes->idsolicitud }}" required>

                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Position</label>


                        <input type="text" class="form-control" id="position" name="nombre"
                            value="{{ $solicitudes->nombresolicitud }}" required>

                    </div>


                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>


                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $solicitudes->asociacionsol }}">

                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>


                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $solicitudes->schedules->idrubro }}">

                    </div>

                    <div class="form-group">
                        <label for="schedule" class="col-sm-3 control-label">Schedule</label>


                        <select class="form-control" id="schedule" name="rubros" required>

                            @foreach ($rubros as $rubro)
                                @if ($rubro->idrubro == $solicitudes->schedules->idrubro )
                                    <option value="{{ $rubro->idrubro }}" selected>{{ $rubro->nombrerubro }} </option>
                                @else
                                <option value="{{ $rubro->idrubro }}">{{ $rubro->nombrerubro }} </option>
                                @endif
                            @endforeach

                        </select>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i
                        class="fa fa-check-square-o"></i>
                    Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete -->
<div class="modal fade" id="delete{{ $solicitudes->idsolicitud }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">

              <h4 class="modal-title "><span class="employee_id">Delete Employee</span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="GET" action="{{ route('employees.destroy', $solicitudes->idsolicitud) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{$solicitudes->idsolicitud }}</h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
