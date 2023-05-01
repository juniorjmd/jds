<?php 
$mensaje='';
if (isset($_GET["nickname"]))
{$nickname=$_GET["nickname"];
if(trim($nickname)!=""){
$mensaje="el usuario o la contraseña no aparecen registrado verifique por favor";
}}

if(isset($_GET["enBlanco"])){$mensaje='el nombre no debe estar en Blanco.';}
else{$nickname="";}

if(isset($_GET["ACCESODENEGADO"])){$mensaje=$_GET["ACCESODENEGADO"];}
else{$nickname="";}
 session_start();
    if($_SESSION[access]!=false) 
        { 	
		unset($_SESSION["IJKLEM1934589"]);
unset($_SESSION["Facturacion"]);
unset($_SESSION["Inventarios"]);
unset($_SESSION["database"]);
unset($_SESSION["sucursalNombre"]);
unset($_SESSION["Transacciones"]);
unset($_SESSION["Usuarios"]);
unset($_SESSION["Empleados"]);
unset($_SESSION["Proveedores"]);
unset($_SESSION["Clientes"]);
unset($_SESSION["usuarioid"]);
unset($_SESSION["usertype"]);
unset($_SESSION["usuario"]);
unset($_SESSION["DataName"]);
$_SESSION[access] = false;
unset($_SESSION["nombreUsuario"]);
unset($_SESSION["usuarioid"]);
$_SESSION = array();
 session_destroy();
  $mensaje="sesion finalizada....";
		}
		
?>

<style>
body{width : 100%; height:100%;  margin : 0px ;
background: url("../imagenes/contable.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

 }
 #cont{background-color:white; position: absolute;   left: 50%;margin-left : -250px; top: 160px; width: 500px; opacity: 1;padding:1%;
 -webkit-border-radius: 5px 10px;  /* Safari  */
  -moz-border-radius: 5px 10px;
}
 #msg_fSesion{position: block;   margin-left: auto ;margin-right:auto; margin-top: 90px; max-width : 40% }

</style>


<body>
<?php if($mensaje!=''){ ?>
<div class="alert alert-danger" role="alert" id='msg_fSesion'>
  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
<?php echo '      '.$mensaje;?></div>

<?php } ?>
<div id='cont' style="display:none">

<form method="post"   action="revisaLogin.php" id='form_1' autocomplete="off">
<?php 
if(isset($_GET["location"])){echo '<input type="hidden" id="location" name="location"  value="'.$_GET["location"].'">';}
else if(isset($_POST["location"])){echo '<input type="hidden" id="location" name="location"  value="'.$POST["location"].'">';}?>
<div class="form-group">
  <label for="sucursalId">Sucursal:</label>
   <select class="form-control" name="sucursalId" id="sucursalId">
     
  </select>
</div><br/>
<div class="input-group" style='width:100%'>
 <label for="usr">Usuario:</label>
 
  <input type="text" class="form-control" placeholder="Usuario" aria-describedby="basic-addon1" id="user"  name="user" value="<?php echo $nickname;?>"  autocomplete="off">
</div>
<br/>
 <div class="input-group" style='width:100%'>
 <label for="pwd">Password:</label>
  <input type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1" name="password"id="password">
</div>
<br/>

 <button type="button" id='ingresar_aux' class="btn btn-success dropdown-toggle"  aria-haspopup="true" aria-expanded="false" title="ingresar" >
    Ingresar <span class=" glyphicon glyphicon-circle-arrow-right"></span>
  </button>

<input type='submit' style='display:none' id='ingresar'>
</form>
 </div>
 
 <div id='prueba'></div>

<input value="" id="databasename" type="hidden" name="sucursalNombre">
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/busqueda.js"></script>
<link rel="stylesheet" href="../css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	
	var datosAjax = {tabla: 'sucursales',
		inicio: '',
		//dataBase:'pedrocontreras4',
		dataBase:'jkou_124569piokmd',
		host:'localhost',
		c14562jk:'juniorjmd',
		er2345:'root',
		datosRequeridos:['nombre_suc','id_suc','nom_database','galeria','host','clavedb','usuariodb']};		
		$.ajax({url: '../php/db_listar_nuevo.php',  
			type: 'POST',
			data: datosAjax,
			dataType: "json",
			 beforeSend: function() {
				//alert(JSON.stringify(datosAjax))
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
				datosTabla=data['datos'];
				for(var i=0; i<datosTabla.length;i++){
					auxDato=datosTabla[i];
					auxOptio=$('<option>');
					auxOptio.attr('value',auxDato.id_suc)
					auxOptio.html(" "+auxDato.nombre_suc+"  ")
					$('#sucursalId').append(auxOptio)
					auxInput=$('<input>');
					auxInput.attr('value',auxDato.nom_database)
					auxInput.attr('name','db_'+auxDato.id_suc)
					auxInput.attr('type','hidden')
					$('#form_1').append(auxInput)
					auxInput2=$('<input>');
					auxInput2.attr('value',auxDato.galeria)
					auxInput2.attr('name','galeria_'+auxDato.id_suc)
					auxInput2.attr('type','hidden')
					$('#form_1').append(auxInput2)
					
					auxInput3=$('<input>');
					auxInput3.attr('value',auxDato.host)
					auxInput3.attr('name','host_'+auxDato.id_suc)
					auxInput3.attr('type','hidden')
					$('#form_1').append(auxInput3)
					
					auxInput4=$('<input>');
					auxInput4.attr('value',auxDato.clavedb)
					auxInput4.attr('name','clavedb_'+auxDato.id_suc)
					auxInput4.attr('type','hidden')
					$('#form_1').append(auxInput4)
					
					auxInput5=$('<input>');
					auxInput5.attr('value',auxDato.usuariodb)
					auxInput5.attr('name','usuariodb_'+auxDato.id_suc)
					auxInput5.attr('type','hidden')
					$('#form_1').append(auxInput5)
					$('#cont').fadeIn()				
					}
					
				},error: function(a,e,b){
					 alert("se genero un error")
					}});//fin bloque obtencion de datos producto
		$('#ingresar_aux').click(function(){
			$('#ingresar').trigger('click')
		});
 });

</script> 

</body>
