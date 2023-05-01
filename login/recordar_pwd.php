<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Monómeros Colombo-Venezolanos S.A.   </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <link href="../css/portada2.css" rel="stylesheet" type="text/css">  
        <link href="../images/favicon.ico" type="image/x-icon" rel="shortcut icon"> 
        <link href="../css/load_style.css" rel="stylesheet" type="text/css"/>
        <script src="../vendor/jquery.js" type="text/javascript"></script>
        <script src="../vendor/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <link href="../vendor/bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
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
                //topperleft
                var colorFrente = ""
                var colorAtras = ''
                var topperleft = '' 
                var imagenlogo = ''
                var topper_right = ''
                var footer_img = ''
                var btnIngresar = ''
                var title_01 = ''
                $('#nameWindows').val(window.name)    
                if (window.name == ''){
                    window.location.href ='../'
                }else{
                if (window.name == 'mcv'){
                   colorFrente = "#008242"
                   colorAtras = "#049d4a" 
                   topperleft = 'topperleft'
                   imagenlogo = '../images/big-logo-logistica.jpg'
                   topper_right = 'topper-right'
                   footer_img  = 'footer-img'
                   btnIngresar='button'
                   title_01 = 'title-01'
                }else{
                   colorFrente = "#64B244"
                   colorAtras = '#FAE0C9'
                   topperleft = 'topperleft-eco'
                   imagenlogo = '../images/logo-comercial-big-01.jpg'
                   topper_right = 'topper-right-eco'
                   footer_img  = 'footer-img-eco'
                   btnIngresar='button_eco'
                    title_01 = 'title-01-eco' 
                }}
                $('#td_barra_principal').css("background-color" ,colorFrente )
                $('.colorFondo').css("background-color" ,colorAtras )
                $('#topperleft').addClass(topperleft)
                $('#logoPrincipal').attr('src',imagenlogo)
                $('#topper_right').addClass( topper_right)
                $('#footer-img').addClass(footer_img)
                $('#btnIngresar').addClass(btnIngresar) 
                $('#title_01').addClass( title_01)
                //evento del boton ingresar.
                $('#btnIngresar').click(function(e){
                     if ($('#identificacion').val() == ""){
                        alert('el nick de usuario no debe estar en blanco.')
                        $('#identificacion').focus() ;
                        e.preventDefault();
                        return;
                    }   
                })
                //fin
            })
        </script>        
    </head>
    <body >
       
     <div id="cont_Load_gif" style='padding-left:20%;padding-right: 20%;display: none ' >
        
         <span style="float: left; color: gray;font-size: 13px "  >Cargando&nbsp;</span>  
<div class="loadingDiv" id="esperaMarcas" style="height:20px; width:100px;  " ><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"> </div></div>
     </div>     <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr >
    <td id='td_barra_principal' width="80%" height="40px" class="topper"  ><a href="http://www.monomeros.com.co/">http://www.monomeros.com.co/</a></td>
    <td  id="topperleft">&nbsp;<!--<img width="69" height="39" alt="" src="principal_archivos/fp-01.jpg">--></td>
    <td  class='colorFondo'>&nbsp;</td></tr></tbody></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      
  <tr>
    <td width="45%">&nbsp;</td>
    <td id='topper_right' class="">&nbsp;<!-- <img width="137" height="57" alt="" src="principal_archivos/fp-02.jpg">-->
       </td>
    <td width="" id='title_01' class="colorFondo"   >Portal 
  Comercial</td></tr></tbody></table>
     <form action="enviar_nuevo_pass.php"  autocomplete="false" method="post" >  
         <input type='hidden' id='nameWindows' name='nameWindows'/>  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="920">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
          <td width="50%" class="mini-gray" valign="middle">
            <div align="center"><img width="390" height="320" alt="Portal Nutrimon" id='logoPrincipal' src="" border="0"></div>
          </td>
          
          
          <td width="50%" class="mini-gray" valign="top">
            <div align="center">
                <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tbody><tr>
                        <td class="mini-gray" valign="middle" colspan="2" height="100">Escriba su usuario y 
                                se le enviará un correo con su nueva contraseña:</td>
                </tr>
                <tr>
                        <td height="30">
                                <div id="Verical-Align-Left">Usuario:</div>
                        </td>
                        <td height="30"><input name="identificacion" type="text" id="identificacion" size="13"></td>
                </tr>
               <!-- <tr>
                        <td width="21%" height="30">
                                <div id="Verical-Align-Left">Contraseña:</div>
                        </td>
                        <td height="30"><input name="password" type="password" maxlength="15" id="password" size="13"></td>
                </tr>-->
                <tr>
                        <td colspan="2" height="40"><input type="submit" name="btnIngresar" value="Enviar" id="btnIngresar" >&nbsp;
                                </td>
                </tr>
                 
        </tbody></table>
            
            
            </div></td>
            
        
        </tr></tbody></table>
      <table width="770" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
          <td id="footer-img">&nbsp;</td></tr>
        <tr>
          <td class="footer">Monomeros Colombo Venezolanos S.A. Todos los derechos reservados Copyright 2010 ©<br>
            <a class="footer-terms" href="#">Términos y Condiciones de Servicio</a></td></tr></tbody></table></td>
    <td width="50%">&nbsp;</td></tr></tbody></table> 
     </form> 
     <div></div>
    </body>
</html>
