<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
 include 'db_conection.php';
 
$grupos2 =$grupos3 ="<option value ='0' >NINGUNO</option>";
 $conn= cargarBD();
$backDir="inventario.php";
$enviar="CreaProductos.php";

if($_GET['llamado']){$backDir="compras.php";
$enviar="CreaProductos.php?llamado=145632jlhsue";
}
if($_GET['AUX']){$AUX="&Aux=1";}
if($_POST['insertar']=="si"){
	$PmasIVA=$_POST['Pventa'];
	$valorIva=1+($_POST['iva']/100);
		$PSinIVA =round($PmasIVA/$valorIva, 2);
	$IVA=$PmasIVA-$PSinIVA;
	//echo "los precios son respectivamente con el iva y sin".$PmasIVA."  ".$IVA."  ".$PSinIVA;
		$stmt = $conn->stmt_init();
		$query="INSERT INTO `producto` ( `IDLINEA`,`idProducto` ,
		subgrupo_1,
		nom_subgrupo_1,
		subgrupo_2,
		nom_subgrupo_2,
		descripcion,		
		`idGrupo` ,`Grupo` , `idlab` ,`laboratorio` , `nombre` , `precioVenta`, `PsIVA`, `IVA` , `porcent_iva` ,`precioCompra` , `cantInicial` , `cantActual` , `compras` , `ventas` , `stock` , `imagen`,`barcode` ,`tipo_producto` , remisionada) VALUES ( ".$_POST['IDLINEA'].",'".$_POST['codigo'].
		"', '".$_POST['idGrupo2']."', 
		'".$_POST['Grupo2']."'
		, '".$_POST['idGrupo3']."',  
		'".$_POST['Grupo3']."'
		, '".$_POST['descripcion']."',  
		'".$_POST['idGrupo']."' , '".$_POST['Grupo']."', '".$_POST['idlab']."',  '".$_POST['laboratorio']."',  '".$_POST['nombre']."', '".$PmasIVA."', '".$PSinIVA."', '".$IVA."', '".$_POST['iva']."', '".$_POST['Pcompra']."','".$_POST['cantidad']."', '".$_POST['cantidad']."', '0', '0', '".$_POST['stock']."', '".$_POST['imagenGuardar']."', '".$_POST['barCode']."', '".$_POST['tipo_producto']."',0 );";
		 $stmt->prepare($query);
                  //ECHO $query;
                 
 $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink(); 
$consulta = $link->prepare($query);
//$stmt->prepare($queryCompra);
if(!$consulta->execute()){   	 
		throw new Exception('No se pudo insertar el nuevo producto :' . $link->errorCode());
		//break;
		}
		else{//echo '<script>window.location="CreaProductos.php"</script>';
		 
			}
		}
$query2="SELECT * FROM `producto` order by idlinea";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$codigo=substr($row["idProducto"],2);
	//echo $codigo.'<br>';
} 
}else{$codigo=0;}

 $codigo++;	
 $cod_aux = $codigo;
$result->free();
//////////////////////////////////////////////////

$query2="SELECT * FROM `grupo`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$grupos=$grupos.'<option value="'.$row["idGrupo"].'">'.$row["GRUPO"].'</option>';}$result->free();
}
 
 
 $query2="SELECT * FROM `grupo2`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$grupos2=$grupos2.'<option value="'.$row["idGrupo"].'">'.$row["GRUPO"].'</option>';}
	$result->free();
}
 
 
 $query2="SELECT * FROM `grupo3`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$grupos3=$grupos3.'<option value="'.$row["idGrupo"].'">'.$row["GRUPO"].'</option>';}$result->free();
}
 
 
 
 
$query2="SELECT * FROM `marcas`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$lab=$lab.'<option value="'.$row["idlab"].'">'.$row["laboratorio"].'</option>';}
}
$conn->close();
?>
<title>Creacion de Productos</title>
<style>
 
.boton{ height:36px; width:38px; }
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
</style>
 <!-- se agregan nuevos estilos con bootstrap --> 
   <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>

<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/> 
<!-- se agregan nuevos estilos con bootstrap --> 


<!-- <link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />-->
<!--<link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" title="win2k-1" />-->
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script> 
<script type="text/javascript" src="jsFiles/listas.js"></script> 
<!--<script type="text/javascript" src="jsFiles/boxover.js"></script>-->
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="js/json2.js"></script>

<script type="text/javascript" src="inicioJS/carteraInicio.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>  
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/>  
 
<form action="<?php echo $enviar;?>" method="post" autocomplete="off" class="formulario">
    <div class="row">
        <div class="col-md-12 col-sm-12"><h2>Creación De Productos</h2><hr /></div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12"><label>Código de producto</label>
            <div><strong>MV<?php echo $codigo; ?></strong>   </div>
        </div>
        <div class="col-md-3 col-sm-12"><label></label>
                    <div> <button class="btn btn-success"    id="enviar" value="Registrar"  > Registrar
                
                </button></div>
        </div>
            
        <div class="col-md-4 col-sm-12">
            <div style="height:10px;  " class="precarga">
      <input type="image" id="pictSelct" name="pictSelct" src="imagenes/imagen_subirla.jpg" height="180px" width="200px" style="margin-left:60px" title="Carga la imagen del producto">
    <input type="file" name="archivos[]" style="display:none" id="archivosUp"/>
    <input type="hidden" name="imagenGuardar" value="imagenes/Sin_imagen_3.png" id="imagenGuardar" class="articulo" ></div>
        </div>
        
    </div>
    
    
    <div class="row">
         <div class="col-md-6 col-sm-12"><label>Nombre</label>
            <div><input type="text" name="nombre" id="nombre" class="form-control articulo" >  </div>
        </div>
       
    </div>
    <div class="row">
         <div class="col-md-2 col-sm-12"><label>Cantidad Inicial</label>
            <div><input type="number" name="cantidad" id="cantidad" class="form-control articulo" step="any">  </div>
        </div>
        
        <div class="col-md-2 col-sm-12"><label>Tipo Producto</label>     
            <div> <select id="aux_tipo_producto" class="form-control text" > 
        <option value="PT">Producto terminado</option>
        <option value="MT">Materia prima</option></select>
        <input type="hidden" name="tipo_producto" id="tipo_producto" class="articulo form-control" > </div>
        </div>
        <div class="col-md-2 col-sm-12"><label>Stock Mínimo</label>
            <div><input type="number" name="stock" id="stock" class="articulo form-control" > </div>
        </div>
        </div>
    <div class="row">
        <div class="col-md-2 col-sm-12"><label>Precio Compra</label>
            <div><input type="number" name="Pcompra" id="Pcompra" class="articulo form-control" step="any">  </div>
        </div>
        
        <div class="col-md-2 col-sm-12"><label>Iva</label>
            <div><select name="iva" id="iva" class="articulo form-control">
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
    </select>  </div>
        </div>
        
        
        <div class="col-md-2 col-sm-12"><label>Precio de Venta</label>
            <div><input type="number" name="Pventa" id="Pventa" class="articulo form-control" size="" step="any">  </div>
        </div>
        <div class="col-md-3 col-sm-12"><label>Marcas</label>
             <div class="input-group tblInfo" >
                 <select name="idlab" id="idlab" class="text form-control"> <?php echo $lab; ?>
                     </select>
                    <a onClick="window.open('laboratorio.php?llamado=4532ffj<?php echo $AUX ;?>','popup','width=600,height=500')"
         ><img src="buscar.png" width="26" height="22" border="0" title="Consulta y Creación de Proveedores"></a>
     </div>
            
    </div> </div>
    <div class="row">
        <div class="col-md-3 col-sm-12"><label>Categoria</label>
            <div class="input-group tblInfo" >
                <select name="idGrupo" id="idGrupo" class="text form-control"  >
      <?php echo $grupos; ?>
    </select> <a href="#"
         onClick="window.open('grupos.php?llamado=4532ffj<?php echo $AUX ;?>','popup','width=600,height=500')"
         ><img src="buscar.png" width="26" height="22" border="0" title="Consulta Y Creación de Grupos"></a>
            </div></div>
        
        <div class="col-md-3 col-sm-12"><label>Categoria 1</label>
            <div class="input-group tblInfo" >
                <select name="idGrupo" id="idGrupo" class="text form-control"  >
      <?php echo $grupos2; ?>
    </select> <a href="#"
         onClick="window.open('grupos2.php?llamado=4532ffj<?php echo $AUX ;?>','popup','width=600,height=500')"
         ><img src="buscar.png" width="26" height="22" border="0" title="Consulta Y Creación de Grupos"></a>
            </div></div>
        
        <div class="col-md-3 col-sm-12"><label>Categoria 2</label>
            <div class="input-group tblInfo" >
                <select name="idGrupo" id="idGrupo" class="text form-control"  >
      <?php echo $grupos3; ?>
    </select> <a href="#"
         onClick="window.open('grupos3.php?llamado=4532ffj<?php echo $AUX ;?>','popup','width=600,height=500')"
         ><img src="buscar.png" width="26" height="22" border="0" title="Consulta Y Creación de Grupos"></a>
            </div></div>
    </div> 
    <div class="row">
         <div class="col-md-3 col-sm-12"><label>Codigo de Barras</label>
             <div>
        <input    type="text" name="barCode" id="barCode" class="articulo form-control" >
        
        
	  <span id='msgBarcode'></span>
    </div></div>
        <div class="col-md-6 col-sm-12"><label>Descipción </label>
            <div>
            <textarea name="descripcion" rows="3" cols="60" class="articulo form-control">Ninguna</textarea>
        </div> </div>
    </div>
 

<input type="hidden" name="IDLINEA" value="<?php echo $cod_aux;?>">
<input type="hidden" name="insertar" id="insertar" value="si">
<input type="hidden" name="Grupo" id="Grupo" value="">
<input type="hidden" name="Grupo2" id="Grupo2" value="">
<input type="hidden" name="Grupo3" id="Grupo3" value="">
<input type="hidden" name="laboratorio" id="laboratorio" value="">
 <input type="hidden" name="codigo" id="codigo" value="MV<?php echo $codigo; ?>">

</form>



<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
     $('a').click(function(e){e.preventDefault();});
	$('#barCode').keydown(function(e){
			//alert(e.keyCode)
		//e.preventDefault();
		var tecla=e.keyCode;
		if(tecla==13){
			
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
e.preventDefault();					
	}})
	var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {if ($(this).val() == "") {
      //  alert("no escogio una verga");
    }else{
		 var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
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
                $("#enviar").attr("disabled","disabled");
				$("#cancelar").attr("disabled","disabled"); 
                                $("#pictSelct").attr("src","imagenes/gif_cargando.gif");
				//$("#pictSelct").css("display","none");
		      
            },
            //una vez finalizado correctamente
            success: function(responseText){
                //alert(responseText);
               $("#enviar").removeAttr('disabled');
				$("#cancelar").removeAttr('disabled');
				$("#pictSelct").attr("src",responseText);
				$("#imagenGuardar").val(responseText);
				//$("#pictSelct").css("display","inline")
               
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });}
    });
	
		
  
	
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
	
$("#pictSelct").click(function(e){
	e.preventDefault();
	
		$("#archivosUp").trigger("click");
	});
	
	
$("#enviar").click(function(e){
	 var str="";
	 var h=0;
	 if ($('#barCode').val()==''){$('#barCode').val($('#codigo').val())}
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
$("#cancelar").click(function(){
	$(".articulo").each(function() {
        $(this).val("")
	});
	$("#pictSelct").attr("src","imagenes/Pregunta.png");
	
	
	});
$("#idGrupo2").change(function(){
$("#Grupo2").val( $( "#idGrupo2 option:selected" ).text() );})		
$("#idGrupo2").trigger( "change" );	
$("#idGrupo3").change(function(){
$("#Grupo3").val( $( "#idGrupo3 option:selected" ).text() );})		
$("#idGrupo3").trigger( "change" );	

$("#idGrupo").change(function(){
$("#Grupo").val( $( "#idGrupo option:selected" ).text() );})		
$("#idGrupo").trigger( "change" );

$("#aux_tipo_producto").change(function(){
$("#tipo_producto").val( $( "#aux_tipo_producto option:selected" ).val() );})		
$("#aux_tipo_producto").trigger( "change" );


/*idlab']."',  '".$_POST['laboratorio'*/
$("#idlab").change(function(){
$("#laboratorio").val( $( "#idlab option:selected" ).text() );})		
$("#idlab").trigger( "change" );	});

</script>


