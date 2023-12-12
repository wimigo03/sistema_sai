$(document).ready(function() {
	$('.select2').select2({
		placeholder: "--Seleccionar--"
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