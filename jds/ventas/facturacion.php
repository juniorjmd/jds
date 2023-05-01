<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$mysqli = cargarBD(); 

include '../php/funcionesMysql.php';


 //$user = cargaDatosUsuarioActual();
$retefuente_ventas =$_SESSION['retefuente_aplica_ventas'];
$total=0;
$ivaVendido=0;
$subtotal=0;
if(isset($_POST['codMesa'])){$codMesa=$_POST['codMesa'];}else{$codMesa='M1';}//optiene el modulo activo donde se realiza la impresion de la factura.
if(isset($_POST['codtipFactura'])){$codtipFactura=$_POST['codtipFactura'];}else{$codtipFactura='1';}//optiene la tabla donde se va ingresar
switch($codtipFactura)
{
	case '1':
		$tabla = 'ventas' ; 
		break;
	case '2':
		$tabla = 'remision' ;
	break;
}


echo "<script> var tip_retefuente = '".TIPO_RETEFUENTE_VENTAS."' ; "
        . "var valor_retefuente = '".PORCENT_RETEFUENTE_VENTA."' ;"
        . "</script>";
        
$ventaActual= 0;
 $row =  genear_consecutivo($_SESSION["ID"],'M1',$mysqli);  
	// print_r($row);
	$ventaActual=$row['id_venta_generado'];
        $cod_factura=$row['cod_factura'];
        //echo $ventaActual.'<br>'; 
echo 'factura No. ';          
echo str_pad($ventaActual, 10, "0", STR_PAD_LEFT); 
$codCiente="";
$razonSocial="";
$id_Ciente="";
$query="SELECT  tc.razonSocial as rSocial, tvc.idCliente as idCliente , tc.nit as nit from clientes tc inner JOIN ventacliente tvc
ON tc.nit = tvc.idCliente  where tvc.idVenta = '".$cod_factura."'";


$mysqli = cargarBD();
$result2 = $mysqli->query($query);
$datosNum = $result2->num_rows;
 
if($datosNum>0){ 
while ($row = $result2->fetch_assoc()) {
	$razonSocial=$row['rSocial'];
	$codCiente=$row['idCliente'];
	$id_Ciente=$row['nit'];
	}
}
$query="SELECT * FROM  `ventastemp` WHERE  `idVenta`='".$cod_factura."' ORDER BY  `ventastemp`.`idLinea` ASC ";
        
$cantVendida = 0;
$html='';
$result = $mysqli->query($query);

$datosNum=$result->num_rows;

if($datosNum>0){
        
$idLineaAux="";
while ($row = $result->fetch_assoc()) {
	if($idLineaAux!=$row["idLinea"])
	{$img='<span class="glyphicon glyphicon-remove" style=" cursor:pointer" aria-hidden="true" id="'.$row["idLinea"].'"></span>';}
	else{$img="";}$idLineaAux=$row["idLinea"];
	$tSinIVA= ($row["presioSinIVa"]*$row["cantidadVendida"]);
	$html=$html.'<tr>
<td>'.$img.'</td>
<td  colspan="2">'.$row["nombreProducto"].'</td>
<td align="center">'.$row["cantidadVendida"].'</td>
<td align="right">'.amoneda($row["presioSinIVa"], pesos).'</td>	
<td align="right">'.amoneda($tSinIVA, pesos).'</td>	

</tr>';
$totalArt=$totalArt+ $row["cantidadVendida"] ;
$subtotal=$subtotal+$tSinIVA;
$valorIva=$row["porcent_iva"]/100;
	$IVA=round($tSinIVA*$valorIva, 2);
$ivaVendido=$ivaVendido+$IVA;
$total=$total+$row["valorTotal"];
	}}

?>
<style>
.cierreVentana { 
background: #CCC;
position: absolute; top: 0; left: 0; height: 100%;
width:100%;
}
 
</style>
<input type="hidden" value="<?php echo $retefuente_ventas;?>" id="retefuente_ventas">
<div id='cuerpoFactura'>
<table  width="90%" class="table" style='font-size:11px' id='tabla_factura' >
<tr><td width='10px'></td>
    <td colspan='2'>descripcion </td> <td style=" text-align: center"> cant </td> 
    <td width='100px'  style=" text-align: center"> precio unidad </td> <td width='100px'  style=" text-align: center"> precio total </td> 
</tr>

<?php echo $html; ?>
<tr>
<td colspan='3'  style='margin-right:10px'><span >subtotal<span> </td> <td></td><td  align='right' colspan='2'> <?php echo amoneda($subtotal, pesos); ?> </td> 
</tr>
<tr>
<td colspan="3" style='margin-right:10px'>iva </td> <td></td><td align='right' colspan='2'> <?php echo amoneda($ivaVendido, pesos); ?> </td>
 </tr>
<tr>
<td colspan='3' style='margin-right:10px'>descuento</td> <td  align='right'>
<span class="glyphicon glyphicon-pencil"   style=" cursor:pointer" aria-hidden="true" id="chg_descuento"></span>
<img src='../imagenes/porcentaje.png' width='10px' style=" cursor:pointer" id='calcual_descuento' >
</td><td  align='right'  colspan='2'>
<label id='descuento' >$ 0.00</label></td>
</tr>
<tr>
<td colspan='3' style='margin-right:10px'>total </td> <td  align='right' colspan='3' > <span id='aux_total_venta'><?php echo amoneda($total, pesos) ; ?> </span></td>
</tr>
<tr> 
</tr>
</table>
<br>
<div align='right' width="90%">
<button type="button" class="btn btn-default" aria-label="Left Align" id='facturar'>
	  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Facturar
	</button> 
	<button type="button" class="btn btn-default" aria-label="Left Align" id='cancelar'>
	  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
	</button>
	</div>

<input type='hidden' value='M1_<?php echo $ventaActual; ?>' id='id_venta_actual'>
<input type='hidden' value='<?php echo $razonSocial; ?>' id='cliente_hidden'>
<input type='hidden' value='<?php echo $codCiente; ?>' id='cliente_id'>
<input type='hidden' value='<?php echo $subtotal; ?>' id='subtotal'>
<input type='hidden' value='<?php echo $totalArt; ?>' id='cantVendida'>
<input type='hidden' value='<?php echo $ivaVendido; ?>' id='ivaVendido'>
<input type='hidden' value='<?php echo $total; ?>' id='total_venta'>
<input type='hidden'value='0' id='descuento_fnal'>
</div>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>

 

<script language="javascript1.1" src="../jsFiles/trim.js" type="text/javascript"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<script src="../bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script language="javascript1.1" type="text/javascript">
     var paga_retefuente = 'N';
     var retefuente_ventas;
 $(document).ready(function(){
     cargar_modal_retefuente_variable()
    
	 padre = $(window.parent.document);
       abuelo = padre.find(window.parent.document)
 $(padre).find("#nombre_cliente").html($('#cliente_hidden').val())
 $(padre).find("#IdVenta").val($('#id_venta_actual').val())
  $(padre).find("#IdCliente_venta").val($('#cliente_id').val())
  OcultaYMuestraPadre("#cuerpo_cliente");
 // alert($('#cliente_id').val())
  if($('#cliente_id').val()==''){
OcultaYMuestraPadre("#container","#mod_usuario");
 OcultaYMuestraPadre("","#mod_insert_user");
$(padre).find("#mod_id_cliente").focus();}
else{OcultaYMuestraPadre("#mod_usuario","#container");

}

 $(padre).find("#muestaFactura").remove();
 
$(padre).find("#devolucion").remove();
$(padre).find("body").append("<div id='devolucion' style='border-style: solid; padding:15 ; margin-right:-125;right:50%;top:10%; background-color:#FFFFFF; width: 250px;  display:none; font-weight: bold; position: absolute; ' >"+
	"Valor Venta : <span id='valorVentaAux'></span><br>"+
"Dinero Ingresado <input id='monIngresado' type='number'/><br>"+
"Total Devolucion : <span id='valorDevolver'></span></div>")
 
 $(padre).find("#cont_venta_credito").remove();
$(padre).find("body").append("<div id='cont_venta_credito' style='border-style: solid; padding:15 ; margin-right:-200;right:50%;top:10%; background-color:#FFFFFF; width: 400px;  display:none; font-weight: bold; position: absolute; ' >"+
	"<table><tr><td style='height: 40px;'>Valor Venta : </td><td><input id='vventacxc' readonly /></td></tr>"+
"<tr><td style='height: 40px;'>Abono inicial</td><td><input id='aux_abono_inicial_vc' type='number'/></td></tr>"+
"<tr><td style='height: 40px;'>Tipos de pagos</td><td><select id='aux_intervalo_pagos' class='NewCartera' style='visibility: visible; width:100%'>"+
"<option value=''>--</option>"+
"<option value='8'>semanal(8 dias)</option>"+
"<option value='15'>Quincenal(15 dias)</option>"+
"<option value='30'>Mensual(30 dias)</option>"+
"<option value='45'>mes y medio(45 dias)</option>"+
"<option value='60'>Bimestral</option>"+
"<option value='90'>Timestral</option>"+
"<option value='180'>Semestral</option>"+
"<option value='365'>Anual</option>" +
"</select></td></tr>"+
"<tr><td style='height: 40px;'>Numero de cuotas : </td><td><input id='aux_num_cuotas' type='number'/></td></tr>"+
"<tr><td style='height: 40px;'></td><td><button id='enviar_venta_credito' style='height: 100%;border:none'><img src='../imagenes/accept (2).png' alt='enviar' style='height: 50px;'></button><button class='cancela_venta' style='height: 100%;border:none' data-padre='#cont_venta_credito'><img src='../imagenes/equis_naranja.gif' alt='enviar'/></button></td></tr></table></div>"
)

$(padre).find('#enviar_venta_credito').unbind('click').click(function(){
  if($(padre).find('#aux_abono_inicial_vc').val()==''  || $(padre).find('#aux_abono_inicial_vc').val()< 0){
      $(padre).find('#aux_abono_inicial_vc').val(0)
  }   
  if($(padre).find('#aux_intervalo_pagos').val()== ''  ){
      alert('Debe seleccionar el intervalo en que se realizaran los pagos (tipos de pago)')
      $(padre).find('#aux_intervalo_pagos').focus();
            return;}   
   if($(padre).find('#aux_num_cuotas').val()==''  || $(padre).find('#aux_num_cuotas').val()< 0){
      alert('Debe ingresar el número de cuotas del credito y este debe ser mayo a 1')
      $(padre).find('#aux_num_cuotas').focus();
            return;} 
       var v_total_venta = $('#total_venta').val()
       
       $(this).parent().find('.cancela_venta').trigger('click')
   ejecutar_cierre_ventas(v_total_venta, 0 , 0);  
})


$(padre).find('.cancela_venta').unbind('click').click(function(){
    var aux_p = $(this).data('padre')
    OcultaYMuestraPadre(aux_p,"#container");
})


//alert( $('#id_venta_actual').val())
 $('#cancelar').click(function(){
	 $('#id_venta_actual').val()
	 //cancelarVenta.php
	  var dato=$('#id_venta_actual').val();
	r = confirm("REALMENTE DESEA ELIMINAR ESTA VENTA");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
			+'&eliminar_venta='+encodeURIComponent(true)
		 
	$.ajax({
			url: 'cancelarVenta.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
				//alert(responseText)
			location.reload();
			}
		});
	 }
	 
 })

 $('#tabla_factura span').click(function(){	 
	 var dato=$(this).attr("id");
	if( dato != 'chg_descuento'){
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("ventastemp")
		  +"&restablecer="+encodeURIComponent(" ")
		  +"&columna="+encodeURIComponent('idLinea');
	$.ajax({
			url: '../EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//$('#frame1').attr('src',$('#frame1').attr('src'));
			location.reload();
			}
		});
	 }	} })
 
 var v_tipoVenta ,v_total_venta, v_abonoInicial , VAUCHE;
$('#facturar').click(function(){ 
	 v_total_venta = $('#total_venta').val()  
	 v_tipoVenta = $(padre).find("#sel_tipoVenta").val() 
	  VAUCHE = '';
           v_abonoInicial = 0; 
	 if (v_total_venta !="" && v_total_venta != 0 &&  v_total_venta != '0' ){
              retefuente_ventas = $('#retefuente_ventas').val()
              paga_retefuente = 'N';
            if(retefuente_ventas == 'S'){
                var p = confirm('¿Desea el proveedor aplicar retefuente?\n\r     Si(Aceptar) - No(Cancelar) ');
               if (p){paga_retefuente = 'S';}
           } 
           if ( tip_retefuente !='F' && paga_retefuente == 'S' ){
               $('#miRetefuente').html(valor_retefuente)
               $('#retefuente_nueva').val(valor_retefuente)
               
               $(retefuentevarible).trigger('click')
           }else{
             continuar_cierre_ventas( padre , v_tipoVenta ,v_total_venta, v_abonoInicial , VAUCHE ) 
         }
         }
    
    })
    
$('#enviarVentaRetefuente').click(function(){
    continuar_cierre_ventas( padre , v_tipoVenta ,v_total_venta, v_abonoInicial , VAUCHE ) 
})
$('#chg_descuento').click(function(){
	var v_descto; 
		do {
		v_descto= prompt("POR FAVOR INTRODUSCA EL VALOR DEL DESCUENTO");}
		while (Trim(v_descto) == ""&&v_descto!=null);
		if (v_descto == null)
		{v_descto=0}
			var total_final = parseFloat($('#total_venta').val() ) - v_descto
		$('#descuento_fnal').val(v_descto)
		var datosAjax = {
		datosConvertir : [v_descto,total_final]};
		
		$.ajax({url: 'aplicar_formato_pesos.php',  
				type: 'POST',
				async: true,
				data: datosAjax,
				dataType: "json",
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
				success: function(responseText){
				//alert(JSON.stringify(responseText));
				var dato = responseText['datos'];
				//alert(dato)
				$('#descuento').html(dato[0]);
				$('#aux_total_venta').html(dato[1])
				
				},error: function(a,e){
					 alert(a+e)
					}
				})	
	})	
$('#calcual_descuento').click(function(){
	var v_descto; 
		do {
		v_descto= prompt("POR FAVOR INTRODUSCA EL PORCENTAJE EQUIVALENTE AL DESCUENTO");}
		while (Trim(v_descto) == ""&&v_descto!=null);
		if (v_descto == null)
		{v_descto=0}	
		v_descto = parseFloat($('#total_venta').val() ) *(parseFloat(v_descto)/100)
		$('#descuento_fnal').val(v_descto)	
		var total_final = parseFloat($('#total_venta').val() ) - v_descto
		var datosAjax = {
		datosConvertir : [v_descto,total_final]};
		$.ajax({url: 'aplicar_formato_pesos.php',  
				type: 'POST',
				async: true,
				data: datosAjax,
				dataType: "json",
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
				success: function(responseText){
				//alert(JSON.stringify(responseText));
				var dato = responseText['datos'];
				$('#descuento').html(dato[0]);				
				$('#aux_total_venta').html(dato[1]);
				},error: function(a,e,f){
					 alert(a+e)
					}
				})	
	})	 

});    
function preguntar_por_retefuente_variable( padre , v_tipoVenta ,v_total_venta, v_abonoInicial , VAUCHE ){
    
}
function continuar_cierre_ventas( padre , v_tipoVenta ,v_total_venta, v_abonoInicial , VAUCHE ){
  if( v_tipoVenta == "ELECTRONICA")
            {
		do {
		VAUCHE= prompt("POR FAVOR INTRODUSCA EL NUMERO DEL VAUCHE PARA CONTINUAR");}
		while (Trim(VAUCHE) == ""&&VAUCHE!=null);
		if (VAUCHE == null){return; }
                ejecutar_cierre_ventas(v_total_venta, v_abonoInicial , VAUCHE)
             }else if( v_tipoVenta == "CREDITO")
             {  
                 OcultaYMuestraPadre("#container","#cont_venta_credito");                
                 //ejecutar_cierre_ventas(v_total_venta, v_abonoInicial , VAUCHE) 
                 console.log(v_total_venta)
                 $(padre).find('#vventacxc').val( v_total_venta );
              }else
              {   ejecutar_cierre_ventas(v_total_venta, v_abonoInicial , VAUCHE)
           }        
}
 //////funciones/////////////////////////////////////////////////////////////
function ejecutar_cierre_ventas(v_total_venta, v_abonoInicial , VAUCHE){
    abuelo.find('#contenedor_espera_respuesta').show();
   // alert(  retefuente_ventas + paga_retefuente)
    var v_modulo = $(padre).find("#modulo").val()
	var  v_descuento = $('#descuento_fnal').val()
	var v_cantVendida = $('#cantVendida').val()
	var v_id_venta_actual = $('#id_venta_actual').val()
	var v_cliente_hidden = $('#cliente_id').val()
	var v_ivaVendido = $('#ivaVendido').val()
	var v_subtotal = $('#subtotal').val()  
	var v_tipoVenta = $(padre).find("#sel_tipoVenta").val()
	var v_nombreCliente = $(padre).find("#nombre_cliente").html()
          var abono_inicia = $(padre).find('#aux_abono_inicial_vc').val() 
        var intervalo_pagos = $(padre).find('#aux_intervalo_pagos').val()
        var num_cuotas =  $(padre).find('#aux_num_cuotas').val()
        var retefuente_nueva = $('#retefuente_nueva').val()
        
        
        $(padre).find('#valorVentaAux').html(v_total_venta );
		//IdVenta  tipoVenta VAUCHE codModulo cantidadVendida valorParcial descuento , valorIVA  , valorTotal ,
				
					OcultaYMuestraPadre("#container","#devolucion");
					$('#cuerpoFactura').attr('class','cierreVentana') 
					$(padre).find('#monIngresado').focus();
					var cierre = $('<input>')
					cierre.attr('type','hidden');
					cierre.attr('id','cierreVenta');
					cierre.attr('value','');		
					$(padre).find("#devolucion").find('#cierreVenta').remove().append(cierre);
                                        $(padre).find("#devolucion").append(cierre);
					//alert($('#cierreVenta').val());
					var v_t_ingresado = 0;
					$(padre).find('#monIngresado').unbind('keydown').keydown(function(e){
                                            var tecla=e.keyCode;		
                                            var v_t_ingresado= $(this).val();
                                                    if( v_t_ingresado == ''){
                                                            v_t_ingresado=$(padre).find('#valorVentaAux').html()
                                                    }		
                                            if(tecla==13){ 
                                                    if ($(padre).find('#cierreVenta').val()!='cierre'){
                                                            $(padre).find('#valorDevolver').html( v_t_ingresado - $(padre).find('#valorVentaAux').html() );
                                                            $(padre).find('#cierreVenta').val('cierre')
                                                    }else{
					var  v_t_devolucion = $(padre).find('#valorDevolver').html() ;
	//datos para envio por medio de ajax
	var datosAjax = {IdVenta: v_id_venta_actual,
		codCiente : v_cliente_hidden,
		tipoVenta: v_tipoVenta,
		VAUCHE : VAUCHE,
		codModulo:v_modulo,
		cantidadVendida :v_cantVendida,
		valorParcial : v_subtotal,
		descuento :   v_descuento,
		valorIVA : v_ivaVendido ,
		valorTotal : v_total_venta,
		nombreCliente : v_nombreCliente, 
		t_ingresado:  v_t_ingresado,
		t_devolucion:  v_t_devolucion,
                 abono_inicia: abono_inicia,
                intervalo_pagos: intervalo_pagos,
                num_cuotas: num_cuotas,
                paga_retefuente : paga_retefuente,
                retefuente_nueva : retefuente_nueva
		};
		 console.log(JSON.stringify(datosAjax))
		$.ajax({url: 'CerrarVentas.php',  
				type: 'POST',
				async: true,
				data: datosAjax,
				dataType: "json",
				beforeSend: function(){
					console.log("mensaje de texto");
							$("#facturar").attr("disabled","disabled")
							$("#cancelar").attr("disabled","disabled")
							
						 },
				error:function(a,b,c){console.log('error al ingresar la venta y generar la factura'+JSON.stringify(a)+JSON.stringify(b)+JSON.stringify(c));
				window.location.reload(true);
				},
				success: function(responseText){
					console.log(  JSON.stringify(responseText));
					//alert(JSON.stringify(responseText));
						datosRecibidos = responseText['print']
						// alert(JSON.stringify(datosRecibidos));
					var tipoImpresion = datosRecibidos['tipoImpresion'];
					if (tipoImpresion === 'P_L'){
						msg = datosRecibidos['modalMsg'];
						
							console.log('mensaje : '+msg) 
							$(padre).find("#muestaFactura").remove();

							$(padre).find("body").append(msg)							
							$(padre).find('#cerrarFacturaModal').click(function(){
								window.location.reload(true);
							});
							OcultaYMuestraPadre("#container","#muestaFactura");
						 
					}else{
						r = confirm("DESEA COPIA DE LA FACTURA");
						if(r==true){$("#print").trigger('click');}
								window.location.reload(true);
						}
					
			}
		})
				$(padre).find("#devolucion").remove();				
					}}	
				});//
    
}

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
</script>
