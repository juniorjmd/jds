<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<title>DEPOSITOS Y BANCOS</title> 
<?php 
include 'db_conection.php';
 $conn= cargarBD();
 include 'php/funcionesMysql.php';
 $conexion =\Class_php\DataBase::getInstance();
 $link = $conexion->getLink();  
 $valorDeposito = $VAUCHE = '';
 if(isset($_POST['valorDeposito'])){
$fecha ="'".normalize_date($_POST["fecha"],"-")."'"; 
$stmt = $conn->stmt_init();
$aux1="";
	$aux2="";
if(trim($_POST['descripcion'])!=""){
	$aux1=",`DESCRIPCION`";
	$aux2=",'".$_POST['descripcion']."'";
	}
revisaCierres($fecha,$conn);
$query="INSERT INTO  `bancos` (
 `id_deposito` ,
 `VALOR` ,
 `VAUCHE` ,
 `FECHA` ,
 `HORA` ,
 `IMANGEN`".$aux1."
)
VALUES (
NULL ,  '".$_POST['valorDeposito']."',  '".$_POST["VAUCHE"]."',  '".$_POST['fecha']."',  CURTIME(),  'imagenes/Sin_imagen.png'".$aux2.");";
// echo $query;
//$stmt->prepare($query);
//if(!$stmt->execute()){

$consulta = $link->prepare($query);
if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
	$valorDeposito=$VAUCHE="";
	echo '<script>window.location="bancos.php"</script>';
	}
 }else {$fecha="CURDATE() ";}
 ?>
<head> 
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


$('#btnListar').click(function(){ 
    
    $.ajax({
        url: 'saveGastSalEfect.php',
        type: 'POST',
        async: true,
        data: 'fecha='+ $('#fInicio').val()+'&fechaHasta='+ $('#fFin').val()+'&tabla=bancos',
         dataType:"html", 
         error: function(xhr, ajaxOptions, thrownError) {
                alert(JSON.stringify(xhr.status));
                alert(JSON.stringify(ajaxOptions));  
                alert(JSON.stringify(thrownError));},
        success: function(responseText){
           //  alert(responseText) ;
        $("#tablaGastos").html(responseText);
        }  
       }); 
   });
   
    //$('#btnListar').trigger('click');
});   
</script>

</head>
<div width="90%" class="mx-auto" > 
<form action="bancos.php" method="post" autocomplete="off">
   
    <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12"><h2>Bancos</h2></div></div>
 <div class="row" style="width:100%">                          
                         <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Fecha : </label>
                            <input  class="form-control" 
                                   id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" class="gasto" type="date" >
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Valor : </label>
                            <input   class="form-control" type="number" width="" id="valorDeposito" name="valorDeposito" value="<?php echo $valorDeposito; ?>"  placeholder="Ingrese el valor" class="gasto">
                            
                        </div></div> 
                        <div class="col-md-3 col-sm-12"> 
                            <div class="form-group">
                                    <label for="email">Num. Vauche : </label>
                                    <input   class="form-control"   id="VAUCHE" name="VAUCHE" type="text"  value="<?php echo $VAUCHE; ?>"  class="gasto" placeholder="ingrese el vauche" >
                                  </div> 
                        </div>   
                   
                    </div>
      <div class="row" style="width:100%">   
          <div class="col-md-5 col-sm-12"><div class="form-group">
                            <label for="email">Descripción : </label>
                             <textarea class="form-control" cols="42" id="descripcion" name="descripcion"  rows="3"> </textarea>
                        </div></div> 
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
        
        <div class="col-md-1 col-sm-12"><div style="padding-left: 10px;" class="form-group">
                <label for="email">&nbsp; </label>
                <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaBancos';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
                       
            </div></div>
        
        
        
    </div>
     <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">
    <table class="table "  id="tabla_resultados"     >
<tr align="center">
<td width="64"><strong>COD.</strong></td>
<td width="221"><strong>PROVIENE DE</strong></td>
<td width="84"><strong>FECHA</strong></td>
<td width="113"><strong>#VAUCHE</strong></td>
<td width="81"><strong>VALOR</strong></td>
<td width="215"><strong>DESCRIPCION</strong></td>
<td width="73"  class='descImg'><strong>IMAGEN</strong></td>
</tr>
<tbody id="tablaGastos" class="tblInfo">
<?php

$query2="SELECT * FROM  `bancos`  where `fecha`= ".$fecha;
// echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	echo "<tr>
<td class = 'ui-widget-content'>".$row["id_deposito"]."</td>
<td class = 'ui-widget-content'>".$row["provieneDe"]."</td>
<td class = 'ui-widget-content'>".$row["FECHA"]."</td>
<td class = 'ui-widget-content'>".$row["VAUCHE"]."</td>
<td class = 'ui-widget-content'>".amoneda($row["VALOR"])."</td>
<td class = 'ui-widget-content'>".$row["DESCRIPCION"]."</td>
<td  class='descImg ui-widget-content'><img   src='".trim($row["IMANGEN"])."' ></td>
</tr>";
}
$result->free();
$conn->close();
?>
    </tbody>
</table>
        </div></div></div></div>