$(document).ready(function(){
			cargaSucursalesMenu();
		  OcultaYMuestra("#infoSem","#infoDia");
		  
		  inicioListar('grupos',list_res_Grup);
		  OcultaYMuestra("#crearGrupos","#listarGrupos");
			//enableDisable("#color");
			var datosJson="";
			$("#print").click(function(){ 
					imprimirSelec(".infoContainer")
								});
			
			carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
							$("#infoSem").html(respuesta_json);
							},"php/notificacionSemana.php");
			datosJson="";
				carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
							$("#infoDia").html(respuesta_json);
							},"php/notificacionDiaria.php");	
		$("#bt1").click(function(){	
							 OcultaYMuestra("#listarGrupos","#crearGrupos");
							 OcultaYMuestra(".busquedas");
							  $(document).unbind('keydown');
							 $(document).keydown(function(tecla){
	var r=tecla.keyCode;
	if (r==113){
		$("#saveNew").trigger('click');}

});	
							});		   
			$("#bt2").click(function(){ $(document).unbind('keydown');
						    OcultaYMuestra("#crearGrupos","#listarGrupos");
							OcultaYMuestra("",".busquedas");
								});
			
			
			
			$("#saveNew").click(function(){
					
				var query="INSERT INTO `grupos` VALUES (?,?,?,?)";
				 datosJson=recogerDatos2(".CreaGrupos")+"respuesta="+ encodeURIComponent("nuevoGrupo")+"&query="+ encodeURIComponent(query)+"&nocache=" + Math.random();
				
			carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
						//	crearId('articulo',"#IdSucursal")
							inicioListar('grupos',list_res_Grup)
							OcultaYMuestra("#crearGrupos","#listarGrupos");
							limpiaVal(".CreaGrupos");							
							alert(respuesta_json);
							});	
				
				
				
						   	});


});	


