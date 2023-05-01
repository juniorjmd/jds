// ***********************************************
//  Funciones para validar campos de formularios
// ***********************************************

//-------------------------------
function validarEmail( Elemento ){
	var campo = Elemento.value;
	var filter = /^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;			
	if ( campo.length == 0 ) 	return true;
	if ( filter.test(campo) )	return true;
	Elemento.focus( );
	return false;
}
//--------------------------------
function validarTelefono( Elemento ){
	var campo = Elemento.value;
	var filter = /(^([0-9\s\+\-]+)|^)$/; // numeros, espacios, + o -
	if ( campo.length == 0 ) 	return true;
	if ( filter.test(campo) )	return true;
	Elemento.focus( );
	return false;
}
//---------------------------------
function validarNombre( Elemento ){
	var campo = Elemento.value;
	var filter = /(^([a-z]|[A-Z]|á|é|í|ó|ú|ñ|ü|\s|\.|-)+|^)$/;	// letras, '.' y '-' o vacio   
	if ( campo.length == 0 ) 	return true;
	if ( filter.test(campo) )	return true;
	Elemento.focus( );
	return false;
}
//-------------------------------
function validarNumerosPositivos( Elemento ) { 
	var campo = Elemento.value;
	var filter = /(^([0-9]+)|^)$/; // numeros
	if ( campo.length == 0 ) 	return true;
	if ( filter.test(campo) )	return true;
	Elemento.focus( );
	return false;
}
//-------------------------------
function validarNumerosPositivos2( Elemento ) { 
	//convierte en valores enteros los datos del formulario (base 10)
	var campo = parseInt( Elemento.value, 10 );
	alert(campo);
	//valida que sean numeros y que sean positivos
	if ( isNaN( campo ) || campo < 0  ) {
		return false
	}
	Elemento.focus( );
	return true;
}
