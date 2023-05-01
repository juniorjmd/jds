$(document).ready(function(){//alert("que es la vaian")
			OcultaYMuestra(".nuevoArticulo");
			OcultaYMuestra("#Mostrar");
			OcultaYMuestra(".divListas","#divListas1");
			var cadena = location.href ;
			var patt = new RegExp("#CrearNuevo");
			var res = patt.test(cadena);
			var llamado;
			if(res){OcultaYMuestra("#listado",".nuevoArticulo");llamado=true;}
			enableDisable(".EditRespuesta");
			enableDisable("#enviarE");
			enableDisable("#color");
			enableDisable("#forma");
			enableDisable("#Tamanio");
			enableDisable("#cantidad");
		//	crearId('articulo',"#IdSucursal")
		cargaSelect("grupos",false,false,"#grupo","nom_gr","id_grupo")
		cargaSelect("forma",false,false,"#forma","nom_forma","id_forma")
		cargaSelect("sucursales",false,false,"#invSuc","nombre_suc","id_suc")
		cargaSelect("colores",false,false,"#color","c_name","id_color")
		$('#codigoAutomatic').click(function(){
			if($('#autoHTML').html()=='Automatico'){
				$('#autoHTML').html('Manual')
				$('#imgCod').attr("src","imagenes/manual.jpg");
				enableDisable(".idArticulo");
				$('#grupo').val('MG')
				carga_insert(null,function(){
								var respuesta_json = this.req.responseText;
								$("#IdArticulo").html(respuesta_json)
								},'php/codigoAutomaticoProducto');}
							else{
								$('#autoHTML').html('Automatico')
								$('#imgCod').attr("src","imagenes/automatico.jpg");
								enableDisable('',".idArticulo");
								$('#grupo').val('')
								$("#IdArticulo").html('')
								}
			
			});
		
			$("#invSuc").change(function(){	
							if($(this).val()=="none")
							{enableDisable("#cantidad");
							$("#cantidad").val(0)}else{
							enableDisable("","#cantidad");}
							});
			
			$(".filasData").each(function(){
			$(this).click(function(){
						var clase=$(this).attr("id");
					
			OcultaYMuestra("#listado","#Mostrar");
			var i=0;
			var datos=[];
			datos=$("."+clase).toArray()
			$(".EditRespuesta").each(function(){
				if(i==0){
				$(this).html(datos[i].value)	
				}else
				{$(this).val(datos[i].value)	}i++					  	
			  });			});
	});


			$("#atrasDiv").click(function(){
						var anterior=$("#anterior").html();
						var actual=$("#actual").html();
						//alert("#divListas"+anterior+" #divListas"+actual);
		OcultaYMuestra("#divListas"+actual,"#divListas"+anterior);
			var NumDiv=parseInt($("#numeroDiv").val());
			
			
			switch(NumDiv){
		case  1:
		break;
		case  2:
		//alert("2");
		$("#anterior").html(actual);
		$("#actual").html(anterior);
		$("#siguiente1").html(actual);
		break;
		default://///////////////////////
		$("#actual").html(anterior);
		var penultimo=$("#siguiente"+(NumDiv-2)).html();
		$("#anterior").html(penultimo);
			var ultimo=parseInt($("#siguiente"+(NumDiv-1)).html())
				for(i=2;i<NumDiv;i++){
					var aux=parseInt($("#siguiente"+i).html())
					//alert(aux)
					if(aux==1)
						{aux=NumDiv;}
						else{aux--;}
//alert(aux)
				$("#siguiente"+i).html(aux);
									}
		$("#siguiente1").html(actual);
		
		break;
		}
			
	});
///////////////////////////////////////////////			
			
			$("#siguienteDiv").click(function(){
						var anterior=$("#anterior").html();
						var actual=$("#actual").html();
						var siguiente=$("#siguiente1").html();
	OcultaYMuestra("#divListas"+actual,"#divListas"+siguiente);
			var NumDiv=parseInt($("#numeroDiv").val());
			
			
			switch(NumDiv){
		case  1:
		break;
		case  2:
		//alert("2");
		$("#anterior").html(actual);
		$("#actual").html(anterior);
		$("#siguiente1").html(actual);
		break;
		default://///////////////////////
		$("#actual").html(siguiente);
		var ultimo=parseInt($("#siguiente"+(NumDiv-1)).html())
				for(i=1;i<NumDiv;i++){
					var aux=parseInt($("#siguiente"+i).html())
					//alert(aux)
					if(aux==NumDiv)
						{aux=1;}
						else{aux++;}
//alert(aux)
				$("#siguiente"+i).html(aux);
									}
		$("#anterior").html($("#siguiente"+(NumDiv-1)).html());
		break;
		}
			
	});

			
//////////////////////////////////////////////////				
		$("#grupo").change(function(){	
							var text1=text2=text3=""
							var p1=p2=p3=p4="";	
								if($("#grupo").val()!="none"){
								text1 = $("#grupo option:selected").text()
									p1=$("#grupo").val()
								enableDisable("","#color");
								enableDisable("","#forma");
								enableDisable("","#Tamanio");
								}else{
								$("#color").val('none');
								$("#forma").val('none');
								$("#Tamanio").val("");
								enableDisable("#color");
								enableDisable("#forma");
								enableDisable("#Tamanio");
										}
								 if($("#forma").val()!="none"){p2=$("#forma").val();
								 text2 = $("#forma option:selected").text()
								 }
								 if($("#color").val()!="none"){p3=$("#color").val();
								  text3 = "de "+$("#color option:selected").text()
								}
								  if(Trim($("#Tamanio").val())!=""){p4=$("#Tamanio").val()}
								  $("#IdArticulo").html(p1+p2+p3+p4)
								  $("#nombre_Art").val(text1+" "+text3 +" "+text2)
								    $("#describe1").val(text2+" "+text3)
							});		 
		
		$("#color").change(function(){var p1=p2=p3=p4="";	
									var text1=text2=text3=""
								if($("#grupo").val()!="none"){p1=$("#grupo").val()
								text1 = $("#grupo option:selected").text()
							
								}
								 if($("#forma").val()!="none"){p2=$("#forma").val();
								 text2 = $("#forma option:selected").text()
								 }
								 if($("#color").val()!="none"){p3=$("#color").val();
								  text3 ="de "+ $("#color option:selected").text()
								}
								if(Trim($("#Tamanio").val())!=""){p4=$("#Tamanio").val()}
								  $("#IdArticulo").html(p1+p2+p3+p4)
								   $("#nombre_Art").val(text1 +" "+text3+" "+text2)
								    $("#describe1").val(text2+" "+text3)
							});		
		
			$("#forma").change(function(){	
							var p1=p2=p3=p4="";	
							var text1=text2=text3=""
								if($("#grupo").val()!="none"){p1=$("#grupo").val()
								text1 = $("#grupo option:selected").text()
							
								}
								 if($("#forma").val()!="none"){p2=$("#forma").val();
								 text2 = $("#forma option:selected").text()
								 }
								 if($("#color").val()!="none"){p3=$("#color").val();
								  text3 = "de "+$("#cSolor option:selected").text()
								}
								if(Trim($("#Tamanio").val())!=""){p4=$("#Tamanio").val()}
								  $("#IdArticulo").html(p1+p2+p3+p4)
								   $("#nombre_Art").val(text1+" "+text3+" "+text2)
								    $("#describe1").val(text2+" "+text3)
							});	
			
			$("#Tamanio").keyup(function(){
								var p1=p2=p3=p4="";	
								//$("#grupo").val()+$("#forma").val()+$("#color").val()
								if($("#grupo").val()!="none"){p1=$("#grupo").val()}
								 if($("#forma").val()!="none"){p2=$("#forma").val()}
								 if($("#color").val()!="none"){p3=$("#color").val()}
								  if(Trim($(this).val())!=""){p4=$(this).val()}
								  $("#IdArticulo").html(p1+p2+p3+p4)
								 });			
			
	$("#bt1").click(function(){	
							 $(document).unbind('keydown');
							  $(document).keydown(function(tecla){
								var r=tecla.keyCode;
							if (r==113){
							$("#saveNew").trigger('click');}
							});	
							OcultaYMuestra("#listado",".nuevoArticulo");
							OcultaYMuestra("#Mostrar");
							OcultaYMuestra("","#botones");
							enableDisable("#enviarE");
							enableDisable("#color");
							enableDisable("#forma");
							enableDisable("#Tamanio");
							enableDisable("#cantidad");
							$("#present").val("Unidades");
							limpiaVal(".respuesta");limpiaVal(".idArticulo");limpiaHtml(".respuesta")
							});		   
			$("#bt2").click(function(){
							$(document).unbind('keydown');
						    OcultaYMuestra(".nuevoArticulo","#listado"); 
							OcultaYMuestra("#Mostrar");
							OcultaYMuestra("","#botones");
						enableDisable("#enviarE");

							});
			$("#EditarBoton").click(function(){
						   	enableDisable("",".EditRespuesta");
							enableDisable("#grupoEd");
							enableDisable("#formaEd");
							enableDisable("#colorEd");
							enableDisable("#TamanioEd");
							OcultaYMuestra("","#botones");
								enableDisable("","#enviarE");
							});
			$("#EliminarBoton").click(function(){
								if(($("#cantidadEd").val()=="0")||($("#cantidadEd").val()==0)){
								dato=$("#IdArticu").html();
								eliminar("articulo",'codigo',dato,"EliminaArt",function(){var respuesta_json = this.req.responseText;
								alert(respuesta_json)		
location.reload() })}else{alert("no se puede elimiar el articulo ya que posee existencia")}
							});
			
			  $("#saveNew").click(function(){
				var dele="no";
				if($('#autoHTML').html()=='Automatico'){
				if($("#grupo").val()!="none"){
				 if(($("#forma").val()!="none")||($("#color").val()!="none")||(Trim($("#Tamanio").val())!="")){
					dele="dele";
					 }}else{$("#grupo").focus(); }}
					 else{dele="dele"}
				if(dele=="dele")			{			   
				var query="INSERT INTO `articulo` VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				 datosJson=recogerDatos2(".respuesta")+ recogerDatos2(".idArticulo")+"respuesta="+ encodeURIComponent("nuevoArticulo")+"&query="+ encodeURIComponent(query)+"&nocache=" + Math.random();
				 $.colorbox({overlayClose:false, inline:true, href:"#loading",width:"100%", height:"100%"});
			carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
							alert(respuesta_json);
							jQuery.colorbox.close();
							if(llamado){javascript:history.back(); }else{
							location.reload()}
							});	
			
				}
				});
			$("#CancelNew").click(function(){
			if(llamado){javascript:history.back(); }else{
			limpiaVal(".respuesta");limpiaVal(".idArticulo");limpiaHtml(".respuesta")
			enableDisable("#cantidad");
			
			if($('#autoHTML').html()!='Automatico'){
				$('#codigoAutomatic').trigger("click");}}});
			
			$("#CancelEdit").click(function(){
			limpiaVal(".EditRespuesta")
			limpiaHtml(".EditRespuesta");
			  	enableDisable(".EditRespuesta","");
			OcultaYMuestra("#Mostrar","#listado"); 						
			enableDisable("#enviarE");

			});
			
				$("#enviarE").click(function(){
				
				 datosJson=recogerDatos(".EditRespuesta") + "respuesta="+ encodeURIComponent("articulo")+"&tabla="+ encodeURIComponent("articulo")+"&columna="+ encodeURIComponent("codigo")+"&nocache=" + Math.random();
				// alert(datosJson)
				 $.colorbox({overlayClose:false, inline:true, href:"#loading",width:"100%", height:"100%"});
				carga_borrarUpdate(datosJson,function(){
							var respuesta_json = this.req.responseText;
							alert(respuesta_json);
							jQuery.colorbox.close();
							location.reload()
							});	
			});
		
						  });	


