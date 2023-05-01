<?php


require_once '../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
  // ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();
$user = cargaDatosUsuarioActual();
if ($_SESSION['access']==false){ 
    header('Location: ../login/');
}
$conexion =Class_php\DataBase::getInstance(); 
      $link = $conexion->getLink(); 
$query="select  * from sucursales   where id_suc = '002'";
	$consulta = $link->prepare($query); 
        $consulta->execute();
        $sucursal_datos = $consulta->fetchAll(); 
       if (sizeof($sucursal_datos) > 0 ){
        foreach ($sucursal_datos as $key => $row) { 
       define('SUCURSALLOGIN',"{$row[ "nombre_suc" ]} - {$row[ "nombre_sucursal_sec" ]}"  );
       }}  
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>JDS - Cambio pass</title>
               <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <link href="../css/portada2.css" rel="stylesheet" type="text/css">  
        <link href="../images/favicon.ico" type="image/x-icon" rel="shortcut icon"> 
        <link href="../css/load_style.css" rel="stylesheet" type="text/css"/>
        <script src="../vendor/jquery.js" type="text/javascript"></script>
        <script src="../vendor/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <link href="../vendor/bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
                  
        <link href="../css/stile_login.css" rel="stylesheet" type="text/css"/>
        <link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>
     
         <script src="view/js/cambioPassPrimerAcceso.js" type="text/javascript"></script>
         <script>
             var url = '<?= URL_BASE?>Principal/';          
          $(document).ready(function(){              
            var cargadorLista= new T_find.CargadorContenidos(url); 
            $(document).keyup(function(e){
                    if(e.which === 13  ){$('#btnIngresar').trigger('click');}
                  // 
                })
          })
        
         </script>
             
        
    </head>
 
    
    <body >
     <input type='hidden' id='nameWindows' name='nameWindows'/>    
     <div id="cont_Load_gif" style='padding-left:20%;padding-right: 20%;display: none ' >
        
         <span style="float: left; color: gray;font-size: 13px "  >Cargando&nbsp;</span>  
<div class="loadingDiv" id="esperaMarcas" style="height:20px; width:100px;  " >
    <div id="blockG_1" class="facebook_blockG"></div>
    <div id="blockG_2" class="facebook_blockG"></div>
    <div id="blockG_3" class="facebook_blockG"></div>
</div>
     </div>     
     <br><br><br> 
     
     
     <h1>Cambio de contraseña</h1>
     <h2><?php echo SUCURSALLOGIN;  ?>
         <img src="../images/jds_ico.png" alt="" width="50px" height="50px"/></h2>
     <div class="w3ls-login box box--big">
		<!-- form starts here -->
		<form action="#" method="post">
			<div class="agile-field-txt">
			<label>
			<i class="fa fa-user" aria-hidden="true"></i> Password Actual</label>
                        <input   name="password_ant" type="password" id="password_ant" placeholder="Ingrese password actual " required="">
			</div>
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-envelope" aria-hidden="true"></i> Password Nueva</label>
				<input type="password" name="password_nw_1" placeholder="Ingrese password nueva" required="" id="password_nw_1">
				
			</div>
                    <div class="agile-field-txt">
				<label>
					<i class="fa fa-envelope" aria-hidden="true"></i> Repita Password </label>
				<input type="password" name="password_nw_2" placeholder="Ingrese password nueva " required="" id="password_nw_2">
				<div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Mostrar password</label>
				</div> 
			</div>
                    
			<!-- script for show password -->
			<script>
				function myFunction() {                                    
                                    let elements = document.getElementsByTagName("input");
                                    for (let i = 0; i < elements.length; i++) {
                                       let x = elements[i];
                                       switch(x.type){
                                           case "password":
                                               x.type = "text";
                                               break;
                                            case "text":
                                               x.type = "password";
                                               break;  
                                       }
					 
                                           
                                    }
					
				}
			</script>
			<!-- //script ends here -->
			<div class="w3ls-bot">
				 
				<div class="form-end">
                                    <input id="btnIngresar" type="submit" value="REGISTRAR">
				</div>
				<div class="clearfix"></div>
			</div>
                        <div style="font-size: 9px;font-family: cursive;font-weight: 500;" >
                            JDS-Soluciones &#169;2020</div>
		</form>
	</div>
     
     
     
      
     
     <div>
         
     </div>
    </body>
    
    
    
     
</html>