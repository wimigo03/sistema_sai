<form method="GET" action="{{ route('partida.index') }}" accept-charset="UTF-8">

<div class="form-group">
	<div class="input-group ">
		<input type="text" class="form-control " name="searchText" placeholder="Buscar por Codigo......" >
		<input type="text" class="form-control" name="searchText2" placeholder="Buscar por Nombre ......" >
		<input type="text" class="form-control" name="searchText3" placeholder="Buscar por Detalle ......" >
		<span class="input-group-btn">
			<button type="submit" class="btn btn-outline-primary">Buscar</button>
		</span>
	</div>
</div>



</form>