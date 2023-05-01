
<!doctype html>
<html>
<head>
<title>Creacion de modelos </title>
<style>
.Modelos{font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif; border-bottom-color:#009}

.divDeCreacion{ height:400px; width:500px; border-bottom-color:#333; border: 1px thin}
body{font: 62.5% "Trebuchet MS", sans-serif;}
#accordion{ width:600px; }
#cuerpo{margin-left:25%; }
#espera{  position: relative;
  display: inline-block;}
#nuevaImagen{ cursor:pointer;}

 
</style>
<link rel="stylesheet" href="css/loadingStile.css" type="text/css" />
</head>
<body>

<div id="cuerpo">

<h2 class="demoHeaders">Creacion de Marcas y Modelos dependientes</h2>
<div id="accordion">
	<h3>Creacion de marcas</h3>
	<div align="center">
    <br>
Nombre de la Marca&nbsp;<input type="text" placeholder="INGRESE MARCA" class="cMarcas" id="nameMarca" name="Nombre_de_la_marca">&nbsp;<img src="imagenes/Sin_imagen_2.png" width="109" height="21" id="nuevaImagen">
<br><br>
<input type="button" value="crearMarcas" id="enviarDatosMarcas" >

<div class="loadingDiv" id="esperaMarcas" style="height:15px; width:35px;  display:none;" ><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"> </div></div>
<br>
    </div>
	<h3>Modelos Dependientes</h3>
	<div id="creacionModelos" align="center" style="overflow:hidden" >
    <br>
Marca&nbsp;<select id="marcasExternas"  class="cModelos" name="Marca_Seleccionada" >
<option value="">ESCOJA LA MARCA</option>
</select><br><br>
Modelo&nbsp;<input type="text" placeholder="INGRESE MODELO" class="cModelos" id="nameModel" name="Nombre_del_modelo">
<br><br>
<input type="button" value="crearModelo" id="enviarDatos" >

<div class="loadingDiv" id="espera" style="height:15px; width:35px;  display:none;" ><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"> </div></div>
<br></div>
	
</div>
</div>
</body>
</html>

<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script src="js/jquery/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<script type="application/javascript" language="javascript">
$(document).ready(function(){
$('#enviarDatos').click(function(){
	$('#espera').css('display','inline-block');
	var verificacion=verificaDatosEnBlanco(".cModelos")
	if(verificacion==true){
		var datosAjax = creaDatosAjax(".cModelos")
		//alert(JSON.stringify(datosAjax))
		$('#esperaMarcas').css('display','none');
	}else{$('#espera').css('display','none');
	}
	})
	$( "#accordion" ).accordion();
$('#enviarDatosMarcas').click(function(){
	$('#esperaMarcas').css('display','inline-block');
	var verificacion=verificaDatosEnBlanco(".cMarcas")
	if(verificacion==true){
		var datosAjax = creaDatosAjax(".cMarcas")
		//alert(JSON.stringify(datosAjax));
		$('#esperaMarcas').css('display','none');
	}else{$('#esperaMarcas').css('display','none');
	}
	})
	
	
	})
	
	
	
function verificaDatosEnBlanco(clase_id){
	var retorno = true;
	$(clase_id).each(function() {
		str=''
		$(this).focus();
        if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el campo "+$(this).attr("name")+str+" no debe estar en blanco");
			 return  retorno = false;
			}
    });
     return retorno
	}	
	
function creaDatosAjax(clase_id){
	datosAjax={}
	$(clase_id).each(function() {
		datosAjax[$(this).attr('id')]=$(this).val()
      });
	 return datosAjax
	}
</script>