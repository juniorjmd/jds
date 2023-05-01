<?php
error_reporting(0);
if(!$incluido){ include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
}
date_default_timezone_set("America/Bogota"); 
if($_POST['IdVenta'] ){$ventaId=$_POST['IdVenta'];}else{$ventaId="M4_1";}
 $mesa=substr($ventaId, 0, strpos($ventaId,"_")); 
echo $_POST['IdVenta'];
$auxR=((int)$numR+1)*27-strlen($string2) .'</br>';
if($_POST['sucursal'] ){$sucursal= $_POST['sucursal'];}else{$sucursal="EL SITIO";}

$inicio=24-strlen($sucursal)/2;
$spc="";
for($i=1;$i<=$inicio;$i++)
{$spc=$spc." ";}
$sucursal=$spc.$sucursal;

$mysqli12 = cargarBD();
$query="SELECT  `ventastemp`.* ,  `producto`.nombre AS  'nomProducto' FROM  `ventastemp` JOIN producto ON  `ventastemp`.idProducto =  `producto`.idProducto WHERE `idVenta`='".$ventaId."' ";
$result = $mysqli12->query($query);
$datosNum=$mysqli12->affected_rows;
if($handle = printer_open("puntoVenta"))
{
//echo printer_get_option($handle, PRINTER_DRIVERVERSION);
printer_set_option($handle, PRINTER_MODE, "raw");
printer_set_option($handle, PRINTER_COPIES, "3"); // i want 3 copies
printer_set_option($handle, PRINTER_SCALE, 75);
printer_set_option($handle, PRINTER_ORIENTATION, PRINTER_ORIENTATION_PORTRAIT );
if($_POST['abrir'])
{printer_write($handle,  chr(27). chr(112). chr(0). chr(100). chr(250));
}
printer_write($handle, "\r\n");
printer_write($handle, $sucursal);
printer_write($handle, "\r\n");
printer_write($handle, "                VENTA DE CONTADO\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "               FECHA ".date("d-M-Y")."\r\n");
printer_write($handle, "                  HORA ".date("g:i:s"));
printer_write($handle, "            TIPO DE VENTA : CONTADO\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "  Cant    Descripcion        VR. Und   VA. TOTAL ");
while ($row = $result->fetch_assoc()) {
printer_write($handle, "\r\n");
$string1="  ".$row["cantidadVendida"];
$inicio=8-strlen($string1);
$spc="";
for($i=1;$i<=$inicio;$i++)
{$spc=$spc." ";}
$string3=trim($row["presioVenta"]);
$inicio=8-strlen($string3);
$spc2="";
//echo $inicio;
for($i=1;$i<$inicio;$i++)
{$spc2=$spc2." ";}
$strcentro="";
for($i=1;$i<=$inicio;$i++)
{$spc2=$spc2." ";}
$spcCentro="\n        ";
$string2=$row["nomProducto"];
$inicio=strlen($string2);
if($inicio>17)
{$inicio=17;}
$aux=0;
for($i=0;$i<$inicio;$i++)
{
	$strcentro=$strcentro.substr($string2,$i,1);$aux++;
}
for($i=0;$i<17-$inicio;$i++)
{
	$strcentro=$strcentro." ";
}
$punto="";
$auxR=8-strlen(trim($row["valorTotal"])) ;
echo "</br> esto es el ultimi espacio".$auxR;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4." ";}
echo $string1.$spc.$strcentro.$spc2.$string3.$row["valorTotal"];
printer_write($handle, $string1.$spc.$strcentro.$spc2.$string3."    ".$spc4.$row["valorTotal"]);
$totalVenta=$totalVenta+$row["valorTotal"];
$totalIva=$totalIva+($row["IVA"]*$row["cantidadVendida"]);
$totalPventa=$totalPventa+($row["presioSinIVa"]*$row["cantidadVendida"]);
}

printer_write($handle, "\r\n\r\n================================================\r\n\r\n");
printer_write($handle, "            Sub total:          $".$totalPventa."\r\n");
printer_write($handle, "            IVA:                $".$totalIva."\r\n");
printer_write($handle, "            Total:              $".$totalVenta."\r\n");

printer_write($handle, "\r\n             GRACIAS POR SU COMPRA");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n    ________________________________________                      FIRMA\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n\r\n\r\n");
printer_close($handle);}
?>