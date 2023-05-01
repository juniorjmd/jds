<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
 include 'db_conection.php';
$conn= cargarBD();

if($_POST['nombre']){	
	$query="INSERT INTO  `combos` (`idCombo` ,`nombre` ,`precioVenta`,`imagen`)VALUES ('".$_POST['codigo']."',  '".$_POST['nombre']."',  '".$_POST['Pventa']."',  '".$_POST['imagenGuardar']."');";
	$stmt = $conn->stmt_init();
	
	$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo insertar datos en la tabla:' . $conn->error);
		break;}
	}
$query2="SELECT * FROM `combos`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$codigo=substr($row["idCombo"],2);
} 
}else{$codigo=0;}
 $codigo++;	
$result->free();
$query2="SELECT * FROM `relacioncombo` WHERE `id`= 'CB".$codigo."'";
//echo $query2;
$result = $conn->query($query2);
$insertados=0;
$filaInsertados="";
$ComboImagen="imagenes/Pregunta.png";
$imagenGuardar="";

if($result->num_rows!=0){
$fileTypes = array('jpg','jpeg','gif','png','JPG'); // File extensions
foreach ($fileTypes as $valor){
	//echo "galerias/combos/CB".$codigo."_picture.".$valor."  -  ";
				if (file_exists("galerias/combos/CB".$codigo."_picture.".$valor)) {
					//echo "  existe el archivo  CB".$codigo.".".$valor."   ";
					$ComboImagen=	"galerias/combos/CB".$codigo."_picture.".$valor."?".time();
					$imagenGuardar=$ComboImagen;
					} 
				}
while ($row = $result->fetch_assoc()) {	
$insertados=$insertados+$row['cantidad'];
	$filaInsertados=$filaInsertados."<tr ><td></td><td >".$row['id']."</td><td >".$row['nombre']."</td><td >".$row['cantidad']."</td></tr>";
} 
}
$result->free();
?>

<title>Creacion de Combos</title>
<style>
.articulo{ font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.boton{ height:50px;}
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
</style><table align="center"><tr align="right"><td><a href="inventario.php">
<input type="image"  src="imagenes/proveedores.jpg" height="70" title="visualizar, modificar y eliminar los productos del inventario"></a></td></tr><tr><td>
<form action="<?php echo $enviar;?>" method="post" autocomplete="off" class="formulario">
<div align="center" style="width:100%">
<input type="hidden" name="insertados" id="insertados" value=<?php echo $insertados; ?>><input type="hidden" name="insertar" id="insertar" value="si">
<input type="hidden" name="Grupo" id="Grupo" value="">
<table width="950" height="362" border="0" >
  <tr>
    <td height="45" colspan="7" align="center"><p>CREAR NUEVO COMBO</p></td>
    </tr>
  <tr>
    <td width="80" rowspan="6">&nbsp;</td>
    <td width="146" height="46" align="right">CODIGO&nbsp;</td>
    <td colspan="2"><input type="hidden" name="codigo" id="codigo" value="CB<?php echo $codigo; ?>">CB<?php echo $codigo; ?></td>
    <td colspan="2" rowspan="3"><div style="height:170; width:170" class="precarga"><input type="image" id="pictSelct" name="pictSelct" src="<?php echo $ComboImagen; ?>" height="170" width="170" style="margin-left:60px" >
    <input type="file" name="archivos[]" style="display:none" id="archivosUp"/>
    <input type="hidden" name="imagenGuardar" id="imagenGuardar" value="<?php echo $imagenGuardar;?>" class="articulo" ></div></td>
    <td width="112" rowspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" align="right">NOMBRE&nbsp;</td>
    <td colspan="2"><input type="text" name="nombre" id="nombre" class="articulo" ></td>
    </tr>
  
   
    <tr>
    
    <td width="146" height="58" align="right">PRECIO VENTA</td>
    <td width="240"><input type="number" name="Pventa" id="Pventa" class="articulo" size=""></td>
   
    </tr><tr><td colspan="4"valign="top">
    <table width="100%" id="tablaIngreso" align="center">
    <tr align="center">
    <td width="12%"></td><td width="15%">CODIGO</td><td width="51%">NOMBRE</td>
    <td width="22%">CANTIDAD</td></tr><?php echo $filaInsertados;?>
    </table>
    
    
    </td>
    <td width="273" height="87"  align="right" valign="top">
        <p><input type="submit" id="nuevoProducto" value="+ Producto" class="boton" style=""> <input type="submit" id="enviar" value="Registrar" class="boton" style=""> 
            <a href="<?PHP echo $backDir;?>"><input type="button" id="cancelar" value="Cancelar" class="boton"></a>
          </p>
        </blockquote>
      </blockquote>
    </blockquote></td>
    </tr>
</table></div></form>
</td></tr></table>
<div style="display:none" width="100%">
<div id="busquedaArticulo"  width="100%" style="height:100%" >
 <input id="busquedaArticuloRegistrado" type="text" /> <input type="hidden" id="respuestaArticulo" /><input type="hidden" id="gridID" />
            <table border="0" id=" Tablacolor" width="695"><tr><td>
             <table  border="0" id="listarTablaArticulo" bordercolor="#71D8E3"  width="100%"    >
		  <tr  id="cabPac" align="center"   class="ui-widget-header">
	        <td width="70"  >CODIGO</td>
		    <td width="400"  >NOMBRE/DESCRIPCION</td>
			<td   width="70">PRECIO</td>		
      </tr><tr><td colspan="3">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaArticulo" ></div>    
     <div align="center" id="indiceListaArticulo" ></div>
       </td></tr></table>
     </div>
	 </div>

<link href="ayuda/jquery-ui.css" rel="stylesheet">
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script type="text/javascript" src="jsFiles/listas.js"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	
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
            url: 'upload/uploadCombos.php',  
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
		     },//una vez finalizado correctamente
            success: function(responseText){
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
	 if($("#insertados").val()>=2){
	$(".articulo").each(function() {$(this).focus();
        if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			$(this).focus();
			 h=1;
			 return false;
			}
    });}else{alert("Debe insertar minimo dos productos para poder crear el combo");h=1;}
	if(h==1){e.preventDefault();}
	});
$("#cancelar").click(function(){
	datos='dato='+encodeURIComponent($("#codigo").val())
		  +"&tabla="+encodeURIComponent("relacioncombo")
		  +"&columna="+encodeURIComponent('id');
	$.ajax({url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
			$(".articulo").each(function() {
        $(this).val("")
	});
	datos='nombre='+encodeURIComponent($("#codigo").val()+"_picture")
		  +"&galeria="+encodeURIComponent("combo")
	$.ajax({url: 'upload/eliminaImagen.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			$("#pictSelct").attr("src","imagenes/Pregunta.png");
			}});
		}
	});
});
	
	
$("#idGrupo").change(function(){
$("#Grupo").val( $( "#idGrupo option:selected" ).text() );})		
$("#idGrupo").trigger( "change" );	

$('#nuevoProducto').click(function(e){
e.preventDefault();
	llenaBusqueda()
$.colorbox({overlayClose:false, inline:true, href:"#busquedaArticulo",width:"750px", height:"400px"});});

});

function llenaBusqueda(){
	
		//carga_listar(datosAjax, respuesta_busqda_articulo);
		inicioListar('producto',respuesta_busqda_articulo,null,null,null,null,null,null,null,'Articulo')
		}

	function respuesta_busqda_articulo(){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados =['idProducto','nombre' ,'precioCompra'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewPac','tablasListaArticulo','indiceListaArticulo','listarTablaArticulo',0,15,false,false,false,false,llenaArticulo,false,false,false,false,false);
}else {limpia_linea('tablasListaArticulo','indiceListaArticulo');
	var texto="encuentra registrado ningun Articulo en la base de datos";
		$('#tablasListaArticulo').html(texto);
	}
}
function llenaArticulo(){
	do {
  catidad = prompt('INTRODUZCA LA CANTIDAD (SOLO NUMEROS)');
   } while (!(/^([0-9])*$/.test(catidad)));
	var DATOS='nombre_del_producto='+this.datosParaEnvio['nombre']+
				"&codigo_del_producto="+this.datosParaEnvio['idProducto']+
				"&cantidad_del_producto="+catidad+
				"&codigo_del_combo="+$("#codigo").val();
				var nombre=this.datosParaEnvio['nombre'];
				var id=this.datosParaEnvio['idProducto']
		$.ajax({
            url: 'saveCombo.php',  
            type: 'POST',
			async: true,
			data: DATOS,
			dataType:"html",
            beforeSend: function(){
                $("#enviar").attr("disabled","disabled")
				$("#cancelar").attr("disabled","disabled")
				},
            success: function(responseText){
				$("#enviar").removeAttr('disabled');
				$("#cancelar").removeAttr('disabled');
				if(responseText==1){
					var str='<tr><td></td><td>'+id+'</td><td>'+nombre+'</td><td>'+catidad+'</td></tr>';
				$("#insertados").val($("#insertados").val()+catidad);
				$('#tablaIngreso').append(str)
					}
				},
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
	
}


</script>


