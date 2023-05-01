<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?><head>
 <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);/*
$('#fecha').datepicker({selectOtherMonths: true,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {}
			});*/		
	
        ////////////////////////
        $('#btnListar').click(function(){ 
    
    $.ajax({
        url: 'saveGastSalEfect.php',
        type: 'POST',
        async: true,
        data: 'fecha='+ $('#fInicio').val()+'&fechaHasta='+ $('#fFin').val()+'&tabla=salidasefectivo',
        dataType:"html",
        success: function(responseText){
        //    alert(responseText)
        $("#tablaGastos").html(responseText);
        },
        error: function(){alert("nos se pudo")}
    });
})     	 
$('#fInicio').datepicker({selectOtherMonths: true,maxDate:new Date() ,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {}
			});	
$('#fFin').datepicker({selectOtherMonths: true,maxDate:new Date() ,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {$('#fInicio').datepicker("option", "maxDate", date )}     }); 
                                             
$('.hasDatepicker').datepicker('setDate', new Date());
      /////////////////////////////////  
        
        
	$('#enviaDatos').click(function(e){
	var str="";
	 var h=0;
	 $(".gasto").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;
			 return false;
			}
    });
	if(h==1){e.preventDefault();}
	
	});

   });			 
					

</script>
<style>
#TablaInicial td { font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
#titulo{ font-size:30px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.boton{ height:50px; width:80px}
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
.Estilo2 {
	font-size: 15px;
	color: #000000;
}
.Estilo3 {font-size: 15px}
</style></head>
<?php 
include 'db_conection.php';
 $conn= cargarBD();
 $pagadoA=''; 
 $porConceptoDe = '';
if(isset($_POST["idUsuario"])){
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
//sis01jdp -- cambio para utilizar PDO en lugar de mysqli
$conexion =\Class_php\DataBase::getInstance();
 $link = $conexion->getLink(); 
//sis01jdp -- fin cambio 
//se modifica la fecha ya que no es necesario normalizarla 
//$fecha ="'".normalize_date($_POST["fecha"],"-")."'"; 
$fecha ="'".$_POST["fecha"]."'"; 
//fin del cambio 
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){
$query="INSERT INTO  `".$_POST["tabla"]."` VALUES (
NULL , '".$_POST["idUsuario"]."','".
$_POST["nombreUsuario"]."','".
$_POST["descripcion"]."',".
$fecha .",'".
$_POST["valorGasto"]."','".
$_SESSION["id_suc"]."','".
$_POST["porConceptoDe"]."','".
$_POST["pagadoA"]."',CURTIME(),'activo');";
//sis01jdp -- se modifica la ejecucion de la consulta.
/*
$stmt->prepare($query);
if(!$stmt->execute()){*/
$consulta = $link->prepare($query);
if(!$consulta->execute()){
//sis01jdp -- fin del cambio
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
	echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!</div><br><br>';
	echo '<script>window.location="salidasEfectivo.php"</script>';
	}
}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
$descripcion=$_POST["descripcion"];
$auxfecha=normalize_date($_POST["fecha"],'/');
$valorGasto=$_POST["valorGasto"];
$porConceptoDe=$_POST["porConceptoDe"];
$pagadoA=$_POST["pagadoA"];	
}}else {$fecha="CURDATE() ";}



$pagadoA='<option value="" >SELECCIONE UN ACCIONISTA</option>';
$query2="SELECT * FROM  `accionistas`  ";echo $query2;
/*
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) { */
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {   
    
	if($row["id"]==$pagadoa){$selected="selected";}else{$selected="";}
$pagadoA=$pagadoA.'<option value="'.$row["nit"].'"
'.$selected.'>'.$row["razonSocial"].'</option>';
}

?>


<div align="left">
<form method="post" autocomplete="off" action="salidasEfectivo.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="salidasefectivo">





    <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">
          <h2>Pagos a accionistas</h2>
        </div></div>
   	   <div class="row" style="width:100%">                          
                         <div class="col-md-3 col-sm-12">
						 <div class="form-group">
                         <label for="email">Fecha : </label>
                            <input  class="form-control" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="gasto" type="date" >
                         </div>
						 </div>
                        		
						<div class="col-md-3 col-sm-12">
						<div class="form-group">
                        <label for="email">Valor : </label>
 						<input class="form-control" type="number" width="" id="valorGasto" name="valorGasto" value="<?php echo $valorGasto; ?>" placeholder="Ingrese el valor" class="gasto">
                       </div>
					   </div> 
           </div>
					
					
     <div class="row" style="width:100%">   

				<div class="col-md-3 col-sm-12"> 
                <div class="form-group">
                <label for="email">Tercero : </label>
                  <select class="form-control gasto" id="pagadoA" name="pagadoA"  placeholder="Tercero" >
                      <?php echo $pagadoA; ?>
                         </select>
                
                </div> 
                </div>   
       

          <div class="col-md-5 col-sm-12">
		  <div class="form-group">
           <label for="email">Concepto : </label>
     		  <input class="form-control" type="text" id="porConceptoDe" name="porConceptoDe" placeholder="Concepto" value="<?php echo $porConceptoDe; ?>"  class="gasto">
		  </div>
		  </div> 

 </div>

					
      <div class="row" style="width:100%">   
          <div class="col-md-5 col-sm-12"><div class="form-group">
          <label for="email">Descripción : </label>
          <textarea class="form-control" cols="42" id="descripcion" name="descripcion"  rows="3"> </textarea>
          </div>
		  </div> 
						
           <div class="col-md-2 col-sm-12"> 
           <div class="form-group">
           <label for="email">&nbsp; </label><br>
           <input type="submit" class="btn btn-primary " id="enviaDatos" value="Registrar">
           </div> 
           </div>   
     </div>


</form>
<hr>



<div align="center" class="tablas-generada">
    <div class="row" style="width:100%">  
        <div class="col-md-1 col-sm-12"><label for="email">&nbsp;</label></div>
        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Desde : </label>
                            <input  class="form-control" 
                                   type="text" id="fInicio"   >
                       
            </div></div>
        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Hasta : </label>
                            <input  class="form-control" 
                                   type="text" id="fFin"   >
                       
            </div></div>
        <div class="col-md-1 col-sm-12"><div class="form-group">
                <label for="email">&nbsp; </label>
                <button class="btn btn-success"id="btnListar">Consultar</button>
                       
            </div></div>
        
         <div class="col-md-1 col-sm-12"><div class="form-group" style="padding-left: 10px;">
                <label for="email">&nbsp; </label>
                <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaPagosAccionistas';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
            </div></div>
        
        
        
    </div>



     <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">
    <table class="table "  id="tabla_resultados"     >
<tr align="center">
<td width="64"><strong>USUARIO</strong></td>
<td width="221"><strong>FECHA</strong></td>
<td width="84"><strong>VALOR</strong></td>
<td width="113"><strong>TERCERO</strong></td>
<td width="81"><strong>CONCEPTO</strong></td>
<td width="215"><strong>DESCRIPCION</strong></td>
</tr>
<tbody id="tablaGastos" class="tblInfo">
<?php 
$query2="SELECT * FROM  `salidasefectivo`  where `fecha`= ".$fecha;
//	echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {

echo "<tr>
<td class= 'ui-widget-content'> ".$row["nombreUsuario"]."</td>
<td class= 'ui-widget-content'>".$row["fecha"]."</td>
<td class= 'ui-widget-content'>".$row["valorGasto"]."</td>
<td class= 'ui-widget-content'>".$row["pagadoA"]."</td>
<td class= 'ui-widget-content'>".$row["porConceptoDe"]."</td>
<td class= 'ui-widget-content'>".$row["descripcion"]."</td>
</tr>";


}
 
$result->free();
$conn->close();

?>
</tbody></table>
</div></div></div></div>


