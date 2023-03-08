<form method="GET" action="{{ route('pedido.index') }}" accept-charset="UTF-8">

<div class="form-group">
	<div class="input-group col-md-10"  >
		<input type="text" class="form-control " name="searchText" placeholder="Buscar por Area ......" style="color:blue">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" class="form-control" name="searchText2" placeholder="Buscar por Proveedor ......" style="color:blue">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" class="form-control" name="searchText3" placeholder="Buscar por Preventivo ......" style="color:blue" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="input-group-btn">
			<button type="submit" class="btn btn-outline-primary">Buscar</button>
		</span>
	</div>
</div>



</form>