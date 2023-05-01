<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>JDS - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <link href="../css/portada2.css" rel="stylesheet" type="text/css">  
        <link href="../images/favicon.ico" type="image/x-icon" rel="shortcut icon"> 
        <link href="../css/load_style.css" rel="stylesheet" type="text/css"/>
        <script src="../vendor/jquery.js" type="text/javascript"></script>
        <script src="../vendor/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <link href="../vendor/bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <style>
body{width : 100%; height:100%;  margin : 0px ;
background: url("") no-repeat center center fixed;
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
.Estilo15 {
	font-family: "Arial Narrow";
	color: #000000;
	font-size: 14px;
}
        .Estilo16 {
	font-family: "Arial Narrow";
	font-size: 17px;
}
        .Estilo17 {
	font-family: "Arial Narrow";
	font-size: 16px;
}
        </style>
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
                window.name = 'mcv'
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
                $('#btnIngresar').click(function(){
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
                                if (data['error'] =='ok'){
                                    msg = 'BIENVENIDO '+datosTabla[0].nombreCompleto 
                                    window.name = $('#nameWindows').val();
                                   window.location.href ='../Principal/'
                                }else{
                                    msg = 'ERROR  '+error 
                                }
                                alert(msg);
                        }	
                });
                         $('table').css( 'opacity', '1') 
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
<div class="loadingDiv" id="esperaMarcas" style="height:20px; width:100px;  " ><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"> </div></div>
     </div>     
     <br><br><br> 
     <table width="778" height="476" border="0" align="center" cellpadding="0" cellspacing="0" background="../jds/imagenes/logo/fondo_mc_login.jpeg">
  <tbody>
  <tr>
    <td width="404">&nbsp;</td>
    <td width="770">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
          <td width="30%" class="mini-gray" valign="middle">&nbsp;</td>
          
          
          <td width="70%" class="mini-gray" valign="top">
            <div align="center">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tbody   ><tr>
                        <td height="100" colspan="2" align="left" valign="middle" class="mini-gray Estilo17"><p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>Escriba su usuario y 
                                contraseña para empezar:</p>
                          <p>&nbsp;</p>
                        </td>
                </tr>
                <tr>
                        <td height="30">
                                <div class="Estilo16" id="Verical-Align-Left">Usuario:</div>                        </td>
                        <td width="82%" height="30"><input name="identificacion" type="text" id="identificacion" size="13"></td>
                </tr>
                <tr>
                        <td width="18%" height="30">
                                <div class="Estilo16" id="Verical-Align-Left">Contraseña:</div>                        </td>
                        <td height="30"><input name="password" type="password" maxlength="15" id="password" size="13"></td>
                </tr>
                <tr>
                        <td height="40" colspan="2" align="left"><blockquote>
                          <blockquote>
                            <p>
                              <input type="submit" name="btnIngresar" value="Ingresar" id="btnIngresar" >
                              &nbsp;                        </p>
                          </blockquote>
                        </blockquote></td>
                </tr>
                <tr>
                        <td colspan="2" height="40"><a class="mini-gray"   href="recordar_pwd.php"></a></td>
                </tr>
        </tbody></table>
            </div></td>
        </tr></tbody></table>
      <table width="770" border="0" cellspacing="0" cellpadding="0">
        <tbody>
         
        <tr>
          <td align="left" class="footer Estilo15">CHARDOM - Sistema Integral de Gesti&oacute;n Administrativa,  VCH Sistema y Tecnologia Todos los derechos reservados Copyright 2018 © </td>
      </tr>
        </tbody></table></td>
  <td width="156">&nbsp;</td></tr></tbody></table> 
     
     <div></div>
    </body>
</html>
