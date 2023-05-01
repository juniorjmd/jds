<?php
session_start();
?>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript"  language="javascript"  >
(function(){
	var content = $("#geolocation-test");

	if (navigator.geolocation)
	{
		var watch_id = navigator.geolocation.watchPosition(function(objPosition)
		{	var lon = objPosition.coords.longitude;
			var lat = objPosition.coords.latitude;
			var latAct = $('#latitudAct').val()
			var lonAct =$('#longitudeAct').val()
			if ((latAct != lat)|| (lonAct != lon)){		
			$('#latitudAct').val(lon)
			$('#longitudeAct').val(lat)
			//$("#geolocation-test").html("<p><strong>Latitud:</strong> " + lat + "</p><p><strong>Longitud:</strong> " + lon + "</p>") ;
			var datosAjax = {longtud:  lon,
							  latitud :	lat ,
							  idUsuario : $('#usuarioid').val()
								};		
		$.ajax({url: '../php/db_cargarUbicacion.php',  
			type: 'POST',
			data: datosAjax,
			//dataType: "json",
			 beforeSend: function() {
				//alert(JSON.stringify(datosAjax))
				}, 
			statusCode: {
    			404: function() {
				 alert( "pagina no encontrada" );
   				 },
				 408: function() {
				alert( "Tiempo de espera agotado. la peticion no se realizo " );
   				 } 
				 },
 			success: function(data) {
				//alert(JSON.stringify(data))
				},error: function(a,e,b){
					 alert("se genero un error"+JSON.stringify(a)+e+b)
					}}); 
}
		}, function(objPositionError)
		{
			switch (objPositionError.code)
			{
				case objPositionError.PERMISSION_DENIED:
					$("#geolocation-test").html("No se ha permitido el acceso a la posición del usuario.");
				break;
				case objPositionError.POSITION_UNAVAILABLE:
					$("#geolocation-test").html("No se ha podido acceder a la información de su posición.");
				break;
				case objPositionError.TIMEOUT:
					$("#geolocation-test").html("El servicio ha tardado demasiado tiempo en responder.");
				break;
				default:
					$("#geolocation-test").html("Error desconocido.");
			}
		}, {
			maximumAge: 75000,
			timeout: 15000
		});
	}
	else
	{
			$("#geolocation-test").html("Su navegador no soporta la API de geolocalización.");
	}
})();
</script>
<input type='hidden' id='usuarioid' value = '<?php echo $_SESSION["usuarioid"]?>'>
<input type='hidden' id='latitudAct' value = '0'>
<input type='hidden' id='longitudeAct' value = '0'>
<div id='geolocation-test'>
 
</div >