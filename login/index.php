<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
    //ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config(); 
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
<html>
    <head>
        <title>JDS</title>
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
        <script>
            $(function() {
                $(document).keyup(function(e){
                    if(e.which == 13  ){$('#btnIngresar').trigger('click');}
                  // 
                })
                  $.ajax({
                        url: 'eliminaSession.php',  
                        type: 'POST',
                         
                        data: null	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(ajaxOptions);  
                                alert(thrownError);},
                        beforeSend: function() {
				//alert(JSON.stringify(datosAjax))
				}, 
                        statusCode: {
                                404: function() { alert( "pagina no encontrada" ); },
                                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                                         },
                        success: function(data) {
                            
                        }	
                });
               
                
                
                //evento del boton ingresar.
                $('#btnIngresar').click(function(e){
                    e.preventDefault();
                    $('#cont_load_gif').show();
                    //password identificacion
                    if ($('#identificacion').val() == ""){
                        alert('el nick de usuario no debe estar en blanco.')
                        $('#identificacion').focus()
                    }else{                        
                        $('table').css( 'opacity', '0.5') 
                        $("input").prop('disabled', true);
                        var datosAjax={
                            pass: $("#password").val(),
                            nickname:$("#identificacion").val(),
                            style:window.name
                        }; 
                        $.ajax({
                        url: 'verificar_login.php',  
                        type: 'POST',
                        
			dataType: "json",
                        data: datosAjax	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                console.log(JSON.stringify(xhr.status));
                                console.log(JSON.stringify(ajaxOptions));  
                                console.log(JSON.stringify(thrownError));},
                        beforeSend: function() {
                            // alert('aqui se va');
				//  console.log(JSON.stringify(datosAjax))
				}, 
                        statusCode: {
                                404: function() { alert( "pagina no encontrada" ); },
                                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                                         },
                        success: function(data) {
                                 //  console.log(JSON.stringify(data)) 
                                var msg = '';  
                                var datosTabla = data['datos'];
                                var error=data["error"]; 
                                if (data['error'] === 'ok'){
                                    msg = 'BIENVENIDO ' + datosTabla[0].nombreCompleto ;
                                    window.name = $('#nameWindows').val();
                                   window.location.href = '../Principal/' ;
                                }else{
                                    msg = 'ERROR  '+error ;
                                    alert(msg);
                                }
                                
                        }	
                });
                         $('table').css( 'opacity', '1') ;
                        $("input").prop('disabled', false);
                    }
                    $('#cont_load_gif').hide();
                })
                //fin
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
     
     
     <h1><?php echo SUCURSALLOGIN;  ?>
         <img src="../images/jds_ico.png" alt="" width="50px" height="50px"/></h1>
     <div class="w3ls-login box box--big">
		<!-- form starts here -->
		<form action="#" method="post">
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-user" aria-hidden="true"></i> Username </label>
                                        <input type="text" id="identificacion" name="name" placeholder="Enter your name " required="">
			</div>
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-envelope" aria-hidden="true"></i> password </label>
				<input type="password" name="password" placeholder="Enter your password " required="" id="password">
				<div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Mostrar password</label>
				</div>
			</div>
			<!-- script for show password -->
			<script>
				function myFunction() {
					var x = document.getElementById("password");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				}
			</script>
			<!-- //script ends here -->
			<div class="w3ls-bot">
				 
				<div class="form-end">
                                    <input id="btnIngresar" type="submit" value="LOGIN">
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
