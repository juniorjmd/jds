<?php
include_once '../../php/inicioFunction.php';
include_once '../../php/db_conection.php';
session_sin_ubicacion_3("login/");
foreach ($_POST as $key => $value) {
    $$key = $value;
}
if(isset($inventarios)){    
    $SQL = 'SET SQL_SAFE_UPDATES = 0;';
    
    //$SQL = "update producto set cantInicial = 0, cantActual =0, compras =0, ventas = 0, devoluciones = 0";
    
$conn= cargarBD();
$stmt = $conn->stmt_init();
    $stmt->prepare($SQL);
//echo $query;
if( $stmt->execute()){
        $SQL = "update producto set cantInicial = 0, cantActual =0, compras =0, ventas = 0, devoluciones = 0";
         $stmt->prepare($SQL);
            if($stmt->execute()){echo'Los datos de la tabla de productos fueron reiniciados con exito';}else{
                echo'error al borrar la tabla producto';
            }
    }
}

if(isset($VENTAS)){
    
$conn= cargarBD();
$stmt = $conn->stmt_init();
    $SQL = 'SET SQL_SAFE_UPDATES = 0;';
    
    //$SQL = "update producto set cantInicial = 0, cantActual =0, compras =0, ventas = 0, devoluciones = 0";
    
    $stmt->prepare($SQL);
//echo $query;
if( $stmt->execute()){
    //ventacliente, ventas, ventastemp
        $SQL = "delete from ventacliente";
         $stmt->prepare($SQL);
         if( $stmt->execute()){
            limpiar_autoincrement('ventacliente');
             $SQL = "delete from ventas";
                $stmt->prepare($SQL);
             if( $stmt->execute()){
                limpiar_autoincrement('ventas');
                 
                 $SQL = "delete from ventastemp";
                $stmt->prepare($SQL);
                 if( $stmt->execute()){
                     limpiar_autoincrement('ventastemp');
                     echo'Los datos de la tabla de ventas fueron reiniciados con exito';}
             }
         }
            
    }
}

if(isset($compras)){
    
$conn= cargarBD();
$stmt = $conn->stmt_init();
    $SQL = 'SET SQL_SAFE_UPDATES = 0;';
    
    //$SQL = "update producto set cantInicial = 0, cantActual =0, compras =0, ventas = 0, devoluciones = 0";
    
    $stmt->prepare($SQL);
//echo $query;
if( $stmt->execute()){
    //ventacliente, ventas, ventastemp
        $SQL = "delete from compras";
         $stmt->prepare($SQL);
         if( $stmt->execute()){
            limpiar_autoincrement('compras');
             $SQL = "delete from listacompra";
                $stmt->prepare($SQL);
             if( $stmt->execute()){
              limpiar_autoincrement('listacompra');
                 $SQL = "delete from listacompraedicion";
                $stmt->prepare($SQL);
                 if( $stmt->execute()){
                   limpiar_autoincrement('listacompraedicion');
                     echo'Los datos de la tabla de COMPRAS fueron reiniciados con exito';}
             }
         }
            
    }
}

if(isset($transacciones)){
	//echo 'entro transaccionas';
$conn= cargarBD();
$stmt = $conn->stmt_init();
    $SQL = 'SET SQL_SAFE_UPDATES = 0;';
    
    //$SQL = "update producto set cantInicial = 0, cantActual =0, compras =0, ventas = 0, devoluciones = 0";
    
    $stmt->prepare($SQL);
//echo $query;
if( $stmt->execute()){ 
        $SQL = "delete from cierrediario";
         $stmt->prepare($SQL);
         if( $stmt->execute()){
               limpiar_autoincrement('cierrediario');
             $SQL = "delete from cierremes";
                $stmt->prepare($SQL);
             if( $stmt->execute()){
                 limpiar_autoincrement('cierremes');
                 $SQL = "delete from cartera";
                $stmt->prepare($SQL);
                 if( $stmt->execute()){
                    limpiar_autoincrement('cartera');
                     
                      $SQL = "delete from bancos";
                        $stmt->prepare($SQL);
                        if( $stmt->execute()){
				limpiar_autoincrement('bancos');		//echo $SQL;
                            $SQL = "delete from abonosnomina";
                               $stmt->prepare($SQL);
                            if( $stmt->execute()){//echo $SQL;
                                limpiar_autoincrement('abonosnomina');
                                $SQL = "delete from abonoscredito";
                               $stmt->prepare($SQL);
                                if( $stmt->execute()){//echo $SQL;
                                     limpiar_autoincrement('abonoscredito');
  //, , , , , , , , , , , pagosiva, retefuente, retefuente_pagada, salidasefectivo, devoluciones  
                                       $SQL = "delete from abonoscartera";
                $stmt->prepare($SQL);
                 if( $stmt->execute()){//echo $SQL;
                    limpiar_autoincrement('abonoscartera');
                                        $SQL = "delete from credito";
                                          $stmt->prepare($SQL);
                                          if( $stmt->execute()){//echo $SQL;
                                               limpiar_autoincrement('credito');
                                              $SQL = "delete from gastos";
                                                 $stmt->prepare($SQL);
                                              if( $stmt->execute()){//echo $SQL;
                                                  limpiar_autoincrement('gastos');
                                                  $SQL = "delete from nomina";
                                                 $stmt->prepare($SQL);
                                                  if( $stmt->execute()){//echo $SQL;
                                                  limpiar_autoincrement('nomina');
                                                       //, , , , , , , , , , , , , , ,   
                                       $SQL = "delete from pagosiva";
                                            $stmt->prepare($SQL);
                                                if( $stmt->execute()){//echo "<br>". $SQL;
                                         limpiar_autoincrement('pagosiva');
                                       $SQL = "delete from retefuente";
                                          $stmt->prepare($SQL);
                                          if( $stmt->execute()){//echo $SQL;
                                          limpiar_autoincrement('retefuente');
                                              $SQL = "delete from retefuente_pagada";
                                                 $stmt->prepare($SQL);
                                              if( $stmt->execute()){//echo $SQL; 
                                              limpiar_autoincrement('retefuente_pagada');
                                                  $SQL = "delete from salidasefectivo";
                                                 $stmt->prepare($SQL);
                                                  if( $stmt->execute()){//echo $SQL;
                                                      limpiar_autoincrement('salidasefectivo');
                                                       $SQL = "delete from devoluciones";
                                                 $stmt->prepare($SQL);
                                                  if( $stmt->execute()){
                                                      limpiar_autoincrement('devoluciones');
                                                      echo'Los datos de las tablas de TRANSACCIONES fueron reiniciados con exito';}
                                                      
                                                   }
                                             }
                                          }
                                   }
                                                      
                                                  }
                                              }
                                          }
                                   }
                                    
                                }
                            }
                        }
                 }
             }
         }else{echo'nop';}
            
    }
}

//compras listacompra listacompraedicion
 function limpiar_autoincrement($tabla){
     $conn= cargarBD();
$stmt = $conn->stmt_init();
      $SQL = "ALTER TABLE {$tabla} AUTO_INCREMENT = 1";
             $stmt->prepare($SQL);
             $stmt->execute();
 }
?>




<table border="1" style="margin: 0 auto; width: 80%">
    
    <tr>
        <td colspan="5" style="text-align: center"> <a href='../'> <<<<ATRAS </td>
    </tr>
	<tr>
        <td colspan="5" style="text-align: center">REINICIAR BASE DE DATOS</td>
    </tr>
    
    <tr>
        <td>
            <form method="POST" >
                <input value="inventarios" name="inventarios" type="hidden"/>
                <table><tr>
                    <td>LIMPIAR INVENTARIO</td>
                </tr>
                <tr><td><input type="submit" value="enviar"/></td>
                </tr>
            </table> 
            </form> 
            
        </td>
        
        
        <td><form  method="POST" >
                <input value="VENTAS" name="VENTAS" type="hidden"/>
                <table><tr>
                    <td>LIMPIAR VENTAS</td>
                </tr>
                <tr><td><input type="submit" value="enviar"/></td>
                </tr>
            </table> 
            </form> </td>
            
            <td>
                <form  method="POST" >
                <input value="Compras" name="compras" type="hidden"/>
                <table><tr>
                    <td>LIMPIAR COMPRAS</td>
                </tr>
                <tr><td><input type="submit" value="enviar"/></td>
                </tr>
            </table> 
            </form> 
            </td>
            <td>
                <form  method="POST" >
                <input value="transacciones" name="transacciones" type="hidden"/>
                <table><tr>
                    <td>LIMPIAR TRANSACCIONES</td>
                </tr>
                <tr><td><input type="submit" value="enviar"/></td>
                </tr>
            </table> 
            </form> 
            </td>
    </tr>
    
    
</table>