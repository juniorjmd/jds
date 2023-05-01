<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
 ?><head>
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
	
$(".abonos").click(function(){
	var dato=$(this).attr("id");
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ABONO REALIZADO");
	
		if(r==true){
			do {
var name = prompt ('POR FAVOR DIGITE SU CLAVE PARA ELIMINAR');
} while (name == null || Trim(name) == "");

		datos='password='+encodeURIComponent(name);
		  
$.ajax({
			url: 'convierteMD5.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			name=responseText;
			}
		});
		if(Trim(name) !=$("#IEJAH12HASJKAÑSL").val())
{alert("CLAVE INVALIDA....");
r=false;}



if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("abonosnomina")
		  +"&columna="+encodeURIComponent('id_abono');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
		 document.location.reload();  
			}
		});
		}}
	
	});
	
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
	if(h==1){e.preventDefault();}
	
	});
	
$('#btnListar').click(function(){ 
    
    $.ajax({
        url: 'saveGastSalEfect.php',
        type: 'POST',
        async: true,
        data: 'fecha='+ $('#fInicio').val()+'&fechaHasta='+ $('#fFin').val()+'&estadoNomina='+ $('#estadoNomina').val()+'&tabla=vwabonosnomina',
        dataType:"html",
        success: function(responseText){
        //    alert(responseText)
        $("#tablanomina").html(responseText);
        },
        error: function(){alert("nos se pudo")}
    });
});    	 
					

</script> </head>

<?php 
include 'db_conection.php';
 $conn= cargarBD();
 $conexion =\Class_php\DataBase::getInstance(); 
 $link = $conexion->getLink();   
 $auxfecha='';
 $pagadoa="";	
		$descripcion='';
 $auxfecha=date('Y-m-d');
 $valorGasto=0;
if(isset($_POST["idUsuario"])){
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
$fecha =$_POST["fecha"]; 
$execute=revisaPagos($fecha,$conn);
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){//echo "entro al primero";
	if($execute){//echo "entro al segundo";
		$query="INSERT INTO  `abonosnomina`(id_usuario, nombreUsuario, id_empleado, cantidad, fecha, estado, id_pago_nomina, descripcion, estadoNomina )  
		VALUES ('".$_SESSION['usuarioid']."','".
		$_SESSION['usuario']."','".
		$_POST["pagadoA"]."',  '".
		$_POST["valorGasto"]."','".
		$fecha ."',   'ACTIVO',  '','".
		$_POST["descripcion"]."','ACTIVO');";
		
              //  echo $query;
		//$stmt->prepare($query);
                $consulta = $link->prepare($query);
			if(!$consulta->execute()){
			//Si no se puede insertar mandamos una excepcion
			throw new Exception('No se pudo insertar:' . $stmt->error);
			}else{
                          echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
			echo '<script>window.location="abonoNomina.php"</script>';
                         
                        }

		}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO EL PAGO DE NOMINA, POR FAVOR CORRIJA </div><br><br>';
		$auxfecha=$_POST["fecha"];
		$valorGasto=$_POST["valorGasto"];
		$pagadoa=$_POST["pagadoA"];	
		$descripcion=$_POST['descripcion'];
		echo 'entro 1';
		}
	}
	else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
	$auxfecha=$_POST["fecha"];
	$valorGasto=$_POST["valorGasto"];
	$pagadoa=$_POST["pagadoA"];	
	$descripcion=$_POST['descripcion'];
	echo 'entro 2';
}

}
else {$fecha="CURDATE() ";}
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
 
$result->free();



?>
<div align="left">
<input type="hidden" name="1234ASDF79A65SDF" id="IEJAH12HASJKAÑSL" value="<?php echo $_SESSION["IJKLEM1934589"];?>">
<form method="post" autocomplete="off" action="abonoNomina.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="nomina">


    <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">
          <h2> Adelanto de nomina</h2>
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

				<div class="col-md-4 col-sm-12"> 
                <div class="form-group">
                <label for="email">Tercero : </label>
 			   <select class="form-control" id="pagadoA" name="pagadoA" class="gasto" placeholder="A Quien Se Pago" >
                               <?php echo $pagadoA; ?>
               </select>
			    </div> 
                </div>   

  
          <div class="col-md-5 col-sm-12"><div class="form-group">
          <label for="email">Descripción : </label>
          <textarea class="form-control" cols="42" id="descripcion" name="descripcion"  rows="3"><?php echo $descripcion; ?></textarea>
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
                                   type="date" id="fInicio"   >
                       
            </div></div>
        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Hasta : </label>
                            <input  class="form-control" 
                                   type="date" id="fFin"   >
                       
            </div></div>
			
			
			<div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Estado : </label>
						   <select id="estadoNomina" class="form-control">
                    <option value=''>TODOS</option>
                    <option value="ACTIVO">ACTIVO</option><option value="INACTIVO">PAGADO</option>
                </select>
            </div></div>
			
			
			
        <div class="col-md-1 col-sm-12"><div class="form-group">
                <label for="email">&nbsp; </label>
                <button class="btn btn-success"id="btnListar">Consultar</button>
                       
            </div></div>
        
        <div class="col-md-1 col-sm-12"><div class="form-group" style="padding-left: 10px;">
                <label for="email">&nbsp; </label>
                <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaAbonosNomina';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
            </div></div>
 


        
        
    </div>



     <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">




<table class="table "  id="tabla_resultados"     >
<tr align="center">
<td><strong>&nbsp;</strong></td>
<td width="64"><strong>USUARIO</strong></td>
<td width="120"><strong>FECHA</strong></td>
<td width="84"><strong>VALOR</strong></td>
<td width="120"><strong>TERCERO</strong></td>

<td width="81"><strong>ESTADO</strong></td>
<td width="180"><strong>DESCRIPCION</strong></td>
</tr>
<tbody id="tablanomina">
<?php 
$query2="SELECT * FROM  `vwabonosnomina`  where `estadoNomina`= 'ACTIVO' ORDER BY   `fecha` DESC ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {

echo "<tr>
<td><img src='imagenes/b_drop.png' id='".$row["id_abono"]."' class='abonos' style='cursor:pointer'></td>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["cantidad"]."</td>
<td>".$row["nombre"]." ".$row["apellido"]."</td>
<td>".$row["estadoNomina"]."</td>
<td>".$row["descripcion"]."</td>
</tr>";


}
 
$result->free();
$conn->close();

?>
</tbody></table>
</div></div></div></div>


