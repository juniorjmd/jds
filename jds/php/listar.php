<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$conn=cargarBD();
$stmt = $conn->stmt_init();

$stmt->prepare('SELECT * FROM  color');

if(!$stmt->execute()){

throw new Exception('No se pudo realizar la consulta:' . $stmt->error);

}

else{

$stmt->store_result(); //Sin esta l�nea no podemos obtener el total de resultados anticipadamente

$cuantos_registros = $stmt->num_rows;

if($cuantos_registros>0){

$stmt->bind_result($col1, $col2,$col3);

    /* fetch values */
    while ($stmt->fetch()) {
        printf("<p>%s %s %s</p>", $col1, $col2,$col3);
    }

}

}

$stmt->close();


?>
