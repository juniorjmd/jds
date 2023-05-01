<?php
function eliminaMov_y_transaccion($idInsertado,$tabla,$columna){
	global $destino,$origen,$conn;
	$query2="DELETE FROM  transacciones where idRegistroModulo =  '".$idInsertado."' ;"; 
	$result = $conn->query($query2);
	$num_rows = 0;
	$num_rows = $conn->affected_rows;
	$query2="DELETE FROM  ".$tabla." where `".$columna."` =  '".$idInsertado."' ;"; 
	$result = $conn->query($query2);
	
	$num_rows += $conn->affected_rows;
	if($num_rows > 0){return true;}else{return false;}
	
	
}
function guardarNuevaPersona(){
	global $conn , $_POST; 
	if (isset($_POST['noExits']) &&$_POST['noExits'] == "N" ){ 
		 $tabla = $_POST['tipPersonaNueva'];
		 $idCiente = 0;
		 //idCliente, nit, nombre, razonSocial, direccion, telefono, email
		 
		 "select * from ´".$tabla."´";
		 $filas = $result->num_rows;
 if ($filas>0){
while ($row = $result->fetch_row()) {
    $filas=  $row[0];
	   //printf("%s\n",$filas);
    }
 }
		 $idCiente=$filas+1;
		 $query="insert into ".$tabla."(idCliente,nit, nombre, razonSocial, direccion) values('".rellenarTruncar($idCiente,10,'','I',false)."','".$_POST['NewNit']."','".$_POST['NewName']."','".$_POST['NewRSoc']."','".$_POST['NewDir']."')";
		$stmt = $conn->stmt_init();
		//echo $query;
		$stmt->prepare($query);
		if(!$stmt->execute()){
		//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo insertar:' . $stmt->error);
		}else{ }	
	}
}
function agregarBusquedaPersonas($idRespuesta,$contenedor,array $opciones = null , $crear = 'Y', $tablas = '1'){
    /*$tablas = '1'
        $tablas = '2' - clientes
     * $tablas = '3' - proveedores    */
	global $conn, $_POST;
	guardarNuevaPersona();
        switch ($tablas) {
            case '1':
              $query2="SELECT * FROM proveedores union SELECT * FROM clientes;"; 
            break;   
            case '2':
              $query2="SELECT * FROM clientes;"; 
            break;
            case '3':
              $query2="SELECT * FROM proveedores;"; 
            break;
            
        }
	//ECHO $query2;
	$result = $conn->query($query2);
	$num_rows = 0;
	$num_rows = $conn->affected_rows;
	$divbusqueda = "";
	$value =$css= $clase = "";
        $tBtn = 1;
        $idRespuestaAux = 'nitBusqueda';
        $mostrar = $trigger ='';
        $tabla = false ; 
        if(!empty($opciones) ){
            if (isset($opciones['table']) && $opciones['table'] == true )$tabla = true;
            if (isset($opciones['clase']))$clase = trim($opciones['clase']);
            if (isset($opciones['value'])) $value = trim($opciones['value']);
            if (isset($opciones['css']))   $css = trim($opciones['css']);  
            if (isset($opciones['tBtn'])&& trim($opciones['tBtn'])!= '')
               {$tBtn = $opciones['tBtn'];}
            if (isset($opciones['idRespuestaAux'])&& trim($opciones['idRespuestaAux'])!= '')
               {$idRespuestaAux = $opciones['idRespuestaAux'];}
             if (isset($opciones['trigger'])&& trim($opciones['trigger'])!= '')
               {$trigger = $opciones['trigger'];}
             if (isset($opciones['mostrar'])&& trim($opciones['mostrar'])!= '')
               {$mostrar = $opciones['mostrar'];}
            if (isset($opciones['titulo'])&& trim($opciones['titulo'])!= '')
               {$titulo = $opciones['titulo'];}
            
        }
	//idCliente, nit, nombre, razonSocial, direccion, telefono, email
        if (!$tabla){
            echo '<div class="form-group">';
           if(trim($titulo) !== ''){
               echo ' <label for="email">'.trim($titulo).' : </label> ';
           }
           echo '<div class="input-group">'
                . '<input type="hidden" id="existeListado"    value="no" />'
                . '<input type="hidden" id="noExits" name="noExits"  value="S" />'
                . '<input type="text"   aria-label="nit busqueda"  id="nitBusqueda" '
                . 'value="'.$value.'" class = "form-control '.$clase.'" '
                . 'name = "nitBusqueda"';
           if(trim($titulo) !== ''){
               echo ' title ="'.trim($titulo).'" ';
           }
                   
           echo ' style="'.$css.'" />';
        if ($crear == 'Y'){
            if ($tBtn == 1) {
             echo ' <input type="image" id="crearPersonaNueva" src="imagenes/nuevo.jpg" style="width:50px" value="Crear"  title="Nuevo tercero"/> ';
            }else{
              echo '<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" id="crearPersonaNueva" title="Nuevo tercero">'.
                '<i class="fa fa-plus" aria-hidden="true"></i>'.
                '</button>';  
            }
        }
        if ($tBtn == 1) {
            echo  '<input type="image" id="buscarDatos" src="imagenes/cargarImagen.jpg" style="width:40px" value="Buscar" title="Consultar tercero"/>'; 
        }else{ echo '<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" id="buscarDatos" title="Consultar tercero">'.
                '<i class="fa fa-search" aria-hidden="true"></i>'.
                '</button>';}
        
        
        echo '</div></div>';
        
        }else{
	echo '<table>'
        . '<tr><td valign="middle">'
                . '<input type="hidden" id="existeListado"    value="no" />'
                . '<input type="hidden" id="noExits" name="noExits"  value="S" />'.
                '<input type="text" id="nitBusqueda" value="'.$value.'" class = "'.$clase.'" name = "nitBusqueda" style="'.$css.'" /></td>';
        if ($crear == 'Y'){
        echo '<td><input type="image" id="crearPersonaNueva" src="imagenes/nuevo.jpg" style="width:50px" value="Crear"/></td>';}
        if ($tBtn == 1) {
            echo '<td>'
        . '<input type="image" id="buscarDatos" src="imagenes/cargarImagen.jpg" style="width:40px" value="Buscar"/>'
        . '</td>';
        }else{
        echo '<td>'.
            '<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" id="buscarDatos" title=" Buscar cliente">'.
                '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>'.
                '</button>' 
        . '</td>';}
        echo  '</tr></table>';
        
         }
        
        
        
	echo '<input type="hidden" id="HtipPersonaNueva" name="tipPersonaNueva"  /> '.
	' <input type="hidden" id="HNewNit" 	name="NewNit" />'.
	' <input type="hidden" id="HNewName" 	name="NewName" />'.
	' <input type="hidden" id="HNewRSoc" 	name="NewRSoc" />'.
	' <input type="hidden" id="HNewDir" 	name="NewDir" />';
	$divCrearNuevo ='<div id="crearPersonas" style=" display:none;  margin-right: auto;margin-left: auto; top: 50px; width: 60%; height:500px; ">'.
	'<table    style=" width:100%;  font-family:Consolas, "Andale Mono", "Lucida Console","Lucida Sans Typewriter", Monaco, "Courier New", monospace">'.
	'<tr><td colspan="2" align="center" valign="middle"><h3>REGISTRO DE TECERO.</h3><hr></td></tr>'. 
	'<tr> <td>Tipo tercero</td><td><select class="form-control" id="tipPersonaNueva" style="width:350px;" ><option value="">SELECCIONE UN TIPO</option><option  value="proveedores">Proveedor</option>'
                . '<option  value="clientes">Cliente</option>'
                . '<option  value="empleado">Empleados</option>'
                . '</select></td> </tr>'.
	'<tr> <td>NIT</td><td><input class="form-control"  tipe="text" id="NewNit"   style="width:350px;"/></td> </tr>'.
	'<tr> <td>Nombre</td><td><input class="form-control" tipe="text" id="NewName" style="width:350px;"/></td> </tr>'.
	'<tr id="tr_apellido" style="display:none"> <td>Apellido</td><td><input class="form-control" tipe="text" id="NewApellido" style="width:350px;"/></td> </tr>'.
        '<tr id="tr_rsocial"> <td>Razon Social</td><td><input class="form-control" tipe="text" id="NewRSoc" style="width:350px;"/></td> </tr>'.
                
        '<tr> <td>Correo Electronico</td><td><input class="form-control" tipe="text" id="NewCElectronico" style="width:350px;"/></td> </tr>'.
        '<tr> <td>Telefono </td><td><input class="form-control" tipe="text" id="NewTelefono" style="width:350px;"/></td> </tr>'.       
                
                
	'<tr> <td>Direccion</td><td><input class="form-control" tipe="text" id="NewDir" style="width:350px;"/></td> </tr>'.
	'<tr> <td colspan="2" align="center"><hr>'
        . '<input class="btn btn-primary" type="button" value="Cerrar" id="cerrarCrear"/>&nbsp;'
        . '<input  class="btn btn-success"  type="button" value="Registrar" id="aceptarCrear"/></td> </tr></table></div>';
            
	
	$divbusqueda .='<div id="listaPersonas" style=" display:none;  margin-right: auto;margin-left: auto; top: 10px; width: 80%; height:500px;overflow: scroll; ">'.
	'<table class="table" style=" width:100%;  font-family:Consolas, "Andale Mono", "Lucida Console","Lucida Sans Typewriter", Monaco, "Courier New", monospace">'.
	'<tr><td colspan="4" align="center" valign="middle"><h3>CONSULTAR TERCERO.</h3></td></tr>'.
	'<tr><td colspan="4" align="center">'.
        '<div class="form-group">  <div class="input-group">'.
        '<input type="text" aria-label="nit busqueda" id="textBusqueda" value="" class="form-control"'. 
        'name="textBusqueda" title="Nit/Cedula" style=""> <div class="input-group-append"  >'.
        '<button type="button" class="btn btn-default  " aria-label="Left Align" id="cleanBusqueda" >'.
        '<i class="fa fa-times-circle" aria-hidden="true"></i></button>'.
        '<button type="button" class="btn btn-default  " aria-label="Left Align" id="cerrarBusqueda">'.
        'Cerrar</button>'.
        '</div></div></div>'    
                . '</td></tr><tr> <td>NIT</td><td>Nombre</td><td>Razon Social</td>'.
	'<td>direccion</td></tr>';
	$count = 0;
	if($num_rows>0){ 
	while ($row = $result->fetch_assoc()) {
            hlp_arrayReemplazaAcentos_utf8_encode($row);
		$count++;		
		$divbusqueda .='<tr style="cursor:pointer" class="filaBusqueda" id="td_'.$count.'">'
                        . '<td id="nit" class = "ui-widget-content" >'.$row["nit"].'</td>'
                        . '<td id="nombre" class = "ui-widget-content">'.$row["nombre"].'</td>'
                        . '<td id="razonSocial" class = "ui-widget-content">'.$row["razonSocial"].'</td>'
                        . '<td id="direccion" class = "ui-widget-content">'.$row["direccion"].'</td></tr>';
	}
	}
	$divbusqueda .='</table></div>';
	echo'<script>  
            $(document).ready(function(){
            
	$("#ContBusquedaPersonas").html('."'".$divbusqueda.$divCrearNuevo."'".');
	
	$("#ContBusquedaPersonas").find("input").click(function(event){
    event.preventDefault();
});
//---------------------------------------------
	$("#tipPersonaNueva").change(function(){ 
            if ($(this).val() == "empleado"){
                $("#tr_rsocial").fadeOut( "slow", function() { 
                    $("#tr_apellido").css("display", ""); 
                  });	
            }else{
                $("#tr_apellido").fadeOut( "slow", function() { 
                    $("#tr_rsocial").css("display", ""); 
                  });	
            }
        }) 
	$("#NewName").keyup(function(){
		$("#NewRSoc").val($(this).val() ) 
	})
	$("#cerrarCrear").click(function(){
		$("#noExits").val("S")
		$("#crearPersonas").hide()
		$("#nitBusqueda").val("")
		$("#'.$contenedor.'").fadeIn( "slow", function() {';
        if(trim($mostrar)!=''){
            echo '$("#'.$mostrar.'").css("display", "block");';
        }			
	echo'});	
	});
	$("#NewNit").keyup(function(){
		var resp1 = "";
		var resp2 = ""; 
		var resp3 = "";
		var encontrar = false;
		var nit = $(this).val()
		if (nit != ""){
		$(".filaBusqueda").each(function(){
			//$(this).find("#nombre").html()
			resp3 = $(this).find("#nit").html();
	 
			if( (resp3 == nit ) && !encontrar){
				 console.log("entro")
				resp1 = $(this).find("#nombre").html()
				resp2 = $(this).find("#nit").html();
				encontrar = true;				
			}			
		});
		if (encontrar){
			$("#existeListado").val("si")
		}else {$("#existeListado").val("no")}}
	}) 
	$("#aceptarCrear").click(function(){
		if ($("#existeListado").val() == "no"){
			if ($("#NewNit").val() != ""){
				if ($("#NewName").val() != ""){ 
					if ($("#NewRSoc").val() != ""){
							$("#HtipPersonaNueva").val($("#tipPersonaNueva").val() )
							$("#HNewNit").val($("#NewNit").val() ) 
							$("#HNewName").val($("#NewName").val() ) 
							$("#HNewRSoc").val($("#NewRSoc").val() ) 
							$("#HNewDir").val($("#NewDir").val())
							$("#noExits").val("N")
							$("#nitBusqueda").val($("#NewNit").val())
							$("#'.$idRespuesta.'").val($("#NewRSoc").val())
							$("#crearPersonas").hide()
							$("#'.$contenedor.'").fadeIn( "slow", function() {';
        if(trim($mostrar)!=''){
            echo '$("#'.$mostrar.'").css("display", "block");';
        }	
                                                        echo '});	
					} else{alert("la razon social no debe estar en blanco");$("#NewRSoc").focus()}
				}else{alert("El nombre no debe estar en blanco");$("#NewName").focus()}
			}else{alert("El NIT no debe estar en blanco");$("#NewNit").focus()}
		}else{alert("El NIT no debe estar en el listado ");$("#NewNit").focus()}
	});
	
//-------------------------------------------------



	$("#buscarDatos").click(function(event){
		event.preventDefault();
		$("#listaPersonas").fadeIn( "slow", function() {
				// Animation complete
			});
		$("#'.$contenedor.'").hide()
                    ';
        if(trim($mostrar)!=''){
             echo '$("#'.$mostrar.'").css("display", "none");';
        }
        echo '
	});
	$("#cerrarBusqueda").click(function(){$("#listaPersonas").hide()
	$("#'.$contenedor.'").fadeIn( "slow", function() {
	';
        if(trim($mostrar)!=''){
             echo '$("#'.$mostrar.'").css("display", "block");';
        }
        echo '
			});
	})
	$(document).keydown(function(e){
		var tecla=e.keyCode;
		if(tecla==13){e.preventDefault();
		}
	})
	$("#cleanBusqueda").click(function(event){
		event.preventDefault(); 
		$("#textBusqueda").val("");
		$("#textBusqueda").trigger("keydown")
	});
	$("#textBusqueda").keydown(function(){
		var busqueda = $(this).val();
                var busqueda_aux = $(this).val().toUpperCase();
		var resp2 = ""; 
		var resp3 = ""; 
		if ( busqueda != ""){
		$(".filaBusqueda").each(function(){ 
			$(this).hide()
			resp3 = $(this).find("#nit").html();
			resp2 = $(this).find("#nombre").html();
                        resp4 = $(this).find("#nit").html().toUpperCase();
			resp5 = $(this).find("#nombre").html().toUpperCase();
                        //alert(resp2+resp3+resp4+resp5);
			if( (resp3.indexOf(busqueda) != -1  ) || (resp2.indexOf(busqueda) != -1 )
                         ||  (resp4.indexOf(busqueda_aux) != -1  ) || (resp5.indexOf(busqueda_aux) != -1 )){
				 console.log("entro")
				$(this).show()
				 				
			}			
		});}else{$(".filaBusqueda").show()}
		 
	});
	$("#nitBusqueda").keydown(function(e){
		
		var tecla=e.keyCode;
		$("#'.$idRespuesta.'").val("")
		if(tecla==13){
			busquedaPersona($("#nitBusqueda").val(),"'.$idRespuesta.'");
			
		}
	});
	$(".filaBusqueda").click(function(){
		//alert("hola papi"+$(this).find("#nombre").html())
		$("#'.$idRespuesta.'").val($(this).find("#nombre").html())
		$("#nitBusqueda").val($(this).find("#nit").html());
		$("#'.$idRespuestaAux.'").val($(this).find("#nit").html());
                $("#cerrarBusqueda").trigger("click");  '; 
		
              
         if(trim($trigger)!=''){
             echo '  $("#'.trim($trigger).'").trigger("click");';
         }
		
	echo '})
	 
	$("#crearPersonaNueva").click(function(e){//crearPersonas
	e.preventDefault();
	$("#NewNit").val($("#nitBusqueda").val()).trigger("keyup")
	$("#crearPersonas").fadeIn( "slow", function() {
				// Animation complete
			});
		$("#'.$contenedor.'").hide()
                    
	});});
	function busquedaPersona(nit , id ){
		var resp1 = "";
		var resp2 = ""; 
		var resp3 = "";
		var encontrar = false;
		if (nit != ""){
		$(".filaBusqueda").each(function(){
			//$(this).find("#nombre").html()
			resp3 = $(this).find("#nit").html(); 
			if( (resp3 == nit ) && !encontrar){
				 console.log("entro")
				resp1 = $(this).find("#nombre").html()
				resp2 = $(this).find("#nit").html();
				encontrar = true;				
			}			
		});
		if (encontrar){ $("#"+id).val(resp1)
				$("#noExits").val("S")
		}else{
			alert("el nit que ingreso no se encuentra registrado, para ingresarlo en la lista de proveedores o clientes, presione NEW")
			
			$("#"+id).val("")
		}
		}else{
			$("#"+id).val("")
		}
		
		 
	}
	</script>';
}

function agregarExcel($id_tabla,$nombreArchivo,$tipoTabla){
   // echo URL_BASE."jds/php/exportExcel.php";
    $divAux =  "<div style='display:none'>";
    $divAux .=  "<input id='datosVistasRecibido' value='' type='hidden'>";
    $divAux .=  "<form action='".URL_BASE."jds/php/exportExcel.php' method='post' accept-charset='UTF-8' id='exportarTabla'>";
    $divAux .=  "<input type='hidden' name='datos_a_enviar' id='datos_a_enviar' style='font-family: monospace;'>";
    $divAux .=  "<input type='hidden' name='nombre_reporte' id='nombre_reporte'  style='font-family: monospace;'>";
    $divAux .=  "<input type='submit' style='font-family: monospace;'>";
    $divAux .=  "</form>";
    $divAux .=  "<form action='' method='post' accept-charset='UTF-8' id='datosVistas'>";
    $divAux .=  "<input type='hidden' name='datos_vistas' id='datos_vistas' style='font-family: monospace;'> ";
    $divAux .=  "<input type='submit' style='font-family: monospace;'>";
    $divAux .=  "</form></div>";
    
    echo '<button id="enviarExcel" class = "btn btn-success">Excel</button> 
     <script>';
    echo " $(document).ready(function(){ 
     $('body').append(\"$divAux\"); $('#enviarExcel').click(function(e){
        e.preventDefault();";
    switch ($tipoTabla){
        case 1:
            echo "var datosAux = $('<div>').append( $('#$id_tabla').eq(0).clone()).html() ;  ";
        break;
        case 2:
            echo "var cabecera = $('#$id_tabla').parent().parent().parent().find('table')
                  var datosAux = $('<div>').append( cabecera.eq(0).clone()).html() ;   
                  $('#$id_tabla').find('.infoContainer').each(function(){
                   datosAux += $('<div>').append( $(this).find('table').eq(0).clone()).html(); 
                  });	";
        break;
    }
   
                           
    echo "             var f = new Date(); 
                 var _nombre = '{$nombreArchivo}_'+f.getDate()   + (f.getMonth() +1)   + f.getFullYear(); 
                $('#datos_a_enviar').val(datosAux);
                $('#nombre_reporte').val(_nombre)
                $('#exportarTabla').submit();
    });";
    echo ' });</script>';
}

function agregarExcelDinamico($tabla,$nombreArchivo,$tipoTabla,array $datos_cabecera = array('*') ,array $parametros = array()){
    $nombreArchivo.='_'.date('dmY'); 
   // echo URL_BASE."jds/php/exportExcel.php";
        
    $divAux =  "<form action='".URL_BASE."jds/php/exportExcelDinamico.php' method='post' accept-charset='UTF-8' id='exportarTabla'>";
    $divAux .=  "<div style='display:none'>";     
    $divAux .=  "<input type='hidden' name='nombre_reporte' id='nombre_reporte' value='$nombreArchivo'  style='font-family: monospace;'>";
    $divAux .=  "<input type='hidden' name='tabla' id='tabla' value='$tabla'  style='font-family: monospace;'>";
    $divAux .=  "<input type='hidden' name='tipo_tabla' id='tipo_tabla' value='$tipoTabla'  style='font-family: monospace;'>";
    
    if ($datos_cabecera[0]=='*'){
         $divAux .=  "<input type='hidden' name='datos_cabecera[]' id='datos_cabecera' value='*'>";
    }else{
    foreach ($datos_cabecera as $key => $value) {
       
        
         $divAux .=  "<input type='hidden' name='datos_cabecera[$key]' id='datos_cabecera' value='$value'>";
    } 
    }
    
   if (sizeof($parametros)>0){
       foreach ($parametros as $key => $value) {
           if ($tipoTabla == '1' ){
           // echo 'entro';
            //   1 => array("columna" => '',"dato" => 'GRUPO',"relacion" => '>',)  
            $divAux .=  "<input type='hidden' name='parametros[$key][columna]' id='datos_cabecera' value='{$value['columna']}'>";
            $divAux .=  "<input type='hidden' name='parametros[$key][dato]' id='datos_cabecera' value='{$value['dato']}'>";
            $divAux .=  "<input type='hidden' name='parametros[$key][relacion]' id='datos_cabecera' value='{$value['relacion']}'>";
        }else{
            $divAux .=  "<input type='hidden' name='parametros[]' id='parametros' value='$value'  style='font-family: monospace;'>";
       }
       }
   }
        
    
    
     $divAux .=  "<input type='submit' style='font-family: monospace;'>";
    $divAux .=  "</div>";
    $divAux .= '<button class="btn btn-success" id="enviarExcel">EXCEL</button>' ;
    $divAux .=  "</form>"; 
    
echo   $divAux;  
        
}
function genera($modulo){

	global $destino,$origen,$conn;
	
	$query2="SELECT * FROM  
	
	mst_modulos where nom_modulo =UPPER('".$modulo."');";
	 
$result = $conn->query($query2);
$numrow = $result->num_rows ;
if ($numrow > 0){
	while ($row = $result->fetch_assoc()) {
	$idmodulo =$row["cod_modulos"];
	}
}

$_SESSION["idModulo"]= 	$idmodulo;
$_SESSION["nameModulo"]= $modulo;
	$query2="SELECT * FROM  vw_relacionmodulos where tipoMovimiento ='O' and modulo= '".$idmodulo."';";
	
$result = $conn->query($query2);
$numrow = $result->num_rows ;
if ($numrow > 0){
	$origen = '<input type="hidden" value="" id="afectacionOrigen" name="afectacionOrigen"/>'.
	'<select id="cuentaOrigen" name="cuentaOrigen" required><option value="">SELECIONE CUENTA ORIGEN</option>';
$inputsHidden='';
	while ($row = $result->fetch_assoc()) {
		$origen .= '<option value="'.$row["cuentaCont"].'">'.$row["NroCuenta"]."-".$row["nombreCuenta"].
		'</option>';
		$inputsHidden .= '<input type="hidden" value="'.$row["Afectacion"].'" id="afCC_'.$row["cuentaCont"].'" />';
		$queryHijos = "select idCuentaContable, idCuentaMayor, nombreCuenta, NroCuenta, idTipoCuenta, descripcion".
		" from cuentascontables where idCuentaMayor = '".$row["cuentaCont"]."'";
		 
		
		$afectaciontmp = $row["Afectacion"];
		$resultAux = $conn->query($queryHijos);
		$numrowHijos = $resultAux->num_rows ;
		if ($numrowHijos > 0){
			while ($rowHijos = $resultAux->fetch_assoc()) {
			$origen .= '<option value="'.$rowHijos["idCuentaContable"].'">'.$rowHijos["NroCuenta"]."-".$rowHijos["nombreCuenta"].
			'</option>';
			$inputsHidden .='<input type="hidden" value="'.$afectaciontmp.'" id="afCC_'.$rowHijos["idCuentaContable"].'"/>';
		//	------------------
			$subqueryHijos = "select idCuentaContable, idCuentaMayor, nombreCuenta, NroCuenta, idTipoCuenta, descripcion".
		" from cuentascontables where idCuentaMayor = '".$rowHijos["idCuentaContable"]."'";
		 
		$resultAuxsub = $conn->query($subqueryHijos);
		$subnumrowHijos = $resultAuxsub->num_rows ;
		if ($subnumrowHijos > 0){
			while ($rowHijossub = $resultAuxsub->fetch_assoc()) {
			$origen .= '<option value="'.$rowHijos["idCuentaContable"].'">'.$rowHijossub["NroCuenta"]."-".$rowHijossub["nombreCuenta"].
			'</option>';
			$inputsHidden .='<input type="hidden" value="'.$afectaciontmp.'" id="afCC_'.$rowHijossub["idCuentaContable"].'"/>';
		
		}
		$resultAuxsub->free();
}
			//-------------------
			
			
		
		}
		$resultAux->free();
}
	
}
$origen .= '</select>'.$inputsHidden.'<script>$("#cuentaOrigen").change(function(){
	$("#afectacionOrigen").val($("#afCC_"+$(this).val()).val());
})</script>';
}

$query2="SELECT * FROM  vw_relacionmodulos where tipoMovimiento ='D' and  modulo= '".$idmodulo."';";

$result = $conn->query($query2);
$numrow = $result->num_rows ;
if ($numrow > 0){
	$destino = '<input type="hidden" value="" id="afectacionDestino" name="afectacionDestino"/>'.
	'<select id="cuentaDestino" name="cuentaDestino" required> <option value="">SELECIONE CUENTA DESTINO</option>';
$inputsHidden='';
while ($row = $result->fetch_assoc()) {
	$destino .= '<option value="'.$row["cuentaCont"].'">'.$row["NroCuenta"]."-".$row["nombreCuenta"].	
	'</option>';
	$inputsHidden .= '<input type="hidden" value="'.$row["Afectacion"].'" id="afCC_'.$row["cuentaCont"].'" />';
	$queryHijos = "select idCuentaContable, idCuentaMayor, nombreCuenta, NroCuenta, idTipoCuenta, descripcion".
	" from cuentascontables where idCuentaMayor = '".$row["cuentaCont"]."'";
	$afectaciontmp = $row["Afectacion"];
	$resultAux = $conn->query($queryHijos);
	$numrowHijos = $resultAux->num_rows ;
	if ($numrowHijos > 0){
		while ($rowHijos = $resultAux->fetch_assoc()) {
			$destino .= '<option value="'.$rowHijos["idCuentaContable"].'">'.$rowHijos["NroCuenta"]."-".$rowHijos["nombreCuenta"].
			'</option>';
			$inputsHidden .='<input type="hidden" value="'.$afectaciontmp.'" id="afCC_'.$rowHijos["idCuentaContable"].'"/>';
			//	------------------
					$subqueryHijos = "select idCuentaContable, idCuentaMayor, nombreCuenta, NroCuenta, idTipoCuenta, descripcion".
						" from cuentascontables where idCuentaMayor = '".$rowHijos["idCuentaContable"]."'";
						
						$resultAuxsub = $conn->query($subqueryHijos);
						$subnumrowHijos = $resultAuxsub->num_rows ;
						if ($subnumrowHijos > 0){
							while ($rowHijossub = $resultAuxsub->fetch_assoc()) {
							$destino .= '<option value="'.$rowHijos["idCuentaContable"].'">'.$rowHijossub["NroCuenta"]."-".$rowHijossub["nombreCuenta"].
							'</option>';
							$inputsHidden .='<input type="hidden" value="'.$afectaciontmp.'" id="afCC_'.$rowHijossub["idCuentaContable"].'"/>';
						
						}
						$resultAuxsub->free();
				}
			//-------------------
		}
		$resultAux->free();
	}
}
$destino .= '</select>'.$inputsHidden .'<script>$("#cuentaDestino").change(function(){
	$("#afectacionDestino").val($("#afCC_"+$(this).val()).val());
})</script>';
}

$datos["datos"]=$data;
$result->free();
echo "
<script type='text/javascript'src='js/jquery.PrintArea.js'></script>
 <script>
function mostrarComprobante(elemento){
	
	$.ajax({
			url: 'php/printComprobante.php',
			type: 'POST',
			async: true,
			data: 'tipcomprobante='+elemento.data('tipcomprobante')+'&tabla='+elemento.data('tabla')+
				  '&columna='+elemento.data('columna')+ '&idmodulo='+elemento.data('idmodulo')+
                  '&numcomprobante='+elemento.data('numcomprobante'),
			dataType:'html',
			success: function(responseText){
			//alert(responseText);
			
 
			$('#modComprobante').html(responseText)
			$('#modComprobante').fadeIn( 'slow', function() {
    // Animation complete
	});
			$('#contenedor').css('display','none')
			 
			},
			error: function(){alert('nos se pudo')}
		}); 
}

 </script>";

}

function guardarTransacciones($valor = null,$cuentaOrigen = null,$afectacionOrigen  = null, $cuentaDestino = null, $afectacionDestino = null, $fecha  = null,$idmodulo,$nomModulo,$idRegustroMod){
	 global  $conn;
	 $stmt = $conn->stmt_init();
$afectacionOrigen = is_null($afectacionOrigen) ? 'C' : $afectacionOrigen;
	$valorOR = is_null($valor) ? '0' : $valor ;
	$valorDE = is_null($valor) ? '0' : $valor ;
   $afectacionDestino = is_null($afectacionDestino) ? 'D' : $afectacionDestino;
   $fecha = is_null($passdb) ? "CURDATE()" : "'".$fecha."'";
   $user =  $_SESSION["usuariodb"] ;
 $resultado = 'ok'; 

if (!is_null($cuentaOrigen )){
	
   if($afectacionOrigen =='D'){$valorOR = "'".$valor."' ,'0'";}else{$valorOR = "'0','".$valor."'";}
   
	$queryOrigen = "INSERT INTO `transacciones`".
	"(`id_cuentaContable`,".
	"`debito`,".
	"`credito`,".
	"`fecha`,".
	"`usuario`, ".
	"`usuarioEstado`,".
	"`fechaEstado`,".
	"`idModulo`,".
	"`idRegistroModulo`,".
	"`nombreModulo`,
	 `idSucursal`)".
	"VALUES".
	"( '".$cuentaOrigen."',".
	$valorOR.",".$fecha.",'".$user."','".$user."',curdate(),'".$idmodulo."','".$idRegustroMod ."','".
	$nomModulo."','".$_SESSION["id_suc"]."');"; 
	
if($resultado=='ok') {
	
$stmt->prepare($queryOrigen);
		if(!$stmt->execute()){ 
			$resultado='01' ;
		} 
}


}
if (!is_null($cuentaDestino )){
	   if($afectacionDestino =='D'){$valorDE = "'".$valor."' ,'0'";}else{$valorDE = "'0','".$valor."'";}
	$queryFin = "INSERT INTO  `transacciones`
( 
`id_cuentaContable`,
`debito`,
`credito`,
`fecha`,
`usuario`, 
`usuarioEstado`,
`fechaEstado`,
`idModulo`,
`idRegistroModulo`,
`nombreModulo`,
`idSucursal`)
VALUES
( '".$cuentaDestino."',".$valorDE.",".$fecha.",'".$user."','".$user."',curdate(),'".$idmodulo."','".$idRegustroMod ."','".
	$nomModulo."','".$_SESSION["id_suc"]."');";
	 
	if($resultado=='ok') {
	
$stmt->prepare($queryFin);
		if(!$stmt->execute()){ 
			$resultado='01' ;
		} 
}
}
if($resultado=='ok') {
 $query2="SELECT count(*) as totales ,sum(debito)as debitos,sum(credito)as creditos FROM transacciones where idRegistroModulo ='".$idRegustroMod ."';";
$debitos  = 0;
$creditos = 0;
$totales =  0;
$result = $conn->query($query2);
$numrow = $result->num_rows ;
if ($numrow > 0){
	while ($row = $result->fetch_assoc()) {
		$debitos  = $row['debitos'];
		$creditos =$row['creditos'];
		$totales = $row['totales'];
}
if ($debitos != $creditos ){
$resultado='02';}
}


}
 	
return $resultado;
}
function modificaCaracteres ($cadena){   
 $cadena = str_replace('ñ','&ntilde;',$cadena);    
 $cadena = str_replace('á','&aacute;',$cadena);    
 $cadena = str_replace('é','&eacute;',$cadena);    
 $cadena = str_replace('í','&iacute;',$cadena);    
 $cadena = str_replace('ó','&oacute;',$cadena);    
 $cadena = str_replace('ú','&uacute;',$cadena);    
 $cadena = str_replace('à','&agrave;',$cadena);    
 $cadena = str_replace('è','&egrave;',$cadena);    
 $cadena = str_replace('ì','&igrave;',$cadena);    
 $cadena = str_replace('ò','&ograve;',$cadena);    
 $cadena = str_replace('ù','&ugrave;',$cadena);   
 $cadena = str_replace('Ñ','&Ntilde;',$cadena);    
 $cadena = str_replace('Á','&Aacute;',$cadena);    
 $cadena = str_replace('É','&Eacute;',$cadena);    
 $cadena = str_replace('Í','&Iacute;',$cadena);    
 $cadena = str_replace('Ó','&Oacute;',$cadena);    
 $cadena = str_replace('Ú','&Uacute;',$cadena);    
 $cadena = str_replace('À','&Agrave;',$cadena);    
 $cadena = str_replace('È','&Egrave;',$cadena);    
 $cadena = str_replace('Ì','&Igrave;',$cadena);    
 $cadena = str_replace('Ò','&Ograve;',$cadena);    
 $cadena = str_replace('Ù','&Ugrave;',$cadena);        
 $cadena = str_replace('ä','&auml;',$cadena);    
 $cadena = str_replace('ë','&euml;',$cadena);    
 $cadena = str_replace('ï','&iuml;',$cadena);    
 $cadena = str_replace('ö','&ouml;',$cadena);    
 $cadena = str_replace('ü','&uuml;',$cadena);    
 $cadena = str_replace('Ä','&Auml;',$cadena);    
 $cadena = str_replace('Ë','&Euml;',$cadena);    
 $cadena = str_replace('Ï','&Iuml;',$cadena);
    $cadena = str_replace('Ö','&Ouml;',$cadena);
    $cadena = str_replace('Ü','&Uuml;',$cadena);    
    return $cadena;

}

function rellenarTruncar($dato,$tamanioCampo,$relleno,$ubicacion,$truncar){
	if((!isset($ubicacion) )or(trim($ubicacion)==''))
	{$ubicacion=I;}
	if((!isset($relleno)) or ($relleno==''))
	{$relleno= '0';}
	if(($relleno=='sP')or (trim($relleno)=='SP')or (trim($relleno)=='Sp')or (trim($relleno)=='sp'))
	{$relleno= '&nbsp;';
}
if($tamanioCampo>strlen($dato)){
	$tope = $tamanioCampo-strlen($dato);
$auxRelleno = '';
for($i=0; $i<$tope ; $i++)
{
	$auxRelleno = $auxRelleno.$relleno;
}
switch ($ubicacion) {
case "I":
	return $auxRelleno.$dato;
break;	
case "D":
	return $dato.$auxRelleno;
break;	
}}else{
	if ($truncar){return substr($dato, 0, $tamanioCampo);}else{
	return $dato;}}


}


function rellenar($dato,$tamanioCampo,$relleno = null,$ubicacion = null){
	if((!isset($ubicacion) )or(trim($ubicacion)==''))
	{$ubicacion=I;}
	if((!isset($relleno)) or ($relleno==''))
	{$relleno= '0';}
	if(($relleno=='sP')or (trim($relleno)=='SP')or (trim($relleno)=='Sp')or (trim($relleno)=='sp'))
	{$relleno= '&nbsp;';}
	if(($relleno=='pP')or (trim($relleno)=='PP')or (trim($relleno)=='Pp')or (trim($relleno)=='pp'))
	{$relleno= ' ';}

if($tamanioCampo>strlen($dato)){
	$tope = $tamanioCampo-strlen($dato);
$auxRelleno = '';
for($i=0; $i<$tope ; $i++)
{
	$auxRelleno = $auxRelleno.$relleno;
}
switch ($ubicacion) {
case "I":
	return $auxRelleno.$dato;
break;	
case "D":
	return $dato.$auxRelleno;
break;	
}}else{return $dato;}
}


function verificaSession_2($dir){ 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
     require_once $nomClass;
 });

new Core\Config(); 
	 if(!$dir){$dir='login.php';}
	 $auxDir =substr( $dir , 0 ,3 );
	//	 echo $auxDir;
	  $dir =  URL_BASE ."login/"; 
          
    if($_SESSION['access']==false)  
        { header("location: ".$dir);}
	else{
		if ($_SESSION["posicion"] == 's' ||$_SESSION["posicion"] == 'S'  ){
		include URL_BASE.'jds/php/inicioPoss.php';
		}
		obtenertVariables();
		}
date_default_timezone_set("America/Bogota"); 
}


function verificaSession_3($dir){ 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
     require_once $nomClass;
 });

new Core\Config(); 

                
              $dir =  URL_BASE ."login/"; 
    if($_SESSION['access']==false) 
        { header("location: ".$dir);}
	else{
		if ($_SESSION["posicion"] == 's' ||$_SESSION["posicion"] == 'S'  ){
		include URL_BASE .'jds/php/inicioPoss.php';
		}
		obtenertVariables();
		}
date_default_timezone_set("America/Bogota"); 
}


function session_sin_ubicacion($dir){
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
     require_once $nomClass;
 });

new Core\Config(); 	 
date_default_timezone_set("America/Bogota"); 
	 if(!$dir){$dir='login.php';}
	 $auxDir =substr( $dir , 0 ,3 );
	//	 echo $auxDir;
	if ($auxDir!='../') 
		{$auxDir='';}
	//echo 'esto es dir '.$auxDir;
                
              $dir =  URL_BASE ."login/";
    if($_SESSION['access']==false) 
        { header("location: ".$dir);}
	else{
		obtenertVariables();
		}
date_default_timezone_set("America/Bogota"); 
}
function cargaDatosUsuarioActual(){
        
    $usuario = new Class_php\Usuarios($_SESSION["ID"],$_SESSION["Login"],$_SESSION["Nombre1"],$_SESSION["Nombre2"],$_SESSION["Apellido1"],$_SESSION["Apellido2"],$_SESSION["nombreCompleto"] ,  $_SESSION["estado"],$_SESSION["pass"],$_SESSION["mail"], 0,$_SESSION["cod_remision"]);
        
    return $usuario;
}
function session_sin_ubicacion_2($dir){
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
     require_once $nomClass;
 });

new Core\Config(); 	 
date_default_timezone_set("America/Bogota"); 
	 if(!$dir){$dir='login.php';}
	 $auxDir =substr( $dir , 0 ,3 );
	//	 echo $auxDir;
	if ($auxDir!='../') 
		{$auxDir='';}
	//echo 'esto es dir '.$auxDir;
              $dir =  URL_BASE ."login/";
    if($_SESSION['access']==false) 
        { header("location: ".$dir);}
	else{
		obtenertVariables();
		}
date_default_timezone_set("America/Bogota"); 

}


function session_sin_ubicacion_3($dir){
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
     require_once $nomClass;
 });

new Core\Config(); 	 
date_default_timezone_set("America/Bogota"); 
	 if(!$dir){$dir='login.php';}
	 $auxDir =substr( $dir , 0 ,3 );
	//	 echo $auxDir;
	if ($auxDir!='../') 
		{$auxDir='';}
        
              $dir =  URL_BASE ."login/";
	//echo 'esto es dir '.$auxDir;
    if($_SESSION['access']==false) 
        { header("location: ".$dir);}
	else{
		obtenertVariables();
		}
date_default_timezone_set("America/Bogota"); 
}


function obtenertVariables(){
	}
function verificaNumeroDeIntervalos($numeroDatos,$numeroIntervalos,$mas)
{
$c=$numeroDatos/$numeroIntervalos;
$pos= strrpos($c,".");
//echo "num datos ".$numeroDatos." num intervalos ".$numeroIntervalos." y c   ".$c."</br> pos es igual a ".$pos."  ojo  ";
if ($pos === false) 
{return $c;}
else
{$p= substr($c,0,$pos);
if($mas){
$p++;}
return $p;}
}
function verificaSessionInventario_1($tipoUsuario){
    session_start();
    if($_SESSION['access']==false) 
        { header("location: ../login.php");} 
    else{if($_SESSION["usertype"]!=$tipoUsuario)
            {header("location: ../error.php");}
				else{
				include 'inicioPoss.php';obtenertVariables();}
    }
	date_default_timezone_set("America/Bogota"); 
}

function verificaSessionInventario_2($destino){
    session_start();
	if(!isset($destino)){$destino="location: ../login.php";}
	if($_SESSION['access']==false) 
        { header($destino);}
	else{
	include 'inicioPoss.php';obtenertVariables();}
	date_default_timezone_set("America/Bogota"); 
	date_default_timezone_set("America/Bogota"); 
}



function creaHidden(){
session_start();
echo'<input type="hidden" id="tipoUsuario"  value="'.$_SESSION["usertype"].'"/> <input type="hidden" id="IdUsuario" value="'.$_SESSION["idCiente"].'"/>';
include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT * FROM `usuarios` WHERE  `idCliente`='".$_SESSION["idCiente"]."'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
echo'<input type="hidden" id="tipoUsuario"  value="'.$_SESSION["usertype"].'"/> <input type="hidden" id="IdUsuario" value="'.$_SESSION["idCiente"].'"/><input type="hidden" id="nombreData" value="'.$row['nombre'].'"/><input type="hidden" id="apellidoData" value="'.$row['apellido'].'"/><input type="hidden" id="direccionData" value="'.$row['direccion'].'"/><input type="hidden" id="emailData" value="'.$row['email'].'"/><input type="hidden" id="telefonoData" value="'.$row['telefono'].'"/><input type="hidden" id="telefonoCelularData" value="'.$row['telefonoCelular'].'"/><input type="hidden" id="observacionesData" value="'.$row['observaciones'].'"/><input type="hidden" id="diferidoPorData" value="'.$row['diferidoPor'].'"/><input type="hidden" id="ciudadData" value="'.$row['ciudad'].'"/><input type="hidden" id="FechaNacimientoData" value="'.$row['FechaNacimiento'].'"/><input type="hidden" id="edadData" value="'.$row['edad'].'"/><input type="hidden" id="sexoData" value="'.$row['sexo'].'"/><input type="hidden" id="estCivilData" value="'.$row['estCivil'].'"/><input type="hidden" id="ocupacionData" value="'.$row['ocupacion'].'"/>';


$result->free();
$mysqli->close();
}
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS M-L.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO M-L. ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS M-L. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

// END FUNCTION
function amoneda($numero, $moneda = null)
{
 $moneda = is_null($moneda)? "pesos" : $moneda;
$longitud = strlen($numero);
$punto = substr($numero, -1,1);
$punto2 = substr($numero, 0,1);
$separador = ".";
if($punto == "."){
$numero = substr($numero, 0,$longitud-1);
$longitud = strlen($numero);
}
if($punto2 == "."){
$numero = "0".$numero;
$longitud = strlen($numero);
}
$num_entero = 0;
$num_entero = strpos ($numero, $separador);
$centavos = substr ($numero, ($num_entero));
                
$l_cent = strlen($centavos);
if($l_cent == 2){$centavos = $centavos."0";}
elseif($l_cent == 3){$centavos = $centavos;}
elseif($l_cent > 3){$centavos = substr($centavos, 0,3);}
$entero = substr($numero, -$longitud,$longitud-$l_cent);
if(!$num_entero){
	$num_entero = $longitud;
	$centavos = ".00";
	$entero = substr($numero, -$longitud,$longitud);
} 
$start = floor($num_entero/3);
$res = $num_entero-($start*3);
$final='';
if($res == 0){$coma = $start-1; $init = 0;}else{$coma = $start; $init = 3-$res;}

$d= $init; $i = 0; $c = $coma; 
$d=0;
	
         IF ($num_entero > 1){  
             $final = '';
             FOR ($i= $num_entero ;$i>=1;$i--){
                 $coma = '';
                 if ($d == 3){
                     $coma = ',';
                     $d = 0;
                 }
                 $d++; 
                 $aux_dato =  $entero[$i-1]; 
                 $final =  $aux_dato.$coma.$final;  
                 
             } 
                
         } else {
           $final =  $entero ;
        }
                
        /////////////////////
	if($moneda == "pesos")  {$moneda = "$";
	return $moneda." ".$final.$centavos;
	}
	elseif($moneda == "dolares"){$moneda = "USD";
	return $moneda." ".$final.$centavos;
	}
	elseif($moneda == "euros")  {$moneda = "EUR";
	return $final.$centavos." ".$moneda;
	}
}

                
$numero2 = 0;
if (count($_POST)>0){
$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);}// obtiene los valores de las varibles
if (count($_GET)>0){$numero2 = count($_GET);
$tags2 = array_keys($_GET); // obtiene los nombres de las varibles
$valores2 = array_values($_GET) ;}
// crea las variables y les asigna el valor
                
for($i=0;$i<$numero2;$i++){ 
$nombre_campo = $tags2[$i]; 
$valor = $valores2[$i];
                
if (is_array($valor))
{  $asignacion = "\$" . $nombre_campo . " =  array();";
 eval($asignacion);
 $$nombre_campo = $valor; 

}
else{$asignacion = "\$" . $nombre_campo . "= '" . $valor . "';";
   eval($asignacion);
   
}
//$$tags2[$i]=$valores2[$i]; 
}

function GENERAR_SELECT_DINAMICO($ID,$LABEL,$TABLA,$OPTION,$TEXT,ARRAY $opciones = null,$valor_inicial = null, array $WHERE = NULL ,  array $opcBusqueda = null ,  array $arr_data = null , array $array_text = null  ){ ?>
<?php
$valor_inicial = is_null($valor_inicial)? "" : $valor_inicial;
	$style = $clase = $name= "";
        if(!empty($opciones) ){
            if(isset($opciones['clase'])){$clase = trim($opciones['clase']);}
            if(isset($opciones['name'])){ $name = trim($opciones['name']);}
            
           
            if($name == ''){$name=$ID;}
            $css = $opciones['style'];
            if(!is_null($css) && sizeof($css) > 0)
            {$coma = '';
            $style = 'style = "';
                foreach ($css as $key_css => $value_css) {
                    $style .=  "$coma $key_css : $value_css";
                    $coma = ';';
                }
             $style .='"'; 
            }
                    
        }
        if (!is_null($opcBusqueda) && sizeof($opcBusqueda) > 0){
            
         $orderby = $opcBusqueda['orderby'] ;
         $groupby = $opcBusqueda['groupby'] ;
         if(trim($orderby)!= ''){$orderby = " order by ".$orderby;}
         if(trim($groupby)!= ''){$groupby = " group by ".$groupby; }
            
        }
?> 

<select  name="<?=$name;?>"  id="<?=$ID;?>" class="<?=$clase;?> form-control" <?=$style;?>>
  <option value='' >Selecciona <?=$LABEL;?></option>
<?php  

try { 
    $conexion =\Class_php\DataBase::getInstance();
    $link = $conexion->getLink();    
}
catch (PDOException $e) {
   echo 'Error de conexión: ' . $e->getMessage();
}
if (!is_null($WHERE) && sizeof($WHERE) > 0){
    $WHERE_FINAL = ' WHERE ';
    $AND = '';
  /* array([
        'COL' => 'id_seleccion',
        'VALOR'=>'0',
        'SIGNO'=>'>',
        'RELACION'=>''
             ])*/
    foreach ($WHERE as $keyW => $valueW) {  
        $WHERE_FINAL.=  " {$valueW['RELACION']} {$valueW['COL']} {$valueW['SIGNO']} {$valueW['VALOR']}";
                
    }
}else{
   
    $WHERE_FINAL  = '';
}
    $datos_sel = '*';
    $GROUP_BY = '';
    if (!is_null($arr_data) && sizeof($arr_data) > 0){
        $coma ='';
        $datos_sel = '';
            foreach ($arr_data as $key2 => $value2) {
                $datos_sel .= $coma.$value2;
               $coma = ',';
            }
        if($groupby){
             $GROUP_BY = 'GROUP BY '.$datos_sel;
        }
    }
    $consulta = $link->prepare("SELECT  $datos_sel FROM  {$TABLA} {$WHERE_FINAL} {$GROUP_BY}    {$orderby}  ");
//$datos['query'] = 'SELECT id_tipo  , nombre  FROM dbo.tipo_padre_elemento ';
    $consulta->execute();
    $registros = $consulta->fetchAll();
//  print_r($registros);
foreach ($registros as $key => $value) {
    $the_data = '';
    if (!is_null($arr_data) && sizeof($arr_data) > 0){
        foreach ($arr_data as $key2 => $value2) {
            $the_data.=" data-{$value2} = '{$value[$value2]}' ";
        }
    }
     $txt_texto = '';
       $signo = '';
    if (!is_null($array_text) &&   sizeof($array_text) > 0){
         $signo = '';
                
        foreach ($array_text as $llave => $valor_text) {
             $txt_texto.= "$signo{$value[$valor_text]}";
             $signo = '-';
        }
    }else{ 
        $txt_texto  = $value[$TEXT];
    }  
             $selected  = '';
        if ($valor_inicial != '' && $value[$OPTION] == $valor_inicial ){$selected  = 'selected';}
       ?>
        <option value='<?php echo $value[$OPTION] ;?>' <?php echo $selected; ?> <?php echo $the_data;?> ><?php echo $txt_texto ;?> </option> 
       <?php 
}
?>                                                 
</select> 
<?php     
} 

function hlp_arrayReemplazaAcentos_utf8_encode(&$array){
    $func = function(&$value,&$key){
        if(is_string($value)){
            $value = hlp_reemplazaAcentos(utf8_encode($value));
        } 
        if(is_string($key)){
            $key = utf8_encode($key);
        }
        if(is_array($value)){
            hlp_arrayReemplazaAcentos_utf8_encode($value);
        }
    };
    array_walk($array,$func);
    return $array;
}
//reemplazaAcentos($cadena)
function hlp_arrayReemplazaAcentos_utf8_decode(&$array){
    $func = function(&$value,&$key){
        if(is_string($value)){
            $value = hlp_reemplazaAcentos(utf8_decode($value));
        } 
        if(is_string($key)){
            $key = utf8_decode($key);
        }
        if(is_array($value)){
            hlp_arrayReemplazaAcentos_utf8_decode($value);
        }
    };
    array_walk($array,$func);
    return $array;
}
function hlp_utf8_string_array_decode(&$array){
    $func = function(&$value,&$key){
        if(is_string($value)){
            $value = utf8_decode($value);
        } 
        if(is_string($key)){
            $key = utf8_decode($key);
        }
        if(is_array($value)){
            hlp_utf8_string_array_decode($value);
        }
    };
    array_walk($array,$func);
    return $array;
}
function hlp_utf8_string_array_encode(&$array){
    $func = function(&$value,&$key){
        if(is_string($value)){
            $value = utf8_encode($value);
        } 
        if(is_string($key)){
            $key = utf8_encode($key);
        }
        if(is_array($value)){
            hlp_utf8_string_array_encode($value);
        }
    };
    array_walk($array,$func);
    return $array;
}

function hlp_reemplazaAcentos($cadena){
  $cadena =   str_replace('á','&aacute;',$cadena) ;
  $cadena =    str_replace('é','&eacute;',$cadena) ;
  $cadena =    str_replace('í','&iacute;',$cadena) ;
  $cadena =    str_replace('ó','&oacute;',$cadena) ;
  $cadena =    str_replace('ú','&uacute;',$cadena) ;
  $cadena =    str_replace('Á','&Aacute;',$cadena) ;
  $cadena =    str_replace('É','&Eacute;',$cadena) ;
  $cadena =    str_replace('Í','&Iacute;',$cadena) ;
  $cadena =    str_replace('Ó','&Oacute;',$cadena) ;
  $cadena =    str_replace('Ú','&Uacute;',$cadena) ;
  $cadena =    str_replace('ñ','&ntilde;',$cadena) ;
  $cadena =    str_replace('Ñ','&Ntilde;',$cadena) ;
    return $cadena;
}
?>
