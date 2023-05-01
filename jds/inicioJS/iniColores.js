$(document).ready(function(){
						   
			cargaSucursalesMenu();
		  OcultaYMuestra("#infoSem","#infoDia");
		  inicioListar('colores',list_res_Color);
		  OcultaYMuestra("#crearGrupos","#listarGrupos");
			//enableDisable("#color");
		
		$("#bt1").click(function(){	
					 OcultaYMuestra("#listarGrupos","#crearGrupos");
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
					
				var query="INSERT INTO `colores` VALUES (?,?,?,?)";
				
				/*INSERT INTO `dondejose`.`colores` (
`id_color` ,
`c_name` ,
`c_n_hex` ,
`descripcion`
)
VALUES (
'1', 'turqueza', '', 'turqueza'
);
*/
				 datosJson=recogerDatos2(".CreaGrupos")+"respuesta="+ encodeURIComponent("nuevoColores")+"&query="+ encodeURIComponent(query)+"&nocache=" + Math.random();
				 alert(datosJson)
				
			carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
						//	crearId('articulo',"#IdSucursal")
							inicioListar('colores',list_res_Color)
							OcultaYMuestra("#crearGrupos","#listarGrupos");
							limpiaVal(".CreaGrupos");							
							alert(respuesta_json);
							});	
				
				
				
						   	});


});	

// JavaScript Document