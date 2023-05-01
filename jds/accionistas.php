<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>JDS/Accionistas</title>
 <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>

</head>

<body><br />
<div    >
    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h2>Creación y Edicion de Accionistas</h2>
        </div>
    </div>
    
    
 
 
    <div class="row">
        <div class="col-md-1 col-sm-12">
            <?php  $id_tabla= 'tablasListaclientes';
                $nombreArchivo= 'listaAccionistas';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> </div>
         <div class="col-md-1 col-sm-12">
             <button class="btn btn-success">Crear</button></div>
         <div class="col-md-1 col-sm-12">
             <button class="btn btn-danger">Cancelar</button>
           </div> 
    
    </div>
    <br>
            
       <div class="row">
           <div class="col-md-12 col-sm-12"> 
<table class="table "  id="tablasListaclientes"     > 
            <tr  id="cabPac" align="center"    > 
              <td   ><strong>Nit/Cedula</strong></td>
               <td   ><strong>Nombr</strong>e</td>
               <td   ><strong>Razon Social</strong></td>
               <td   ><strong>Telefono</strong></td>
               <td  ><strong>Direcci&oacute;n</strong></td>
               <td   ><strong>E-mail</strong></td>
            </tr> 
<tbody id="tablanomina">
<?php 
include 'db_conection.php';
 $conn= cargarBD();
$query2="SELECT * FROM  `accionistas` ";
//	echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
//idCliente, nit, nombre, razonSocial, direccion, telefono, email
echo "<tr>
<td nowrap class= 'ui-widget-content'>".$row["nit"]."</td>
<td nowrap class= 'ui-widget-content'>".$row["nombre"]."</td>
<td nowrap class= 'ui-widget-content'>".$row["razonSocial"]."</td>
<td nowrap class= 'ui-widget-content'>".$row["direccion"]."</td> 
<td nowrap class= 'ui-widget-content'> ".$row["telefono"]." </td>
<td nowrap class= 'ui-widget-content'> ".$row["email"]." </td> </tr>";
}


 
$result->free();
$conn->close();

?>
</tbody></table>       
               
     
            </div> 
        
        
    </div>
    
    <div id="Mostrar"  >  
      <div id="Mcontainer" >
        <div id="Mheader">
          <div align="left" >
            <label class="cabeza" >ID</label>
            <label class="lbrespuesta" id="IdClienteM"></label>  &nbsp;&nbsp;
            <img src="imagenes/ui-icons_lapizNEGRO.png" width="18" height="19" title="Editar"  id="EditarBoton" style="cursor:pointer" /><img  src="imagenes/basureroNEGRO.jpg" width="18" height="19" title="Eliminar"  id="EliminarBoton" style="cursor:pointer" />
           
           </div> 
           <div align="left"> <label  class="cabeza">Nombre</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" id="nombre" style="width:20%"/> &nbsp;&nbsp;<label  class="cabeza">Nit/CC</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" id="Nit" style="width:10%"/> &nbsp;&nbsp;  <label  class="cabeza">Razon Social</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" id="Rsocial" style="width:20%"/>
        </div><br />
        
       
          <div align="left" style=" width:100%">
            <label class="cabeza" >email</label>
            &nbsp;&nbsp;
            <input name="text" type="text"  class="Mrespuesta" style="width:15%" id="email"/>
            <label class="cabeza" style="margin-left:5%" >telefono</label>
            &nbsp;&nbsp;
            <input name="text" type="text"class="Mrespuesta" id="telefono" style="width:10%"/>  &nbsp;&nbsp;
            <label class="cabeza" >Direccion</label>
            &nbsp;&nbsp;
            <input name="text" type="text" class="Mrespuesta" style="width:35%" id="direccion"/>
          </div>
          
         
        </div>
        
      </div>
      </div>
 
</div> 
</body></html>

