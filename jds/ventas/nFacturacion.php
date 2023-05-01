<?php include '../php/inicioFunction.php';
verificaSession_3("../../login/"); 

include_once '../db_conection.php';
 $conn= cargarBD();
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();
$cajero = $_SESSION["usuario"];

?>
<link rel="stylesheet" href="../css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/json2.js"></script>
<script type="text/javascript" src="../js/wp-nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js" language="javascript1.1" ></script>
<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script type="text/javascript" src="../jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="../jsFiles/ajax.js"></script>
<script type="text/javascript" src="../jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorContenidos.js"></script>
 <link href="../../vendor/font-awesome/css/fontawesome-all.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" >
   function NumCheck(e, field , tnum) {
  key = e.keyCode ? e.keyCode : e.which
  // backspace
  if (key == 8) return true
  // 0-9
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{2}$/
    //return !(regexp.test(field.value))
    
    return !(esEntero(field.value , tnum));
  }
  // .
  if (key == 46) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
   // return regexp.test(field.value)
    return !(esEntero(field.value , tnum));
  }
  // other key
  return false
 
}    
 

$(document).ready(function(){
		 $("#ingresar_cantidad").data('estado','disabled')
                 $("#calculadora a").data('estado','enabled')
		$("#cerrarliquidar").click(function(){//cierra la ventana de seleccion de cantidad a vender
				$("#liquidar").css("display","none");
				 $("#filasData").removeAttr('disabled');	
				 $("#calculadora").removeAttr('disabled');
				 $("#suma10").removeAttr('disabled');
				 if($("#cantidadVenta").val()!="0"){}
				 $("#cantidadVenta").val(0)	
				 $('#id_producto').focus(); 
                                $("#liquidar").find("#cantidadVenta").prop('readonly',true)
                                $("#liquidar").find("#calculadora a").prop('disabled',false)
                                 $("#ingresar_cantidad").data('estado','disabled')
				//selecciona el primer elemento input que contenga la clase gruposBT
				});	
                                
                 $("#cerrarTransformar").click(function(){//cierra la ventana de seleccion de cantidad a vender
				$("#transformar").css("display","none");
				 $("#filasData").removeAttr('disabled');  
				 $("#cantTranformada").val(0)	
                                 $("#cant_venta_tranformada").val(0)
                                 $("#cantidadVenta").val(0)
				 $('#id_producto').focus();
				//selecciona el primer elemento input que contenga la clase gruposBT
				});	
		
		$("#calculadora a").click(function(r){
			r.preventDefault();
                        var estado = $(this).data('estado')
                        if (estado == 'enabled'){
			var cadAux = '#'+Trim($(this).attr('id'))+' span'
			var venta=parseInt($("#cantidadVenta").val());
			venta=venta+parseInt($(cadAux).html());
			$("#cantidadVenta").val(venta);
			var cantActual=parseInt($("#cantActualArt").val());
			var peticionCant=parseInt($("#cantidadVenta").val());
			if(cantActual<peticionCant){
				r = confirm("Esta intentando facturar una cantidad mayor de la existencia actual del producto, presione aceptar para continuar la operacion con el valor ingresado o cancelar para facturar la existencia actual del producto");
				 	if(r==false){$("#cantidadVenta").val(cantActual);}
				}
                          $("#cantidadVenta_descontar").val($("#cantidadVenta").val())
			enviar_ventas_simple();
			$("#cerrarliquidar").trigger("click");
                    }
			
		});
		
		
		$("#guardarliquidar").click(function(e){
			e.preventDefault(); 
			if($("#cantidadVenta").val()!="0"){
                             $("#cantidadVenta_descontar").val($("#cantidadVenta").val())
                             
				enviar_ventas_simple();
				$("#cerrarliquidar").trigger("click");
				}
				else{alert('la cantidad debe ser mayor a cero (0)')}
		});
                $("#guardarTranf").click(function(e){
			e.preventDefault(); 
			if($("#cant_venta_tranformada").val()!="0"){
                                var nombre = $("#nombreProducto").val()+' medidas : '+ $('#aux_nombre_venta').val();
                                
                                $("#nombreProducto").val(nombre)
                                /*$('#cant_venta_tranformada').val(total_pies)
                                            $('#cantTranformada').val()*/
                               $("#cantidadVenta").val($("#cantTranformada").val())
                               $("#cantidadVenta_descontar").val($("#cant_venta_tranformada").val())
                               
				enviar_ventas_simple();
				$("#cerrarTransformar").trigger("click");
				}else{
                                    alert('el total en pies debe ser mayor a cero (0)');
                                }
		});
		
		$("#suma10").click(function(e){
			e.preventDefault();
			var venta=parseInt($("#cantidadVenta").val());
			venta=venta+10;			
			$("#cantidadVenta").val(venta);
		});
 $("#liquidar").find("#cantidadVenta").keyup(function(){
     
        var cont =  $(this) ;
    if (Trim($(this).val()) == '' )
    {$(this).val(0);
    return false;
        } 
   try{
    var nwCNT =  $(this).val().replace(',','.')
    
    var repetir = 0;
    for (i = 0 ; i< nwCNT.length;i++)
    {  if(nwCNT[i] == '.'){
         repetir++;   
    } 
    } 
    if (/^([0-9])*[.]?[0-9]*$/.test(nwCNT)){}else{
        $(this).val(0);
            alert('error : La cantidad digitada no es un numero valido '  );
        return false;}
    var axnwCNT
        axnwCNT =  parseFloat(nwCNT) 
       if ( nwCNT.length == 1 && repetir == 1){      nwCNT = '0.';}
    if (Number.isNaN(axnwCNT) || repetir>1) 
     throw "exite un error en la nueva cantidad " ; 
 
   $(this).val(nwCNT);
   
   }   
   catch(err){
       alert('error : ' + err );
       return false;
   }     
   
 })
 $("#ingresar_cantidad").click(function(e){
			e.preventDefault();
                        // $("#ingresar_cantidad").data('estado','disabled')
                        $("#liquidar").find("#cantidadVenta").val(0)
                        if ($(this).data('estado') == 'disabled'){
                            $(this).data('estado','enable')
                            $("#liquidar").find("#cantidadVenta").prop('readonly',false);
                                 $("#calculadora a").data('estado','disabled');
                        }else{
                            $(this).data('estado','disabled')
                            $("#liquidar").find("#cantidadVenta").prop('readonly',true);
                            $("#calculadora a").data('estado','enabled');
                        }
                        $("#liquidar").find("#cantidadVenta").focus()
			 
		});
   //$("#liquidar").find("#cantidadVenta").()
   $("#liquidar").find("#cantidadVenta")           
//ingresar_cantidad
 });	
</script>
<script src="../inicioJS/punto_de_venta.ini.js"></script>

<style>

.Estiloesne {
	font-family: "Arial Narrow";
	font-size: 16px;
}


#container{display:none}

#id_producto{text-transform:uppercase}
#calculadora > div .caption { height: 30px;}
 #calculadora > div .col-md-3 { min-width:33%;  }
  #suma_10 > div .col-md-3 { min-width:40%;  }
 
#header{
	padding:10px;
	height:60px;margin-top : 10px
}
#panelSuper > div{height:40px; float:left;margin-left:10px;}
#tabConf td{}

#cantidadVenta{height:40px; width:100%; 
}
#tabConf #nop{ background-color: #006699;}
#izquierda_div {padding:10px; }
iframe{ border:none}
 #lb_mostrar_header {  position: absolute;  z-index: 5; left: 1%; top: px; display:none   }
 #lb_quitar_header{  position: absolute;  z-index: 5; left: 1%; top: px;   }
 #busquedaArticulo{padding: 10Px; color: #ffffff; font-weight: bold; position: absolute;  left: 25%; top: 80px;  display:none}
#liquidar {padding: 10Px; font-weight: bold; position: absolute;  z-index: 5; left: 50%; top: 120px; width: 400px;
margin-left: -200px;   height: 450px; display:none}
#transformar {padding: 10Px; font-weight: bold; position: absolute;  z-index: 5; left: 50%; top: 120px; width: 500px;
margin-left: -250px;   height: 550px; display:none}
</style>
<body> 
 
    <input type="hidden" value="" id="aux_nombre_venta">
    <input type="hidden" value="" id="cantidadVenta_descontar">
  <div id="container" style = 'width:100%;height:100%;margin:0px;'>
 <div  class="panel panel-default" style ='width:100%;height:100%'>
  <div class="btn-toolbar" role="toolbar" aria-label="..."style=" width:100%; margin:10px;" id='panelSuper'>

 
        
<table width="1000" border="0" align="center" style="width:95%">
  <tr>
   <td colspan="6">
   
<table width="200" border="0" align="right">
  <tr align="center">
    <td><input type="image" src="../imagenes/cliente_saltando.png" height="30" title="cambiar el cliente" id="cambiaCliente" ></td>
    <td><input type="image" src="../imagenes/icono_acceso_usuario.png" height="30" title="cambiar el cajero" id="cambiaCajero" ></td>
    <td><input type="image" src="../imagenes/cierre_de_caja.png" height="30" title="CIERRE DE CAJA" id='btn_cierreCaja'></td>
    <td><input type="image" src="../imagenes/monedero_1.png"  height="30" title="ABRIR CAJON" id="abrirCajon"></td>
  </tr>
</table>
</td>

  <tr>
    <td width="54"><span class="Estiloesne"><strong>Cliente:</strong></span></td>
    <td width="248"><span id='nombre_cliente' class="Estiloesne"></span></td>
    <td width="106"><span class="Estiloesne"><strong>Tipo de venta:</strong></span></td>
    <td> <select class="form-control" id="sel_tipoVenta" style=" width:150px ">
          <option value="EFECTIVO">De contado</option>
          <option value="CREDITO">A credito</option>
          <option value="ELECTRONICA">Con datafono</option>
      </select></td>
    <td><div class="input-group" style="max-width:280px" >      
    <input id='id_producto' type="text"  class="form-control" placeholder="ingresar producto..." autofocus>
	  <span class="input-group-btn">
        <button class="btn btn-default" type="button" id='enviarIdProducto'>
				 <span class="glyphicon glyphicon-check" aria-hidden="true"></span>_
		</button>
      </span>
	   <span class="input-group-btn">
        <button class="btn btn-default" type="button" id='inicioBuscar'>
				 <span class="glyphicon glyphicon-search" aria-hidden="true"></span>_
		</button>
      </span>
    </div>	 </td>
   
  </tr>
   
  </tr>
</table>
					
	<span id='N_cajero' class="hidden"><?php echo $cajero;?></span> 
  </div> 
<div style='width:100%; float:right;     padding-left: 5%;
    padding-right: 5%;' >
<iframe name='frame_facturas' id='frame_facturas' src='facturacion.php' height="100%" width = '100%'></iframe>
</div>   

 
</div>
</div>
<style>
#mod_Cajero{width : 100%; height:100%;  margin : 0px ;
background: url("../imagenes/fondo_1.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
display:none
 }
#cont_mod_cajero{width : 100%; height:100%; background-color:black; margin : 0px ; opacity: 0.5; }
#mod_insert_cajero {  position: absolute;   left: 50%;margin-left : -250px; top: 160px; width: 500px; opacity: 1;}
#respuestaOK {  position: absolute;   left: 50%; top: 60px; width: 500px; opacity: 1;}
</style>

<title>facturar</title>

<input type='hidden' id='IdVenta'/>
<input type='hidden' id='activaContainer'  />
<input type='hidden' id='llamado'  />
<input type='hidden' id='IdCliente_venta' value=''  />
<style>
#mod_usuario{width : 100%; height:100%;  margin : 0px ;
background: url("../imagenes/fondo_1.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

 }
#cuerpo_cliente{display:none}
#cont_mod_usuario{width : 100%; height:100%; background-color: #FFFFFF; margin : 0px ; opacity: 0.0; }
#mod_insert_user {   position: absolute;   left: 50%;margin-left : -250px; top: 160px; width: 500px; opacity: 1;display:none}
</style>
<div id='ContBusquedaPersonas'></div>
<div id='mod_usuario'>
<div id='cont_mod_usuario'> </div>
	<div class="alert alert-danger" role="alert" id='mod_insert_user'>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
Registro del Cliente
  
  <table class='table' >

  <tr>
 <td>
  <div class="input-group" style='max-width:300px'>
  <span class="input-group-addon" id="basic-addon1">CC/NIT/TI...</span>
  <input type="text" class="form-control" id='mod_id_cliente' placeholder="Identificacion" aria-describedby="basic-addon1"  onkeypress="validar(event)" >
</div>
    </td>
	
	<td><button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='(enter) ingresar/crear cliente' id='enterBtn'>
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
</button> </td>
 <td>
    <?php agregarBusquedaPersonas('cliente','contenedor',[
    "css" => "display:none;" ,
    "tBtn" => "2",
    "idRespuestaAux" =>"mod_id_cliente",    
    "trigger" =>"enterBtn",  
        "mostrar"=>"mod_insert_user"  
         ],'N','2');?>    
        </td>
  </tr>
  

  <tbody id='cuerpo_cliente'>
<tr>
 <td>
  <div class="input-group" style='max-width:300px'>
  <span class="input-group-addon" id="basic-addon1">Id_cliente</span>
  <input type="text" class="form-control" id='id_tabla_cliente' placeholder="" aria-describedby="basic-addon1" disabled>
</div>
    </td>  </tr>
  <tr>
   <td colspan='2'>
  <div class="input-group"  style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Nombre Completo</span>
  <input type="text" class="form-control" placeholder="Nombre & apellido" aria-describedby="basic-addon1" id='auxNombre'>
</div></td>
   
  </tr>
  
  <tr>
   <td colspan='2'>
  <div class="input-group"  style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Telefono</span>
  <input type="text" class="form-control" placeholder="Telefono" aria-describedby="basic-addon1" id='auxTelefono'>
</div></td>
   
  </tr>
  <tr>
   <td colspan='2'>
  <div class="input-group" style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Mail</span>
  <input type="text" class="form-control" placeholder="Correo Electronico" aria-describedby="basic-addon1" id='auxEmail'>
</div></td>
  
  </tr>
    <tr>
   <td colspan='2'>
  <div class="input-group" style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Direccion</span>
  <input type="text" class="form-control" placeholder="Direccion" aria-describedby="basic-addon1" id='auxDireccion'>
</div></td></tr>

</tbody>
  </table>
</div>
</div>
<div id='mod_Cajero' >

<div id='cont_mod_cajero'> </div>


	<div class="alert alert-danger" role="alert" id='mod_insert_cajero'>
  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
Loguin Vendedor<br/>

<div class="input-group" style='width:100%'>
  <input type="text" class="form-control" placeholder="Usuario" aria-describedby="basic-addon1" id='auxUsuario'>
</div>
<br/>
<div class="input-group" style='width:100%'>
  <input type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1" id='auxClave'>
</div>
<br/>
<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='aceptar cambio' id='aceptar_cajero'>
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span> aceptar
</button>
<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='cancelar cambio' id='Ccambio_cajero'>
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span> cancelar
</button>
</div></div>
  
  <div id="busquedaArticulo" class="panel panel-default" style="width:650px; height:500px">
  <div class="panel-heading">
					<strong>Busqueda</strong><span class="glyphicon glyphicon-remove" aria-hidden="true" style='float:right; cursor:pointer' id="cerrarBuscar"  title="cerrar" ></span>
				  </div>
				  <div class="panel-body">
	<button type="button" class="btn btn-default" aria-label="Left Align" id='limpiar'>
	  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	</button>
<div style='width : 80%; float:left'>
	<div class="input-group">
	  <span class="input-group-addon" id="basic-addon1">BUSQUEDA : </span>
	  <input type="text" class="form-control" placeholder="Busca Productos" aria-describedby="basic-addon1" id="busqueda">
	</div>
</div>
	
<iframe id="frameBusqueda" align="top" style="border:none" src="" height="80%" width="100%"></iframe>
</div></div>
	
<div class="panel panel-info" id="liquidar" >
<div class="panel-heading" style='height:80px'>
<div style='float:left'>Selecione la Cantidad </div>
<div style='float:right; margin-right: 10px'>
<button type="button" class="btn btn-default" id='cerrarliquidar'   >
<span  class="glyphicon glyphicon-remove"  aria-hidden="true"  ></span>
</button></div>
<div style='float:left' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='nomProducto'></span></div>
   <div style='float:left' id='areaDescripcionProducto'>Precio :&nbsp;<span id='Ps_IVA'></span>
    
<button type="button" class="btn btn-default" id='cambiarPrecio'   >
<span  class="glyphicon "  aria-hidden="true"  ></span>$
</button> 
   
   &nbsp;|&nbsp;IVA :&nbsp;<span id='_IVA'></span>&nbsp;|&nbsp;Total :&nbsp;<span  id='pVenta'></span></div> 
  
</div>
 <div class="panel-body">
 <div class="panel-heading">
  
  <input value="0" id="cantidadVenta" type="text"  onkeypress="return NumCheck(event, this,'float')"  style='width:100%'>
    </div>
<div id='calculadora'>
  <div class="row">
  <div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_1'>
     <div class="caption">
        <span>1</span>     
      </div>
    </a></div><div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_2'>
     <div class="caption">
        <span>2</span>     
      </div>
    </a></div><div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_3'>
     <div class="caption">
        <span>3</span>     
      </div>
    </a></div>
</div>
<div class="row">
  <div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_4'>
     <div class="caption">
        <span>4</span>     
      </div>
    </a></div><div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_5'>
     <div class="caption">
        <span>5</span>     
      </div>
    </a></div><div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_6'>
     <div class="caption">
        <span>6</span>     
      </div>
    </a></div>


</div>
<div class="row">
  <div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_7'>
     <div class="caption">
        <span>7</span>     
      </div>
    </a></div><div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_8'>
     <div class="caption">
        <span>8</span>     
      </div>
    </a></div><div class="col-md-3" >
  <a href="#" class="thumbnail" id='btn_9'>
     <div class="caption">
        <span>9</span>     
      </div>
    </a></div>


</div></div>
<div class="row" id='suma_10'>
 <div class="col-md-3" >
  <a href="#" class="thumbnail" id="suma10">
     <div class="caption">
        <span>+10</span>     
      </div>
    </a></div>
     <div class="col-md-3" >
  <a href="#" class="thumbnail" id="ingresar_cantidad">
     <div class="caption">
        <span><i class="fal fa-calculator"></i></span>     
      </div>
    </a></div>
	<div class="col-md-5" id=''>
  <a href="#" class="thumbnail" id="guardarliquidar">
     <div class="caption">
        <span>OK</span>     
      </div>
    </a></div>


</div>
 
  
  </div>
</div>


<div class="panel panel-info" id="transformar" >
<div class="panel-heading" style='height:80px'>
<div style='float:left'>Selecione la Cantidad </div>
<div style='float:right; margin-right: 10px'>
<button type="button" class="btn btn-default" id='cerrarTransformar'   >
<span  class="glyphicon glyphicon-remove"  aria-hidden="true"  ></span>
</button></div>
<div style='float:left' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='nomProducto'></span></div>
   <div style='float:left' id='areaDescripcionProducto'>Precio :&nbsp;<span id='Ps_IVA'></span>
    
<button type="button" class="btn btn-default" id='cambiarPrecio_tf'   >
<span  class="glyphicon "  aria-hidden="true"  ></span>$
</button> 
   
   &nbsp;|&nbsp;IVA :&nbsp;<span id='_IVA'></span>&nbsp;|&nbsp;Total :&nbsp;<span  id='pVenta'></span></div> 
  
</div>
 <div class="panel-body">
 <div class="panel-heading">
  
     <input type="number" value="0" id="cantTranformada" onKeyPress="return valida_numeros(event)"  style='width:100%'>
    </div> 
     <table>
         <tr>
             <td >
                 <table style="width:100%">
                     <tr>
                         <td style="    text-align: left;"><button class="flechas_medidas" data-movimiento="atras" data-numero="1">&lt;&lt;</button></td>
                         <td style="    text-align: -webkit-center;"><span class="contador_contenedores">1</span></td>
                         <td style=" text-align: right; "><button class="flechas_medidas" data-movimiento="adelante" data-numero="1">&gt;&gt;</button></td>
                     </tr>
                     
                      </table>
                  
             </td>
             <td style=" padding:10px; vertical-align: text-top;" > </td>
         </tr>
         <tr><td id="cont_lista_medidas">
             
             </td>
             <td style=" padding:10px; vertical-align: text-top;" >total pies<br> <input type="text" readonly="" id="cant_venta_tranformada" value="0">
                                    
                                                    </td></tr>
     </table>
<div class="row"  > 
	<div class="col-md-7" id=''>
  <a href="#" class="thumbnail" id="guardarTranf">
     <div class="caption">
        <span>OK</span>     
      </div>
    </a></div>


</div>
 
  
  </div>
</div>



<input type="button" class="hidden" onClick="listar_tipos_medidas()" id="generar_tipos_medidas" >
<input type='hidden' value='M1' id='modulo'/>
<input type='hidden' id='cantActualArt'/>
	<input type='hidden' id='idProducto'>
					<input type='hidden' id='nombreProducto'/>
					<input type='hidden' id='presioVenta' data-preventa=""/>
					<input type='hidden' id='PsIVA'/>
					<input type='hidden' id='IVA'/>
					<input type='hidden' id='porcent_iva'/>
<input type='hidden' id='PCname' value='<?php echo php_uname('n');?>' />

<body>