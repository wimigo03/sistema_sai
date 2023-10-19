<table>
    <thead>
        <tr>
            <th><b>ID</b></th>
            <th><b>NOMBRE</b></th>
            <th><b>USUARIO</b></th>
            <th><b>EMAIL</b></th>
            <th><b>ROL</b></th>
            <th><b>ESTADO</b></th>
        </tr>
    </thead>
    @if ((isset($users) && (count($users) > 0)))
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nombre_completo }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->title }}</td>
                    <td>{{ $user->status }}</td>
                </tr>
            @endforeach
        </tbody>
    @endif
</table>