<?php 
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=".$_POST['nombre_reporte'].".xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
     
include_once 'inicioFunction.php';
include_once 'db_conection.php';
session_sin_ubicacion_2("login/");
$mysqli = cargarBD();
$stmt = $mysqli->stmt_init();
$aux=''; 
/*$divAux .=  "<input type='hidden' name='nombre_reporte' id='nombre_reporte' value='$nombreArchivo'  style='font-family: monospace;'>";
    $divAux .=  "<input type='hidden' name='tabla' id='tabla' value='$tabla'  style='font-family: monospace;'>";
    $divAux .=  "<input type='hidden' name='tipo_tabla' id='tipo_tabla' value='$tipoTabla'  style='font-family: monospace;'>";
    $divAux .=  "<input type='hidden' name='datos_cabecera' id='datos_cabecera' value='$datos_cabecera'  */
   // print_r($_POST );       
foreach($_POST as $key => $value )
{
	$$key = $value;
}     
if(isset($tabla) && trim($tabla) != ''){  
     $parametrosaux = '';   
    switch ($tipo_tabla) {
        case 1:
                if (isset($parametros) && sizeof($parametros)>0){
                    $coma='';
                 foreach ($parametros as $keyP => $valueP) {
                     
                       //   1 => array("columna" => '',"dato" => 'GRUPO',"relacion" => '>',)  
                    $parametrosaux .= "$coma {$valueP['columna']} {$valueP['relacion']} '{$valueP['dato']}'";
                    $coma = ' and '; 
                 }
                 if ($parametrosaux != ''){
                     $parametrosaux = " WHERE $parametrosaux";
                 }
                
             }
              $queryPrincipal = "select * from $tabla $parametrosaux";  
            break;
         case 2:
             $coma = '';
             if (isset($parametros) && sizeof($parametros)>0){
                 foreach ($parametros as $keyP => $valueP) {
                    $parametrosaux .= "$coma'$valueP'";
                    $coma = ','; 
                 }
                
             }
            $queryPrincipal = "call $tabla($parametrosaux)"; 
            break;
    }
   

        
     $datos = array();
    $cabecera = '';
    $count = 0;
      if (trim($datos_cabecera[0]) == '*'){
          if ($tipo_tabla == '1'){
                $queryAux = " SHOW COLUMNS FROM $tabla ;";
                 $result = $mysqli->query($queryAux);
            if($result->num_rows>0){ 
                while ($row = $result->fetch_assoc()) {
                    
                     $datos[$count]=$row['Field'];
                     $row['Field'] = strtoupper($row['Field']);
                     $cabecera .="<td>{$row['Field']}</td>";
                     $count++;
                } 
            }
      }
      }else{ 
         
        foreach ($datos_cabecera as $key => $value) {
        $value = strtoupper($value);
        $cabecera .= "<td>$value</td>";
        $datos[$count]=$key;
        $count++;
        }
      }
     if ($cabecera!=''){
         $cabecera = "<tr>$cabecera</tr>";
    }  
    
    //echo $queryPrincipal;
        $result = $mysqli->query($queryPrincipal); 
    if($result->num_rows>0){
        $columnas ="";
        $coma = '';
        $cabeceraaux  = '';
        $cont=0; 
    while ($row = $result->fetch_assoc()) {
         $columnas .="<tr>";
        if (sizeof($datos)>0){
            foreach ($datos as $keyDatos => $valueDatos) {
               $columnas .="<td>{$row[$valueDatos]}</td>";
            }
        }else{
            print_r($row);
            foreach ($row as $keyRow => $valueRow) { 
             $columnas .="<td>{$valueRow}</td>";
             if ($cabecera == '' && $cont == 0){
                 $value = strtoupper($valueRow);
                $cabeceraaux = "<td>$valueRow</td>";
             }
             
            } 
        }
         $columnas .="</tr>";
$cont++;
    } 
    if ($cabeceraaux != ''){
        $cabecera = $cabeceraaux;
    }
    }
   echo "<table border='1'>"; 
   echo $cabecera.$columnas ;
   echo "</table>"; 
}