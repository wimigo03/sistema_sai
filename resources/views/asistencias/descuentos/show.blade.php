@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$descuento->descrip_hb}}</h1>
    <h2>Descuentos asignados:</h2>
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
        </thead>

        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>

    </table>
</div>
@endsection