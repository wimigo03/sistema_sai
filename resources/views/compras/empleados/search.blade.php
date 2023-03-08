<form method="GET" action="{{ route('empleados.index') }}" accept-charset="UTF-8">

<div class="form-group">
	<div class="input-group col-sm-4">
		<input type="text" class="form-control" name="searchText" placeholder="Buscar por Nombre ......" >
		<span class="input-group-btn">
			<button type="submit" class="btn btn-outline-primary">Buscar</button>
		</span>
	</div>
</div>


</form>