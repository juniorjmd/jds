<?php
include_once '../../php/inicioFunction.php';
include_once '../../php/db_conection.php';
session_sin_ubicacion_3("login/");
$mysqli = cargarBD();
$stmt = $mysqli->stmt_init();
$aux=''; 

  
foreach($_POST as $key => $value )
{
	$$key = $value;
}     
if(isset($tablas)){ 
  $arr_restaurar = array();
foreach ($restaurar as $key => $value) {
$arr_restaurar[$value] = 'ok';}
foreach ($tablas as $key => $value) {
    $query = " SHOW COLUMNS FROM $data_base_res.$value ;";
    $columnas ='*';
            
     $result = $mysqli->query($query);
    if($result->num_rows>0){
        $columnas ='';
        $coma = '';
	$cont=0;
while ($row = $result->fetch_assoc()) {
     $columnas .="$coma `{$row['Field']}`";
        $coma = ',';
   
}
    }
    echo "<br> TRUNCATE table {$_SESSION["N_database"]}.$value ;";
    if(isset($arr_restaurar[$value]))
    echo "<br> insert into  {$_SESSION["N_database"]}.$value select $columnas from $data_base_res.$value;"; 
}

}
$query="SHOW FULL TABLES FROM  {$_SESSION["N_database"]};";
$result = $mysqli->query($query);
?>
<form method="POST" id="f1" target="index.php">
    <table><tr><td>
    <?php
if($result->num_rows>0){
	$cont=0;
while ($row = $result->fetch_assoc()) {
     //print_r($row);
     if($row['Table_type'] == 'BASE TABLE')
    echo'<br>'.'<input type="checkbox" value="'. $row['Tables_in_'.$_SESSION["N_database"]].'" name = "tablas[]"/>'. $row['Tables_in_'.$_SESSION["N_database"]].'<input type="checkbox" value="'. $row['Tables_in_'.$_SESSION["N_database"]].'" name="restaurar[]">RESTAURAR';
	$cont++;
}

$result->free();
}

?>
            </td><td><input type="text" name="data_base_res" value="<?php echo $_SESSION["N_database"];?>"><br><input type="submit" value="enviar"></td></tr></table>
</form>   