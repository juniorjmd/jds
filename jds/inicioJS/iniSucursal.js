$(document).ready(function(){
			OcultaYMuestra("#Nuevo");
			OcultaYMuestra("#Mostrar");
			enableDisable(".Mrespuesta");
			enableDisable("#enviarE");
			inicioListar('sucursales',list_res_Suc)
			crearId('sucursales',"#IdSucursal")
			$("#bt1").click(function(){	
							OcultaYMuestra("#listado","#Nuevo");
							OcultaYMuestra("#Mostrar");
							OcultaYMuestra("","#botones");
							enableDisable("#enviarE");

							});		   
			$("#bt2").click(function(){
						    OcultaYMuestra("#Nuevo","#listado"); 
							OcultaYMuestra("#Mostrar");
							OcultaYMuestra("","#botones");
						enableDisable("#enviarE");

							});
			$("#EditarBoton").click(function(){
						   	enableDisable("",".Mrespuesta");
							OcultaYMuestra("","#botones");
								enableDisable("","#enviarE");
							});
			$("#EliminarBoton").click(function(){
								dato=$("#IdSucursalM").html();
								eliminar("sucursales",'id_suc',dato,"EliminaSucursal",function(){var respuesta_json = this.req.responseText;
																									crearId('sucursales',"#IdSucursal");
																									inicioListar('sucursales',list_res_Suc);
																									enableDisable(".Mrespuesta","");
																									OcultaYMuestra("#Mostrar","#listado"); })
							});
			
			  $("#saveNew").click(function(){
				var query="INSERT INTO `sucursales` VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				 datosJson=recogerDatos(".respuesta")+ "respuesta="+ encodeURIComponent("nuevaSuc")+"&query="+ encodeURIComponent(query)+"&nocache=" + Math.random();;
				//alert(datosJson)
				carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
							crearId('sucursales',"#IdSucursal")
							inicioListar('sucursales',list_res_Suc)
							OcultaYMuestra("#Nuevo","#listado");
							limpiaVal(".respuesta")
							alert(respuesta_json);
							});	
				
				});
			$("#CancelNew").click(function(){
			limpiaVal(".respuesta")
			});
			
			$("#CancelEdit").click(function(){
			limpiaVal(".Mrespuesta")
			limpiaHtml(".lbrespuesta");
			  	enableDisable(".Mrespuesta","");
			OcultaYMuestra("#Mostrar","#listado"); 						
			enableDisable("#enviarE");

			});
			
				$("#enviarE").click(function(){
				 datosJson=recogerDatos(".Mrespuesta")+recogerDatos(".lbrespuesta") + "respuesta="+ encodeURIComponent("sucursales")+"&tabla="+ encodeURIComponent("sucursales")+"&columna="+ encodeURIComponent("id_suc")+"&nocache=" + Math.random();
				// alert(datosJson)
				carga_borrarUpdate(datosJson,function(){
							var respuesta_json = this.req.responseText;
							inicioListar('sucursales',list_res_Suc)
							OcultaYMuestra("#Mostrar","#listado");
							enableDisable(".Mrespuesta","");
						enableDisable("#enviarE");
							alert(respuesta_json);
							});	
			});
		
						  });	


