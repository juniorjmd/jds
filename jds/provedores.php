<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
$backDir="index.php";
if($_GET['llamado']){$backDir="compras.php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>proveedores...</title>
<link media="screen" rel="stylesheet" href="css/container.css" />
<link media="screen" rel="stylesheet" href="css/estilo.css" />
<link media="screen" rel="stylesheet" href="css/menuDesplegable.css" />

<style >
#Nuevo #Ncontainer{position:relative;display:block;margin:auto;overflow:visible;width:100%;z-index:1;background-color:#FFF; padding:3%}
#Nuevo #Ncontainer{box-shadow:0 2px 10px #aaa;-moz-box-shadow:0 2px 10px #aaa;-webkit-box-shadow:0 2px 10px #aaa}
			.cabeza{color:#CC9933; font-size:12px}
			.respuesta{color:#0000FF; font-size:14px}
#Mcontainer{position:relative;display:block;margin:auto;overflow:visible;width:100%;z-index:1;background-color:#FFF; padding:3%}
#botones{ margin-right:10%;}
#Mcontainer{box-shadow:0 2px 10px #aaa;-moz-box-shadow:0 2px 10px #aaa;-webkit-box-shadow:0 2px 10px #aaa}
			.cabeza{color:#CC9933; font-size:12px}
			.respuesta{color:#0000FF; font-size:14px}
			div{ border:#666666  thin ;}
#menu{width:90%;  margin-left:5%; }
#tablasListasucursales tr:hover{ background-color: #80CDF7}
</style>

<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="jsFiles/listas.js"></script>
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>

</head>

<body><br />
<div id="container"  >
  <div id="menu" ><?php 
	   echo'<input name="button" type="button" class="button small blue"  id="bt1" value="Crear Nueva" style=" margin-top:30px; margin-bottom:10px"/>';
	   ?>
	   Buscar
      <input name="text" type="text" class="busquedas" width="400" data-invoker='proveedores' /><a href="<?php echo $backDir; ?>">
      <img  src="imagenes/images (1).jpg" width="50" height="30" style="margin-left:0px; " title="inicio/menu principal"/></a>
  </div>
 
    <div id="listado" style="padding:3%; height:350px;overflow:auto" > 
      <table border="0" id=" Tablasucursales" width="100%">
        <tr>
          <td><table  border="0" id="listarTablasucursales" width="100%"    >
            <tr  id="cabPac" align="center"   class="ui-widget-header">
              <td width="50"  >ID</td>
              <td width="100"  >NIT/CEDULA</td>
               <td width="150"  >NOMBRE</td>
               <td width="150"  >RAZON SOCIAL</td>
              <td width="100" >TELEFONO</td>
             <td   width="230">DIRECCION</td>
              <td   width="230">E-MAIL</td>
            </tr>
            <tr>
              <td colspan="7"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><div align="center" id="tablasListaproveedores" ></div>
            <div align="center" id="indiceListaproveedores" ></div></td>
        </tr>
      </table>
      <br />
      <br />
    </div>
    <div id="Nuevo" > <br />
      <br />
      <div id="Ncontainer" >
        <div id="Nheader"><div align="left" style="">
        <label class="cabeza" >ID</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="respuesta" id="idCliente" ></label>  <input name="saveNew" type="button" class="button small blue"  id="saveNew" value="Enviar" style="margin-left:500px"/>
          <input name="CancelNew" type="button" class="button small blue" id="CancelNew" value="Cancelar"/> </div>
          
          
          <br /><div align="left" style=""> <label  class="cabeza">Nombre</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="respuesta" id="Nnombre" style="width:20%"/> &nbsp;&nbsp;<label  class="cabeza">Nit/CC</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="respuesta" id="nit" style="width:10%"/> &nbsp;&nbsp;  <label  class="cabeza">Razon Social</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="respuesta" id="NrazonSocial" style="width:20%"/>
        </div><br />
        
       
          <div align="left" style=" width:100%">
            <label class="cabeza" >email</label>
            &nbsp;&nbsp;
            <input name="text" type="text"  class="respuesta" style="width:15%" id="email"/>
            <label class="cabeza" style="margin-left:5%" >telefono</label>
            &nbsp;&nbsp;
            <input name="text" type="text"class="respuesta" id="telefono" style="width:10%"/>  &nbsp;&nbsp;
            <label class="cabeza" >Direccion</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="respuesta" style="width:35%" id="direccion"/>
          </div>
          
          </div>
         </div>
       </div>
      
  
    <div id="Mostrar"  > <br /><br />
      <div id="Mcontainer" >
        <div id="Mheader">
          <div align="left" >
            <label class="cabeza" >ID</label><label class="lbrespuesta" id="IdClienteM"></label>  &nbsp;&nbsp;<img src="imagenes/ui-icons_lapizNEGRO.png" width="18" height="19" title="Editar"  id="EditarBoton" style="cursor:pointer" /><img  src="imagenes/basureroNEGRO.jpg" width="18" height="19" title="Eliminar"  id="EliminarBoton" style="cursor:pointer" />
           &nbsp;&nbsp;
           <input type="image" src="imagenes/accept (2)negro.png" width="30" height="30" title="Editar"  id="saveEdicion" style="  margin-left:20px" />&nbsp;&nbsp; <input type="button" id="creditos" value="Creditos"/>
          
           </div><br />
           <div align="left"> <label  class="cabeza">Nombre</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" id="nombre" style="width:20%"/> &nbsp;&nbsp;<label  class="cabeza">Nit/CC</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" id="Nit" style="width:10%"/> &nbsp;&nbsp;  <label  class="cabeza">Razon Social</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" id="Rsocial" style="width:20%"/>
        </div><br />
        
       
          <div align="left" style=" width:100%">
            <label class="cabeza" >email</label>
            &nbsp;&nbsp;
            <input name="text" type="text"  class="Mrespuesta" style="width:15%" id="email"/>
            <label class="cabeza" style="margin-left:5%" >telefono</label>
            &nbsp;&nbsp;
            <input name="text" type="text"class="Mrespuesta" id="telefono" style="width:10%"/>  &nbsp;&nbsp;
            <label class="cabeza" >Direccion</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" style="width:35%" id="direccion"/>
          </div>
          
         
        </div>
        
      </div>
      </div>
 
</div>
<script type="text/javascript" >
$(document).ready(function(){
	$("#creditos").click(function(){
				if(Trim($("#IdClienteM").html())!=""){
					//alert($("#IdClienteM").html());
					 window.location="listadoCreditosProveedor.php?tabla1=proveedores&idCliente="+Trim($("#IdClienteM").html())+"&tabla2=credito&dir=estadoCredito.php"
					}
				})
	
			OcultaYMuestra("#Nuevo");
			enableDisable(".Mrespuesta");
			enableDisable("#saveEdicion");
			inicioListar('proveedores',list_res_prov);
			crearId('proveedores',"#idCliente",null , 'idCliente')
			$("#bt1").click(function(){
							crearId('proveedores','#idCliente', null , 'idCliente')	
							OcultaYMuestra('','#Nuevo');
							OcultaYMuestra('#Mostrar');
							OcultaYMuestra('','#botones');
							enableDisable('#enviarE');
							$('#Nnombre').focus()
							});	
			$('#Nnombre').keyup(function(){$("#NrazonSocial").val($(this).val());});
				
			$("#EditarBoton").click(function(){
						   	if (Trim($("#IdClienteM").html())!=""){
								enableDisable("",".Mrespuesta");
							enableDisable("","#saveEdicion");
							$("#saveEdicion").attr('src', 'imagenes/accept (2).png');
								}
							
							});
			$("#EliminarBoton").click(function(){
								if (Trim($("#IdClienteM").html())!=""){
								dato=$("#IdClienteM").html();
								eliminar("proveedores",'idCliente',dato,"EliminaCliente",function(){var respuesta_json = this.req.responseText;
																									crearId('proveedores',"#idCliente",null , 'idCliente');
																									OcultaYMuestra("#Nuevo");
																									enableDisable(".Mrespuesta");
																									enableDisable("#saveEdicion");
																									inicioListar('proveedores',list_res_prov);
																									limpiaVal(".Mrespuesta");
																									limpiaHtml(".lbrespuesta");
																									$("#EliminarBoton").attr('src', 'imagenes/basureroNEGRO.jpg');
			$("#EditarBoton").attr('src', 'imagenes/ui-icons_lapizNEGRO.png');
	
																									
																									})}
							});
			
			$("#saveNew").click(function(){
                              
                                if($('#Nuevo').find('#nit').val()==''){
                                    alert('El Nit es de caracter obligatorio');
                                    $('#Nuevo').find('#nit').focus();
                                    return;
                                }
				var query="INSERT INTO `proveedores` VALUES (?,?,?,?,?,?,?)";
				 datosJson=recogerDatos(".respuesta")+ "respuesta="+ encodeURIComponent("nuevoProvedor")+"&query="+ encodeURIComponent(query)+"&nocache=" + Math.random();;
				//alert(datosJson)
				carga_insert(datosJson,function(){
							var respuesta_json = this.req.responseText;
                                                        alert(this.req.responseText);
							crearId('sucursales',"#IdSucursal",null , 'id_suc');
							inicioListar('proveedores',list_res_prov);
							OcultaYMuestra("#Nuevo","#Mostrar");
							limpiaVal(".respuesta");
							limpiaVal(".Mrespuesta");
							limpiaHtml(".lbrespuesta");
							$("#EliminarBoton").attr('src', 'imagenes/basureroNEGRO.jpg');
							$("#EditarBoton").attr('src', 'imagenes/ui-icons_lapizNEGRO.png');
							//alert(respuesta_json);
							});	
				
				});
			$("#CancelNew").click(function(){
			limpiaVal(".respuesta")
			OcultaYMuestra("#Nuevo","#Mostrar");
			});
			
			$("#saveEdicion").click(function(){
				if($('#Mheader').find('#Nit').val()==''){
                                    alert('El Nit es de caracter obligatorio');
                                    $('#Mheader').find('#Nit').focus();
                                    return;
                                }
				 datosJson=recogerDatos(".Mrespuesta")+recogerDatos(".lbrespuesta") + "respuesta="+ encodeURIComponent("cliente")+"&tabla="+ encodeURIComponent("proveedores")+"&columna="+ encodeURIComponent("idCliente")+"&nocache=" + Math.random();
				//alert(datosJson)
				carga_borrarUpdate(datosJson,function(){
							var respuesta_json = this.req.responseText;
							inicioListar('proveedores',list_res_prov);
							OcultaYMuestra("#Nuevo","#Mostrar");
							enableDisable(".Mrespuesta","");
						enableDisable("#saveEdicion");
						$("#saveEdicion").attr('src', 'imagenes/accept (2)negro.png');
							//alert(respuesta_json);
							});	
			});
		
						  });	



</script>
</body></html>

