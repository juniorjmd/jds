<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../db_conection.php';
	
///////////////////////////777
$mysqli = cargarBD();
$total=0;
$ivaVendido=0;
$subtotal=0;
$query="SELECT * FROM  `factenvios`  where  id_factura = '".$_POST['codigo']."'";
//echo $query;
$ultVenta="";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$ultVenta=$row['id_factura'];
	$fechaInicio=$row['fechaInicio'];
$fechaFinal=$row['fechaFinal'];
$flete=$row['flete'];
$descuento=$row['descuento'];
$s_combustible=$row['s_combustible'];
$otros=$row['otros'];
$arancel=$row['arancel'];
$iva_arancel=$row['iva_arancel'];
$c_administrativos=$row['c_administrativos'] ;
$manejos=$row['manejos'];
$iva_manejos=$row['iva_manejos'];
$otros_costos=$row['otros_costos'];
$cod_factura=$row['cod_factura'];
$cuenta_cliente=$row['cuenta_cliente'];
$ref_1=$row['ref_1'];
$ref_2=$row['ref_2'];
$ref_3=$row['ref_3'];
$ref_4=$row['ref_4'];
$ref_5=$row['ref_5'];
	}
//echo $fechaInicio;
$ventaActual=substr($ultVenta, strlen('MER_'));
//echo $ventaActual;
}
else{$ventaActual=0;}
$codCiente="";
$razonSocial="";
$id_Ciente="";




//////////////////////////////////	
	
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

 <style>
 #cuerpo{ max-width : 80%; margin-left:auto; margin-right:auto; padding-top: 4px}

 
 </style>
<div id='respuesta'></div>
 <div id='cuerpo'>
 <div class='row'>
 
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Fecha Inicio</span>
  <input type="date" class="form-control"   aria-describedby="basic-addon1" name='fechaInicio' value='<?php echo $fechaInicio;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Fecha Vencimiento</span>
  <input type="date" class="form-control"   aria-describedby="basic-addon1" name='fechaFinal' value='<?php echo $fechaFinal;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">
<?php echo 'factura No. '.rellenar($ventaActual,10,NULL,NULL); ?></span>
</div>
</div>
 </div>

 <div class='row alert-success' style='margin-top:10px ; padding:2px'>
 <div style='margin-left:20px'>
 <h5>Gastos de flete</h5></div>
  <div  class="col-xs-3" >
  <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Flete</span>
  <input type="number" class="form-control" placeholder="flete" aria-describedby="basic-addon1" name='flete' value='<?php echo $flete;?>'>
</div>

</div> <div class="col-xs-3" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Descuento</span>
  <input type="number" class="form-control" placeholder="descuento" aria-describedby="basic-addon1" name='descuento' value='<?php echo $descuento;?>'>
</div>
</div>
<div class="col-xs-3" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Combustible</span>
  <input type="number" class="form-control" placeholder="combustible" aria-describedby="basic-addon1" name='s_combustible' value='<?php echo $s_combustible;?>'>
</div>
</div>

  <div  class="col-xs-3" >
  <div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Otros</span>
  <input type="number" class="form-control" placeholder="otros gastos" aria-describedby="basic-addon1" name='otros' value='<?php echo $otros;?>'>
</div>

</div> 
 </div>
  <div class='row alert-info' style='margin-top:10px; padding:2px'>
  <div style='margin-left:20px'>
 <h5>Gastos de Arancel</h5></div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Arancel</span>
  <input type="number" class="form-control" placeholder="Valor Arancel" aria-describedby="basic-addon1" name='arancel' value='<?php echo $arancel;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">IVA</span>
  <input type="number" class="form-control" placeholder="IVA Arancel" aria-describedby="basic-addon1" name='iva_arancel' value='<?php echo $iva_arancel;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Carg. Admin. </span>
  <input type="number" class="form-control" placeholder="Cargos administrativos" aria-describedby="basic-addon1" name='c_administrativos' value='<?php echo $c_administrativos;?>'>
</div>
</div>
 </div>
 
 <div class='row alert-success' style='margin-top:10px; padding:2px'>
  <div style='margin-left:20px'>
 <h5>Gastos de Manejo</h5></div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Manejos</span>
  <input type="number" class="form-control" placeholder="Valor Manejo" aria-describedby="basic-addon1" name='manejos' value='<?php echo $manejos;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">IVA</span>
  <input type="number" class="form-control" placeholder="IVA Manejo" aria-describedby="basic-addon1" name='iva_manejos' value='<?php echo $iva_manejos;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">otros_costos</span>
  <input type="number" class="form-control" placeholder="Cargos administrativos" aria-describedby="basic-addon1" name='otros_costos' value='<?php echo $otros_costos;?>'>
</div>
</div>
 </div>
 
  <div class='row alert-info' style='margin-top:10px; padding:2px'>
  <div style='margin-left:20px'>
 <h5>Refencias </h5></div>
 <div class='row' style='margin-left:20px;margin-top:5px '  >
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">cod_factura</span>
  <input type="text" class="form-control" placeholder="cod_factura" aria-describedby="basic-addon1" name='cod_factura' value='<?php echo $cod_factura;?>'>
</div>
</div>
<div class="col-xs-4" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">cuenta/cliente</span>
  <input type="number" class="form-control" placeholder="cuenta del cliente" aria-describedby="basic-addon1" name='cuenta_cliente' value='<?php echo $cuenta_cliente;?>'>
</div>
</div>
</div> <div class='row' style='margin-left:20px;margin-top:5px '  >
<div class="col-xs-6" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Referencia 1</span>
  <input type="text" class="form-control" placeholder="num. de control" aria-describedby="basic-addon1" name='ref_1' value='<?php echo $ref_1;?>'>
</div>
</div>
<div class="col-xs-6" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Referencia 2</span>
  <input type="text" class="form-control" placeholder="referencia" aria-describedby="basic-addon1" name='ref_2' value='<?php echo $ref_2;?>'>
</div>
</div></div> <div class='row' style='margin-left:20px;margin-top:5px '  >

<div class="col-xs-6" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Referencia 3</span>
  <input type="text" class="form-control" placeholder="referencia" aria-describedby="basic-addon1" name='ref_3' value='<?php echo $ref_3;?>'>
</div>
</div>
<div class="col-xs-6" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Referencia 4</span>
  <input type="text" class="form-control" placeholder="referencia" aria-describedby="basic-addon1" name='ref_4' value='<?php echo $ref_4;?>'>
</div>
</div></div> <div class='row' style='margin-left:20px;margin-top:5px '  >

<div class="col-xs-6" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Referencia 5</span>
  <input type="text" class="form-control" placeholder="referencia" aria-describedby="basic-addon1" name='ref_5' value='<?php echo $ref_5;?>'>
</div></div>
<div class="col-xs-6" >

	
</div>
 </div>
 
 </div>
 <input type='hidden' name='valor_total' id='valor_total' />
 <input type='hidden' value='MER_<?php echo $ventaActual; ?>' id='id_venta_actual'>
<input type='hidden' value='<?php echo $razonSocial; ?>' id='cliente_hidden'>
<input type='hidden' value='<?php echo $codCiente; ?>' id='cliente_id'>
<input type='hidden' value='<?php echo $subtotal; ?>' id='subtotal'>
<input type='hidden' value='<?php echo $totalArt; ?>' id='cantVendida'>
<input type='hidden' value='<?php echo $ivaVendido; ?>' id='ivaVendido'>
<input type='hidden' value='<?php echo $total; ?>' id='total_venta'>
<input type='hidden'value='0' id='descuento_fnal'>
 
 <script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script language="javascript1.1" type="text/javascript">
 $(document).ready(function(){
	 padre = $(window.parent.document);
 $(padre).find("#nombre_cliente").html($('#cliente_hidden').val())
 $(padre).find("#IdVenta").val($('#id_venta_actual').val())
  $(padre).find("#IdCliente_venta").val($('#cliente_id').val())
  OcultaYMuestraPadre("#cuerpo_cliente");
  if($('#cliente_id').val()==''){
OcultaYMuestraPadre("#container","#mod_usuario");
 OcultaYMuestraPadre("","#mod_insert_user");
$(padre).find("#mod_id_cliente").focus();}
else{OcultaYMuestraPadre("#mod_usuario","#container");

}


 $('#cancelar').click(function(){
	 $('#id_venta_actual').val()
	 //cancelarVenta.php
	  var dato=$('#id_venta_actual').val();
	r = confirm("REALMENTE DESEA ELIMINAR ESTA VENTA");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
			+'&eliminar_venta='+encodeURIComponent(true)
		 
	$.ajax({
			url: 'cancelarEnvio.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
				//alert(responseText)
			location.reload();
			}
		});
	 }
	 
 })

	 $('#facturar').click(function(){
	var v_modulo = $(padre).find("#modulo").val()
	var  v_descuento = $('#descuento_fnal').val()
	var v_cantVendida = $('#cantVendida').val()
	var v_id_venta_actual = $('#id_venta_actual').val()
	var v_cliente_hidden = $('#cliente_id').val()
	var v_ivaVendido = $('#ivaVendido').val()
	var v_subtotal = $('#subtotal').val()
	var v_total_venta = $('#total_venta').val() 
	 var v_tipoVenta = $(padre).find("#tipoVenta").html()
	var v_nombreCliente = $('#cliente_hidden').val() 
	
var vfechaInicio= $('#fechaInicio').val(); 
var vfechaFinal=$('#fechaFinal').val(); 
 var vflete= $('#flete').val(); 
 var vdescuento = $('#descuento').val() ;
 var vs_combustible = $('#s_combustible').val();
 var votros=$('#otros').val(); 
 var varancel= $('#arancel').val(); 
 var viva_arancel= $('#iva_arancel').val(); 
 var vc_administrativos=  $('#c_administrativos').val();  
 var vmanejos=  $('#manejos').val(); 
 var viva_manejos= $('#iva_manejos').val(); 
 var votros_costos=  $('#otros_costos').val();
 var vvalor_total= parseFloat(vflete )- parseFloat(vdescuento )+ parseFloat(vs_combustible) + parseFloat(votros )+ parseFloat(varancel) + parseFloat(viva_arancel) + parseFloat(vc_administrativos) + parseFloat(vmanejos) +parseFloat(viva_manejos) + parseFloat(votros_costos)
 var vcod_factura= $('#cod_factura').val(); 
 var vcuenta_cliente=  $('#cuenta_cliente').val(); 
 var vref_1= $('#ref_1').val(); 
 var vref_2= $('#ref_2').val();
 var vref_3= $('#ref_3').val();  
 var vref_4=  $('#ref_4').val(); 
 var vref_5=  $('#ref_5').val(); 
	
	
	 var VAUCHE = '';
	 if( v_tipoVenta=="ELECTRONICA"){
		do {
		VAUCHE= prompt("POR FAVOR INTRODUSCA EL NUMERO DEL VAUCHE PARA CONTINUAR");}
		while (Trim(VAUCHE) == ""&&VAUCHE!=null);
		if (VAUCHE == null){return; }
	}
	var v_abonoInicial = 0;
	 if( v_tipoVenta=="CREDITO"){
		 do {
		v_abonoInicial = prompt("POR FAVOR INTRODUSCA EL VALOR DEL ABONO INICIAL");}
		while (Trim(v_abonoInicial) == ""&& v_abonoInicial!=null);
		if (v_abonoInicial == null){return; }
	}
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
		abonoInicial : v_abonoInicial,
		fechaInicio : vfechaInicio ,
fechaFinal : vfechaFinal ,
flete : vflete ,
descuento : vdescuento ,
s_combustible : vs_combustible ,
otros : votros ,
arancel : varancel ,
iva_arancel : viva_arancel ,
c_administrativos : vc_administrativos ,
manejos : vmanejos ,
iva_manejos : viva_manejos ,
otros_costos : votros_costos ,
valor_total : vvalor_total ,
cod_factura : vcod_factura ,
cuenta_cliente : vcuenta_cliente ,
ref_1 : vref_1 ,
ref_2 : vref_2 ,
ref_3 : vref_3 ,
ref_4 : vref_4 ,
ref_5 : vref_5 
		
		};
		//$('#respuesta').html(JSON.stringify(datosAjax))
		
	//IdVenta  tipoVenta VAUCHE codModulo cantidadVendida valorParcial descuento , valorIVA  , valorTotal ,
		$.ajax({url: 'CerrarEnvio.php',  
				type: 'POST',
				async: true,
				data: datosAjax,
				success: function(responseText){
					$('#respuesta').html(responseText)
				//	$('#respuesta').html(responseText)
				/*r = confirm("DESEA COPIA DE LA FACTURA");
				 	if(r==true){$("#print").trigger('click');}*/
					if(Trim(responseText)=='factura insertada con exito...'){
						location.reload();
					}
				}
					
			})
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
				//$('#respuesta').html(JSON.stringify(datosAjax))
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
	
 
	$('#fechaInicio').change(function(){
		if ($('#fechaInicio').val()!= ''){
		if ($('#fechaInicio').val() > $('#fechaFinal').val()){
			$('#fechaFinal').val('')
			$('#fechaFinal').focus()
		}
		if ($('#fechaFinal').val() == ''){
			$('#fechaFinal').val($('#fechaInicio').val())
		}
		}
		$('#fechaFinal').attr('min',$('#fechaInicio').val())
	});
	$('#fechaFinal').change(function(){
		if ($('#fechaFinal').val()!= ''){
		if ($('#fechaInicio').val() > $('#fechaFinal').val()){
			$('#fechaInicio').val('')
			$('#fechaInicio').focus()
		}
		if ($('#fechaInicio').val() == ''){
			$('#fechaInicio').val($('#fechaFinal').val())
		}
		}
		$('#fechaInicio').attr('max',$('#fechaFinal').val())
	});
	});

 ////////////////////////////////////////////////////////////////////

</script>
