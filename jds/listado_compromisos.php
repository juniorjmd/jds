<?php
include 'php/inicioFunction.php';
verificaSession_2("login/"); 
 include 'db_conection.php';
 
 
if(isset($_POST)&& sizeof($_POST)>0){
    $array_var = $_POST;
}elseif(isset($_GET)&& sizeof($_GET)>0){
    $array_var = $_GET;
}
if(isset($array_var['T0D41T0W'])){//HOY Y MAÑANA
    $DATE_AUX = "and fecha_max_pago  between '".date('Y-m-d')."' and DATE_ADD('".date('Y-m-d')."', INTERVAL 1 DAY)";
}
$QUERY_CP = "SELECT * FROM  fecha_cuotas_creditos ".
"inner join  credito on id_compromiso = idCartera ".
"left join   proveedores on credito.idCliente = proveedores.NIT where tipo_compromiso ='CXP'  $DATE_AUX   order by fecha_max_pago;";

$QUERY_CC = "SELECT * FROM  fecha_cuotas_creditos ".
"inner join  credito on id_compromiso = idCartera ".
"left join   proveedores on credito.idCliente = proveedores.NIT where tipo_compromiso ='CXC' $DATE_AUX   order by fecha_max_pago;";


 
$mysqli = cargarBD(); 
//edicion de compras final
  
	//echo $query2;
$fila_cp = '';
$result = $mysqli->query($QUERY_CP);
//print_r($mysqli);
$valorParcialCC = $valorParcialCC = $CantVendidaCC = $valorParcialCP = $CantVendidaCP = 0;
if($result->num_rows >0){
while ($row = $result->fetch_assoc()) {
	$valorParcialCP+=$row['valorCuota']; 
        $fila_cp .= '<tr>' ; 
  $fila_cp .= "<td>{$row['razonSocial']}</td>" ; 
  $fila_cp .= "<td>{$row['fecha_max_pago']}</td>" ; 
  $fila_cp .= "<td>{$row['numero_cuota']}</td>" ; 
  $fila_cp .= "<td>{$row['idCartera']}</td>" ; 
  $fila_cp .= "<td>{$row['valorCuota']}</td>" ; 
  $fila_cp .= "<td>{$row['TotalInicial']}</td>" ; 
  $fila_cp .= "<td>{$row['TotalActual']}</td>" ; 
  $fila_cp .= '</tr>' ; 
}
$result->free();

}else{
    
  $fila_cp = '<tr><td colspan="7" >NO EXISTEN CUETAS POR COBRAR</td></tr>' ; 
}
$fila_cc = '';
$result = $mysqli->query($QUERY_CC);
if($result->num_rows >0){
while ($row = $result->fetch_assoc()) {
	$valorParcialCC+=$row['valorCuota']; 
       
  $fila_cc .= '<tr>' ; 
  $fila_cc .= "<td>{$row['razonSocial']}</td>" ; 
  $fila_cc .= "<td>{$row['fecha_max_pago']}</td>" ; 
  $fila_cc .= "<td>{$row['numero_cuota']}</td>" ; 
  $fila_cc .= "<td>{$row['idCartera']}</td>" ; 
  $fila_cc .= "<td>{$row['valorCuota']}</td>" ; 
  $fila_cc .= "<td>{$row['TotalInicial']}</td>" ; 
  $fila_cc .= "<td>{$row['TotalActual']}</td>" ; 
  $fila_cc .= '</tr>' ; 
        
}
$result->free();

}else{
  $fila_cc = '<tr><td colspan="7" >NO EXISTEN CUETAS POR COBRAR</td></tr>' ; 
    
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
     <meta charset="utf-8" />  
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->

   <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>

  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/>  
  <style>
      .tabla_info th{
          font-size: 11px !important;
      }
  </style>
</head>

    <body>
        <div class="container">
            <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                <h3><label>Cuentas por cobrar.</label></h3>
            </div>  
            </div>
            <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                
<table class="table tabla_info" > 
    
 

<tr>
    <th  scope="col">Total cuotas</th>
    <th  scope="col" colspan="6"><?=$valorParcialCC;?></th> 
</tr>
    <tr>
<th  scope="col">Razon social</th>
<th  scope="col">Fecha de pago</th>
<th  scope="col">Nùmero de cuota</th>
<th  scope="col">Id Cartera</th>
<th  scope="col">Cuota</th>
<th  scope="col">Valor inicial</th>
<th  scope="col">Valor actual</th></tr>
    <tr>
        <?php echo $fila_cc;?>
    </tr>
    
</table>

            </div>  
            </div>
  <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                <h3> <label>Cuentas por pagar.</label></h3>
            </div>  
            </div>
            <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
<table class="table tabla_info">
    <tr>
    <th  scope="col">Total cuotas</th>
    <th  scope="col" colspan="6"><?=$valorParcialCP;?></th> 
</tr>
       <tr>
<th  scope="col">Razon social</th>
<th  scope="col">Fecha de pago</th>
<th  scope="col">Nùmero de cuota</th>
<th  scope="col">Id Cartera</th>
<th  scope="col">Cuota</th>
<th  scope="col">Valor inicial</th>
<th  scope="col">Valor actual</th></tr>
    <tr>
        <?php echo $fila_cp;?>
    </tr>
    
</table>
            </div></div>
</div>

    </body></html>