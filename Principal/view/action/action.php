<?php
require_once '../../../php/helpers.php'; 
require_once '../../../php/mail_helper.php';

spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../../'. str_replace('\\','/',$nombre_clase ).'.php' ; 
    require_once $nomClass;
 });
new Core\Config(); 
if ($_SESSION['access']==false){ 
    header('Location: ../../');
}
$busquedaDinamica = null;  

// $json ='{"action":"APROBAR_ORDENES_DE_CARGUE","NO_O_CARGUE":"10257"}';
//  var_dump(json_decode($json, true));echo '<br>';
// $_POST = json_decode($json, true);        
$action = $_POST['action'];
$nomTableCabecera = $_POST['cabeceras'];  
if (isset($_POST['columnas'])){
    $cabeceras = obtenerNomCabeceraBusqueda($nomTableCabecera);
    $busquedaDinamica = true;
   
   switch ($_POST['concordancia']){
       case '0':
           $signo = '=';
           $ini=$fin = '';
           break;
       case '1':
           $signo = 'like';
            $ini=$fin = '%';
           break;
       case '3':
           $signo = 'like';
            $ini='%';
            $fin = '';
           break;
       case '2':
           $signo = 'like';
           $ini= '';
            $fin = '%';
           break;
   }
    if ($_POST['columnas'] == '*'){
         $where =' where';
         foreach ($cabeceras as $key => $value) {
             if ($key > 0)$where.= ' or ';
            $where.= " $value  $signo  '$ini{$_POST['item']}$fin'";
         }
        
    }
    else{
        $where = " where {$_POST['columnas']} $signo  '$ini{$_POST['item']}$fin'";
    }
}

switch ($action){
    //<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE USUARIOS - CAMBIO CLAVE...">
    case 'CAMBIAR_PASSWORD':
        $hash = sha1($_POST['passActual']);
        unset($_POST['passActual']);
        $usuario = Class_php\Usuarios::verificarLogin($_SESSION["usuario_logeado"],$hash);
        if ($usuario){
           $datos[':PASS_OLD'] = $hash;
             $hash = sha1($_POST['passNew']);             
             unset($_POST['passNew']); 
            $usuario = $usuario->setNewPass($hash) ;
            
            if ($usuario){ $datos['error']='ok';
                cargarVariablesSessionUsuario($usuario->getUserArray());
            }else{$datos['error']='No fue posible realizar el cambio de password!';}
        }
        else{
            $datos['error']='El password ingresado no pertenece al usuario logueado!';
        }
    break;
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE RFC ...">
    //CREACION DE NUEVA ORDEN DE CARGA
    CASE 'GUARDAR_ORDEN_DE_CARGA' :
    
          $userActual = cargaDatosUsuarioActual();  
    $tableInterior = $tableExterior = "";  
    $Ecof_ui_widget_content=' border: 1px solid #23282D;
    background: #fcfdfd  ;
    color: #505253;
    font-size: 10px';
    $ui_widget_content = '
    border: 1px solid #536675;
    background: #fcfdfd ;
    color: #505253;
     font-size: 10px';
    $mcv_ui_widget_content =' border: 1px solid #23282D;
    background: #fcfdfd ;
    color: #505253;
     font-size: 10px';
    $clase = trim($_SESSION["style"]).'_ui-widget-content';  
        try { 
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();  
       if ($_POST['id_transportador'] == 'otro'){
           $transportador = $_POST['otro_transportador'];
       }else{$transportador =$_POST['transportador'];}
              $consulta = $link->prepare("call  `sp_procesar_ordenes_de_carga`( '{$_SESSION["cod_remision"]}'".
                      ", '' ".
                      ",  '{$_POST['referencia_cliente']}' ,".
                      " '{$_POST['id_ciudad']}',".
                      " '{$_POST['ciudad_txt']}',".
                      " '{$_POST['ClientesAsignadosUsuario']}',".
                      " '{$_POST['nom_cliente']}' , ".
                      "'{$_POST['PLACA_VEHICULO']}' , ".
                      "'{$_POST['id_SAP_cedula_conductor']}', ".
                      "'{$_POST['cedula_conductor']}', ".
                      "'{$_POST['id_transportador']}' , ".
                      "'{$transportador}'  , ".
                      "'".normalize_date($_POST['fecha_de_cargue'],'-')."' , ".
                      "'{$_SESSION["ID"]}' , ''   , '' , ''  , 'INICIO' )");  
    
    $consulta->execute(); 
    
    
       $array =  $consulta->fetchAll() ;
       $resultado = $array[0]['result']; 
       if (is_numeric($resultado))
       {   $LINEAS_CARGUE = array();
           $LINEAS_CARGUE = $_POST['ARRAY_LINEAS'];
    
       
           foreach ($LINEAS_CARGUE as $key => $value_detalles) {
               $consulta = $link->prepare("CALL  `sp_procesar_detalle_ordenes_carga`(:_id_cabecera  , :_pedido, :_id_centro  , :_centro  , :_id_puesto_exp  , :_puesto_exp  , :_posicion  , :_id_material  , :_material  , :_cantidad  , :_cod_usuario_registro  );");
               $consulta->bindParam(':_id_cabecera',$resultado);
                $consulta->bindParam(':_pedido',$value_detalles['_pedido']);
                $consulta->bindParam(':_id_centro',$value_detalles['_id_centro']);
                $consulta->bindParam(':_centro',$value_detalles['_centro']);
                $consulta->bindParam(':_id_puesto_exp',$value_detalles['_id_puesto_exp']);
                $consulta->bindParam(':_puesto_exp',$value_detalles['_puesto_exp']);
                $consulta->bindParam(':_posicion',$value_detalles['_posicion']);
                $consulta->bindParam(':_id_material',$value_detalles['_id_material']);
                $consulta->bindParam(':_material',$value_detalles['_material']);
                $consulta->bindParam(':_cantidad',$value_detalles['_cantidad']);
                $consulta->bindParam(':_cod_usuario_registro',$_SESSION["ID"]);
                $consulta->execute(); 
                $array =  $consulta->fetchAll();
                $resultado_detalle = $array[0]['result'];
                if (!is_numeric($resultado_detalle)){
                    $datos['error'] = $resultado_detalle;
                    exit();
                }else{
                $datos['error'] = '';  
                
            $tableExterior .= "<tr>".
                    "<td style='{$$clase}'>{$value_detalles['_pedido']}</td>". 
                    "<td style='{$$clase}'>{$value_detalles['_centro']}</td>". 
                    "<td style='{$$clase}'>{$value_detalles['_puesto_exp']}</td>".
                    "<td style='{$$clase}'>{$value_detalles['_posicion']}</td>". 
                    "<td style='{$$clase}'>{$value_detalles['_material']}</td>".                            
                    "<td style='{$$clase}'>{$value_detalles['_cantidad']}</td>".
                    "<td style='{$$clase}'>TM</td>".
                    "</tr>";
            
            
            $tableInterior .= "<tr>".
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_pedido']}</td>". 
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_id_centro']}</td>".  
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_id_puesto_exp']}</td>".  
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_posicion']}</td>". 
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_id_material']}</td>". 
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_material']}</td>". 
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$value_detalles['_cantidad']}</td>". 
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >TM</td>". 
                    "</tr>";
                }
           }
           $datos['resultado_ingreso'] = $_SESSION["cod_remision"].$resultado;
           //////////////////////////////////////////////////////////////////////
           
           
           
    
        $cuerpoMailExterno = reemplazaAcentos(  mail_externo_cargue_pedido(trim($_SESSION["style"])));
        $cuerpoMailInterno = reemplazaAcentos(mail_interno_cargue_pedido());
       ///reemplazo de datos en el cuerpo del mail externo/////// 
        
         $cuerpoMailExterno =  str_replace ("%DESTINATARIO%",reemplazaAcentos($_POST['nom_cliente']),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%SOLICITUD_NUM%",$datos['resultado_ingreso'],$cuerpoMailExterno);	   
       $cuerpoMailExterno =  str_replace ("%FECHA_RECOGIDA%",$_POST['fecha_de_cargue'],$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%TRANSPORTADOR%",$transportador,$cuerpoMailExterno);	   
       $cuerpoMailExterno =  str_replace ("%PLACA%",$_POST['PLACA_VEHICULO'],$cuerpoMailExterno);	   
       $cuerpoMailExterno =  str_replace ("%CEDULA_CONDUCTOR%",$_POST['cedula_conductor'],$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%CEDULA_CONDUCTOR%",$_POST['cedula_conductor'],$cuerpoMailExterno);	   
       $cuerpoMailExterno =  str_replace ("%ELABORADO_POR%",reemplazaAcentos($userActual->getFullname()) ,$cuerpoMailExterno);	   
       $cuerpoMailExterno =  str_replace ("%LINEAS_MATERIALES%",$tableExterior,$cuerpoMailExterno);  
              
       ///reemplazo de datos en el cuerpo del mail interno///////       
        $cuerpoMailInterno =  str_replace ("%DESTINATARIO%",reemplazaAcentos($_POST['nom_cliente']),$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%SOLICITUD_NUM%",$datos['resultado_ingreso'],$cuerpoMailInterno);	   
       $cuerpoMailInterno =  str_replace ("%FECHA_RECOGIDA%",$_POST['fecha_de_cargue'],$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%TRANSPORTADOR%",$transportador,$cuerpoMailInterno);	   
       $cuerpoMailInterno =  str_replace ("%PLACA%",$_POST['PLACA_VEHICULO'],$cuerpoMailInterno);	   
       $cuerpoMailInterno =  str_replace ("%CEDULA_CONDUCTOR%",$_POST['cedula_conductor'],$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%CEDULA_CONDUCTOR%",$_POST['cedula_conductor'],$cuerpoMailInterno);	   
       $cuerpoMailInterno =  str_replace ("%ELABORADO_POR%",reemplazaAcentos($userActual->getFullname()) ,$cuerpoMailInterno);	   
       $cuerpoMailInterno =  str_replace ("%LINEAS_MATERIALES%",$tableInterior,$cuerpoMailInterno);  
//       $datos['cuerpoMailInterno'] = $cuerpoMailInterno;
//       $datos['cuerpoMailExterno']= $cuerpoMailExterno;
       
       $cuerpoMailInterno =  reemplazaAcentos( $cuerpoMailInterno );
       $cuerpoMailExterno= reemplazaAcentos( $cuerpoMailExterno );
       
         $para_interno = $_SESSION["mail"]   ;
         $para_externo = $_SESSION["mail"]   ;
         $titulo_externo = "Solicitud de orden de cargue {$datos['resultado_ingreso']} Portal Comercial";
         $titulo_interno = "Solicitud de orden de cargue {$datos['resultado_ingreso']}, destinatario ".reemplazaAcentos($_POST['nom_cliente']);
         
          if (PHP_OS == 'Linux') {
                    $breakLine = "\n";
                } else {
                    $breakLine = "\r\n";
                }
           
        $headers = "From: Portar de clientes <noresponder@monomeros.com.co>" . $breakLine;
                $headers .= "Reply-to: <noresponder@monomeros.com.co>\nContent-type: text/html" . $breakLine;
                
        $headers_externo = $headers_interno = $headers;
        //añadir el proceso para envia las copias...        
        //*
        //*
        //*
        //*
        //*
        //*
        //*
        //*
        //*
    
     $datos['error_mail']='';
      if (!mail($para_externo, $titulo_externo, $cuerpoMailExterno, $headers_externo))
       {$datos['error_mail'].='\n\rError al enviar el mail al cliente!!'   ;   }
       if ( !mail($para_interno, $titulo_interno, $cuerpoMailInterno, $headers_interno) )    
       {$datos['error_mail'].='\n\r Error al enviar el mail al encargado en Monomeros!!'   ;   }
           
           
           /////////////////////////////////////////////////////////////////////////
       }
       else
       { $datos['error'] = $resultado; }
      $conexion = null;
       } catch (PDOException $e) {
            $datos['error'] =  'Error de conexión: ' . $e->getMessage();
       }
       break;
        //INGRESO Y VERIFICACION DE CEDULA CONDUCTOR.
    case 'INGRESAR_NUEVO_CONDUCTOR':
        $NAME1 = $_POST['NAME1'];
        $ORT02 = $_POST['ORT02'];
        $TELF2 = $_POST['TELF2'];
        $STCD1 = $_POST['STCD1'];
       // /"NAME1"=>"jose dominguez","ORT02"=>"CO5002","LAND1"=>"CO","TELF2"=>"3017460499","STCD1"=>"84455110"  
       $array_respuesta =  ZMCV_RFC_CREAR_CTE($NAME1,$ORT02,$STCD1,$TELF2) ;    
          $datos['datos'] =   $array_respuesta;
            $datos['error'] =   '';
            $datos['filas'] = sizeof( $array_respuesta );      
        break;
    case 'VERIFICAR_CEDULA_CONDUCTOR':        
       $array_respuesta =  ZMCV_RFC_BUS_CONDUCTORES($_POST['cedulaConductor']);
          $datos['datos'] =   $array_respuesta;
            $datos['error'] =   '';
            $datos['filas'] = sizeof( $array_respuesta );      
        break;
    ///////////////////////////////////////////////
    //INGRESO Y VERIFICACION DE PLACAS DE VEHICULOS.
    case 'INGRESAR_NUEVA_PLACA_VEHICULO':
        $MATNR = $_POST['MATNR'];
        $MAKTX = $_POST['MAKTX'];
        $ZZPESOMAX = $_POST['ZZPESOMAX'];
        $BRGEW = $_POST['BRGEW'];
        $array_respuesta =  ZMCV_RFC_CREAR_VEHICULO($MATNR,$MAKTX,$ZZPESOMAX,$BRGEW) ; 
        $datos['datos'] =   $array_respuesta;
        $datos['error'] =   '';
        $datos['filas'] = sizeof( $array_respuesta );      
        break;    
    case 'VERIFICAR_PLACA_VEHICULO':
        
       $array_respuesta =  ZMCV_RFC_MATERIALES_VEHICULOS($_POST['PLACA_VEHICULO']);
          $datos['datos'] =   $array_respuesta;
            $datos['error'] =   '';
            $datos['filas'] = sizeof( $array_respuesta );      
        break;
    case 'LISTAR_ZMCV_RFC_CONSULTA_PEDIDO':        
        $arreglo = array(); 
        $ORDEN = trim($_POST['VBELN']);
        
        $relleno = "";
        if (strlen($ORDEN)< 10){
            $final = 10 - strlen($ORDEN) ;
            for ($i=0 ; $i< $final;$i++){$relleno .= '0';} 
            $ORDEN = $relleno.$ORDEN ;//0000253855
            }
            
        header('Content-Type: text/html; charset=ISO-8859-1');
        $arreglo = array()     ;                 
        $arreglo = ZMCV_RFC_CONSULTA_PEDIDO( $ORDEN   ) ; 
        if (!is_null($arreglo)&& sizeof($arreglo) > 0 && $arreglo['rows'] >0 ){
            $RESPONSABLE = $arreglo['RESPONSABLE'];
            $userActual = cargaDatosUsuarioActual();  
           // getNombreAmacen();
            $arrayClientesUsuario = $userActual->buscarClienteUsuario($RESPONSABLE);
        
            $arreglo['NOM_SOLICITANTE'] = $arrayClientesUsuario['nombre_cliente_SAP'];//Responsable -> buscar nombre en los permisos y validar si se tiene permiso a ese cliente
            $ZTERM= ZMCV_RFC_BUSCAR_FORMAS_PAGO($arreglo['ZTERM'] );//SE DEBE CREAR EL LLAMADO A LA RFC
            $arreglo['NOM_FORM_PAGO'] =  reemplazaAcentos(utf8_encode( $ZTERM['VTEXT']));
            $arreglo['CHECK_DESCUENTO']='0';
            $arreglo['CHECK_SEGURO']='0'; 
            $arreglo['CHECK_FLETE']='0'; 
            foreach ($arreglo['ZTBCABPED'] as $key => $value) {
                IF ($value['WAERK'] == 'COP'){//ntval(str_replace('.', '', $value['SALDO']));
                    $value['NETWR'] = str_replace('.', '',$value['NETWR'] ) ;
                }     
                 $value['NETWR_M'] = amoneda($value['NETWR'],'pesos');
                $arreglo['ZTBCABPED'] = $value;
            }
            foreach ($arreglo['ZTBPOSPED'] as $key => $value) {
                
                $centroDelSistema = getCentrosDelSistema($value['WERKS']);
                $value['NOMBRE_CENTRO']=reemplazaAcentos(utf8_encode($centroDelSistema[0]['NAME1']));
                $_PUNTO_EXPEDICION  = getPuntoDeExpedicion( $value['VSTEL']);
                $value['MATNR'] = intval($value['MATNR']);
                $value['PUNTO_EXPEDICION'] =$_PUNTO_EXPEDICION['VTEXT'];
                
                IF(( $value['VBELN'] >= "0070000000" && $value['VBELN'] <= "0074999999")||  ( $value['VBELN'] >= "0060000000" && $value['VBELN'] <= "0064999999"))
                {  $value['CANT_PEDIDO'] = $value['ZMENG'];
                    If  ($value['DLV_QTY'] >  $value['ZMENG'])
                        $value['CANT_ENTRADA']  = $value['ZMENG'];
                    Else
                        $value['CANT_ENTRADA']  = $value['DLV_QTY'];////////////////
                    $value['SALDO'] = "0.00";
                    If ($value['ABGRU'] == "" ){
                        $saldo =  $value['CANT_PEDIDO']- $value['CANT_ENTRADA'] ;
                       $value['SALDO'] = $saldo; // df(7) = $saldo;
                    }
                    }
                ELSE
                {   $value['CANT_PEDIDO'] = $value['KWMENG'];
                    If ($value['DLV_QTY'] >  $value['KWMENG'])//.Dlv_Qty > .Kwmeng Then
                       $value['CANT_ENTRADA'] =  $value['KWMENG'] ;//=  df(6) = decimales(.Kwmeng)
                    Else
                        $value['CANT_ENTRADA'] =  $value['DLV_QTY']; //=  df(6) = decimales(.Dlv_Qty)  

                    $value['SALDO'] = "0";
                    If ($value['ABGRU'] == "" ){
                        $saldo =  $value['CANT_PEDIDO']- $value['CANT_ENTRADA'] ;
                       $value['SALDO'] = $saldo; // df(7) = $saldo;
                    }
                }
                
                //$value['SALDO_M'] = amoneda($value['SALDO'],'pesos');
                $cant = intval($value['CANT_ENTRADA']);
                If ($cant == 0 )
                    $cant = 1;
                $value['PREC_UNITARIO'] = '0.00';                
                $PRECIO_UNITARIO = 0;
                $DESCUENTO = 0;
                $SEGURO = 0;
                $FLETE = 0;
                foreach ($arreglo['ZMCV_KONV'] as $newkey => $value_KONV) {                    
                    IF ($value_KONV['KPOSN'] == $value['POSNR']){
                        $KWERT = $value_KONV['KWERT'];
                        $pos = strpos($KWERT, '-');
                        if ($pos !== false){
                               $KWERT = str_replace('-', '', $KWERT);
                               $KWERT = floatval($KWERT) * -1;
                               }else{
                               $KWERT = floatval($KWERT);}                               
                    IF (in_array( $value_KONV['KSCHL'],array('Z001' ,'Z003' ,'ZCAN' ,'ZCOM' ,'ZPRO' ,'Z0V1' ,'Z0P1' ,'ZDBC' ,'ZNEG' ,'ZNEV' ,'Z007' ,'Z004' ,'Z012' ,'Z016')))
                        {$PRECIO_UNITARIO += $KWERT;}                        
                    IF (in_array( $value_KONV['KSCHL'],array('ZPDF' )))//DESCUENTO   
                        {$DESCUENTO += $KWERT;  } 
                    IF (in_array( $value_KONV['KSCHL'],array('Z008' ,'ZFM8' ,'Z006' ,'Z011' ))) //FLETE
                        {$FLETE += $KWERT;}
                    IF (in_array( $value_KONV['KSCHL'],array('Z012' , 'Z016' ))) //SEGURO
                        {$SEGURO += $KWERT;}
                    }                    
                } //fin del for
                $value['DESCUENTO'] = $DESCUENTO;
                $value['PREC_UNITARIO'] = $PRECIO_UNITARIO;
                $value['SEGURO'] = $SEGURO; 
                $value['FLETE'] = $FLETE; 
                $value['DESCUENTO_M'] = amoneda($DESCUENTO,'pesos');
                $value['PREC_UNITARIO_M'] = amoneda($PRECIO_UNITARIO,'pesos');
                $value['SEGURO_M'] = amoneda($SEGURO,'pesos');
                $value['FLETE_M'] = amoneda($FLETE,'pesos');
                
                if ($DESCUENTO != 0){ $arreglo['CHECK_DESCUENTO']=1;}
                if ($SEGURO != 0){ $arreglo['CHECK_SEGURO']=1;}
                if ($FLETE != 0){ $arreglo['CHECK_FLETE']=1;}
                $arreglo['ZTBPOSPED'][$key]=$value;
              }
              $datos['datos'] =   $arreglo;
            $datos['error'] =   '';
            $datos['filas'] =   $arreglo['rows'];         
         }else{
             $datos['datos'] =   null;
            $datos['error'] =   '';
            $datos['filas'] =   0;
         }                
     break;
     
     
     
     
     
    case 'LISTAR_ZMCV_RFC_CONSULTA_FACTURA':        
        $arreglo = array(); 
        $ORDEN = $_POST['VBELN'];
        
        $relleno = "";
        if (strlen($ORDEN)< 10){
            $final = 10 - strlen($ORDEN) ;
            for ($i=0 ; $i< $final;$i++){$relleno .= '0';}
            $ORDEN = $relleno.$ORDEN ;//0000253855
            }
        $datos['orden_enviada'] = $ORDEN;
        header('Content-Type: text/html; charset=ISO-8859-1');
        $arreglo = array()     ;                 
        $arreglo = ZMCV_RFC_CONSULTA_FACTURA( $ORDEN   ) ; 
        $RESPONSABLE = $arreglo['RESPONSABLE'];
        $userActual = cargaDatosUsuarioActual();   
        if (!is_null($arreglo)|| sizeof($arreglo) > 0 ){
            $WAERK = "";
            foreach ($arreglo['ZTBCABFACT'] as $key => $value) {
                 $arrNOM_FORM_PAGO = ZMCV_RFC_BUSCAR_FORMAS_PAGO($value['ZTERM'] );
                 $value['NOM_FORM_PAGO'] = reemplazaAcentos(utf8_encode( $arrNOM_FORM_PAGO['VTEXT']));
                 $arrayClientesUsuario = $userActual->buscarClienteUsuario($value['KUNRG']);
                 $value['NOM_RESPONSABLE_PAGO'] = $arrayClientesUsuario['nombre_cliente_SAP'];//Responsable -> buscar nombre en los permisos y validar si se tiene permiso a ese cliente
    
                 $arreglo['ZTBCABFACT'][$key]=$value;
                 $WAERK = $value['WAERK'] ;
                 
             }
            $NETWR= 0;
            foreach ($arreglo['ZTBPOSFACT'] as $key => $value) {    
                //$value['NOMBRE_CENTRO']=reemplazaAcentos(utf8_encode($centroDelSistema[0]['NAME1']));
                //$_PUNTO_EXPEDICION  = getPuntoDeExpedicion( $value['VSTEL']);
                
                $value['ARKTX']=reemplazaAcentos(utf8_encode($value['ARKTX']));//DENOMINACION
                $value['MATNR'] = intval($value['MATNR']); 
                $value['PREC_UNITARIO'] = '0.00';                
                $PRECIO_UNITARIO = 0;
                $DESCUENTO = 0;
                $SEGURO = 0;
                $FLETE = 0;
                $IMPUESTO = 0;
                $FINANCIACION=0;
                foreach ($arreglo['ZMCV_KONV'] as $newkey => $value_KONV) {                    
                    IF ($value_KONV['KPOSN'] == $value['POSNR']){
                        $KWERT = $value_KONV['KWERT'];
                        $pos = strpos($KWERT, '-');
                        if ($pos !== false){
                               $KWERT = str_replace('-', '', $KWERT);
                               $KWERT = floatval($KWERT) * -1;
                               }else{
                               $KWERT = floatval($KWERT);}  
                               
                    IF (in_array( $value_KONV['KSCHL'],array( 'Z013' )))
                        {$FINANCIACION += $KWERT;}  
                    IF (in_array( $value_KONV['KSCHL'],array('Z001' ,'Z003' ,'ZCAN' ,'ZCOM' ,'ZPRO' ,'Z0V1' ,'Z0P1' ,'ZDBC' ,'ZNEG' ,'ZNEV' ,'Z007' ,'Z004' ,'Z012' ,'Z016')))
                        {$PRECIO_UNITARIO += $KWERT;}                        
                    IF (in_array( $value_KONV['KSCHL'],array('ZPDF' )))//DESCUENTO   
                        {$DESCUENTO += $KWERT;  } 
                    IF (in_array( $value_KONV['KSCHL'],array('Z008' ,'ZFM8' ,'Z006' ,'Z011' ))) //FLETE
                        {$FLETE += $KWERT;}
                    IF (in_array( $value_KONV['KSCHL'],array('Z012' , 'Z016' ))) //SEGURO
                        {$SEGURO += $KWERT;}
                    IF (in_array( $value_KONV['KSCHL'],array('MWST' ))) //SEGURO
                        {$IMPUESTO += $KWERT;}
                    }  
                } 
                $NETWR += $value['NETWR'] ;//TOTAL FACTURA
                IF ($WAERK == 'COP'){
                    $DESCUENTO =   str_replace('.', '', $DESCUENTO) ;
                    $PRECIO_UNITARIO=   str_replace('.', '', $PRECIO_UNITARIO) ;
                    $FLETE=   str_replace('.', '', $FLETE) ;
                    $SEGURO=   str_replace('.', '', $SEGURO) ;
                    $NETWR = str_replace('.', '', $NETWR) ;
                    $DESCUENTO *=100;
                    $PRECIO_UNITARIO*=100;
                    $FLETE*=100;
                    $SEGURO*=100;
                    $NETWR*=100; 
                     $value['KZWI1'] = str_replace('.', '', $value['KZWI1']) ;
                     //$value['KZWI1']*=100; 
                }
                $value['DESCUENTO'] = $DESCUENTO;
                $value['PREC_UNITARIO'] = $PRECIO_UNITARIO; 
                $value['FLETE_y_SEGURO'] = $FLETE+$SEGURO; 
                $value['IMPUESTO'] = $IMPUESTO ; 
                $value['FINANCIACION'] = $FINANCIACION;
                
                ///////////////////////////////////////////////////////
    
                $value['KZWI1_M']= amoneda($value['KZWI1'], 'pesos');
                $value['DESCUENTO_M'] = amoneda($DESCUENTO, 'pesos');
                $value['PREC_UNITARIO_M'] = amoneda($PRECIO_UNITARIO, 'pesos');  
                 $value['FLETE_y_SEGURO_M'] = amoneda($value['FLETE_y_SEGURO_M'], 'pesos')  ; 
                $value['IMPUESTO_M'] = amoneda($IMPUESTO, 'pesos')  ; 
                $value['FINANCIACION_M'] = amoneda($FINANCIACION, 'pesos') ;
                
                if ($DESCUENTO != 0){ $arreglo['CHECK_DESCUENTO']=1;}
                if ($SEGURO != 0){ $arreglo['CHECK_SEGURO']=1;}
                if ($value['FLETE_y_SEGURO'] != 0){ $arreglo['CHECK_FLETE']=1;}      
                $arreglo['ZTBPOSFACT'][$key]=$value;
              }
    
            $arreglo['NETWR'] =  $NETWR;
            $datos['datos'] =   $arreglo;
            $datos['error'] =   '';
            $datos['filas'] =   $arreglo['NUM_ZTBCABFACT'];         
         }else{
             $datos['datos'] =   null;
            $datos['error'] =   '';
            $datos['filas'] =   0;
         }                
     break;
    case 'LISTAR_ZMCV_RFC_MATERIALENTREGA':  
        $arreglo = array(); 
         $ORDEN = $_POST['VBELN'];
           header('Content-Type: text/html; charset=ISO-8859-1');
                 $arreglo = array()     ;                 
                $arreglo = ZMCV_RFC_MATERIALENTREGA( $ORDEN   ) ;
            if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arreglo = array();
        } 
        $arregloAux = array();
        $userActual = cargaDatosUsuarioActual();  
        $arrayClientesUsuario = $userActual->getClientesUsuario();
       // SELECT distinct  VKORG FROM clientes.relacion_usuario_area_venta WHERE cod_usuario = '4'; ID
        try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
            $consulta = $link->prepare("SELECT distinct  VKORG FROM clientes.relacion_usuario_area_venta WHERE cod_usuario = '{$userActual->getId()}' ");
            $datos['query'] = "SELECT distinct  VKORG FROM clientes.relacion_usuario_area_venta WHERE cod_usuario = '{$userActual->getId()}'";
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ; 
            $COUNT = 0;
            if($datos['filas'] > 0){ 
                foreach ($registros as $key => $value) {
                    $arrayVKORG[$COUNT] = $value['VKORG'];
                    $COUNT++;
                }}
    
        } catch (PDOException $e) {
              $datos['error'] =  'Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;                  
               exit();
        } 
          foreach ( $arreglo as $key => $value) {
              /* MANDT	VBELN	POSNR	SPRAS	VKORG	ZUKRL	KUNNR	MATNR	MAKTX */
               if (in_array($value['VKORG'],$arrayVKORG )  && in_array($value['KUNNR'],$arrayClientesUsuario ) ){
               //echo "entro CHARG : {$value['CHARG']}<br>";
                    $value['VBELN']= intval($value['VBELN']);
                    $value['MATNR']= intval($value['MATNR']);     
                    $value['MAKTX']=reemplazaAcentos(utf8_encode( $value['MAKTX'])); 
                    $arregloAux[$key]=$value;
                }  
            }  
            $arreglo = $arregloAux;
           if (is_null($arregloAux)|| sizeof($arregloAux) == 0 )
               $arreglo = array();
            
    
        $datos['datos']=$arreglo;
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
       
        
        
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'LISTAR_ZMCV_RFC_CONSULTA_DESPACHOS':  
        $arreglo = array(); 
         $FECHA_FIN =normalize_date_rfc($_POST['fechaFinal'],'');
         $FECHA_INI=normalize_date_rfc($_POST['fechaInicial'],'');
    
         $ORDEN =$_POST['ordenEntrega'] ;
         $REMISION=$_POST['pedidoVenta'] ; 
           header('Content-Type: text/html; charset=ISO-8859-1');
           $LGORT =  $centro = $material = $cliente  = null ;
            if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] !='%')
                {     $cliente = $_POST['ClientesAsignadosUsuario'] ;}
            if(isset($_POST['MaterialesAsignadosUsuario']) && $_POST['MaterialesAsignadosUsuario'] !='%')
                {     $material = $_POST['MaterialesAsignadosUsuario'] ;}
            if(isset($_POST['CentosLogAsignadosUsuario']) && $_POST['CentosLogAsignadosUsuario'] !='%')
                {     $centro = $_POST['CentosLogAsignadosUsuario'] ;} 
            if(isset($_POST['AlmacenesAsignadosUsuario']) && $_POST['AlmacenesAsignadosUsuario'] !='%')   {
                     $LGORT  = $_POST['AlmacenesAsignadosUsuario'];
            }  
            
                 $arreglo = array()     ;                 
                $arreglo = ZMCV_RFC_CONSULTA_DESPACHOS($FECHA_FIN,$FECHA_INI,$centro,$LGORT , $material ,$ORDEN  ,$REMISION  ) ;
            if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arreglo = array();
        } 
        $arregloAux = array();
                     header('Content-Type: text/html; charset=ISO-8859-1');
          foreach ( $arreglo as $key => $value) {
              
              if ( $value['CHARG'] != "" && $value['LFART'] != "ZE05"){
               //echo "entro CHARG : {$value['CHARG']}<br>";
                $value['VBELN']= intval($value['VBELN']);
                 $value['MATNR']= intval($value['MATNR']);              
                 IF ($value['VRKME']=='ST')
                            $value['VRKME'] = 'UN';
                                  $value['ARKTX']=reemplazaAcentos(utf8_encode( $value['ARKTX']));
                 $value['NAME1_O']=reemplazaAcentos(utf8_encode( $value['NAME1_O']));
                  $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1']));
                 $value['LGOBE_O']=reemplazaAcentos(utf8_encode( $value['LGOBE_O']));
                 $value['VTEXT']=reemplazaAcentos(utf8_encode( $value['VTEXT']));
                $arregloAux[$key]=$value;
          }  
            }
            $arreglo = $arregloAux;
           if (is_null($arregloAux)|| sizeof($arregloAux) == 0 )
               $arreglo = array();
        
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}  
           
        
        
        $userActual = cargaDatosUsuarioActual();  
    if(isset($_POST['CentosLogAsignadosUsuario']) && $_POST['CentosLogAsignadosUsuario'] =='%')
           {   $arrayCentro = $userActual->getArrayCentosLog();     }   

    if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] =='%')
           {   $arrayCliente  = $userActual->getClientesUsuario();  }
        else{         $arrayCliente[0]=$_POST['ClientesAsignadosUsuario'];     }
     
    if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arregloFinal = array();
        } else{
        $arregloFinal = FILTRAR_DATOS_RFC_CONSULTA_DESPACHOS($arreglo , $arrayCliente, $arrayCentro, $LGORT);
      
        foreach ( $arregloFinal as $key => $value) {  
                 $value['VBELN']= intval($value['VBELN']);
                 $value['MATNR']= intval($value['MATNR']);                 
                 IF ($value['VRKME']=='ST')
                            $value['VRKME'] = 'UN';
                 $arregloFinal[$key]=$value;                
        }}
            $datos['datos']=$arregloFinal;
        
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
       
        
        
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'LISTAR_ZMCV_RFC_FACTURA_CTE2':  
        $arreglo = array(); 
         $FECHA_FIN =normalize_date_rfc($_POST['fechaFinal_fsn'],'');
         $FECHA_INI=normalize_date_rfc($_POST['fechaInicial_fsn'],''); 
         
           header('Content-Type: text/html; charset=ISO-8859-1');
           $VKORG =  $KUNNR  = $cliente  = null ;
           //KUNNR
            if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] !='%')
                {   //  $cliente = $_POST['ClientesAsignadosUsuario'] ;
                     $KUNNR= $_POST['ClientesAsignadosUsuario'] ;
                }
             if(isset($_POST['organizacion']) && $_POST['organizacion'] !='')
                {   //  $cliente = $_POST['ClientesAsignadosUsuario'] ;
                     $VKORG= $_POST['organizacion'] ;
                } 
                 $arreglo = array()     ;                 
                $arreglo = ZMCV_RFC_FACTURA_CTE2($FECHA_FIN,$FECHA_INI,null,$KUNNR,$VKORG  ) ;
    
            if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arreglo = array();
        } 
        $arregloAux = array(); 
                     
          foreach ( $arreglo as $key => $value) {
              
    
                $value['AUBEL']= intval($value['AUBEL']);            
                   $value['KWERT_M']= amoneda($value['KWERT'], 'pesos');
                  $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1'])); 
                $arreglo[$key]=$value;
    
            }
    
        
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}  
           
        
        
        $userActual = cargaDatosUsuarioActual();  
    if(isset($_POST['organizacion']) && $_POST['organizacion'] =='')
           {   $arrayOrganizacion = $userActual->getOrganizacion();     }   else{
               $arrayOrganizacion[0]=$_POST['organizacion'];
           }

    if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] =='%')
           {   $arrayCliente  = $userActual->getClientesUsuario();  }
        else{         $arrayCliente[0]=$_POST['ClientesAsignadosUsuario'];     }
     if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arregloFinal = array();
        } else{
         $arregloFinal = FILTRAR_DATOS_RFC_FACTURA_CTE2($arreglo , $arrayCliente, $arrayOrganizacion);
       }
        
        $datos['datos']=$arregloFinal;
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
       
        
        
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'LISTAR_ZMCV_RFC_PEDIDOS_FACTURAS':  
        $arreglo = array(); 
         $FECHA_FIN =normalize_date_rfc($_POST['fechaFinal'],'');
         $FECHA_INI=normalize_date_rfc($_POST['fechaInicial'],'');
        $TPEDIDO = $_POST['tipoDePedido'] ;
           header('Content-Type: text/html; charset=ISO-8859-1');
          $KUNWE =  $AUART = $VKORG = $LGORT =  $centro = $material = $cliente  = null ;
            IF (isset($_POST['selectORG']) && $_POST['selectORG'] != ''){ $VKORG = $_POST['selectORG'];}          
            if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] !='%')
                {     $cliente = $_POST['ClientesAsignadosUsuario'] ;}
            if(isset($_POST['MaterialesAsignadosUsuario']) && $_POST['MaterialesAsignadosUsuario'] !='%')
                {     $material = $_POST['MaterialesAsignadosUsuario'] ;}
            if(isset($_POST['CentosLogAsignadosUsuario']) && $_POST['CentosLogAsignadosUsuario'] !='%')
                {     $centro = $_POST['CentosLogAsignadosUsuario'] ;} 
            if(isset($_POST['AlmacenesAsignadosUsuario']) && $_POST['AlmacenesAsignadosUsuario'] !='%')   {
                     $LGORT  = $_POST['AlmacenesAsignadosUsuario'];
            }            
            $arreglo = array()     ;  
            $arreglo =  ZMCV_RFC_PEDIDOS_FACTURAS2(
                                $AUART,//tipo pedido no se envia 
                                $FECHA_FIN  ,//fecha fin
                                $FECHA_INI ,//fecha inicio 
                                $cliente,  //$KUNNR  ,//cliente
                                $KUNWE  ,//solicitante
                                $LGORT ,//almacen
                                $material ,//material
                                $TPEDIDO,//tipo pedido
                                $VKORG ,//organizacion
                                $centro//$WERKS //centro
                                ); 
                if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arreglo = array();
        }         
        $arregloAux = array();
        header('Content-Type: text/html; charset=ISO-8859-1');
        $cont = 0; 
        $cont_ARREGLO = 0; 
      foreach ( $arreglo as $key => $value) { 
        $value['NAMEWERKS']=reemplazaAcentos(utf8_encode( $value['NAMEWERKS']));
        $value['NAME1_WE']=reemplazaAcentos(utf8_encode( $value['NAME1_WE']));
        $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1']));
        $value['BSTNK']=reemplazaAcentos(utf8_encode( $value['BSTNK'])); 
        $value['NAMELGORT']=reemplazaAcentos(utf8_encode( $value['NAMELGORT']));
        $value['MAKTX']=reemplazaAcentos(utf8_encode( $value['MAKTX']));
        $value['BEZEI']=reemplazaAcentos(utf8_encode( $value['BEZEI'])); 
        $value['VTEXTCMGST']=reemplazaAcentos(utf8_encode( $value['VTEXTCMGST']));  
        
        $value['NETWR_M']= amoneda($value['NETWR'],'pesos');
        
        
        if((isset($_POST['SALDOS_POR_DESPACHAR'])&& $_POST['SALDOS_POR_DESPACHAR'] == 'SI' )
                || (isset($_POST['SALDOS_POR_FACTURAR'])&&$_POST['SALDOS_POR_FACTURAR'] == 'SI' )
                || (isset($_POST['NO_APROBADOS'])&& $_POST['NO_APROBADOS'] == 'SI'  ))
            {//si fueron enviados al php
                $saldo  = intval(str_replace('.', '', $value['SALDO']));
                $facturado =intval(str_replace('.', '',  $value['FACTU'])); 
                $ordenado = intval(str_replace('.', '', $value['KWMENG']));
                $sEstado = trim(strtoupper($value['VTEXTCMGST']));
                $sMotivo = trim(strtoupper($value['BEZEI']));
                
            if ($_POST['SALDOS_POR_DESPACHAR']=== 'SI' && $_POST['SALDOS_POR_FACTURAR'] === 'SI' && $_POST['NO_APROBADOS']=== 'SI')
              { 
                 if($saldo > 0 && $facturado < $ordenado && $sEstado  == "NO APROBADO" &&  $sMotivo == "" )
                { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}
             }
              elseif($_POST['SALDOS_POR_DESPACHAR'] === 'SI' && $_POST['SALDOS_POR_FACTURAR'] === 'SI'  &&  $_POST['NO_APROBADOS']=== 'NO'){
                 if($saldo > 0 && $facturado < $ordenado && $sMotivo == "" )// If saldo > 0 And facturado < ordenado And sEstado.ToUpper = "NO APROBADO" And sMotivo = "" Then
                { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}
              } elseif($_POST['SALDOS_POR_DESPACHAR']=== 'SI' &&  $_POST['SALDOS_POR_FACTURAR'] === 'NO' && $_POST['NO_APROBADOS']=== 'SI'){
                  if($saldo > 0 && trim($sEstado)  == "NO APROBADO" && $sMotivo == "")
                    { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}
              } elseif( $_POST['SALDOS_POR_DESPACHAR']=== 'NO' && $_POST['SALDOS_POR_FACTURAR'] === 'SI' && $_POST['NO_APROBADOS']=== 'SI'){
                  if($facturado < $ordenado && trim($sEstado)  == "NO APROBADO" && $sMotivo == "")
                    { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}                      
              } elseif($_POST['SALDOS_POR_DESPACHAR']=== 'SI' &&  $_POST['SALDOS_POR_FACTURAR'] === 'NO' && $_POST['NO_APROBADOS']=== 'NO'){
                  if($saldo > 0 && $sMotivo == "" )
                     { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}
              } elseif( $_POST['SALDOS_POR_DESPACHAR']=== 'NO' && $_POST['SALDOS_POR_FACTURAR'] === 'SI' &&  $_POST['NO_APROBADOS']=== 'NO' ){
                  if($facturado < $ordenado && $sMotivo == "" )
                    { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}
              } elseif(!$_POST['SALDOS_POR_DESPACHAR']=== 'NO' && $_POST['SALDOS_POR_FACTURAR'] === 'NO' && $_POST['NO_APROBADOS']=== 'SI'){
                  if(trim($sEstado) == "NO APROBADO" && $sMotivo == "")
                    { $arregloAux[$cont_ARREGLO]=$value;$cont_ARREGLO ++;}
              }               
           }
           else{  $arregloAux[$cont]=$value;
           $cont++;
           }   
            
        }//fin for
            
            $arreglo = $arregloAux;
           if (is_null($arregloAux)|| sizeof($arregloAux) == 0 )
               $arreglo = array();
        
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}  
            
        $userActual = cargaDatosUsuarioActual(); 
        
        IF (isset($_POST['selectORG']) && $_POST['selectORG'] != ''){
            $arrayClientesUsuario = $userActual->getClientesUsuario();                         
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
            $consulta = $link->prepare("SELECT distinct   relacion_usuario_area_venta.VKORG , ifnull( VTEXTVKORG,relacion_usuario_area_venta.VKORG)AS VTEXTVKORG FROM clientes.relacion_usuario_area_venta " 
                                       . "left join clientes.vw_SAP_rfc_Areasdeventa on relacion_usuario_area_venta.VKORG = vw_SAP_rfc_Areasdeventa.VKORG "
                                       . "WHERE cod_usuario = '{$userActual->getId()}' ");
            $datos['query'] = "SELECT distinct   relacion_usuario_area_venta.VKORG ,ifnull( VTEXTVKORG,relacion_usuario_area_venta.VKORG)AS VTEXTVKORG   FROM clientes.relacion_usuario_area_venta " 
                                       . "left join clientes.vw_SAP_rfc_Areasdeventa on relacion_usuario_area_venta.VKORG = vw_SAP_rfc_Areasdeventa.VKORG "
                                       . "WHERE cod_usuario = '{$userActual->getId()}' ";
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $COUNT = 0;
             if(sizeof( $registros) > 0){ 
                foreach ($registros as $key => $value) { 
                    $ARRAY_ORG[$COUNT]= $value['VKORG'] ;   
                    $COUNT++;
            } }}        
    if(isset($_POST['CentosLogAsignadosUsuario']) && $_POST['CentosLogAsignadosUsuario'] =='%')
           {   $arrayCentro = $userActual->getArrayCentosLog();     }   
    if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] =='%')
        {   $arrayCliente  = $userActual->getClientesUsuario();  }
    else{   $arrayCliente[0]=$_POST['ClientesAsignadosUsuario'];     }
    
    if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arregloFinal = array();}
    else{$arregloFinal = FILTRAR_DATOS_ZMCV_RFC_PEDIDOS_FACTURAS2($arreglo, $ARRAY_ORG , $arrayCliente, $arrayCentro, $LGORT);}  
        //print_r($arregloFinal);
    $datos['datos']=$arregloFinal;        
    $datos['error'] = '';
    $datos['filas'] = sizeof( $datos['datos']) ;
    $datos['filas_2'] = sizeof($arregloFinal);
    if ($nomTableCabecera and $nomTableCabecera != ''){
        $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
        $datos['nombreCabecera']=$nomTableCabecera;
    }
    break;
    
    
    
    
    case 'LISTAR_ZMCV_RFC_TESORERIA':
        $arreglo = array(); 
        IF ((isset($_POST['KKBER']) && $_POST['KKBER'] != '' )&&(isset($_POST['KUNDE']) &&$_POST['KUNDE'] != '' )){
            $KKBER = $_POST['KKBER'];//AREA DE CONTROL 
            $KUNDE = $_POST['KUNDE'];//CLIENTE
            $arreglo =  GET_DATOS_RFC_TESORERIA($KKBER ,$KUNDE);
            header('Content-Type: text/html; charset=ISO-8859-1');
            $cont = 0;  
    
    
             IF($arreglo['CASHC']=='COP' )
             {
                 
             } 
             $arreglo['CAR_AVALADA_M']= amoneda($arreglo['CAR_AVALADA'], 'pesos') ; 
             $arreglo['CAR_AVA_VENC_M']= amoneda($arreglo['CAR_AVA_VENC'], 'pesos') ; 
             $arreglo['CAR_TOTAL_M']= amoneda($arreglo['CAR_TOTAL'], 'pesos') ; 
             $arreglo['CAR_VENC1_M']= amoneda($arreglo['CAR_VENC1'], 'pesos') ; 
             $arreglo['CAR_VENC_TOTAL_M']= amoneda($arreglo['CAR_VENC_TOTAL'], 'pesos') ;              
             $VENC = $arreglo['CAR_X_VENC1'];
             $pos = strpos($VENC, '-');             
            if ($pos === false) {
                 str_replace('-', '',$VENC);
                 $VENC = (-1)*$VENC;
                }
            $arreglo['CAR_X_VENC1_M']= amoneda($VENC, 'pesos') ; 
             
             
             $arreglo['CAR_X_VENC2_M']= amoneda($arreglo['CAR_X_VENC2'], 'pesos') ; 
             $arreglo['KLIMK_M']= amoneda($arreglo['KLIMK'], 'pesos') ; 
             $arreglo['OBLIG_M']= amoneda($arreglo['OBLIG'], 'pesos') ; 
             $arreglo['OBLIG2_M']= amoneda($arreglo['OBLIG2'], 'pesos') ; 
             $arreglo['OEIKW_M']= amoneda($arreglo['OEIKW'], 'pesos') ; 
             $arreglo['OFAKW_M']= amoneda($arreglo['OFAKW'], 'pesos') ; 
             $arreglo['OLIKW_M']= amoneda($arreglo['OLIKW'], 'pesos') ; 
             $arreglo['PEND_X_FACT_M']= amoneda($arreglo['PEND_X_FACT'], 'pesos') ; 
             $arreglo['VAL_PEND1_M']= amoneda($arreglo['VAL_PEND1'], 'pesos') ; 
             $arreglo['VAL_PEND2_M']= amoneda($arreglo['VAL_PEND2'], 'pesos') ; 
             $arreglo['DISPO_M'] = amoneda($arreglo['DISPO'], 'pesos') ; 
         //IT_PEND_FAC  
        foreach ( $arreglo['IT_PEND_FAC'] as $key => $value) {
                $value['NAME1_P']=reemplazaAcentos(utf8_encode( $value['NAME1_P']));
                $value['NAME1_S']=reemplazaAcentos(utf8_encode( $value['NAME1_S']));
                $value['MAKTX']=reemplazaAcentos(utf8_encode( $value['MAKTX'])); 
               $value['MAKTX'] = intval($value['MAKTX']);
                if (trim($value['WAERK']) == 'COP'){
                    $value['MATNR']=  str_replace('.', '', $value['MATNR'] ); 
                    $value['VAL_NETO']=  str_replace('.', '', $value['VAL_NETO']) ; 
                    $value['RFWRT']=  str_replace('.', '', $value['RFWRT'] ); 
                    $value['VAL_PEND']=  str_replace('.', '', $value['VAL_PEND'] ); 
                }
                
                $value['MATNR_M']= amoneda($value['MATNR'], 'pesos') ; 
                    $value['VAL_NETO_M']= amoneda($value['VAL_NETO'], 'pesos') ; 
                    $value['RFWRT_M']= amoneda($value['RFWRT'], 'pesos') ; 
                    $value['VAL_PEND_M']= amoneda($value['VAL_PEND'], 'pesos')  ;
                
                $arreglo['IT_PEND_FAC'][$key] = $value;
                }
        foreach ( $arreglo['IT_CREDITO_CLIENTES'] as $key => $value) {
                $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1']));  
                $value['KLIMK'];
               
                $value['CUPO_DISPONIBLE']='0.0';
                if (trim($value['WAERK']) == 'COP'){
                $value['SKFOR']=  str_replace('.', '', $value['SKFOR']) ;
                $value['SSOBL']=  str_replace('.', '', $value['SSOBL']) ;
                $value['OLIKW']= str_replace('.', '', $value['OLIKW']) ;
                $value['OFAKW']=  str_replace('.', '', $value['OFAKW']) ;
                $value['OEIKW']=  str_replace('.', '', $value['OEIKW']) ;
                $value['OBLIG']=  str_replace('.', '', $value['OBLIG']) ;
                $value['KLIMK']=  str_replace('.', '', $value['KLIMK']) ;
                }
                 $value['PENDIENTE_POR_FACTURAR']= $value['OBLIG'] - $value['SKFOR'];
                 $value['CUPO_DISPONIBLE']= $value['KLIMK'] -($value['SKFOR'] + $value['PENDIENTE_POR_FACTURAR']);
                
                 
                 $value['SKFOR_M']=  amoneda($value['SKFOR'], 'pesos');
                $value['SSOBL_M']=  amoneda($value['SSOBL'], 'pesos');
                $value['OLIKW_M']=  amoneda($value['OLIKW'], 'pesos');
                $value['OFAKW_M']=  amoneda($value['OFAKW'], 'pesos');
                $value['OEIKW_M']=  amoneda($value['OEIKW'], 'pesos');
                $value['OBLIG_M']=  amoneda($value['OBLIG'], 'pesos');
                $value['KLIMK_M']=  amoneda($value['KLIMK'], 'pesos');
    
                 $value['PENDIENTE_POR_FACTURAR_M']=  amoneda($value['PENDIENTE_POR_FACTURAR'], 'pesos');
                 $value['CUPO_DISPONIBLE_M']=  amoneda($value['CUPO_DISPONIBLE'], 'pesos');
    
                 
                $arreglo['IT_CREDITO_CLIENTES'][$key] = $value;
                }
            $datos['datos']=$arreglo;        
            $datos['error'] = '';
            $datos['filas'] = sizeof( $datos['datos']) ;}
        ELSE{$datos['datos']=array();        
            $datos['error'] = 'Faltan datos para realizar la consulta';
            $datos['filas'] = sizeof($datos['datos']) ;}
    if ($nomTableCabecera and $nomTableCabecera != ''){
        $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
        $datos['nombreCabecera']=$nomTableCabecera;
    }

    break;
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE CLIENTES - AREAS DE VENTA  - CENTROS LOGISTICOS...">
    case 'GET_LISTADO_CLIENTES_POR_USUARIO':
    if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $datos= \Class_php\Usuarios::recuperarTodosClientes(" where id_usuario = '{$_POST['idUsuario']}' ");
    }
    else{
        $datos = \Class_php\Usuarios::recuperarClientesTmp();
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);   
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break;
    case 'GET_LISTADO_AREAS_DE_VENTA_POR_USUARIO':
    if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $datos= \Class_php\Usuarios::recuperarTodosAreasVentas(" where cod_usuario = '{$_POST['idUsuario']}' ");
    }
    else{
        $datos = \Class_php\Usuarios::recuperarAreasVentasTmp();
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break;
   case 'GET_LISTADO_AREAS_DE_VENTA_POR_USUARIO_Y_ORGANIZACION':
       $userActual = cargaDatosUsuarioActual();
         $datos= \Class_php\Usuarios::recuperarTodosAreasVentas(" where cod_usuario = '{$userActual->getId()}' AND VKORG = '{$_POST['selectORG']}' ");
    
    
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break; 
    case 'ELIMINAR_RELACION_MAIL_NOTIFICACION_CLIENTE':
                TRY {
       $conexion =Class_php\DataBase::getInstance(); 
       if (isset($_POST['id_correo']) && $_POST['id_correo'] != ''){
             $_result =$conexion->eliminarDato('relacion_mail_cliente',  $_POST['id_relacion'],'id_relacion');
        }
        else{
            $_result =$conexion->eliminarDato('aux_relacion_mail_cliente',  $_POST['id_cliente_SAP'],'id_cliente_SAP');
        }
     
      switch ($_result[0]['result'])
      {
           case '100':
                $datos['error'] ='ok';  
           break;
           case '-1':
                $datos['error'] ='_table';  
           break;   
           case '-2':
                $datos['error'] ='_dato';  
           break;   
           case '-3':
                $datos['error'] ='_COLUMNA';  
           break;   
       default :
                $datos['error'] = $_result[0]['result'];
           break;
       }
      }
      catch (PDOException $e) {
        $datos['error']= 'Error de conexión: ' . $e->getMessage();
           
     }
        
    break;
    case 'GET_LISTADO_CLIENTES_MAIL_NOTIFICACIONES':
       try {     
        if (isset($_POST['id_correo']) && $_POST['id_correo'] != '')
            { 
                $conexion =\Class_php\DataBase::getInstance();
                $link = $conexion->getLink();      
                $consulta = $link->prepare("SELECT * FROM  relacion_mail_cliente  where id_correo_notificacion = {$_POST['id_correo']}  ");
                $datos['query'] = "SELECT * FROM  relacion_mail_cliente  where id_correo_notificacion = {$_POST['id_correo']}  ";
                $consulta->execute();
                $registros = $consulta->fetchAll(); 
                $datos['error']='';
                $datos['datos'] = $registros;
                $datos['filas'] = sizeof( $registros) ;
            }
            else{ 
                $conexion =\Class_php\DataBase::getInstance();
                $link = $conexion->getLink();      
                $consulta = $link->prepare('SELECT distinct * FROM aux_relacion_mail_cliente    ');
                $datos['query'] = 'SELECT distinct * FROM aux_relacion_mail_cliente ';
                $consulta->execute();
                $registros = $consulta->fetchAll(); 
                $datos['error']='';
                $datos['datos'] = $registros;
                $datos['filas'] = sizeof( $registros) ; 
                }  
        }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break;
    case 'GUARDAR_RELACION_CLIENTE_CORREO_NOTIFICACION':
        IF (!ISSET($_POST['tipo_relacion']) || $_POST['tipo_relacion'] == '') {$_POST['tipo_relacion'] = '1';}
       IF (!ISSET($_POST['tipo_notificacion']) || $_POST['tipo_notificacion'] == '') {$_POST['tipo_notificacion'] = '1';}
      // echo $_POST['id_correo'];
      try { 
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();     
       IF (!ISSET($_POST['id_correo']) || $_POST['id_correo'] == ''){ 
             IF (ISSET($_POST['id_relacion']) && $_POST['id_relacion'] != '')    /*Modifica*/ {  
              $consulta = $link->prepare("call  sp_Crear_editar_tmp_cliente_mail_notificacion(:_id_relacion,:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, '0000',  :usuarioIngresado , :_FULLNAME_SAP)");
              $consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute(); 
           }else /*Inserta*/ {  
                 $consulta = $link->prepare("call  sp_Crear_editar_tmp_cliente_mail_notificacion('',:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, '0000',  :usuarioIngresado , :_FULLNAME_SAP)");
              //$consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute();  
           } 
      //echo  "call  sp_Crear_editar_tmp_cliente_mail_notificacion('{$_POST['id_relacion']}','{$_POST['COD_CLI_SAP']}', '{$_POST['tipo_relacion']}' ,  '{$_POST['tipo_notificacion']}', '0000',  '{$_SESSION["usuario_logeado"]}' , '{$_POST['FULLNAME']}')";
     
       }else{ 
           IF (ISSET($_POST['id_relacion']) && $_POST['id_relacion'] != '')    /*Modifica*/ { 
              $consulta = $link->prepare("call  sp_Crear_editar_cliente_mail_notificacion(:_id_relacion,:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, :_id_correo,  :usuarioIngresado , :_FULLNAME_SAP)");
              $consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']);
              $consulta->bindParam(':_id_correo', $_POST['id_correo']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute(); 
           }else /*Inserta*/ {
                 $consulta = $link->prepare("call  sp_Crear_editar_cliente_mail_notificacion('',:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, :_id_correo,  :usuarioIngresado , :_FULLNAME_SAP)");
              //$consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']); 
              $consulta->bindParam(':_id_correo', $_POST['id_correo']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute();  
           } 
           
          // echo "call  sp_Crear_editar_cliente_mail_notificacion('{$_POST['id_relacion']}','{$_POST['COD_CLI_SAP']}', '{$_POST['tipo_relacion']}' ,  '{$_POST['tipo_notificacion']}', '{$_POST['id_correo']}',  '{$_SESSION["usuario_logeado"]}', '{$_POST['FULLNAME']}')";
       }
        $conexion = null;
       $array =  $consulta->fetchAll();
       switch ($array[0]['result']){
           case '100':
           case '101':
                $datos['error']  ='ok';  
           break;
           case '-1':
           case '-2':
                $datos['error']  ='not ok';  
           break; 
       default :
           $datos['error']  =$array[0]['result'];  
           break;
       } 
      
      $conexion = null;
       } catch (PDOException $e) {
     $datos['error'] =  'Error de conexión: ' . $e->getMessage();
           
}
    break;
    case 'GUARDAR_DATOS_USUARIO_CLIENTES': 
        $nuevoUsuario = new Class_php\Usuarios(  $_POST['ID_cliente'] 
         ,  $_POST['Login'] 
         ,  $_POST['Nombre1']
         ,  $_POST['Nombre2'] 
         ,  $_POST['Apellido1'] 
         ,  $_POST['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $_POST['estado'] 
         ,  $_POST['pass']  );
        
        IF (ISSET($_POST['ID_cliente']) && $_POST['ID_cliente'] != ''){        
             $datos['error']  = $nuevoUsuario->guardarClienteUsuario($_POST['id_relacion'],$_POST['KUNNR'],$_POST['FULLNAME'],$_POST['estado']);
        }ELSE{//$_id_relacion = null,$_id_cliente_SAP, $_nombre_cliente_SAP, $_estado
            $datos['error'] = $nuevoUsuario->guardarTmpClienteUsuario($_POST['id_relacion'],$_POST['KUNNR'],$_POST['FULLNAME'],$_POST['estado']);
        }
    break;
    case 'GUARDAR_DATOS_USUARIO_AREAS_DE_VENTA': 
        $nuevoUsuario = new Class_php\Usuarios(  $_POST['ID_cliente'] 
         ,  $_POST['Login'] 
         ,  $_POST['Nombre1']
         ,  $_POST['Nombre2'] 
         ,  $_POST['Apellido1'] 
         ,  $_POST['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $_POST['estado'] 
         ,  $_POST['pass']  );
        
        IF (ISSET($_POST['ID_cliente']) && $_POST['ID_cliente'] != ''){        
             $datos['error']  = $nuevoUsuario->guardarAreaVentaUsuario($_POST['id_relacion'],$_POST['VKORG'],$_POST['VTWEG'],$_POST['SPART'] );
        }ELSE{//($_id_relacion = null,$_VKORG, $_VTWEG,$_SPART, $_estado)
            $datos['error'] = $nuevoUsuario->guardarTmpAreaVentaUsuario($_POST['id_relacion'],$_POST['VKORG'],$_POST['VTWEG'],$_POST['SPART'] );
        }
    break;
    case 'GUARDAR_DATOS_AREAS_DE_VENTA_CENTROS_LOGISTICOS': 
           
       try { 
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();   
       $consulta = $link->prepare("call  sp_crear_relacion_centro_log_area_venta('',:_VKORG  , :_VTEXTVKORG  ,  :_VTWEG,:_VTEXTVTWEG,:_SPART  , :_VTEXTSPART  ,:_WERKS  ,:_NAME1  ,:_usuarioIngresado )");
       $consulta->bindParam(':_VKORG', $_POST['VKORG']);
       $consulta->bindParam(':_VTEXTVKORG', $_POST['VTEXTVKORG']);
       $consulta->bindParam(':_VTWEG', $_POST['VTWEG']);
       $consulta->bindParam(':_VTEXTVTWEG', $_POST['VTEXTVTWEG']);
       $consulta->bindParam(':_SPART', $_POST['SPART']); 
       $consulta->bindParam(':_VTEXTSPART',$_POST['VTEXTSPART'] );  
       $consulta->bindParam(':_WERKS',$_POST['WERKS'] );  
       $consulta->bindParam(':_NAME1', $_POST['NAME1'] );   
       $consulta->bindParam(':_usuarioIngresado', $_SESSION["usuario_logeado"] ); 
      // $query =  "call  sp_crear_relacion_centro_log_area_venta('',:_VKORG  , :_VTEXTVKORG  ,  :_VTWEG,:_VTEXTVTWEG,:_SPART  , :_VTEXTSPART  ,:_WERKS  ,:_NAME1  ,:_usuarioIngresado )";
      //  $query=  str_replace(array( ':_VKORG',':_VTEXTVKORG',':_VTWEG', ':_VTEXTVTWEG', ':_SPART',':_VTEXTSPART',':_WERKS',':_NAME1',':_usuarioIngresado'),    array("'{$_POST['VKORG']}'","'{$_POST['VTEXTVKORG']}'","'{$_POST['VTWEG']}'","'{$_POST['VTEXTVTWEG']}'","'{$_POST['SPART']}'","'{$_POST['VTEXTSPART']}'","'{$_POST['WERKS']}'","'{$_POST['NAME1']}'","'{$_SESSION["usuario_logeado"]}'") ,$query);
    
         $consulta->execute();  
       $array =  $consulta->fetchAll();
       switch ($array[0]['result']){
           case '100':
           case '101':
                $datos['error']  ='ok';  
           break;
           case '-1':
           case '-2':
                $datos['error']  ='not ok';  
           break; 
       default :
           $datos['error']  =$array[0]['result'];  
           break;
       } 
      
      $conexion = null;
       } catch (PDOException $e) {
     $datos['error'] =  'Error de conexión: ' . $e->getMessage();
           
}
    break; 
    case 'LISTAR_ZMCV_RFC_DESPACHOS_PENDIENT_02':  
        $arreglo = array();
           header('Content-Type: text/html; charset=ISO-8859-1');
        if ($_POST['CentosLogAsignadosUsuario']=='%'){
            /*  MaterialesAsignadosUsuario:   $('#MaterialesAsignadosUsuario').val() ,
          ClientesAsignadosUsuario : $('#ClientesAsignadosUsuario').val()*/
         if (!isset($_SESSION['DATOS_RFC_DESPACHOS_PENDIENT_02']) || $_SESSION['DATOS_RFC_DESPACHOS_PENDIENT_02'] == '' || sizeof($_SESSION['DATOS_RFC_DESPACHOS_PENDIENT_02'])== 0){
             $arreglo = ZMCV_RFC_DESPACHOS_PENDIENT_02();
                   header('Content-Type: text/html; charset=ISO-8859-1');                   
          foreach ( $arreglo as $key => $value) {  
                 $value['VBELN']= intval($value['VBELN']);
                 $value['MATNR']= intval($value['MATNR']); 
                 $value['ZDESPACHAR']= intval($value['ZDESPACHAR']); 
                 $value['ZORDENADO']= intval($value['ZORDENADO']);                 
                 IF ($value['VRKME']=='ST')
                            $value['VRKME'] = 'UN';
                 $value['SALDO']=floatval(str_replace(".","",$value['KWMENG'] ))- floatval(str_replace(".","",$value['ZDLV_QTY']));
                 $value['ZDES_ORDENADO']=reemplazaAcentos(utf8_encode( $value['ZDES_ORDENADO'])); 
                 $value['ZDES_DESPACHAR']=reemplazaAcentos(utf8_encode( $value['ZDES_DESPACHAR']));
                 $value['ARKTX']=reemplazaAcentos(utf8_encode( $value['ARKTX']));
                 $value['NAME1_O']=reemplazaAcentos(utf8_encode( $value['NAME1_O']));
                 $value['LGOBE_O']=reemplazaAcentos(utf8_encode( $value['LGOBE_O']));
                 $value['VTEXT']=reemplazaAcentos(utf8_encode( $value['VTEXT']));
                $arreglo[$key]=$value;                  
            }
             $_SESSION['DATOS_RFC_DESPACHOS_PENDIENT_02'] = $arreglo;
         }        
        $arreglo =  $_SESSION['DATOS_RFC_DESPACHOS_PENDIENT_02'] ;
        }else{      $centro = $material = $cliente = $NUM_PEDIDO = null ;
            if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] !='%')
                {     $cliente = $_POST['ClientesAsignadosUsuario'] ;}
            if(isset($_POST['MaterialesAsignadosUsuario']) && $_POST['MaterialesAsignadosUsuario'] !='%')
                {     $material = $_POST['MaterialesAsignadosUsuario'] ;}
            if(isset($_POST['CentosLogAsignadosUsuario']) && $_POST['CentosLogAsignadosUsuario'] !='%')
                {     $centro = $_POST['CentosLogAsignadosUsuario'] ;}
             if(isset($_POST['NUM_PEDIDO']) && $_POST['NUM_PEDIDO'] !='')
                {     $NUM_PEDIDO = $_POST['NUM_PEDIDO'] ;
                            $relleno = "";
                    if (strlen($NUM_PEDIDO)< 10){
                        $final = 10 - strlen($NUM_PEDIDO) ;
                        for ($i=0 ; $i< $final;$i++){$relleno .= '0';} 
                        $NUM_PEDIDO = $relleno.$NUM_PEDIDO ;//0000253855
                        }
                }
                $arreglo = array()     ;
                $arreglo = ZMCV_RFC_DESPACHOS_PENDIENT_02($centro , $material ,$cliente ,$NUM_PEDIDO);
            if (is_null($arreglo)|| sizeof($arreglo) == 0 ){
               $arreglo = array();
        } 
          foreach ( $arreglo as $key => $value) {  
                 $value['VBELN']= intval($value['VBELN']);
                 $value['MATNR']= intval($value['MATNR']); 
                 $value['ZDESPACHAR']= intval($value['ZDESPACHAR']); 
                 $value['ZORDENADO']= intval($value['ZORDENADO']);                 
                 IF ($value['VRKME']=='ST')
                            $value['VRKME'] = 'UN';
                 $value['SALDO']=floatval( $value['KWMENG']  )- floatval( $value['ZDLV_QTY']);
                 $value['ZDES_ORDENADO']=reemplazaAcentos(utf8_encode( $value['ZDES_ORDENADO'])); 
                 $value['ZDES_DESPACHAR']=reemplazaAcentos(utf8_encode( $value['ZDES_DESPACHAR']));
                 $value['ARKTX']=reemplazaAcentos(utf8_encode( $value['ARKTX']));
                 $value['NAME1_O']=reemplazaAcentos(utf8_encode( $value['NAME1_O']));
                 $value['LGOBE_O']=reemplazaAcentos(utf8_encode( $value['LGOBE_O']));
                 $value['VTEXT']=reemplazaAcentos(utf8_encode( $value['VTEXT']));
                 $value['NUM_ORDEN_CARGA'] = '';  
                  $value['DISPONIBLE_A_CARGAR'] = '';  
                $arreglo[$key]=$value;
            } 
        if (is_null($arreglo)|| sizeof($arreglo) == 0 )
               $arreglo = array();
        } 
    $userActual = cargaDatosUsuarioActual();  
    if(isset($_POST['CentosLogAsignadosUsuario']) && $_POST['CentosLogAsignadosUsuario'] =='%')
           {   $arrayCentro = $userActual->getArrayCentosLog();     }   

    if(isset($_POST['ClientesAsignadosUsuario']) && $_POST['ClientesAsignadosUsuario'] =='%')
           {   $arrayCliente  = $userActual->getClientesUsuario();  }
        else{         $arrayCliente[0]=$_POST['ClientesAsignadosUsuario'];     }
           
       $LGORT = null;    
    if(isset($_POST['AlmacenesAsignadosUsuario']) && $_POST['AlmacenesAsignadosUsuario'] !='%')   {
        $LGORT  = $_POST['AlmacenesAsignadosUsuario'];
    } 
    $arregloFinal = FILTRAR_DATOS_RFC_DESPACHOS_PENDIENT_02($arreglo , $arrayCliente, $arrayCentro, $LGORT);
    $tipo_pedido_verificar = "";
    $puesto_expedicion_verificar = "";
     $datos['tipos_pedido_iguales'] = "si";
     $datos['puesto_expedicion_iguales'] = "si";
     
    foreach ( $arregloFinal as $key => $value) {  
            if ($tipo_pedido_verificar == ""){
                $tipo_pedido_verificar = $value['AUART'];
            }
            if ($tipo_pedido_verificar != $value['AUART'] ){
                $datos['tipos_pedido_iguales'] = "no";
            }
            
            if ($puesto_expedicion_verificar == ""){
                $puesto_expedicion_verificar = $value['VSTEL'];
            }
            if ($puesto_expedicion_verificar != $value['VSTEL'] ){
                $datos['puesto_expedicion_iguales'] = "no";
            }
            $aux_cant = 0;
            IF (isset($_POST['VERIFICAR_ORDEN_CARGA'])&& $_POST['VERIFICAR_ORDEN_CARGA']!='')
                 { try { 
                       $conexion =\Class_php\DataBase::getInstance();
                       $link = $conexion->getLink();   
                       $consulta = $link->prepare("SELECT IFNULL(cantidad,0)as cantidad FROM vw_orden_de_carga_detalle WHERE estado in ('PR','ER') and pedido = {$value['VBELN']} ");
                       $consulta->execute();  
                       $registros =  $consulta->fetchAll();
                       foreach ($registros as $key2 => $value_2) {  
                           $aux_cant += number_format(floatval($value_2['cantidad']),3);
                       }
                       $value['NUM_ORDEN_CARGA'] = $aux_cant;
                       $conexion = null;
                       } catch (PDOException $e) {
                            $datos['error'] =  'Error de conexión: ' . $e->getMessage();
                        }
                }
             $value['VBELN']= intval($value['VBELN']);
             $value['MATNR']= intval($value['MATNR']); 
             $value['ZDESPACHAR']= intval($value['ZDESPACHAR']); 
             $value['ZORDENADO']= intval($value['ZORDENADO']);                 
             IF ($value['VRKME']=='ST')
                        $value['VRKME'] = 'UN';
             
             $value['SALDO']=floatval( $value['KWMENG']  )- floatval( $value['ZDLV_QTY'] );
             $value['DISPONIBLE_A_CARGAR'] =  floatval($value['KWMENG'] )-$aux_cant;
             
             $arregloFinal[$key]=$value;                
            }
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){
           
            $datos['datos'] = verificaContenidoArray( $arregloFinal , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{  
                $datos['datos'] = $arregloFinal;}
          $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ;   
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'LISTAR_MATERIALES_USUARIO'://ZMCV_RFC_ALMACENES_02
           header('Content-Type: text/html; charset=ISO-8859-1'); 
         if (!isset($_SESSION['DATOS_RFC_ALMACENES_02']) || $_SESSION['DATOS_RFC_ALMACENES_02'] == '' || sizeof($_SESSION['DATOS_RFC_ALMACENES_02'])== 0){
            $arreglo_RFC_ALMACENES = ZMCV_RFC_ALMACENES_02();
            foreach ( $arreglo_RFC_ALMACENES as $key => $value) { 
                $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1'])); 
                  $value['LGOBE']=reemplazaAcentos(utf8_encode( $value['LGOBE']));
                  $value['VTEXT']=reemplazaAcentos(utf8_encode( $value['VTEXT']));
                $arreglo[$key]=$value;
                  
            }
            $_SESSION['DATOS_RFC_ALMACENES_02'] = $arreglo;
         }
         
        $arreglo_RFC_ALMACENES =  $_SESSION['DATOS_RFC_ALMACENES_02'] ;         
       
        $arreglo_RFC_RECURSO_CLASIFICACION =  $datosRecibidos = array();
        
        if(isset($_POST['CentosLogAsignadosUsuario'])){
            if($_POST['CentosLogAsignadosUsuario'] == '%'){
                $userActual = cargaDatosUsuarioActual();
                $arrayVerificacion = $userActual->getArrayCentosLog();
            }else{
                $arrayVerificacion[0]= $_POST['CentosLogAsignadosUsuario'];
            }
            
            if($_POST['AlmacenesAsignadosUsuario'] == '%'){
                $almacen = "";
            }else{
                $almacen = $_POST['AlmacenesAsignadosUsuario'] ;
            }
            $index = 0;
             if (!is_null($arrayVerificacion) && sizeof($arrayVerificacion)>0){
                  foreach ($arrayVerificacion as $key => $_centro_log) {
                     $arreglo_RFC_RECURSO_CLASIFICACION =  ZMCV_RFC_RECURSO_CLASIFICACION($almacen,$_centro_log ) ;
                    foreach ( $arreglo_RFC_RECURSO_CLASIFICACION as $key => $value) { 
                            $value['MAKTX']=reemplazaAcentos(utf8_encode( $value['MAKTX']));  
                            $datosRecibidos[$index]=$value;   
                            $index++;
                        }
            }
             }
           // $datosAlmacenes= FILTRAR_DATOS_RFC_ALMACENES_02($datos['datos'],$arrayVerificacion);
           
          $datos['datos']= $datosRecibidos;
        }
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'LISTAR_CENTROS_LOG_USUARIO'://ZMCV_RFC_ALMACENES_02 
        $userActual = cargaDatosUsuarioActual();
        $datosRecibidos = array();
        IF ($_POST['selectORG'] == ''){
        $datos['datos']  = $userActual->getClientesCentrosLogisticos(); }else{
             $datosRecibidos  = $userActual->getClientesCentrosLogisticos();
             $cont = 0;
             $auxArray = array();
             $WERKSArrays = array();
                 foreach ($datosRecibidos as $key => $value) {
                     if ($value['VKORG'] == $_POST['selectORG'] && !in_array($value['WERKS'],$WERKSArrays )){
                         array_push ($WERKSArrays,$value['WERKS']);
                     $auxArray[$cont]= $value;
                     $cont++;}
                } 
                $datos['datos'] =$auxArray ;
        }
        
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
        
        
         
    break;
    case 'LISTAR_ALMACENES_USUARIO'://ZMCV_RFC_ALMACENES_02
           header('Content-Type: text/html; charset=ISO-8859-1'); 
         if (!isset($_SESSION['DATOS_RFC_ALMACENES_02']) || $_SESSION['DATOS_RFC_ALMACENES_02'] == '' || sizeof($_SESSION['DATOS_RFC_ALMACENES_02'])== 0){
            $arreglo = ZMCV_RFC_ALMACENES_02();
            foreach ( $arreglo as $key => $value) { 
                $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1'])); 
                  $value['LGOBE']=reemplazaAcentos(utf8_encode( $value['LGOBE']));
                  $value['VTEXT']=reemplazaAcentos(utf8_encode( $value['VTEXT']));
                $arreglo[$key]=$value;
                  
            }
            $_SESSION['DATOS_RFC_ALMACENES_02'] = $arreglo;
         }
         
        $arreglo =  $_SESSION['DATOS_RFC_ALMACENES_02'] ;
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}  
            
        if(isset($_POST['CentosLogAsignadosUsuario'])){
            if($_POST['CentosLogAsignadosUsuario'] == '%'){
                $userActual = cargaDatosUsuarioActual();
                $arrayVerificacion = $userActual->getArrayCentosLog();
            }else{
                $arrayVerificacion[0]= $_POST['CentosLogAsignadosUsuario'];
            }
            
             if (!is_null($arrayVerificacion) && sizeof($arrayVerificacion)>0)
            $datos['datos']= FILTRAR_DATOS_RFC_ALMACENES_02($datos['datos'],$arrayVerificacion);
        
        }
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
       
        
        
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'GET_LISTADO_CENTROS_LOGISTICOS':
           header('Content-Type: text/html; charset=ISO-8859-1'); 
         if (!isset($_SESSION['DATOS_RFC_CENTROS']) || $_SESSION['DATOS_RFC_CENTROS'] == '' || sizeof($_SESSION['DATOS_RFC_CENTROS'])== 0){
            $arreglo = GET_DATOS_RFC_CENTROSLOGISTICOS();
            foreach ( $arreglo as $key => $value) { 
                $value['NAME1']=reemplazaAcentos(utf8_encode( $value['NAME1'])); 
                $arreglo[$key]=$value;
            }
            $_SESSION['DATOS_RFC_CENTROS'] = $arreglo;
         }
        $arreglo =  $_SESSION['DATOS_RFC_CENTROS'] ;
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}  
            
        if (!is_null($_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']) && sizeof($_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']))
        $datos['datos']= FILTRAR_DATOS_RFC_CENTROSLOGISTICOS($datos['datos'],$_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS'],false);
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'GET_LISTADO_AREAS_DE_VENTAS':
         $datos['error']=''; 
        if (!isset($_SESSION['DATOS_RFC_AREASDEVENTA']) || $_SESSION['DATOS_RFC_AREASDEVENTA'] == '' || sizeof($_SESSION['DATOS_RFC_AREASDEVENTA'])== 0)
            $_SESSION['DATOS_RFC_AREASDEVENTA'] = GET_DATOS_RFC_AREASDEVENTA();
        
        $arreglo = $_SESSION['DATOS_RFC_AREASDEVENTA'];
        
         if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}
           
        
        $datos['filas'] = sizeof( $datos['datos']) ; 
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'GET_LISTADO_AREAS_DE_VENTAS_CON_CENTRO_LOG':
          $where = null;
        if(isset($_POST['VKORG'])){
            $where = " where a.VKORG = ".$_POST['VKORG'];
        }        
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
             if(isset($_POST['cod_usuario'] )&& $_POST['cod_usuario'] != ''){
                $consulta = $link->prepare("SELECT a.VKORG, a.VTEXTVKORG, a.VTWEG, a.VTEXTVTWEG, a.SPART, a.VTEXTSPART FROM clientes.vw_SAP_rfc_Areasdeventa a left join ".
                "relacion_usuario_area_venta on `relacion_usuario_area_venta`.`VKORG` = a.VKORG and ".
                "`relacion_usuario_area_venta`.`VTWEG` = a.VTWEG  and ".
                "`relacion_usuario_area_venta`.`SPART` = a.SPART ".
                "where ifnull( `relacion_usuario_area_venta`.`cod_usuario`,0) <> '{$_POST['cod_usuario']}' ");
                
                $datos['query'] ="SELECT a.VKORG, a.VTEXTVKORG, a.VTWEG, a.VTEXTVTWEG, a.SPART, a.VTEXTSPART FROM clientes.vw_SAP_rfc_Areasdeventa a left join ".
                "relacion_usuario_area_venta on `relacion_usuario_area_venta`.`VKORG` = a.VKORG and ".
                "`relacion_usuario_area_venta`.`VTWEG` = a.VTWEG  and ".
                "`relacion_usuario_area_venta`.`SPART` = a.SPART ".
                "where ifnull( `relacion_usuario_area_venta`.`cod_usuario`,0) <> '{$_POST['cod_usuario']}' ";
             }else{
            $consulta = $link->prepare('SELECT VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART  FROM clientes.vw_SAP_rfc_Areasdeventa '.$where.'    ');
            $datos['query'] = 'SELECT VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART  FROM clientes.vw_SAP_rfc_Areasdeventa '.$where.'    ';
            }
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ;
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
              
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'GET_LISTADO_CENTRO_LOG_POR_AREAS_DE_VENTAS':
          $where = null;
           
         if(isset($_POST['VKORG']) && $_POST['VKORG'] != '' && isset($_POST['VTWEG'])&&$_POST['VTWEG']!= "" && isset($_POST['SPART']) && $_POST['SPART']!='' ){
            $where = " where VKORG = '{$_POST['VKORG']}' AND VTWEG ='{$_POST['VTWEG']}' AND  SPART = '{$_POST['SPART']}'" ;
        }  
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
            $consulta = $link->prepare('SELECT id_relacion, VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART, WERKS, NAME1 FROM clientes.SAP_rfc_Areasdeventa_centros_log '.$where.'    ');
            $datos['query'] = 'SELECT id_relacion, VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART, WERKS, NAME1 FROM clientes.SAP_rfc_Areasdeventa_centros_log '.$where.'    ';
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ;
            $_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS'] = null;
            if($datos['filas'] > 0){
                $I = 0;
                foreach ($registros as $key => $value) {
                    $ARRAY_CENTRO_LOG_POR_AREAS_DE_VENTAS[$I] = $value['WERKS'];
                    $I++;
                }
                $_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']= $ARRAY_CENTRO_LOG_POR_AREAS_DE_VENTAS;
            }
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
              
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'GET_LISTADO_CLIENTES':
        
          $datos['error']='';  
      
         if (!isset($_SESSION['DATOS_RFC_EASYSALE_CLIENTES']) || $_SESSION['DATOS_RFC_EASYSALE_CLIENTES'] == '' || sizeof($_SESSION['DATOS_RFC_EASYSALE_CLIENTES'])== 0)
            $_SESSION['DATOS_RFC_EASYSALE_CLIENTES'] = GET_DATOS_RFC_EASYSALE_CLIENTES();
        
          $arreglo=$_SESSION['DATOS_RFC_EASYSALE_CLIENTES']; 
        
        if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
             $nuevoUsuario = new Class_php\Usuarios($_POST['idUsuario'] );
             $arrayClientesRelacionados = array();
             $arrayClientesRelacionados = $nuevoUsuario->getClientesUsuario();
             $arreglo= FILTRAR_DATOS_RFC_EASYSALE_CLIENTES($arreglo,$arrayClientesRelacionados,false);
        }else{
           
        $arreglo= FILTRAR_DATOS_RFC_EASYSALE_CLIENTES($arreglo); }
            if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}
            $datos['filas'] = sizeof( $datos['datos']) ;        
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'ELIMINAR_DATOS_USUARIO_CLIENTES': 
         $nuevoMenu = new Class_php\Usuarios( $_POST['id_usuario']);
        $datos['error'] = $nuevoMenu->eliminarRelacionCliente($_POST['dato_eliminar']);
            
        break;
    case 'ELIMINAR_DATOS_USUARIO_AREAS_DE_VENTA': 
         $nuevoMenu = new Class_php\Usuarios( $_POST['id_usuario']);
        $datos['error'] = $nuevoMenu->eliminarRelacionAreaDeVenta($_POST['dato_eliminar']);
            
        break;
    case 'ELIMINAR_DATOS_TMP_USUARIO_CLIENTES':
        $datos['error']  =  Class_php\Usuarios::eliminaRelacionTemporal();
     break;
    case 'ELIMINAR_DATOS_TMP_USUARIO_AREA_DE_VENTA':
        $datos['error']  =  Class_php\Usuarios::eliminaRelacionAreaDeVentaTemporal();
     break;
   case 'ELIMINAR_AREAS_DE_VENTAS_CENTROS_LOG':
        TRY {
       $conexion =Class_php\DataBase::getInstance(); 
      $_result =$conexion->eliminarDato('SAP_rfc_Areasdeventa_centros_log',  $_POST['id_relacion'],'id_relacion');
      switch ($_result[0]['result'])
      {
           case '100':
                $datos['error'] ='ok';  
           break;
           case '-1':
                $datos['error'] ='_table';  
           break;   
           case '-2':
                $datos['error'] ='_dato';  
           break;   
           case '-3':
                $datos['error'] ='_COLUMNA';  
           break;   
       default :
                $datos['error'] = $_result[0]['result'];
           break;
       }
      }
      catch (PDOException $e) {
        $datos['error']= 'Error de conexión: ' . $e->getMessage();
           
     }
        break;
//</editor-fold>
    
    case 'INGRESAR_DATOS_PEDIDO':
        $materiales = $_POST['materiales'];
        $numFilasInsertadas = $_POST['numFilasInsertadas'];
        $solicitanteUsuario = $_POST['solicitanteUsuario'];        
        $solicitanteUsuarioTXT = $_POST['solicitanteUsuarioTXT'];
        $destinatarioUsuario = $_POST['destinatarioUsuario'];             
        $destinatarioUsuarioTXT = $_POST['destinatarioUsuarioTXT'];        
        $id_sitio = $_POST['id_sitio'];
         header('Content-Type: text/html; charset=ISO-8859-1');        
       try { 
             $conexion = Class_php\DataBase::getInstance();
             $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
             do {
                    $sol_pedido = OrdenPortal();
                    $consulta = $link->prepare("SELECT COUNT(*) as cont_datos   FROM pedidos_proceso WHERE  cod_generado_sistema = '$sol_pedido'");
                    $datos['query'] ="SELECT COUNT(*) as cont_datos   FROM pedidos_proceso WHERE  cod_generado_sistema = '$sol_pedido'";
                    $consulta->execute();
                    $registros = $consulta->fetchAll();
                    foreach ($registros as $key => $value) 
                     {$cont_datos = $value['cont_datos'];}
                } while ($cont_datos > 0);
            } catch (PDOException $e) {
                   $datos['error']='Error de conexión: ' . $e->getMessage();
                   $datos['datos'] =null; 
                   echo json_encode($datos);
                   return;
            }
         $userActual = cargaDatosUsuarioActual();  
         $TIPO_DOCUMENTO = $_POST['TIPO_DOCUMENTO'];
         $ORGANIZACION = $_POST['selectORG'];
         $AREAS_VENTAS = $_POST['AREAS_VENTAS'];
       //ENVIO DE DATO PARA LA CREACION DEL PEDIDO
        $RESPUESTA_PEDIDO =  ZMCV_RFC_CREARPEDIDOS($_POST['materiales'],$solicitanteUsuario,$destinatarioUsuario ,$TIPO_DOCUMENTO,$ORGANIZACION,$AREAS_VENTAS,$sol_pedido,$_POST['COMENTARIOS'],$_POST['condicionExpedicion'],$_POST['NOTA_BREVE']);
       ///////////////////////////////////////////////////
      $MENSAJE_ERROR = "";
      $CONT_ERROR = 0;
       $procesado = false;
       $SEPARADOR = '';
       $datos['RESPUESTA_PROCESO'] = 'FAIL'; 
 foreach ($RESPUESTA_PEDIDO as $key => $value) {//MESSAGE_V1	MESSAGE_V2	MESSAGE_V3	MESSAGE_V4	PARAMETER
     $RESPUESTA_PEDIDO[$key] =  utf8_encode( $value['MESSAGE']) ;
     $RESPUESTA_PEDIDO[$key] =  utf8_encode( $value['MESSAGE_V1']) ;
     $RESPUESTA_PEDIDO[$key] =  utf8_encode( $value['MESSAGE_V2']) ;
     $RESPUESTA_PEDIDO[$key] =  utf8_encode( $value['MESSAGE_V3']) ;
     $RESPUESTA_PEDIDO[$key] =  utf8_encode( $value['MESSAGE_V4']) ;
     $RESPUESTA_PEDIDO[$key] =  utf8_encode( $value['PARAMETER']) ; 
   
     if($value['ID'] =="V1"&& $value['NUMBER'] =="311" && $value['MESSAGE_V2'] != ""){
     $procesado  = true;
    $datos['COD_SAP_GENERADO'] =  $COD_SAP_GENERADO = $value['MESSAGE_V2'];
     $datos['RESPUESTA_PROCESO'] = 'OK';
 }ELSE{
     IF ($CONT_ERROR > 0){
         $SEPARADOR = '/';
     }
        $MENSAJE_ERROR.= $SEPARADOR. utf8_encode( $value['MESSAGE']) ;
        $MENSAJE_ERROR.= '-'. utf8_encode( $value['MESSAGE_V1']);
        $MENSAJE_ERROR.= '-'. utf8_encode( $value['MESSAGE_V2']);
        $MENSAJE_ERROR.= '-'.utf8_encode( $value['MESSAGE_V3']) ;
        $MENSAJE_ERROR.= '-'.utf8_encode( $value['MESSAGE_V4']); 
             $CONT_ERROR++;
 }
 
     }
  
     
     
     
     
     
     
  $datos['DATOS_RFC'] = $RESPUESTA_PEDIDO;
   $datos['CUERPO_HTML_MAIL'] = "";
 if($procesado){   
      try { 
            $estadoInicial = "1";
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();  
             $consulta = $link->prepare("call  sp_crear_editar_pedidos(:_id_pedido_SAP, :_cod_generado_sistema, :_estado, :_usuario)");
             $consulta->bindParam(':_id_pedido_SAP', $COD_SAP_GENERADO);
             $consulta->bindParam(':_cod_generado_sistema', $sol_pedido);
             $consulta->bindParam(':_estado', $estadoInicial);
             $consulta->bindParam(':_usuario', $userActual->getId()); 
             $datos['query2'] ="call  sp_crear_editar_pedidos('$COD_SAP_GENERADO', '$sol_pedido', '$estadoInicial', '{$userActual->getId()}')" ;
             $consulta->execute();
             $conexion = null;
             $array =  $consulta->fetchAll();
             switch ($array[0]['result']){
                case '100':
                case '101':
                $result ='ok';  
                break; 
                case '-2':
                $result ='not ok';  
                break;   
                default :
                    $result = $array[0]['result'];
                break;
             }
            $datos['error'] =  $result;
             } catch (PDOException $e) {
             $datos['error']='Error de conexión - sp_crear_editar_pedidos : ' . $e->getMessage();
             $datos['datos'] =null; 
             echo json_encode($datos);
             return;
        }
        $conexion = null;
     
         if ($_POST['selectORG'] == "MCV")
            $KKBER =  "ACC1";//AREA DE CONTROL 
        if ($_POST['selectORG'] == "ECO")
            $KKBER =  "ACC2";//AREA DE CONTROL 
        $KUNDE = $solicitanteUsuario;//CLIENTE 
        $arreglo =  GET_DATOS_RFC_TESORERIA($KKBER ,$KUNDE);                     
      $TOTAL_PEDIDO = 0;//CAMBIAR CON LA FUNCION QUE GENERA EL TOTAL PEDIDO
      $DISPONIBLE =  $arreglo['DISPO']  * 100;
      $CAR_VENC_TOTAL = $arreglo['CAR_VENC_TOTAL'] * 100;
                IF ($DISPONIBLE < $TOTAL_PEDIDO && $CAR_VENC_TOTAL == 0 ){
                    $NOTA_EXT = "Estimado cliente, con base en su Solicitud de Pedido No.<strong>$sol_pedido</strong>, el sistema nos reporta que Ud. no cuenta con cupo de crédito disponible. Por favor comuníquese con la Gerencia Comercial al teléfono: (5) 3618212. ";
                    $NOTA2 = "El cliente NO tiene Cupo de Crédito.";
                }
                  IF ($DISPONIBLE > $TOTAL_PEDIDO && $CAR_VENC_TOTAL > 0 ){
                      $NOTA_EXT = "Estimado cliente, con base en su Solicitud de Pedido No.<strong>$sol_pedido</strong>, nos permitimos informarle que su estado de cartera presenta facturas vencidas a la fecha. Por favor comuníquese con la Gerencia de Tesorería al teléfono: (5) 3618105.";
                    $NOTA2 = "El cliente presenta Facturas Vencidas.";
                }
                  IF ($DISPONIBLE < $TOTAL_PEDIDO && $CAR_VENC_TOTAL > 0 ){
                      $NOTA_EXT = "Estimado cliente, con base en su Solicitud de Pedido No.<strong>$sol_pedido</strong>, nos permitimos informarle que actualmente Ud. no cuenta con cupo de crédito disponible y, además, su estado de cartera reporta facturas vencidas, por lo cual le agradecemos comunicarse con La Gerencia Comercial al teléfono: (5) 3618212. ";
                    $NOTA2 = "El cliente NO tiene Cupo de Crédito y ademas, presenta Facturas Vencidas.";
                }
        $tableExterior = "";
        $tableInterior = ""; 
       $datos['nota_respuesta']  = $NOTA_EXT ;
       $datos['SENIOR_RESPUESTA']  = $userActual->getFullname(); 
          $Ecof_ui_widget_content=' border: 1px solid #23282D;
    background: #fcfdfd  ;
    color: #505253;
    font-size: 10px';
    $ui_widget_content = '
    border: 1px solid #536675;
    background: #fcfdfd ;
    color: #505253;
     font-size: 10px';
    $mcv_ui_widget_content =' border: 1px solid #23282D;
    background: #fcfdfd ;
    color: #505253;
     font-size: 10px';
    $clase = $id_sitio.'_ui-widget-content';
        for ($i=0;$i<$numFilasInsertadas ; $i++){
            $materia_tmp = $materiales[$i];
            $tableExterior .= "<tr>".
                    "<td style='{$$clase}'>{$materia_tmp['MATERIAL']}</td>".
                    "<td style='{$$clase}'>{$materia_tmp['PRECIO_UNITARIO']}</td>".
                    "<td style='{$$clase}'>{$materia_tmp['CANTIDAD']}</td>".
                    "<td style='{$$clase}'>{$materia_tmp['CENTRO_ALMACEN']}</td>".
                    "</tr>";
            
            
            $tableInterior .= "<tr>".
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$materia_tmp['MATERIAL']}</td>".
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$materia_tmp['PRECIO_UNITARIO']}</td>".
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$materia_tmp['CANTIDAD']}</td>".
                    "<td style=' border: 1px solid  #23282D;  padding: 2px' >{$materia_tmp['CENTRO_ALMACEN']}</td>".
                    "</tr>";
        }   
        $cuerpoMailExterno = reemplazaAcentos(  mail_externo($id_sitio));
        $cuerpoMailInterno = reemplazaAcentos(mail_interno());
       ///reemplazo de datos en el cuerpo del mail externo/////// 
         $cuerpoMailExterno =  str_replace ("%CLIENTE%",reemplazaAcentos($solicitanteUsuarioTXT),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%FECHA%",date('d/m/Y'),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%CATEGORIA%",reemplazaAcentos($_POST['categoria_txt']),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%SOL_PEDIDO%",reemplazaAcentos($sol_pedido),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%ELABORADO_POR%",reemplazaAcentos($userActual->getFullname()) ,$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%COMENTARIOS%",reemplazaAcentos($_POST['COMENTARIOS']),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%NOTA%",$NOTA_EXT,$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%LINEAS_MATERIALES%",$tableExterior,$cuerpoMailExterno);                
       ///reemplazo de datos en el cuerpo del mail interno/////// 
       $datos['CUERPO_HTML_MAIL'] = str_replace ("\n", "",  $cuerpoMailExterno);       
       $cuerpoMailInterno =  str_replace ("%CLIENTE%",reemplazaAcentos($solicitanteUsuarioTXT),$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%SOLICITUD_DE_PEDIDO%",reemplazaAcentos($sol_pedido),$cuerpoMailInterno);//EL GENERADO POR EL SISTEMA
       $cuerpoMailInterno =  str_replace ("%TIPO_DE_PEDIDO%",reemplazaAcentos($_POST['categoria_txt']),$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%USUARIO_CREADOR%",$userActual->getFullname(),$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%COMENTARIOS%",reemplazaAcentos($_POST['COMENTARIOS']),$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%NOTA_RFC%",$NOTA2,$cuerpoMailInterno);
       $cuerpoMailInterno =  str_replace ("%NUM_PEDIDO_SAP%",$COD_SAP_GENERADO,$cuerpoMailInterno);    
       $cuerpoMailInterno =  str_replace ("%LINEAS_MATERIALES%",$tableInterior,$cuerpoMailInterno); 
//       $datos['cuerpoMailInterno'] = $cuerpoMailInterno;
//       $datos['cuerpoMailExterno']= $cuerpoMailExterno;
       
       $cuerpoMailInterno =  reemplazaAcentos( $cuerpoMailInterno );
       $cuerpoMailExterno= reemplazaAcentos( $cuerpoMailExterno );
                
         $titulo = "Pedido $sol_pedido creado por {$userActual->getFullname()}";
         
          if (PHP_OS == 'Linux') {
                    $breakLine = "\n";
                } else {
                    $breakLine = "\r\n";
                }
           
                
     
      $datos['error']='ok'     ; 
       
          $para_interno = $_SESSION["mail"]   ;
         $para_externo = $_SESSION["mail"]   ;
                
           
        $headers = "From: Portar de clientes <noresponder@monomeros.com.co>" . $breakLine;
                $headers .= "Reply-to: <noresponder@monomeros.com.co>\nContent-type: text/html" . $breakLine;
                
        $headers_externo = $headers_interno = $headers;
        //añadir el proceso para envia las copias...        
        //*
        //*
        //*
        //*
        //*
        //*
        //*
        //*
        //*
    
     mail($para_interno, $titulo, $cuerpoMailInterno, $headers_interno);//INTERNO
       mail($para_externo, $titulo, $cuerpoMailExterno, $headers_externo);//EXTERNO
       
       
       
}
ELSE{
    try { 
    $estadoInicial = "1";
    $conexion = Class_php\DataBase::getInstance();
    $link = $conexion->getLink();  
    $consulta = $link->prepare("INSERT INTO log_proceso_pedidos( usuario, resultado, fecha) VALUES('{$userActual->getId()}','{$MENSAJE_ERROR}', CURDATE())");
    $datos['query2'] ="INSERT INTO log_proceso_pedidos( usuario, resultado, fecha) VALUES('{$userActual->getId()}','{$MENSAJE_ERROR}', CURDATE())" ;
    $consulta->execute();
    $conexion = null;
    $datos['error']=$MENSAJE_ERROR;
} catch (PDOException $e) {
    $datos['error']='Error de conexión - INSERTAR DATOS EN EL LOG : ' . $e->getMessage();
    $datos['datos'] =null; 
    echo json_encode($datos);
    return;
}   
}

    break;
    case 'LISTAR_ORDENES_DE_CARGUE':
        $where = '';
        $AND = '';
        if (isset($_POST['CENTRO']) && $_POST['CENTRO'] != ''&& $_POST['CENTRO'] != '%'){
           $where .=  $AND." id_centro = '{$_POST['CENTRO']}' ";
            $AND =' AND ';
        }
         if (  isset($_POST['DESTINATARIO']) && $_POST['DESTINATARIO'] != ''&& $_POST['DESTINATARIO'] != '%'){
            $where .=  $AND." cod_destinataio = '{$_POST['DESTINATARIO']}' ";
            $AND =' AND ';
        }
         if ( isset($_POST['NUM_PEDIDO']) && $_POST['NUM_PEDIDO'] != ''){
            $where .=  $AND." pedido = '{$_POST['NUM_PEDIDO']}' ";
            $AND =' AND ';
        }
         if (isset($_POST['NO_O_CARGUE']) && $_POST['NO_O_CARGUE'] != ''){
            $where .=  $AND." id_cabecera = '{$_POST['NO_O_CARGUE']}' ";
            $AND =' AND ';
        }
         if (isset($_POST['ESTADO']) && $_POST['ESTADO'] != ''){
            $where .=  $AND." estado = '{$_POST['ESTADO']}' ";
            $AND =' AND ';
        }
         if (isset($_POST['FECHA_INICIAL']) && $_POST['FECHA_INICIAL'] != ''){
             $FECHA = ''; 
             $f1= normalize_date($_POST['FECHA_INICIAL'],'-') ;
             if (isset($_POST['FECHA_FINAL']) && $_POST['FECHA_FINAL'] != ''){                
                 $f2= normalize_date($_POST['FECHA_FINAL'],'-') ;
                 $FECHA = "  convert(fecha_registro,date)   BETWEEN '$f1' AND '$f2' ";
             }ELSE{
                 $FECHA = "  convert(fecha_registro,date)   = '$f1' ";
             }
            $where .=  $AND. $FECHA ;
            $AND =' AND ';
        }
       if (   $where != '' ) {$where = ' WHERE '.$where; }        
    try { 
        $estadoInicial = "1";
        $conexion = Class_php\DataBase::getInstance();
        $link = $conexion->getLink();  
        $consulta = $link->prepare("SELECT * FROM clientes.vw_orden_de_carga_detalle $where");
        $datos['query2'] ="SELECT * FROM clientes.vw_orden_de_carga_detalle $where";
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $datos['error']='';
        $datos['datos'] = $registros;
        $datos['filas'] = sizeof( $registros) ;
        $conexion = null;
    } catch (PDOException $e) {
        $datos['error']='Error de conexión - INSERTAR DATOS EN EL LOG : ' . $e->getMessage();
        $datos['datos'] =null; 
        echo json_encode($datos);
        return;
} 
    break;
    
    
    case 'APROBAR_ORDENES_DE_CARGUE':
        $where = '';
        $AND = '';
       
         if (isset($_POST['NO_O_CARGUE'])){
            $where .=  $AND." id_cabecera = '{$_POST['NO_O_CARGUE']}' ";
            $AND =' AND ';
        } 
       if (   $where != '' ) {$where = ' WHERE '.$where; }        
    try { 
        $estadoInicial = "1";
        $conexion = Class_php\DataBase::getInstance();
        $link = $conexion->getLink();  
        $consulta = $link->prepare("SELECT * FROM clientes.vw_orden_de_carga_detalle $where");
        $datos['query2'] ="SELECT * FROM clientes.vw_orden_de_carga_detalle $where";
        $consulta->execute();
        $registros_orden_carga = $consulta->fetchAll();
        $arr_respuesta =  ZMCV_RFC_OCARGUE_ENTREGA($registros_orden_carga);
        if($arr_respuesta['MESSAGE_V2'] != ''){
           $ejecutar = true;
           $cod_remision = $arr_respuesta['MESSAGE_V2'];           
            $query_auditoria = "INSERT INTO `clientes`.`clientes_auditoria_remision` " .
            "(`id_cabecera`, `usuario`,`nom_usuario`,`fecha_aprobacion`,`observacion`)".
            "VALUES ('{$_POST['NO_O_CARGUE']}','{$_SESSION["ID"]}','{$_SESSION["nombreCompleto"]}',now(),'$cod_remision');" ;
        }else{
            $ejecutar = false;
            $query_auditoria = "INSERT INTO `clientes`.`clientes_auditoria_remision` " .
            "(`id_cabecera`, `usuario`,`nom_usuario`,`fecha_aprobacion`,`observacion`)".
            "VALUES ('{$_POST['NO_O_CARGUE']}','{$_SESSION["ID"]}','{$_SESSION["nombreCompleto"]}',now(),'{$arr_respuesta['MESSAGE']}');" ;
                
        }
         $consulta = $link->prepare($query_auditoria);  
           $consulta->execute(); 
        $datos['error']='';
        $datos['datos'] = $arr_respuesta;
        $datos['filas'] = sizeof( $registros) ;
        
        if($ejecutar){ 
            $consulta = $link->prepare("call  `sp_procesar_ordenes_de_carga`( '{$_SESSION["cod_remision"]}', "
                    ."'{$_POST['NO_O_CARGUE']}' , '' , '', '', '','', '' ,'',  '',  '' ,''  ,'' , '' , ''   , "
                    ."'$cod_remision' , ''  , 'APROBAR' );");  
                    
//                    echo "<br>call  `sp_procesar_ordenes_de_carga`( '{$_SESSION["cod_remision"]}', "
//                    ."'{$_POST['NO_O_CARGUE']}' , '' , '', '', '','', '' ,'',  '',  '' ,''  ,'' , '' , ''   , "
//                    ."'$cod_remision' , ''  , 'APROBAR' );<br>";
                    
           $consulta->execute();            
           $array =  $consulta->fetchAll();
            $resultado = $array[0]['result']; 
           if (is_numeric($resultado)){
               $datos['error']='';
           }ELSE{
               $datos['error']=$resultado;
            }              }  
        $conexion = null;
    } catch (PDOException $e) {
        $datos['error']='Error de conexión - INSERTAR DATOS EN EL LOG : ' . $e->getMessage();
        $datos['datos'] =null; 
        echo json_encode($datos);
        return;
} 
    break;
CASE 'RECHAZAR_ORDENES_DE_CARGUE':
        try { 
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();
       $consulta = $link->prepare("call  `sp_procesar_ordenes_de_carga`( '{$_SESSION["cod_remision"]}', '{$_POST['NO_O_CARGUE']}' , '' , '', '', '','', '' ,'',  '',  '' ,''  ,'' , '' , ''   , '' , ''  , 'RECHAZAR' )"); 
    //   echo "call  `sp_procesar_ordenes_de_carga`( '{$_SESSION["cod_remision"]}', '{$_POST['NO_O_CARGUE']}' , '' , '', '', '','', '' ,'',  '',  '' ,''  ,'' , '' , ''   , '' , ''  , 'RECHAZAR' )";
       $consulta->execute(); 
       $array =  $consulta->fetchAll();
       $resultado = $array[0]['result'];
       if (is_numeric($resultado)){
           $datos['error']='';
       }ELSE{
           $datos['error']=$resultado;
       }                
        $conexion = null;
    } catch (PDOException $e) {
        $datos['error']='Error de conexión - CAMBIAR EL ESTADO : ' . $e->getMessage();
        $datos['datos'] =null; 
                
} 
        BREAK;
}

 echo json_encode($datos);