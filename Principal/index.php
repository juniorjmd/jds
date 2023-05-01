<?php
require_once '../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
    //ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();
$user = cargaDatosUsuarioActual();
if ($_SESSION['access']==false){ 
    header('Location: ../login/');
}  
if($_SESSION["change"] == '0'){
    header('Location: cambiar_pass_primer_ingreso.php');
}

$permisos = $user->getArrayPermisos('principal');

//print_r($user->getArrayPermisos());
?>
<!DOCTYPE html>
<html>
    <head>

<script type="text/javascript">
<?php 
$urlBase = URL_BASE;
 
echo "var urlBase = '$urlBase'; "
        . "//alert(urlBase);"
         
?>   
</script>
<title>JDS - ModPrincipal</title>
<link rel="icon" type="image/png" href="<?php echo URL_BASE; ?>/images/jds_ico.png" sizes="64x64">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    
    <link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
    
    <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
    <link href="../css/load_style.css" rel="stylesheet" type="text/css"/>
    <script src="../vendor/wp-nicescroll/jquery.nicescroll.min.js" type="text/javascript"></script>
    <script src="../vendor/listas.js" type="text/javascript"></script>
    <script src="../vendor/funciones.js" type="text/javascript"></script> 
    <script src="../vendor/jquery.PrintArea.js" type="text/javascript"></script>
    
    <script src="../vendor/busquedasEnListasDinamicas.js" type="text/javascript"></script> 
    <link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/> 
    <link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../node_modules/clock.js/js/clock.js" type="text/javascript"></script>
    <link href="../css/generales.css" rel="stylesheet" type="text/css"/>
<style>
    <?php funciones_javaSc(); ?> 
    .container{width:100%;height: 98%} 
 
   .hidden{
       display:none;
   }
    
 
</style>
<script>
   $(document).ready(function(){
       var url_base = $('#url_base').val();
        $.datepicker.setDefaults({ selectOtherMonths: true,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],changeYear: true,
            
            dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]}); 
      $('*[data-url="despachos.php"]').unbind('click') 
      var url = '../Principal/'; 
      	$('#CambioPass').click(function(e){ 
             e.preventDefault()
             $('#cargarDatos').load(url_base+$(this).data('url'),function(responseTxt, statusTxt, xhr){
                                    if(statusTxt == "success")                                      
                                    //    alert("External content loaded successfully!");
                                    var cargadorLista= new T_find.CargadorContenidos();
                                    if(statusTxt == "error")
                                        alert("Error: " + xhr.status + ": " + xhr.statusText);
                                });
              
         });
         
         $('.menuHijo').click(function(e){ 
             var menu = $(this);
             var url_go ='';
             e.preventDefault()
              if( $(this).data('url') != ''){
                  url_go = url_base+$(this).data('url');
                  console.log( url_go)
                   $("#msg_pantalla").html('Cargando Datos de la P&aacute;gina ...')
                   
                 $('#contenedor_espera_respuesta').show(function(){ 
                     
                     // $('#cargarDatos').attr('src',url_go).load(function(responseTxt, statusTxt, xhr){
                       $('#cargarDatos').attr('src',url_go).load(url_go,function(responseTxt, statusTxt, xhr){    
                        if(statusTxt === "success") 
                            { 
                                //var cargadorLista= new T_find.CargadorContenidos(url);
                                
                                if(!$("#mostrarLateral").hasClass("collapsed")){
                                    
                                  $("#mostrarLateral").trigger('click'); 
                                }
                            }
                        if(statusTxt === "error")
                            {alert("Error: " + xhr.status + ": " + xhr.statusText);}
                            $('#contenedor_espera_respuesta').hide()

                            $("#msg_pantalla").html('Procesando la informacion ...')
                        
                        });
                    })
                
        }
         });
         
          if($('#datosVistasRecibido').val() !== ''){
             $($('#datosVistasRecibido').val()).trigger('click')
         }              
         $('#salidaSegura').click(function(){
             var confimar = confirm('Esta seguro que desea salir?')
             if (confimar){
                 window.location.href ='../login/' 
             }
         }); 
   }) 
</script>
    </head>
    <body>
     
 
 
 
 


<nav class="navbar navbar-expand-lg   navbar-light   fixed-top sticky-top" style="background-color: #9fc2e0;    
     ">
 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <a class="navbar-brand" href="#">
    <img src="<?=LOGO_USUARIO1?>" width="30" height="30" alt="" loading="lazy">
  </a>
       
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
         
        <li class="nav-item active">
            <div class="row">
                <div class="col-md-3"><?php echo SUCURSALNOMBRE.'-'.SUCURSALNOMBRE_2;  ?></div>
                    <div class="col-md-4">
                        <span><?="Usuario : {$user->getNombre1()} {$user->getLasName()}" ;?> </span>  </div>
                    <div class="col-md-5">
                         <div class="date">
                <span id="weekDay" class="weekDay"></span>, 
                <span id="day" class="day"></span> <span> de</span> 
                <span id="month" class="month"></span><span> del</span> 
                <span id="year" class="year"></span>
            </div>
               <div class="clock">
                <span id="hours" class="hours"></span> :
                <span id="minutes" class="minutes"></span> :
                <span id="seconds" class="seconds"></span>
            </div></div>
            </div>
                   
            
        </li>
         
    </ul>
    <div class="form-inline my-2 my-lg-0">
        
        <a id='salidaSegura' class="linkCabecera m-2" href="#" title="Salida Segura" > 
            <i class="fa fa-door-open fa-2x" ></i></a> 
            
         <?php if ($permisos['BTN_CONTABILIDAD']) {?>
        <a  class="m-2" href="<?php echo URL_BASE; ?>Contabilidad/" > 
                        
            <i class="fas fa-calculator fa-2x"      
               aria-hidden="true"></i></a>  <?php } 
    
        if ($permisos['BTN_ADMINISTRACION']) {?>
        <a  class=" m-2 " href="../administracion/" >
            <img style="height:30px;  "   src="../images/configuracion.png" alt="configuraciones"/>
        </a> 
            <?php } ?>    
        <a class="m-2"  href="#"
               onclick = "window.open('<?php echo URL_BASE; ?>/jds/listado_compromisos.php?&T0D41T0W=<?php echo "ok"; ?>','popup','width=1200,height=500')" 
                  > 
                <i class="fa fa-list-ol fa-2x" ></i> 
            </a>
    </div>
  </div>
</nav>
<div class="container-fluid">
    <div class="row flex-xl-nowrap">
        <div class="col-md-3 col-xl-2 bd-sidebar menuLateral">
            <nav   class=" navbar navbar-expand-lg   show bd-links" id="bd-docs-nav" aria-label="Main navigation">
            <button id="mostrarLateral"class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <i class="fas fa-bars  "      
               aria-hidden="true"></i>
  </button>
       
                 <div  id="navbarSupportedContent2">
                     
                      
                      <?php  echo $user->getMenuUsuario_2('principal');?>   
                      <?php //echo $user->getMenuUsuario('principal');?> 
                 </div>       
           
            
            </nav>    
             
           
        </div>
        <main class="col-md-10 col-xl-10 py-md-3 pl-md-5 bd-content"> 
    <iframe id="cargarDatos"    style="border:none;overflow-y: hidden; outline: none;width:100%; height:100vh; " src="<?php echo URL_BASE; ?>/jds/listado_compromisos.php?&T0D41T0W=<?php echo "ok"; ?>"></iframe> 
        </main>
    </div> 
    </div>
    
</div>
<footer class="footer_view Estilo1"  >JDS - Sistema Integral de Gesti&oacute;n Administrativa,  VCH Sistema y Tecnologia Todos los derechos reservados Copyright 2018 ©</footer> 

    
    <div id="modalContainer"></div>
 <div id="contenedor_espera_respuesta" style=" padding: 10px; color: rgb(255, 255, 255); font-weight: bold; position: absolute; opacity: 0.5; background-color: rgb(102, 102, 102); z-index: 5;   top: -50px; width: 100%; height: 148%; display: none; " >
    <div   align="center" style="margin-top:20%">
        <table><tr><td><span id='msg_pantalla'  style="float: left; font-size: 20px ">Procesando la informacion ...  </span>  </td><td>
         
<div class="loadingDiv" id="esperaMarcas" style="height:20px; width:100px;  ">
    <div id="blockG_1" class="facebook_blockG"></div>
    <div id="blockG_2" class="facebook_blockG"></div>
    <div id="blockG_3" class="facebook_blockG"> </div></div></td></tr></table>
     </div>
</div>
    
       
        <input type="hidden" value="<?php echo URL_BASE ; ?>" id="url_base" />
            
<div class="hidden">
    <input id='datosVistasRecibido' value='<?php echo $_POST['datos_vistas']; ?>' type="hidden" />
    <form  action="../php/exportExcel.php" method="post" accept-charset="UTF-8" id="exportarTabla">
        <input type="hidden" name="datos_a_enviar" id="datos_a_enviar" style="font-family: monospace;">
        <input type="hidden" name="nombre_reporte" id="nombre_reporte" style="font-family: monospace;">
        <input type="submit" style="font-family: monospace;">
    </form>
    <form  action="" method="post" accept-charset="UTF-8" id="datosVistas" >
        <input type="hidden" name="datos_vistas" id="datos_vistas" style="font-family: monospace;"> 
        <input type="submit" style="font-family: monospace;">
    </form>
  
</div>
        <input type="hidden" id="cargarFechas" value="si"/>
    </body>
 </html>
 
