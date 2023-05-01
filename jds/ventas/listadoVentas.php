<?php
if (!isset($independiente)){
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../php/db_conection.php';
$mysqli = cargarBD();
include '../php/inicioFunction.php';
echo '<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script language="javascript1.1" src="../jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorContenidos.js"></script>
<link rel="stylesheet" href="../css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" src="../js/json2.js"></script>
<script type="text/javascript" src="../js/wp-nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="../jsFiles/ajax.js"></script>

';
}
 $tamanioBloque = 12; 
$query="SELECT * FROM  `producto` LIMIT 0, 15;";
$result = $mysqli->query($query);

$datosNum=$mysqli->affected_rows;
$i=0;
if($datosNum>0){
	while ($row = $result->fetch_assoc()) {

	$datosGenerados[$i]=$row;
	$i++;
	}}
$query="SELECT * FROM  `producto`  ";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
	
//echo 'num resul '.$datosNum;
if ($datosNum <= $tamanioBloque )
{$display='none';}
?>



<script type="text/javascript" >
$(document).ready(function(){
		
		$("#cerrarliquidar").click(function(){//cierra la ventana de seleccion de cantidad a vender
				$("#liquidar").css("display","none");
				 $("#filasData").removeAttr('disabled');	
				 $("#calculadora").removeAttr('disabled');
				 $("#suma10").removeAttr('disabled');
				 if($("#cantidadVenta").val()!="0"){}
				 $("#cantidadVenta").val(0)	
				//selecciona el primer elemento input que contenga la clase gruposBT
				});	
		
		$("#calculadora a").click(function(r){
			r.preventDefault();
			var cadAux = '#'+Trim($(this).attr('id'))+' span'
			var venta=parseFloat($("#cantidadVenta").val());
			venta=venta+parseInt($(cadAux).html());
			$("#cantidadVenta").val(venta);
			var cantActual=parseFloat($("#cantActualArt").val());
			var peticionCant=parseFloat($("#cantidadVenta").val());
			if(cantActual<peticionCant){
				r = confirm("Esta intentando facturar una cantidad mayor de la existencia actual del producto, presione aceptar para continuar la operacion con el valor ingresado o cancelar para facturar la existencia actual del producto");
				 	if(r==false){$("#cantidadVenta").val(cantActual);}
				}
			enviar_ventas_simple();
			$("#cerrarliquidar").trigger("click");
			
		});
		
		
		$("#guardarliquidar").click(function(e){
			e.preventDefault();
			$("#cantidadVenta").val()
			if($("#cantidadVenta").val()!="0"){
				enviar_ventas_simple();
				$("#cerrarliquidar").trigger("click");
				}
				else{alert('la cantidad debe ser mayor a cero (0)')}
		});
		
			$("#suma10").click(function(e){
			e.preventDefault();
			var venta=parseFloat($("#cantidadVenta").val());
			venta=venta+10;			
			$("#cantidadVenta").val(venta);
		});
		$("#filasData a").click(function(e){
			e.preventDefault();
 		    var cantAct;
			$("#cantidadVenta").val(0);
			//inicio bloque obtencion de datos producto
			var datosAjax = {tabla: 'producto',
		inicio: '',
		where:true,
		igual:true,
		columna1:'idProducto',
		dato:$(this).attr("id"),
		datosRequeridos:['idProducto','PsIVA','nombre','IVA','precioVenta','porcent_iva','stock','cantActual']};		
		$.ajax({url: '../php/db_listar_nuevo.php',  
			type: 'POST',
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
 			success: function(data) {
				datosTabla=data['datos'];
				for(var i =0; i<datosTabla.length;i++){
					auxDato=datosTabla[i];
					 $("#nomProducto").html(auxDato.nombre)
					 $("#idProducto").val(auxDato.idProducto)
					 $("#nombreProducto").val(auxDato.nombre)
					 $("#presioVenta").val(auxDato.precioVenta)
                                         
					  $("#pVenta").html(formatNumber.new(  auxDato.precioVenta, "$"))
					 $("#Ps_IVA").html(formatNumber.new( auxDato.PsIVA, "$") )
					 $("#_IVA").html(formatNumber.new( auxDato.IVA, "$") )
                                         
					 $("#PsIVA").val(auxDato.PsIVA)
					 $("#IVA").val(auxDato.IVA)
					 $("#porcent_iva").val(auxDato.porcent_iva)
					 $("#cantActualArt").val(auxDato.cantActual)
					}
					$("#liquidar").css("display","inline")
					
				},error: function(a,e,b){
					 alert("se genero un error")
					}});//fin bloque obtencion de datos producto					
					});
		
			/*$('#columnaBuscar').val()
				var $dato = $('#idColumnaBuscar').val()		*/
			$('#lista_grupo').find('button').each(function(){
				$(this).click(function(){
				$('#columnaBuscar').val('idGrupo')
				$('#idColumnaBuscar').val($(this).attr('id'))	
				$('#list_inicio').trigger('click')
			});});
			
			$('#lista_lap').find('button').each(function(){
				$(this).click(function(){
				$('#columnaBuscar').val('idLab')
				 $('#idColumnaBuscar').val($(this).attr('id'))
				$('#list_inicio').trigger('click')
			});
			});
			$('#marcasSelect').click(function(){
				$('#columnaBuscar').val('idLab')
				var id = $('#lista_lap').find('button').first().attr('id')
				$('#idColumnaBuscar').val(id)
				$('#list_inicio').trigger('click')
			});
			$('#groupSelect').click(function(){
				$('#columnaBuscar').val('idGrupo')
				var id = $('#lista_grupo').find('button').first().attr('id')
				$('#idColumnaBuscar').val(id)
				$('#list_inicio').trigger('click')
			});
			$('.botonExploradorListas').click(function(e){	
			if ($('#columnaBuscar').val()!=''){var $columnaBuscar = $('#columnaBuscar').val()
				var where = true; var igual = true;
			}else{var $columnaBuscar = false; var igual = false;
			var where = false}
			 if ($('#idColumnaBuscar').val()!=''){var $dato = $('#idColumnaBuscar').val()}else{var $dato = false;}		
			
				var id = '#'+$(this).attr('id')+'_aux'
				var tamanio_bloque = $('#tamanioBloque').val()
				var inicio =  $(id).val()
				var datosAjax = {tabla: 'producto',
				inicio: inicio,
				where:where,
				igual:igual,
				tamanioBloque:tamanio_bloque,
				columna1:$columnaBuscar,
				dato:$dato,
		datosRequeridos:['idProducto','imagen','nombre','stock','cantActual']
				};
			$.ajax({url: '../php/db_listar_nuevo.php',  
			type: 'POST',
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
 			success: function(data) {
				//alert(JSON.stringify(data))
				datosTabla=data['datos'];
				if (!datosTabla){
					datosTabla = new Array()
				}
				//alert(data['filas'])
				if(data['filasTotales']<=tamanio_bloque){
					$('#nv').css('display','none')
				}
				else{$('#nv').show()
					$('#list_ant_aux').val(data['anterior'])
				$('#list_sig_aux').val(data['siguiente'])
				$('#list_last_aux').val(data['ultimo'])
				}				
				for(var i =0; i<tamanio_bloque;i++){
					if (typeof(datosTabla[i])!='undefined')
						{
						auxDato=datosTabla[i];
						//alert(JSON.stringify(auxDato))
						$('#div_'+i).find('img').attr('src','../'+auxDato['imagen'])		
						$('#div_'+i).find('a').prop( "disabled", false );
						$('#div_'+i).find('a').attr('id',auxDato['idProducto'])	
						$('#div_'+i).attr('title',auxDato['nombre'])
						if (auxDato['nombre'].length > 25)
						{puntos= '...'}
						else{puntos=''}
						$('#div_'+i).find('span').html(auxDato['nombre'].substring(0,25)+puntos)
					}else{
						$('#div_'+i).find('img').attr('src','../imagenes/Sin_imagen_3.png')
						$('#div_'+i).find('a').attr('id','')					
						$('#div_'+i).find('a').prop( "disabled", true );
						$('#div_'+i).find('span').html('SIN PRODUCTO')
						$('#div_'+i).attr('title','')
			}	}		
				},error: function(a,e,b){
					 alert("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto		
				});
				 
 });	
</script>
<style>
.nombresProductos{ color: #333; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif
 }
 span { font-size:13px}
 .container img{ width:70%; height:80px;}
 .container{width:100%; min-height:90%; padding-top:2%}
 .col-md-2{min-width:20%; } 
 .col-md-3{min-width:23%; } 
 .container .row{height:30%}

 .col-xs-6 .col-md-3 > img  {border:none; width:100px ; height: 100px}  
 .caption { height: 50px}
 #calculadora > div .caption { height: 30px;}
 #calculadora > div .col-md-3 { min-width:33%;  }
  #suma_10 > div .col-md-3 { min-width:40%;  }
  #liquidar {padding: 10Px; font-weight: bold; position: absolute;  z-index: 5;
  left: 50%; top: 120px; width: 400px; height: 450px; display:none;
margin-left: -200px;  
  }

 
</style>

<div id="listado" style="padding:5px" >
<div class="panel panel-default" >
  <!-- Default panel contents -->
  <div id='nv' class="panel-heading"  style='height:35px;padding-top:4px;display:<?php echo $display;?>'>
<input type="button" title="listado inicial" id="list_inicio" class="botonExploradorListas" value="<<" >
<input type="button" title="listado anterior" class="botonExploradorListas"  id="list_ant" value="<" >
<input type="button" title="listado sigiente" class="botonExploradorListas"  id="list_sig"  value=">"  >
<input type="button" title="listado final" class="botonExploradorListas"  id="list_last" value=">>" >

<input type="hidden" title="listado inicial" id="list_inicio_aux"  value="0" >
<input type="hidden" title="listado anterior"  id="list_ant_aux" value="<?php echo $datosNum-15;?>" >
<input type="hidden" title="listado sigiente"   id="list_sig_aux"  value="13"  >
<input type="hidden" title="listado final"  id="list_last_aux" value="<?php echo $datosNum-15;?>" >
<input type="hidden" title="listado final"  id="tamanioBloque" value="<?php echo $tamanioBloque ;?>" >

<input type="hidden" title="listado final"  id="columnaBuscar" value="" >
<input type="hidden" title="listado final"  id="idColumnaBuscar" value="" >
</div>
 
<div class="container" id='filasData' >
	<div class="row">    
  <div class="col-xs-6 col-md-3" id='div_0' title='<?php echo $datosGenerados[0]['nombre'] ;?>'><?php if (isset($datosGenerados[0])){ ?>
  <a href="" class="thumbnail" id='<?php echo $datosGenerados[0]['idProducto'] ;?>' '>
      <img src="../<?php echo $datosGenerados[0]['imagen'] ;?>" alt="..." >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[0]['nombre']),20,'sp','D',true);?> </span>     
      </div>
    </a>
  <?php } ?>
</div>
    

  <div class="col-xs-6 col-md-3" id="div_1" title='<?php echo $datosGenerados[1]['nombre'] ;?>'><?php if (isset($datosGenerados[1])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[1]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[1]['imagen'] ;?>" alt="..." >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[1]['nombre']),20,'sp','D',true) ;?> <span>     
      </div>
    </a>
  <?php } ?>
</div>

  <div class="col-xs-6 col-md-3" id="div_2" title='<?php echo $datosGenerados[2]['nombre'] ;?>'>
  <?php if (isset($datosGenerados[2])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[2]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[2]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[2]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a><?php } ?>
</div>
  <div class="col-xs-6 col-md-3" id="div_3" title='<?php echo $datosGenerados[3]['nombre'] ;?>'><?php if (isset($datosGenerados[3])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[3]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[3]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[3]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a><?php } ?>
</div>


</div>
	<div class="row">

  <div class="col-xs-6 col-md-3" id="div_4" title='<?php echo $datosGenerados[4]['nombre'] ;?>'><?php if (isset($datosGenerados[4])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[4]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[4]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[4]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a><?php } ?>
</div>
  <div class="col-xs-6 col-md-3" id="div_5" title='<?php echo $datosGenerados[5]['nombre'] ;?>'><?php if (isset($datosGenerados[5])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[5]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[5]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[5]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div><div class="col-xs-6 col-md-3" id="div_6" title='<?php echo $datosGenerados[6]['nombre'] ;?>'><?php if (isset($datosGenerados[6])){ ?>  
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[6]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[6]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[6]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div> <div class="col-xs-6 col-md-3" id="div_7" title='<?php echo $datosGenerados[7]['nombre'] ;?>'><?php if (isset($datosGenerados[7])){ ?> 
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[7]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[7]['imagen'] ;?>" height='50px'>
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[7]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div>

</div>
	<div class="row">
  <div class="col-xs-6 col-md-3" id="div_8" title='<?php echo $datosGenerados[8]['nombre'] ;?>'><?php if (isset($datosGenerados[8])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[8]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[8]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[8]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div>
 <div class="col-xs-6 col-md-3" id="div_9" title='<?php echo $datosGenerados[9]['nombre'] ;?>'><?php if (isset($datosGenerados[9])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[9]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[9]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[9]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div>
 <div class="col-xs-6 col-md-3" id="div_10" title='<?php echo $datosGenerados[10]['nombre'] ;?>'><?php if (isset($datosGenerados[10])){ ?>
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[10]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[10]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[10]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div> <div class="col-xs-6 col-md-3" id="div_11" title='<?php echo $datosGenerados[11]['nombre'] ;?>'><?php if (isset($datosGenerados[11])){ ?> 
  <a href="#" class="thumbnail" id='<?php echo $datosGenerados[11]['idProducto'] ;?>' >
      <img src="../<?php echo $datosGenerados[11]['imagen'] ;?>" >
      <div class="caption">
        <span><?php echo rellenarTruncar(strtoupper($datosGenerados[11]['nombre']),20,'sp','D',true) ;?> </span>     
      </div>
    </a>
<?php } ?></div> 


 </div>
    
    
    
    </div></div></div>
	
 <input type="hidden" value="" id="nombreProducto">
<input type="hidden" value="" id="presioVenta">
<input type="hidden" value="" id="porcent_iva">
<input type="hidden" value="" id="cantidadVendida">
<input type="hidden" value="" id="valorTotal">
<input type="hidden" value="" id="idProducto">
<input type="hidden" value="" id="PsIVA">
<input type="hidden" value="" id="IVA">

<form id="formularioDeEnvio" action="listadoVentasNuevo.php" autocomplete="off" method="post" >
	<input type="hidden" name="dato" id="datoEnvio" value="<?php echo $dato;?>">
	<input type="hidden" name="columna" id="columnaEnvio" value="<?php echo $columna;?>">
	<input type="hidden" name="inicio" id="inicioEnvio" value="">
    <input type="submit" style="display:none" id="enviando"></form>
	
	
<div class="panel panel-info" id="liquidar" >
<div class="panel-heading" style='height:80px'>
<div style='float:left'>Selecione la Cantidad </div>
<div style='float:right; margin-right: 10px'>
<button type="button" class="btn btn-default" id='cerrarliquidar'   >
<span  class="glyphicon glyphicon-remove"  aria-hidden="true"  ></span>
</button></div>
<div style='float:left' ><span id='nomProducto'></span></div>
   <div style='float:left' id='areaDescripcionProducto' >Precio :&nbsp;<span id='Ps_IVA'></span>
   <button type="button" class="btn btn-default" id='cambiarPrecio'   >
<span  class="glyphicon "  aria-hidden="true"  ></span>$
</button> 
   &nbsp;|&nbsp;IVA :&nbsp;<span id='_IVA'></span>&nbsp;|&nbsp;Total :&nbsp;<span  id='pVenta'></span></div> 
  
</div>
 <div class="panel-body">
 <div class="panel-heading">
  
  <input type="text" value="0" id="cantidadVenta"  style='width:100%'>
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
	<div class="col-md-7" id=''>
  <a href="#" class="thumbnail" id="guardarliquidar">
     <div class="caption">
        <span>OK</span>     
      </div>
    </a></div>


</div>
 
  
  </div>
</div>
<input type='hidden' value='M1' id='modulo'/>
<input type='hidden' id='cantActualArt'/>
<input type='hidden' id='PCname' value='<?php echo php_uname('n');?>' />

