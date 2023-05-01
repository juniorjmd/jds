<?php include 'php/inicioFunction.php';
session_sin_ubicacion("login/"); 

require_once 'Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();

?>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta charset="utf-8">

 <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/> 
  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>

<title>JDS_inventario</title>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
		$("#busqueda").keyup(function(e){
			
			if  (e.which== 13){
			$('#frameaux').attr('src',"invView.php?id="+encodeURIComponent($(this).val())+"&tip_busqueda="+encodeURIComponent($("#tip_busqueda").val())+"&nocache=" + Math.random());
				//alert($('#frameaux').attr('src'))
				}
			});	
		$('#limpiar').click(function(){
			$("#busqueda").val('');	
			$('#frameaux').attr('src',"invView.php");
			})
		
 });

</script> 


<div  >
 <div class="row">
     <div class='col-md-12 col-sm-12'  > <h3>Listado De Productos</h3></div></div>
    <div class="row"> <div class='col-md-4 col-sm-12'  >  <span class="Estilo1">BUSCAR</span> 
  <div class="input-group tblInfo" >
      <input type="text" class="form-control" id="busqueda" > 
      <button class="btn "> <img src="imagenes/limpiar_nuevo.png"  id="limpiar"></button></div>
 </div>
 
<div class="col-md-2 col-sm-12"   >Total Existencia :<br/><span style='margin-left:auto;margin-right:auto' id='sp_1' >0000</span>  </div>
<div class="col-md-2 col-sm-12" >Total Tip. producto :<br/><span style='margin-left:auto;margin-right:auto' id='sp_2' >0000</span>  </div>
<div class="col-md-2 col-sm-12" >T. Precio Venta:<br/><span style='margin-left:auto;margin-right:auto' id='sp_3' >$ 00.000.00</span> </div>
<div class="col-md-2 col-sm-12"  >T. Precio Compra:<br/><span style='margin-left:auto;margin-right:auto' id='sp_4' >$ 00.000.00</span>  </div>
 
</div>
    
 <div class="col-md-12 col-sm-12"   >   
<iframe id="frameaux" src="invView.php" style="border:none; padding:0; height:100%; width:100%; margin:0"> 
</div>