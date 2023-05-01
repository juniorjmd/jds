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
    },3000);

	
	$('#enviaDatos').click(function(e){
		
	var str="";
	 var h=0;
	 $(".gasto").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;$(this).focus();
			 return false;
			}
    }); 
	$(".pagosN").removeAttr('disabled');
	$(".pagosN").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;$(this).focus();
			 return false;
			}
    });
	if(h==1){e.preventDefault();
	$(".pagosN").attr('disabled','disabled');
	}
	
	});
	
	$("#pagadoA").change(function(){
	datos='empleadoId='+encodeURIComponent($(this).val());
	$.ajax({
			url: 'abonosRealizadosAEmpleados.php',  
			type: 'POST',
			
			data: datos,
			dataType: "json",
			success: function(DATA){
				//alert(DATA.total)
			if(Trim(DATA.total)!=""){
				$("#abonosRealizados").val(DATA.total)
				}else{$("#abonosRealizados").val(0)}
				
			if(Trim(DATA.monto_dia)!=""){
				$("#PagoDia").val(DATA.monto_dia)
				}else{$("#PagoDia").val(0)}
			}
		});
	if($("#diasTrabajo").val()!=0){$("#diasTrabajo").trigger("change")}
	});	
	
///
$("#diasTrabajo").change(function(){
	$("#totalParcial").val($(this).val()*$("#PagoDia").val())
	$("#totalPago").val($("#totalParcial").val()-$("#abonosRealizados").val());
	});	
	
	
$("#diasTrabajo").keyup(function(){
	$(this).trigger("change")
	})
///


$("#actualiza").click(function(){
	document.location.reload();  
	});
$("#buscarNominas").click(function(){
	var datos="";
	var aux=0;
	if(Trim($("#findUsuario").val())!="")
	{datos='empleadoId='+encodeURIComponent($("#findUsuario").val());aux=1}
	if(Trim($("#findFecha").val())!=""){
		if(aux==1){datos=datos+'&SI=TRUE&'}
		datos=datos+'fecha='+encodeURIComponent($("#findFecha").val())
		}

	if(datos!=""){
	$.ajax({
			url: 'nominasPagadas.php',  
			type: 'POST',
			
			data: datos,
			beforeSend: function(){$("#imgFind").css("display","inline")},
			success: function(DATA){
				$("#tablanomina").html(DATA);
				$("#imgFind").css("display","none")
			}
		});}
	})
   });			 
					

</script>
</head>

<?php 
$auxfecha=date("Y-m-d"); 
include 'db_conection.php';
 $conn= cargarBD();
 $conexion =\Class_php\DataBase::getInstance();
 $link = $conexion->getLink();  
 $descripcion=''; 
$valorGasto=0;
$porConceptoDe = $pagadoA = $pagadoa='';
if(isset($_POST["pagadoA"])){
	
	/*fecha pagadoA diasTrabajo totalParcial abonosRealizados totalPago*/
	
$descripcion= $porConceptoDe="PAGO DE LOS ".$_POST["diasTrabajo"]." DIAS TRABAJADOS, MENOS LOS ANTICIPOS REALIZADOS";	
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
$fecha ="'".$_POST["fecha"]."'"; 
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){
$query="INSERT INTO  `nomina` 
(   `idUsuario`, `nombreUsuario`, `descripcion`, `fecha`, `idSucursal`, `porConceptoDe`, `pagadoA`, `hora`, `estado`, 
`diasTrabajados`, `totalParcial`, `abonos/Anticipos`, `totalPagado`)    
VALUES ('".$_SESSION["usuarioid"]."','".
$_SESSION["usuario"]."','".
$descripcion."',".
$fecha .",'".
$_POST["idSucursal"]."','".
$porConceptoDe."','".
$_POST["pagadoA"]."',CURTIME(),'activo','".
$_POST["diasTrabajo"]."','".
$_POST["totalParcial"]."','".
$_POST["abonosRealizados"]."','".
$_POST["totalPago"]."');";
 
 // echo $query;
//if(!$stmt->execute()){
$consulta = $link->prepare($query);
if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error. $query);
}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
$ultimoId=$stmt->insert_id;
$descripcion="ultimo anticipo del pago de la nomina numero ".$ultimoId;
$query2="INSERT INTO  `abonosnomina` 
		VALUES (
		NULL , '".$_SESSION['usuarioid']."','".
		$_SESSION['usuario']."','".
		$_POST["pagadoA"]."',  '".
		$_POST["totalPago"]."',".
		$fecha .",   'ACTIVO',  '".$ultimoId."','".
		$descripcion."', 'ACTIVO' ,'pagoNomina');";
 	 	echo $query2;
//		$stmt->prepare($query2);
//if(!$stmt->execute()){
$consulta = $link->prepare($query2);
if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
	$query3="UPDATE  `abonosnomina` SET  `estadoNomina` =  'INACTIVO',
`id_pago_nomina` =  '".$ultimoId."' WHERE `id_empleado`= ".$_POST["pagadoA"]." AND `estadoNomina` =  'ACTIVO' ";
//	echo $query2;
$result = $conn->query($query3);	
//echo '<script>window.location="nomina.php"</script>';
	}
}}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
$descripcion=$_POST["descripcion"];
$auxfecha=$_POST["fecha"];
$valorGasto=$_POST["valorGasto"];
$porConceptoDe=$_POST["porConceptoDe"];
$pagadoA=$_POST["pagadoA"];	
}
}else {$fecha="CURDATE() ";}


$pagadoA='<option value=""
>SELECCIONE UN EMPLEADO</option>';
$query2="SELECT * FROM  `empleados`  ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["id"]==$pagadoa){$selected="selected";}else{$selected="";}
$pagadoA=$pagadoA.'<option value="'.$row["id"].'"
'.$selected.'>'.$row["nombre"].' '.$row["apellido"].'</option>';
}

?>


<div align="left">
<form method="post" autocomplete="off" action="nomina.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="nomina">
<input type="hidden" name="PagoDia" id="PagoDia" >


   <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">
          <h2>Nomina</h2>
        </div></div>
   	   <div class="row" style="width:100%">                          
                         <div class="col-md-3 col-sm-12">
						 <div class="form-group">
                         <label for="email">Fecha : </label>
     						<input class="form-control gasto" id="fecha" name="fecha" value="<?php echo $auxfecha; ?>" type="date"    >
						 </div>
						 </div>
                        		
						<div class="col-md-3 col-sm-12">
						<div class="form-group">
                        <label for="email">Tercero : </label>
						<select class="form-control gasto" id="pagadoA" name="pagadoA"  placeholder="A Quien Se Pago" ><?php echo $pagadoA; ?>
                         </select>
					   </div>
					   </div> 
           </div>
					

					
     <div class="row" style="width:100%">   

				<div class="col-md-3 col-sm-12"> 
                <div class="form-group">
                <label for="email">Dias trabajados : </label>
			  <input class="form-control gasto" type="number"  value="<?php echo $diasTrabajo; ?>" id="diasTrabajo" name="diasTrabajo" min="0">
			    </div> 
                </div>   


				<div class="col-md-3 col-sm-12"> 
                <div class="form-group">
                <label for="email">Total : </label>
                <input class="form-control pagosN" type="number" value="0" disabled    id="totalParcial"  name="totalParcial">
			    </div> 
                </div>   
 </div>

         <div class="row" style="width:100%">   
          <div class="col-md-3 col-sm-12"><div class="form-group">
          <label for="email">Abonos realizados : </label>
 		  <input class="form-control pagosN" type="number" value="0" disabled   id="abonosRealizados" name="abonosRealizados" >
          </div>
		  </div> 
		  
          <div class="col-md-3 col-sm-12"><div class="form-group">
          <label for="email">Total a pagar : </label>
		  <input class="form-control pagosN" type="number" value="0" disabled  id="totalPago" name="totalPago" >
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
                            <label for="email">Fecha : </label>
						   <input id="findFecha" name="fecha"  type="date" class="form-control">
            </div></div>
        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Empleado : </label>
				<select class="form-control" id="findUsuario"  ><?php echo $pagadoA; ?></select>
            </div></div>
			
			
        <div class="col-md-1 col-sm-12"><div class="form-group">
                <label for="email">&nbsp; </label>
   			  <input class="form-control" title="buscar....." type="image" src="imagenes/16325437-lupa-buscar-en-la-base-de-datos-icono-aislado-en-blanco.jpg" width="36" height="30" id="buscarNominas" >
            </div></div>



        <div class="col-md-1 col-sm-12"><div class="form-group">
                <label for="email">&nbsp; </label>
   			 <input class="form-control" type="image" src="imagenes/actualizar.png" width="36" height="30" id="actualiza" title="actualizar la lista">
            </div></div>
        
         <div class="col-md-1 col-sm-12"><div class="form-group" style="padding-left: 10px;">
                <label for="email">&nbsp; </label>
                <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaGastos';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 

            </div></div>
        
    </div>
     <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">


<table class="table "  id="tabla_resultados"     >
<tr align="center">
<td><strong>COMPROBANTE</strong></td>
<td width="64"><strong>USUARIO</strong></td>
<td  ><strong>FECHA</strong></td>
<td  ><strong>VALOR</strong></td>
<td ><strong>IDENTIFICACION</strong></td>
<td ><strong>EMPLEADO</strong></td>
<td  ><strong>POR CONCEPTO</strong></td>
 
</tr>
<tbody id="tablanomina">
<?php 
$query2="SELECT * FROM  `vwnomina` ";
//	echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {

echo "<tr><td nowrap class= 'ui-widget-content'><a href='desplegarNominas.php?idSF=".$row["idSF"]."'><img src='imagenes/libro.jpg'></a></td>
<td nowrap class= 'ui-widget-content'>".$row["nombreUsuario"]."</td>
<td nowrap class= 'ui-widget-content'>".$row["fecha"]."</td>
<td nowrap class= 'ui-widget-content'>".amoneda($row["totalParcial"])."</td>
<td nowrap class= 'ui-widget-content'> ".$row["pagadoA"]." </td><td> ".$row["nombre"].' '.$row["apellido"]."</td>
<td class= 'ui-widget-content'>".$row["porConceptoDe"]."</td>
 
</tr>";
}


 
$result->free();
$conn->close();

?>
</tbody></table>
</div></div></div></div>
