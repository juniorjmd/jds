<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
 include 'db_conection.php';
 $conn= cargarBD();
if($_POST['insertar']=="si"){

if($_POST['cantidadAct']!="")
  $aux="`cantActual` =".$_POST['cantidad']." +  `compras` -  `ventas` ,";
  
  $PmasIVA=$_POST['Pventa2'];
	$valorIva=1+($porcent_iva/100);
		$PSinIVA =round($PmasIVA/$valorIva, 2);
	$IVA=$PmasIVA-$PSinIVA;
 
$stmt = $conn->stmt_init();
	$query="UPDATE  `producto` SET  
	`idGrupo` =  '".$_POST['idGrupo']."',
`Grupo` =  '".$_POST['Grupo']."',
`subgrupo_1` =  '".$_POST['idGrupo2']."',
`nom_subgrupo_1` =  '".$_POST['Grupo2']."',
`subgrupo_2` =  '".$_POST['idGrupo3']."',
`nom_subgrupo_2` =  '".$_POST['Grupo3']."',
`descripcion` =  '".$_POST['descripcion']."',`idlab` = '".$_POST['idlab']."' ,
`laboratorio`=  '".$_POST['laboratorio']."' ,
`nombre` =  '".$_POST['nombre']."',
`precioVenta` =  '".$PmasIVA."',
`PsIVA` ='".$PSinIVA."', 
`IVA` ='".$IVA."',
 `porcent_iva` ='".$porcent_iva."',
`precioCompra` =  '".$_POST['Pcompra']."',
`cantInicial` =  '".$_POST['cantidad']."', ".$aux."
`stock` =  '".$_POST['stock']."',`imagen` =  '".$_POST['imagenGuardar'].
"',`barcode`  =  '".$_POST['barCode']."'  WHERE CONVERT(  `producto`.`idProducto` USING utf8 ) =  '".$_POST['codigo']."' LIMIT 1 ;";
 $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink(); 
$consulta = $link->prepare($query);
//$stmt->prepare($queryCompra);
if(!$consulta->execute()){  	  
		throw new Exception('No se pudo realizar la actualizacion de datos :' . $link->errorCode());
		 
		}else{
			echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el producto fue editado con exito!!!!!!!!!!!   <br><br></div>';
			echo '<script>window.location="editar.php"</script>';
		echo'<script>
		setTimeout(function() {
        $(".content").fadeOut(1000);
		
    },2000);
		</script>';
		}
		}
		if($_POST['codigo']){
	$codigoSend=$_POST['codigo'];}
	else{$codigoSend=$_GET['codigo'];}
$query2="SELECT * FROM  `producto`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
	$i=$aux=0;
while ($row = $result->fetch_assoc()) {$aux++;
	$rowAux[$aux]['id']=$row["idProducto"];
	if(trim($row["idProducto"])==trim($codigoSend)){
		$i=$aux;
	$codigo=$row["idProducto"];
	$idGrupo=$row["idGrupo"];
	$idGrupo2=$row["subgrupo_1"];
	$idGrupo3=$row["subgrupo_2"];
	
	$descripcion = $row["descripcion"];
	
	$idlab=$row["idLab"];
    $nombre=$row["nombre"];
    $Pventa=$row["precioVenta"];
    $Pcompra=$row["precioCompra"];
    $cantidad=$row["cantInicial"];
    $stock=$row["stock"];
	$porcent_iva=$row["porcent_iva"];
    $imagenGuardar=$row["imagen"];
	$CantAct=$row["cantActual"];
	$barCode = $row["barcode"];}
} }
if ($descripcion == '' ) {$descripcion = 'Ninguna';}

$result->free();

echo '<input type="hidden"  id="barCodeAux" value="'.$barCode.'">'; 
echo '<input type="hidden" name="porcentajeIva" id="porcentajeIva" value="'.$porcent_iva.'">'; 

if($i==1){
	$sig=2;
	$ant=$aux;
	}else{
	if($i==$aux){
		$sig=1;
		$ant=$i-1;
		}else{$sig=$i+1;
		$ant=$i-1;}
	}
	$siguiente=$rowAux[$sig]['id'];
	$anterior=$rowAux[$ant]['id'];
$query2="SELECT * FROM `grupo2`";
//echo $query2;
$result = $conn->query($query2);
$nomGrupo2="";
$grupos2 =$grupos3 ="<option value ='0' >NINGUNO</option>";
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {$select='';
	if($idGrupo2==$row["idGrupo"]){$select="selected";$nomGrupo2=$row["GRUPO"];}
	$grupos2=$grupos2.'<option  value="'.$row["idGrupo"].'" '.$select.' >'.$row["GRUPO"].'</option>';
	
	
	
	}
} 

$query2="SELECT * FROM `grupo3`";
//echo $query2;
$result = $conn->query($query2);
$nomGrupo="";
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {$select='';
	if($idGrupo3==$row["idGrupo"]){$select="selected";$nomGrupo3=$row["GRUPO"];}
	$grupos3=$grupos3.'<option  value="'.$row["idGrupo"].'" '.$select.' >'.$row["GRUPO"].'</option>';}
} 

$query2="SELECT * FROM `grupo`";
//echo $query2;
$result = $conn->query($query2);
$nomGrupo="";
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {$select='';
	if($idGrupo==$row["idGrupo"]){$select="selected";$nomGrupo=$row["GRUPO"];}
	$grupos=$grupos.'<option  value="'.$row["idGrupo"].'" '.$select.' >'.$row["GRUPO"].'</option>';}
} 
$result->free();$nomLab="";
$query2="SELECT * FROM `marcas`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$select='';
	if($idlab==$row["idlab"]){$select="selected";$nomLab=$row["laboratorio"];}
	$lab=$lab.'<option value="'.$row["idlab"].'" '.$select.' >'.$row["laboratorio"].'</option>';}
}
$conn->close();
?>
<title>EDICION DE PRODUCTOS</title>
<style>
select{ font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.articulo{ background: #F5F5F5; font-family:Arial, Helvetica, sans-serif; font-size:13px; color: #000000; border-radius: 5px 5px 5px 5px; padding: 5px;  border: 1.5px solid #999999; }



  
  
   
   
   
   


.boton{ height:36px; width:38px; }
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
 select {width:95%}
.Estilo1 {
	font-family: "Arial Narrow";
	font-size: 18px;
	color: #993300;
	font-weight: bold;
}
.Estilo6 {font-family: "Arial Narrow"; font-size: 17px; color: #993300; }
.Estilo11 {
	font-family: "Arial Narrow";
	font-size: 17px;
}

input.text, select.text, textarea.text {
   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.Estilo12 {
	font-family: "Arial Narrow";
	font-size: 16px;
	color: #993300;
	font-style: italic;
	font-weight: bold;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.Estilo14 {font-family: "Arial Narrow"; font-size: 20px; color: #993300; font-weight: bold; }
</style>
<form action="editar.php" method="post" autocomplete="off" class="formulario">
<div align="center" style="width:100%">
<input type="hidden" name="Grupo2" id="Grupo2" value="<?php echo $nomGrupo2; ?>">
<input type="hidden" name="Grupo3" id="Grupo3" value="<?php echo $nomGrupo3; ?>">
<input type="hidden" name="insertar" id="insertar" value="si"><input type="hidden" name="laboratorio" id="laboratorio" value="<?php echo $nomLab; ?>">
<input type="hidden" name="Grupo" id="Grupo" value="<?php echo $nomGrupo; ?>">
	<a href="editar.php?codigo=<?php echo $anterior;?>" class="Estilo14" title="Atras"> << </a>			&nbsp;&nbsp;&nbsp;&nbsp;		<a href="editar.php?codigo=<?php echo $siguiente;?>" class="Estilo14" title="Adelante">	>> </a>
<table width="78%" height="486" border="0" style='' >
  <tr>
    <td height="45" colspan="7" align="center"><p><span class="Estilo1">EDITAR  PRODUCTO<br />
    _________________________________________________________________________________</span>&nbsp;</p></td>
    </tr>
  <tr>
    <td width="80" rowspan="12">&nbsp;</td>
    <td width="146" height="24" align="right"><span class="Estilo6">Codigo&nbsp;</span></td>
    <td colspan="2"><span class="Estilo12">
      <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo; ?>">
      <?php echo $codigo; ?></span></td>
    <td colspan="2" rowspan="4" valign="top"><div style="height:10; width:200" class="precarga">
   <input type="image" id="pictSelct" name="pictSelct" src="<?php echo $imagenGuardar;?>" height="100" width="200" style="margin-left:60px" >
   <input type="file" name="archivos[]" style="display:none" id="archivosUp"/>
    <input type="hidden" name="imagenGuardar" id="imagenGuardar" class="articulo" value="<?php echo $imagenGuardar;?>" >
    <input type="hidden" name="archivo" id="archivo" class="articulo" value="<?php echo $imagenGuardar;?>" >
   </div></td>
    <td width="56" rowspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td height="28" align="right"><span class="Estilo6">Nombre&nbsp;</span></td>
    <td colspan="2"><input type="text" name="nombre" id="nombre" value="<?php echo  $nombre;?>" class="articulo" ></td>
    </tr>
  <tr>
    <td height="28" align="right"><span class="Estilo6">Cantidad Inicial &nbsp;</span></td>
    <td colspan="2"><input type="number" name="cantidad" id="cantidad" value="<?php echo  $cantidad;?>" class="articulo"> <input type="hidden" name="cantidadAct" id="cantidadAct"  value="<?php echo $cantidad;?>" ></td>
    </tr><tr>
    <td height="28" align="right"><span class="Estilo6">Estock Minimo &nbsp;</span></td>
    <td colspan="2"><input type="number" name="stock" id="stock" class="articulo"  value="<?php echo $stock;?>"></td>
    </tr>
	
	<tr>
    <td height="36" align="right"><span class="Estilo6">Descripción :</span></td>
    <td valign="middle" colspan='4'  > <textarea name="descripcion" cols="70" rows="3" class="text"><?php echo $descripcion;?></textarea> </td>
	</tr>
	<tr>
    <td  align="right"><span class="Estilo6">Categoria/Grupo</span></td>
    <td width="286"colspan="2"><select name="idGrupo" id="idGrupo" class="articulo"><?php echo $grupos; ?></select></td>
	
	 <td height="24" align="right"><span class="Estilo6">Iva</span></td>
	 <td ><select name="porcent_iva" id="porcent_iva" class="articulo">
       <option value="0">EXENTO</option>
 
      <option value="19">IVA 19%</option>
      <option value="18">IVA 18%</option>
      <option value="17">IVA 17%</option>
      <option value="16">IVA 16%</option>
	  
      <option value="15">IVA 15%</option>
      <option value="14">IVA 14%</option>
	  
      <option value="13">IVA 13%</option>
      <option value="12">IVA 12%</option>
	  
      <option value="11">IVA 11%</option>
      <option value="9">IVA 9%</option>
      <option value="8">IVA 8%</option>
      <option value="7">IVA 7%</option>
      <option value="5">IVA 5%</option>
      <option value="4">IVA 4%</option>
      <option value="3">IVA 3%</option> 
    </select></td>
    </tr>
    <tr>
   
	
    <td height="28" align="right"><span class="Estilo6">Marca</span></td>
    <td colspan="2" ><select name="idlab" id="idlab" class="articulo">
      <?php echo $lab; ?>
    </select></td>
    <td width="113" align="right"><span class="Estilo6">Cantidad Actual</span></td>
    <td width="240"><input type="number" name="Pventa" id="Pventa" class="articulo"  value="<?php echo $CantAct;?>"></td>
    </tr>
	
	<tr>
    <td height="28" align="right"><span class="Estilo6">Precio Compra </span></td>
    <td colspan="2"><input type="number" name="Pcompra" id="Pcompra" class="articulo" value="<?php echo $Pcompra;?>" /></td>
    <td width="113" align="right"><span class="Estilo6">Precio  Venta</span></td>
    <td width="240"><input type="number" name="Pventa2" id="Pventa2" class="articulo"  value="<?php echo $Pventa;?>" /></td>
	</tr>
    <tr>
    <tr style="display:none">
    <td height="31" align="right">SUBGRUPO 2</td>
    <td colspan="2"><select name="idGrupo3" id="idGrupo3">
      <?php echo $grupos3; ?>
    </select></td>
    <td width="113" align="center"> SUBGRUPO 1</td>
    <td width="240"><select name="idGrupo2" id="idGrupo2"  >
        <?php echo $grupos2; ?>
      </select></td></tr>
    <tr>
	 <tr style="display:none">
	 <td colspan='2'height="28" align="right"><span class="Estilo11">CODIGO DE BARRAS</span></td><td  align="LEFT" colspan='3'><input style='width:75%' value="<?php echo $barCode;?>"  type="text" name="barCode" id="barCode" class="articulo" >
	  <span id='msgBarcode'></span>
	  <!--<input type='image' height="50" src='imagenes/icono-generar.png'>--></td>	
	 </tr>
    <td height="87" colspan="7" align="center">
    
          
            <span class="Estilo1">_______________________________________________________________________________________</span><br />
             <input  type="image" src="guardar1.png" width="38" height="36" id="enviar" value="Editar" class="boton" >
			 
			<img src="btn_cancelar.png" width="38" height="36" border="0" title="Regresar" onclick="algo()"/>
	       
      </td>
    </tr>
</table>
</div></form>



<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$('#barCode').keydown(function(e){			//alert(e.keyCode)
		//e.preventDefault();
		var tecla=e.keyCode;
		if(tecla==13){
		if ($(this).val()!=$('#barCodeAux').val())	{
		var datosAjax = {tabla: 'producto',
		inicio: '',
		datosRequeridos:null,
		where:true,
		igual:true,
		columna1:'barcode',
		dato:$(this).val()
		};		
		$.ajax({url: 'php/db_listar_nuevo.php',  
			type: 'POST',
			data: datosAjax,
			dataType: "json",
			 beforeSend: function() {
				//alert(JSON.stringify(datosAjax))
				console.log(JSON.stringify(datosAjax))
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
				console.log(JSON.stringify(data))
				datosTabla=data['filas'];
				if (datosTabla>0){$('#msgBarcode').html('<br>el codigo de barra que intenta ingresar pertenece a otro producto');$('#msgBarcode').focus();
				$('#barCode').val('')
				}else{$('#msgBarcode').html('ok');}
				},error: function(a,e,b){
					 console.log(JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto
					}else{$('#msgBarcode').html('OK')}
e.preventDefault();					
	}})
	
	
	$("#porcent_iva").val($("#porcentajeIva").val());
	var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {if ($(this).val() == "") {
      //  alert("no escogio una verga");
    }else{
		 var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
		$("#archivo").val($("#pictSelct").attr("src"));
        r = confirm("ESTA A PUNTO DE CAMBIAR LA IMAGEN PERMANENTEMENTE, DESEA CONTINUAR");
		if(r==true){
		$.ajax({
            url: 'upload/upload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                $("#enviar").attr("disabled","disabled")
				$("#cancelar").attr("disabled","disabled")
				$("#pictSelct").css("display","none")
		      
            },
            //una vez finalizado correctamente
            success: function(responseText){
				//alert(responseText)
               $("#enviar").removeAttr('disabled');
				$("#cancelar").removeAttr('disabled');
				$("#pictSelct").attr("src",responseText)
				$("#imagenGuardar").val(responseText)
				$("#pictSelct").css("display","inline")
               
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });}
		
		}
    });
	
		
  
	
	
	
$("#pictSelct").click(function(e){
	e.preventDefault();
	
		$("#archivosUp").trigger("click");
	});
	
	
$("#enviar").click(function(e){
	 var str="";
	 var h=0;//`cantActual` =  '
	 
	 if(Trim($('#barCode').val())== ''){
		 $('#barCode').val($('#barCodeAux').val())
	 }
	 if(Trim($('#barCode').val())== ''){
		 $('#barCode').val($('#codigo').html())
	 }
	 if($("#cantidadAct").val()!=$("#cantidad").val()){
	 	$("#cantidadAct").val($("#cantidad").val()+"+`compras`-`ventas`")
	 }else{$("#cantidadAct").val("");}
	$(".articulo").each(function() {$(this).focus();
        if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			$(this).focus();
			 h=1;
			 return false;
			}
    });
	if(h==1){e.preventDefault();}
	});
	
	
/*$("#cancelar").click(function(){
	//location.href="invView.php";
	window.location="invView.php";
	});
	*/

	
$("#idGrupo2").change(function(){
$("#Grupo2").val( $( "#idGrupo2 option:selected" ).text() );})		
$("#idGrupo2").trigger( "change" );	
$("#idGrupo3").change(function(){
$("#Grupo3").val( $( "#idGrupo3 option:selected" ).text() );})		
$("#idGrupo3").trigger( "change" );	

$("#idGrupo").change(function(){
$("#Grupo").val( $( "#idGrupo option:selected" ).text() );})	
	});
$("#idGrupo").trigger( "change" );

$("#idlab").change(function(){
$("#laboratorio").val( $( "#idlab option:selected" ).text() );})		
$("#idlab").trigger( "change" );	


function algo(){ 
//opener.location.reload(); 
//window.location=invView.php; 
 window.location.href="comprasEdit.php";
} 

	

</script>


