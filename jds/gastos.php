<?php  
include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
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
  
 
$('#btnListar').click(function(){ 
    
    $.ajax({
        url: 'saveGastSalEfect.php',
        type: 'POST',
        async: true,
        data: 'fecha='+ $('#fInicio').val()+'&fechaHasta='+ $('#fFin').val()+'&tabla=gastos',
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
$('#origenPago').change(function(){
             
     
            if ($(this).val() == 'caja'){
                $("#vauche").val(0)
                $('#tr_origenPago').fadeOut()
            }else{
                $("#vauche").val('')
                $('#tr_origenPago').fadeIn()
            }
        })
$('#origenPago').trigger('change')

   });			 
					

</script>
<style>
#TablaInicial td { font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
#titulo{ font-size:30px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.boton{ height:50px; width:80px}
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
</style></head>

<?php 
include 'db_conection.php';
 $conn= cargarBD();
 
$conexion =\Class_php\DataBase::getInstance();
 $link = $conexion->getLink();  
 
$descripcion='';
$auxfecha= date("Y-m-d");  
$valorGasto='';
$porConceptoDe='';
$pagadoA=''; 
if(isset($_POST["idUsuario"])){
include 'php/funcionesMysql.php';
 
$_POST["valorGasto"] = str_replace('.', '', $_POST["valorGasto"]);
$_POST["valorGasto"] = str_replace('$', '', $_POST["valorGasto"]);
$_POST["valorGasto"] = str_replace(',', '', $_POST["valorGasto"]);
$_POST["valorGasto"] = str_replace(' ', '', $_POST["valorGasto"]);
print_r($_POST);
$stmt = $conn->stmt_init();
$fecha ="'".$_POST['fecha']."'"; 
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){
$query="INSERT INTO  `".$_POST["tabla"]."`(
    idGasto, idUsuario, nombreUsuario, descripcion, fecha, valorGasto, idSucursal, 
    porConceptoDe, pagadoA, hora, estado, nit_persona, pagado_desde, ref1, ref2, ref3) VALUES (
NULL , '".$_POST["idUsuario"]."','".
$_POST["nombreUsuario"]."','".
$_POST["descripcion"]."',".
$fecha .", ".
$_POST["valorGasto"]." ,'".
$_SESSION["id_suc"]."','".
$_POST["porConceptoDe"]."','".
$_POST["pagadoA"]."',CURTIME(),'activo','".$_POST["nitBusqueda"]."','".$_POST["origenPago"]."','".$_POST["vauche"]."','','');";




//$stmt->prepare($query);
//if(!$stmt->execute()){
echo $query;
$consulta = $link->prepare($query);
if(!$consulta->execute()){



//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
echo '<script>window.location="gastos.php"</script>';
}
}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
$descripcion=$_POST["descripcion"];
$auxfecha=normalize_date($_POST["fecha"],'/');
$valorGasto=$_POST["valorGasto"];
$porConceptoDe=$_POST["porConceptoDe"];
$pagadoA=$_POST["pagadoA"];	
}}else {$fecha="CURDATE() ";}


?>
<div id='ContBusquedaPersonas'></div>
<div id="contenedor" width="90%" class="mx-auto" > 
    
<form method="post" autocomplete="off" action="gastos.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="gastos">
 <div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12"><h2>Gastos</h2></div></div>
        
 <div class="row" style="width:100%">                          
                         <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Fecha : </label>
                            <input  class="form-control" 
                                   id="fechaGasto" name="fecha" value="<?php echo $auxfecha; ?>" value="<?php echo date("Y-m-d"); ?>" class="gasto" type="date" >
                        </div></div>
       <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Valor : </label>
                            <input    type="number" width="" id="valorGasto" 
                                     name="valorGasto" value="<?php echo $valorGasto; ?>"  
                                     placeholder="Ingrese el valor" class="gasto form-control">
                            
                        </div></div> 
                        <div class="col-md-3 col-sm-12"> 
                            <div class="form-group">
                                    <label for="email">Origen Pago : </label>
                                      <select id="origenPago" class="gastos form-control" name="origenPago" >
                                        <option value="caja" >CAJA</option>
                                        <option value="banco" >BANCOS</option>

                                    </select>
                            </div> 
                        </div>   
     
     </div>

<div class="row" style="width:100%">
    <div class="col-md-4 col-sm-12"> 
    <?php agregarBusquedaPersonas('pagadoA','contenedor',[
    "clase" => "gasto" ,
    "table" => false,
    "titulo" => 'Nit/Cedula',
    "tBtn" => 2
]);?>
</div>
    <div id="tr_origenPago" class="col-md-4 col-sm-12">  
        <div class="form-group">
                                    <label for="email">Numero del Vauche : </label>
  <input id="vauche" name="vauche" type="text"  value="<?php echo $vauche; ?>" 
         class="gasto form-control" placeholder="NUMERO DEL VAUCHE"   required >
   
    </div>
</div>
</div>

<div class="row" style="width:100%">
    <div class="col-md-4 col-sm-12"> <div class="form-group">
             <label for="email">Nombre / Razon social : </label>
        <input id="pagadoA" name="pagadoA" type="text"  value="<?php echo $pagadoA; ?>"  
               class="gasto form-control" placeholder="Nombre / Razon social" readonly required >
</div></div>
    
    
      <div class="col-md-6 col-sm-12"> 
          <div class="form-group">
      <label for="email">Concepto : </label>
            <?php GENERAR_SELECT_DINAMICO('porConceptoDe','el concepto del gasto',
            'vw_gastos_operacionales','nro_scuenta','nombre_scuenta',[
    "clase" => "gasto form-control"  
]  ,null,
           array([
        'COL' => 'id_seleccion',
        'VALOR'=>'0',
        'SIGNO'=>'>',
        'RELACION'=>''
             ])
             ,array('orderby' => '' ,'groupby' => '') ,    null , ['nombre_scuenta','nombre_cuenta','nombre_grupo']); ?>   

          
          
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
                $nombreArchivo= 'listaGastos';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
                       
            </div></div>
        
        
        
  </div>
<div class="row" style="width:100%">   
        <div class="col-md-12 col-sm-12">
    <table class="table "  id="tabla_resultados"     >
        <tr>
<td><strong>USUARIO</strong></td>
<td><strong>FECHA</strong></td>
<td><strong>VALOR</strong></td>
<td><strong>PAGADO A</strong></td>
<td><strong>POR CONCEPTO</strong></td>
<td><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablaGastos">
<?php 
$query2="SELECT * FROM  `gastos`  where `fecha`= ".$fecha;
//	echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	echo "<tr>
<td class = 'ui-widget-content'>".$row["nombreUsuario"]."</td>
<td class = 'ui-widget-content'>".$row["fecha"]."</td>
<td class = 'ui-widget-content'>".amoneda($row["valorGasto"])."</td>
<td class = 'ui-widget-content'>".$row["pagadoA"]."</td>
<td class = 'ui-widget-content'>".$row["porConceptoDe"]."</td>
<td class = 'ui-widget-content'>".$row["descripcion"]."</td>
</tr>";


}

//$datos["datos"]=$data;
$result->free();
$conn->close();

?>
</tbody></table></div></div>

</div>

