$(document).ready(function() {
	$('.select2').select2({
		placeholder: "--Seleccionar--"
	});
	
	$('#datatable').DataTable({
		"processing":true,
		"iDisplayLength": 10,
		"order": [[ 0, "asc" ]],
		"language":{"info": "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
		"search": '',
		"searchPlaceholder": "Buscar",
		"paginate": {"next": "<span class='font-verdana'>Siguiente</span>","previous": "<span class='font-verdana'>Anterior</span>"},
		"lengthMenu":   '<select class="form form-control-sm">' + 
							'<option value="10">10</option><option value="25">25</option>' + 
							'<option value="50">50</option><option value="100">100</option>' + 
							'<option value="-1">Todos</option>' + 
						'</select>',
		"loadingRecords": "<span class='font-verdana'>...Cargando...</span>",
		"processing": "<span class='font-verdana'>...Procesando...</span>",
		"emptyTable": "<span class='font-verdana'>No hay datos</span>",
		"zeroRecords": "<span class='font-verdana'>No hay resultados para mostrar</span>",
		"infoEmpty": "<span class='font-verdana'>Ningun registro encontrado</span>",
		"infoFiltered": "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
		}
	});
});
		
$('.intro').on('keypress', function(event) {
	if (event.which === 13) {
		procesar();
		event.preventDefault();
	}
});

function valideNumberInteger(evt){
	var code = (evt.which) ? evt.which : evt.keyCode;
	if(code>=48 && code<=57){
		return true;
	}else{
		return false;
	}
}

function valideNumberDecimal(evt){
	var code = (evt.which) ? evt.which : evt.keyCode;
	if((code == 46) || (code>=48 && code<=57)){
		return true;
	}else{
		return false;
	}
}
		
var Modal = function(mensaje){   
	$("#modal-alert .modal-body").html(mensaje);
	$('#modal-alert').modal({keyboard: false});
}