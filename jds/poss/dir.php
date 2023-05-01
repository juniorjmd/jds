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
 

<!-- Optional theme --> 
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script> 
<script type="text/javascript" src="jquery.gmap.js"></script>
<head>
    <title>Geocoding service</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
<style>
#mapa_1{ width:100%;max-width: 700px; height: 70%; max-height: 450px; border: 1px solid #777; overflow: hidden; margin: 10 auto; }

.panel .panel-default{width : 100%; height:100%;  margin : 0px ;   }
	
 
button 	{vertical-align: -webkit-baseline-middle;}
#container{width : 100%;  }
</style>
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
 
<a  href="index.php"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">Inicio</span></a>

</div> 

</div> 
<div id='container'>
 <div id="floating-panel">
      <input id="address" type="textbox" value="Sydney, NSW">
      <input id="submit" type="button" value="Geocode">
    </div>
    <div id="map"></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }//AIzaSyBn8PDDN4eoNGWKzNktk2oPnKl-Xs9-PCo
	  //AIzaSyCQYycDDTLxEVpLDjcI7htzw2O4Cr_vYmo
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQYycDDTLxEVpLDjcI7htzw2O4Cr_vYmo&callback=initMap">
    </script>
</div></div>
</body>