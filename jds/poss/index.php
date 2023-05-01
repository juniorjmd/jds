<?php include '../php/inicioFunction.php';
verificaSession_2("../login/"); 
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();

?>
<?php 
include '../db_conection.php';
$mysqli = cargarBD();
$independiente=true;
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<script src="../bootstrap/js/bootstrap.min.js"></script>


<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta charset="utf-8">
 

<!-- Optional theme  --> 
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script> 
 <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
 
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcLkYmApcgXquH5dh9Jhup8QcJaJhO-W4"   type="text/javascript"></script> --> 
   <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcLkYmApcgXquH5dh9Jhup8QcJaJhO-W4&callback=initMap">
    </script>

<script type="text/javascript" src="jquery.gmap.2016.js"></script>

<style>
#mapa_1{ width:100%;max-width: 700px; height: 70%; max-height: 450px; border: 1px solid #777; overflow: hidden; margin: 10 auto; }

.panel .panel-default{width : 100%; height:100%;  margin : 0px ;   }
	
 
button 	{vertical-align: -webkit-baseline-middle;}
#container{width : 100%;  }
</style>

<script type="application/javascript">

function fubicacion(zoom, usuario){
	//alert(zoom, usuario)
var markers=[];
var cuerpo='';
var datos=null;
if (usuario){
	datos={usuarioid:usuario};
} 
alert(JSON.stringify(datos));
$.ajax({url: 'verificarDireccion.php',  
			type: 'POST',
			data:datos,
			dataType: "json",
			 beforeSend: function() {
				 $("#container").css('opacity',0.3);
      			   }, 
			statusCode: {
    			404: function() {
     			 alert( "pagina no encontrada" );
				 $( "#inial" ).css('display','none') 
   				 },
				 408: function() {
				 $( "#inicial" ).css('display','none')
     			 alert( "Tiempo de espera agotado. la peticion no se realizo " );
   				 }
				 
				 },
 			success: function(data) {		
				alert(JSON.stringify( data))
				i=0;coma=''; 
				usuarios='';
				for(var aux in data)  
					{
					for(var auxDatos in data[aux]){		
						if(auxDatos!='count'){
						 	aux2=data[aux][auxDatos];						
							usuarios=usuarios+aux2['nombre'] 
							latitud=aux2['latitud']
							longitud=aux2['longitud']
							count=aux2['nombre'] ;
						count2=aux2['nombre'] ;
							}
						else{ }
						}
						if(i==0){coma=''}
						else{coma=','}
						markers[i]={latitude:latitud, longitude:longitud,title:usuarios,popup:true,html: count}
						i++;
						usuarios='';
					}
				$('#mapa_1').html('');
				  $('#mapa_1').gMap({ markers:markers, 
							zoom: zoom 
						});
						$("#container").css('opacity',1);
						},error: function(a,e,b){
					 alert("se genero un error solo uno" +JSON.stringify(a+e+b))
					}
						});
						}
						
						
$(document).ready(function() {
 
	var datosAjax = {tabla: 'usuarios',
		inicio: '',
		//dataBase:'pedrocontreras4',
		//dataBase:'jkou_124569piokmd', 
		datosRequeridos:['concat','nombre','apellido','fconcat','id' ]};		
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
				//alert(JSON.stringify(data))
				datosTabla=data['datos'];
				for(var i=0; i<datosTabla.length;i++){
					auxDato=datosTabla[i];
					auxOptio=$('<option>');
					auxOptio.attr('value',auxDato.id)
					auxOptio.html(" "+auxDato.concat1+"  ")
					$('#usuariosId').append(auxOptio)
					
					}
					
				},error: function(a,e,b){
					alert("se genero un error"+JSON.stringify(a+e+b))
					}});//fin bloque obtencion de datos producto
 $('#usuariosId').unbind('change');
 $('#usuariosId').change(function(){
						var id = $(this).val();
						//alert('el id es '+id)
						var zoom = 18;
						if (id == '')	
						{zoom = 11;}	
						fubicacion(zoom,id); 
						
					});
    $('#historial').click(function() {
		fubicacion(11 ,null)
		})
		fubicacion(11,null )
});
</script>

<body>
<div class="panel panel-default" >
<div style='height:45px' class="panel-heading">
<div id='cordinates'></div>
<div  style='float:left'>
<span style="font-size:20px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 
 
<div style="float:right ; margin-right: 10px">
 
<a  href="../index.php"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">MenuPincipal</span></a>

</div><div style="float:right ; margin-right: 10px">
<div class="btn-group">
<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+ <span class="caret"></span></button>
 <ul class="dropdown-menu dropdown-menu-right">
    <li><a href="dir.php">Direcciones</a></li>
    <li><a href="routs.php">Asignar Rutas</a></li>
    <li><a href="hst.php">Historial</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="deliveries.php">Deliveries</a></li>
  </ul>
</div>

</div></div>
<div id='container'>
<div class='row alert-success'id='' style='  padding-left:20px;padding-bottom:10px'>
<h4>Usuarios</h4>
 <div class="btn-toolbar" role="toolbar"> 
<div class="input-group">
<select id='usuariosId' style='height:105%'><option value=''>Todos los Usuarios</option></select>
  <button type="button" class="btn btn-default" aria-label="Right Align" id='historial'>historial
 </button> 
 </div></div></div>



<div id="mapa_1" ></div> 



</div></div></body>