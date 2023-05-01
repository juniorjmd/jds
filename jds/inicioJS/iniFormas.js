$(document).ready(function(){
						   
			cargaSucursalesMenu();
		  OcultaYMuestra("#infoSem","#infoDia");
		  inicioListar('forma',list_res_Forma);
		  OcultaYMuestra("#crearGrupos","#listarGrupos");
			//enableDisable("#color");
		
		$("#bt1").click(function(){	
							 OcultaYMuestra("#listarGrupos","#crearGrupos");
							 $(document).unbind('keydown');
							 $(document).keydown(function(tecla){
	var r=tecla.keyCode;
	if (r==113){
		$("#saveNew").trigger('click');}

});	
							});		   
			$("#bt2").click(function(){
							$(document).unbind('keydown');
						    OcultaYMuestra("#crearGrupos","#listarGrupos");
								});
			
			
			
			$("#saveNew").click(function(){
					
				var query="INSERT INTO `forma` VALUES (?,?,?)";
				 datosJson=recogerDatos2(".CreaGrupos")+"respuesta="+ encodeURIComponent("nuevoForma")+"&query="+ encodeURIComponent(query)+"&nocache=" + Math.random();
				
			carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
						//	crearId('articulo',"#IdSucursal")
							inicioListar('forma',list_res_Forma)
							OcultaYMuestra("#crearGrupos","#listarGrupos");
							limpiaVal(".CreaGrupos");							
							alert(respuesta_json);
							});	
				
				
				
						   	});


});	

// JavaScript Document