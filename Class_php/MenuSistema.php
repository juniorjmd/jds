<?php
namespace Class_php;

use PDO;

class MenuSistema {
    //atributos
    private $idmenus;
    private $Descripcion;
    private $PadreId;
    private $Icono;
    private $Url;
    private $Orden;
    static private $hijos;
    static private $arrHijos = array();
    static private $arrPadres = array()  ;
    static private $cont_hijos;
    private $Nombre;
    static private $recursosHTML = '';
    static private $arrayHijos ;
    static private $TABLA = 'menus'; 
    static private $tipoNodo; 

//idmenus, Descripcion, PadreId, Icono, Url, Orden, Nombre
    public function __construct($idmenus = null ,  $Nombre = null ,   $Descripcion = null ,     $PadreId = null,     $Icono = null,     $Url = null,$Orden = null) {
        
        $this->idmenus=  is_null($idmenus) ? "" : $idmenus;
        $this->Descripcion=  is_null($Descripcion) ? "" : $Descripcion;
        $this->PadreId=  is_null($PadreId) ? "" :$PadreId;
        $this->Icono=  is_null($Icono) ? "" :$Icono;
        $this->Url=  is_null($Url) ? "" :$Url;
        $this->Nombre =  is_null($Nombre) ? "" :$Nombre;
        $this->Orden=  is_null($Orden) ? "" :$Orden;
    }
   
       public function guardar(){
      try { 
          $conexion =DataBase::getInstance();
            $link = $conexion->getLink();
      if($this->idmenus) /*Modifica*/ {
         $consulta = $link->prepare("call `sp_crear_editar_menu`(:idmenus,:Descripcion,    :PadreId,    :Icono,    :Url,      :nombre, :user  )");
         $consulta->bindParam(':idmenus', $this->idmenus);
         $consulta->bindParam(':Descripcion', $this->Descripcion);
         $consulta->bindParam(':PadreId', $this->PadreId);
         $consulta->bindParam(':Icono', $this->Icono);
         $consulta->bindParam(':Url', $this->Url); 
         $consulta->bindParam(':nombre', $this->Nombre);
         $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
         $consulta->execute(); 
      }else /*Inserta*/ {
          $consulta = $link->prepare("call `sp_crear_editar_menu`('',:Descripcion,    :PadreId,    :Icono,    :Url,  :nombre, :user  )");           
         $consulta->bindParam(':Descripcion', $this->Descripcion);
         $consulta->bindParam(':PadreId', $this->PadreId);
         $consulta->bindParam(':Icono', $this->Icono);
         $consulta->bindParam(':Url', $this->Url); 
         $consulta->bindParam(':nombre', $this->Nombre);
         $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
         $consulta->execute();
         $this->idmenus = $conexion->getlastInsertId();
      }
       $conexion = null;
  
      $array =  $consulta->fetchAll();
           
       switch ($array[0]['result']){
           case '100':
               case '100':
                $result ='ok';  
           break;
           case '-1':
                $result ='not ok';  
           break;           
       }
       return $result;
      } catch (PDOException $e) {
    return 'Error de conexión: ' . $e->getMessage();
    exit;
}
   }
    public function guardarPerfil(  $ID_recurso,$tipoRecurso,$nombreRecurso,$id_sistema,$estado){
      try { 
          $conexion =DataBase::getInstance();
            $link = $conexion->getLink();
      if($ID_recurso && $ID_recurso != '') /*Modifica*/ {
         $consulta = $link->prepare("call `sp_crear_editar_recurso`(:idrecurso, :id_menu, :tipo_recurso, :nombre_recurso, :id_recurso_sistema, :estado, :user  )");
         $consulta->bindParam(':idrecurso', $ID_recurso);
         $consulta->bindParam(':id_menu', $this->idmenus);
         $consulta->bindParam(':tipo_recurso', $tipoRecurso);
         $consulta->bindParam(':nombre_recurso', $nombreRecurso);
         $consulta->bindParam(':id_recurso_sistema', $id_sistema); 
         $consulta->bindParam(':estado', $estado);
         $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
         $consulta->execute(); 
      }else /*Inserta*/ {
         $consulta = $link->prepare("call `sp_crear_editar_recurso`('', :id_menu, :tipo_recurso, :nombre_recurso, :id_recurso_sistema, :estado, :user  )");
           
         $consulta->bindParam(':id_menu', $this->idmenus);
         $consulta->bindParam(':tipo_recurso', $tipoRecurso);
         $consulta->bindParam(':nombre_recurso', $nombreRecurso);
         $consulta->bindParam(':id_recurso_sistema', $id_sistema); 
         $consulta->bindParam(':estado', $estado);
         $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
         $consulta->execute();
      }
           
      $conexion = null;
  
      $array =  $consulta->fetchAll();
           
       switch ($array[0]['result']){
           case '100':
               case '101':
                $result ='ok';  
           break;
           case '-1':
                $result ='not ok';  
           break;           
       }
       return $result;
      } catch (PDOException $e) {
    return 'Error de conexión: ' . $e->getMessage();
    exit;
}
   }
   public function getMenuObjet($idMenu){ 
       $array = self::recuperarTodos('where idmenus = '.$idMenu); 
        $newMenu = null;
       if (!is_null($array)){ 
       $newMenu = self::getInstance($array[0]['idmenus'],
               $array[0]['Nombre'],
               $array[0]['Descripcion'],
               $array[0]['PadreId'],
               $array[0]['Icono'],
               $array[0]['Url'],
               $array[0]['Orden'] 
               );
        }  
        return $newMenu;  
}
    public static function getInstance($idmenus = null ,  $Nombre = null ,   $Descripcion = null ,     $PadreId = null,     $Icono = null,     $Url = null,$Orden = null){
        if (!(self::$_instance instanceof self)){ 
           self::$_instance=new self($idmenus ,  $Nombre ,   $Descripcion  ,     $PadreId ,     $Icono  ,     $Url ,$Orden   );
        }
        return self::$_instance;
   }
   public function recuperarTodos($where = NULL){
        try {                        
            $conexion = DataBase::getInstance();
            $link = $conexion->getLink();
            $consulta = $link->prepare('SELECT * FROM vw_' . self::$TABLA . ' '.$where.' ORDER BY PadreId , idmenus   ');
            $result['query'] = 'SELECT * FROM vw_' . self::$TABLA . ' '.$where.' ORDER BY PadreId , idmenus   ';
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $result['error']='';
            $result['datos'] = $registros;
            $result['filas'] = sizeof( $registros) ;
            return $result ;
        } catch (PDOException $e) {
               $result['error']='Error de conexión: ' . $e->getMessage();
               $result['datos'] =null;
               return $result ;
               exit;
        }
    }
    public function recuperarRecursos($where = NULL){
        try {                        
            $conexion = DataBase::getInstance();
            $link = $conexion->getLink();
            $consulta = $link->prepare('SELECT * FROM  vw_recurso '.$where.' ORDER BY id_menu , nombre_recurso   ');
            $result['query'] = 'SELECT * FROM  vw_recurso '.$where.' ORDER BY id_menu , nombre_recurso   ';
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $result['error']='';
            $result['datos'] = $registros;
            $result['filas'] = sizeof( $registros) ;
            return $result ;
        } catch (PDOException $e) {
               $result['error']='Error de conexión: ' . $e->getMessage();
               $result['datos'] =null;
               return $result ;
               exit;
        }
    }
 
static public function get_id_padre_by_name($nameMenuPadre ){	
         $conexion =DataBase::getInstance();
         $link = $conexion->getLink();
	$query= $link->prepare('SELECT * FROM '. self::$TABLA . " where Nombre = '" .$nameMenuPadre."' ");
	$query->execute(); 
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $idMenu = $row["idmenus"] ;			
	}
	$conexion = null;
	return $idMenu;
}
public function get_html_recursos_by_menu($idMenu){
    self::$recursosHTML = '';
    self::$tipoNodo = 'nodoAbierto';
    self::set_html_recursos_by_menu($idMenu);
    return self::$recursosHTML;
}
private function set_html_recursos_by_menu($idMenu){    
    $array = self::get_recursos($idMenu); 
    $arrayMenus = array();
    if (!is_null($array['datos'])){
        $arrayMenus = $array['datos'];
        self::$tipoNodo = 'nodoAbierto';
        self::$recursosHTML = str_replace(':nodo:','nodoAbierto', self::$recursosHTML );
    }   else{
        self::$recursosHTML = str_replace(':nodo:','nodoHijo', self::$recursosHTML );
    }
    self::$recursosHTML.= '<ul class="nodos">';
    foreach ($arrayMenus as $key => $value) {  
       // self::$recursosHTML = str_replace(':clasehijo:','nodoHijo', self::$recursosHTML ); 
         self::$recursosHTML .="<li class=':nodo:' id='menu_{$value['id_recurso_sistema']}'>"
        . "<input type='checkbox' data-tipo='recurso' data-recurso_id='{$value['idrecurso']}' class='menu_{$value['id_recurso_sistema']}'  />"
        . "<span>{$value['nombre_recurso']}</span>"; 
       // self::$recursosHTML .= "<li>{$value['nombre_recurso']} ";
        if ($value['tipo_recurso']  == '1')
          { self::set_html_recursos_by_menu($value['id_recurso_sistema']  );
            
          }else{
              self::$recursosHTML = str_replace(':nodo:','nodoHijo', self::$recursosHTML );
          }
        self::$recursosHTML .= "</li> ";
    } 
   // self::$recursosHTML = str_replace('nodoAbierto','nodoHijo', self::$recursosHTML ); 
    self::$recursosHTML.= '</ul>';
}

private function get_recursos($idMenu = null ){	
         $idMenu = is_null($idMenu)? '':  "where id_menu = '" .$idMenu."'";  
        try {                        
            $conexion = DataBase::getInstance();
            $link = $conexion->getLink();
            $consulta = $link->prepare("SELECT * FROM vw_recurso  " .$idMenu ." order by id_recurso_sistema" );
            $result['query'] = "SELECT * FROM vw_recurso  " .$idMenu ;
            //echo "<br>{$result['query']}";
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $result['error']='';
            $result['datos'] = $registros;
            $result['filas'] = sizeof( $registros) ;
            return $result ;
        } catch (PDOException $e) {
               $result['error']='Error de conexión: ' . $e->getMessage();
               $result['datos'] =null;
               return $result ;
               exit;
        }
           
        
}

private function set_array_son($menuPadre  ){
    $array = self::recuperarTodos('where PadreId = '.$menuPadre); 
            $arrayMenus = array();
        if (!is_null($array['datos'])){
            $arrayMenus = $array['datos'];
        }           
        foreach ($arrayMenus as $key => $value) { 
            array_push( self::$arrayHijos ,$value['idmenus']);
            self::set_array_son($value['idmenus']  );
        } 
}
public function get_array_son($menuPadre){
    self::$arrayHijos = array();
    self::set_array_son($menuPadre);
    return self::$arrayHijos;
}

public function get_menus_no_child($menuPadre){
    $where = ' where idmenus <> '.$menuPadre;
    $array = self::recuperarTodos($where); 
    $arrayMenus = $array['datos'];
    $arrayVer = self::get_array_son($menuPadre);
     $filas = 0;
    foreach ($arrayMenus as $key => $value) {
         
      if(  !in_array($value['idmenus'],$arrayVer)){
            $arrayFinal[$filas] = $value ;
             $filas++;
            }
        }
    $array['datos'] = $arrayFinal;    
    $array['filas'] = $filas;
    return  $array  ;
}
public function Crea_descripcion_menu($menuPadre,$tipo_menu){	 
        $arrayMenus = array();
	$menuGenerado = "<table>";
        $array = self::recuperarTodos('where idmenus = '.$menuPadre); 
        if (!is_null($array['datos'])){
            $arrayMenus = $array['datos'];
        }//else{echo $result['error'];}      
           
        self::Agregar_descripcion_hijo($menuPadre, $tipo_menu); 
}
private function Agregar_descripcion_hijo($menuPadre  ,$tipo_menu)
{   
    $array = self::recuperarTodos('where PadreId = '.$menuPadre);
    $arrayMenus = array();
    $arrayMenus  = $array['datos'];
    //print_r($arrayMenus);
        
        if (!is_null($arrayMenus) && sizeof($arrayMenus)> 0){
            foreach ($arrayMenus as $key => $value) { 
            if (in_array($value['idmenus'], $tipo_menu)) {
                $arrayAux = self::recuperarTodos('where PadreId = '.$value['idmenus']);
                 //echo sizeof($arrayAux); 
                if(!is_null($arrayAux) &&  $arrayAux['filas'] > 0){
                    ?><p> En la sección de  <strong><?php echo $value['Nombre'] ;?></strong>, utilice los enlaces disponibles así:</p><ul> <?php
                 self::Agregar_descripcion_hijo($value['idmenus'],$tipo_menu );
                ?> </ul> <?php }
                else{
                    ?><li> <strong><?php echo $value['Nombre'] ;?></strong>, <?php echo $value['Descripcion'] ;?> </li><?php
                }
                
             }
            }
        }
}


public function Crea_menu($menuPadre,$tipo_menu){	 
        $arrayMenus = array();
	$menuGenerado = "<table>";
        $array = self::recuperarTodos('where idmenus = '.$menuPadre); 
        if (!is_null($array['datos'])){
            $arrayMenus = $array['datos'];
        }//else{echo $result['error'];}      
        foreach ($arrayMenus as $key => $value) { 
           // $menuGenerado .= '<tr><td class="moduloTitle_principal">'.$value["Nombre"].'</td></tr>';	
        }
        self::Agregar_hijo($menuPadre, $tipo_menu);
	$menuGenerado .=self::$hijos;
	self::$hijos = '';
	$menuGenerado .= '</table>'; 
	return $menuGenerado;
}
private function Agregar_hijo($menuPadre  ,$tipo_menu)
{   $array = self::recuperarTodos('where PadreId = '.$menuPadre);
        $arrayMenus = array();
        if (!is_null($array['datos'])){
            $arrayMenus = $array['datos'];
            if (sizeof($arrayMenus)>0){
                self::$hijos = str_replace(':CLASS',trim($_SESSION["style"]).'_menu-level-1',self::$hijos);
               // self::$hijos = str_replace(':HREF','',self::$hijos);
            }else{ self::$hijos = str_replace(':CLASS','menu-level-2',self::$hijos);
                 //   self::$hijos = str_replace(':HREF','#',self::$hijos);
            }
        }else{
            echo $result['error'];
            self::$hijos = str_replace(':CLASS','menu-level-2',self::$hijos);
            // self::$hijos = str_replace(':HREF','#',self::$hijos);
            
        }            
        foreach ($arrayMenus as $key => $value) { 
            if (in_array($value['idmenus'], $tipo_menu)) {
                self::$hijos .= '<tr><td class="menuHijo" data-url="'.$value["Url"].'"> <em class=":CLASS">'.$value["Nombre"].' </em></td></tr>'; 
                self::$hijos.= self::Agregar_hijo($value['idmenus'],$tipo_menu );
             }
        }
     
}

public function Crea_menu_2($menuPadre,$tipo_menu){	 
        $arrayMenus = array();
	//$menuGenerado = '<div class="accordion" id="accordionExample">';
        $array = self::recuperarTodos('where PadreId = '.$menuPadre); 
        if (!is_null($array['datos'])){
            $arrayMenus = $array['datos'];
        }//else{echo $result['error'];}    
        $padreConHijos =  array();
        foreach ($arrayMenus as $key => $value) {  
            if ( in_array($value['idmenus'], $tipo_menu) ){
                $arrHijos = self::getHijosMenu($value['idmenus']  ,$tipo_menu );
                $padreConHijos[$value['Nombre']] = $arrHijos ;
            }
        } 
        $menuGenerado = '';
        $cont_hijos = 0; 
        $open = 'show'; 
        $hijosQueSonPadre = array();
        foreach ($padreConHijos as $auxPadre => $auxHijos) {
            
            $cont_hijos++; 
            
            $menuGenerado .= '<div class="card" style=" border-bottom-width: 0px; ">'  
                        .'<div class=" btn-primary card-header " id="headingOne"   data-toggle="collapse" data-target="#collapse'.$cont_hijos.'" aria-expanded="true" aria-controls="collapse'.$cont_hijos.'">'
                        .$auxPadre 
                        .' </div>'
                        . '<div id="collapse'.$cont_hijos.'" class="collapse '.$open.'" aria-labelledby="headingOne" 
                            data-parent="#navbarSupportedContent2"><div class="card-body">
                            <ul style=" padding-left: 0px;">';
            foreach ($auxHijos as $auxHijo ){
                if (trim($auxHijo["Url"]) == ''){
                    $arrHijos2 = array();
                    $arrHijos2 = self::getHijosMenu($auxHijo['idmenus']  ,$tipo_menu );
                   $hijosQueSonPadre[$auxHijo['Nombre']] = $arrHijos2 ;
                }else{
                $menuGenerado .= '<li><a href="#"  class="menuHijo" data-url="'.$auxHijo["Url"].'" >'
                                 .$auxHijo["Nombre"].'</a></li>'; 
            } 
            
                }
            
            
            
            $_hijosQueSonPadre = $hijosQueSonPadre;
            if (sizeof($hijosQueSonPadre)>0){
                $hijosQueSonPadre = array();
                foreach ( $_hijosQueSonPadre as $auxPadre => $auxHijos ) 
                    { 
                    $menuGenerado .= '<hr><li>' .$auxPadre   . '<ul style=" padding-left: 5px;">';
                    foreach ($auxHijos as $auxHijo ){
                        if (trim($auxHijo["Url"]) == ''){
                            $arrHijos2 = array();
                            $arrHijos2 = self::getHijosMenu($auxHijo['idmenus']  ,$tipo_menu );
                           $hijosQueSonPadre[$auxHijo['Nombre']] = $arrHijos2 ;
                        }else{
                        $menuGenerado .= '<li><a href="#"  class="menuHijo" data-url="'.$auxHijo["Url"].'" >'
                                         .$auxHijo["Nombre"].'</a></li>'; 
                    } 

                        }

                    $menuGenerado .= '</ul> </li>';

                    $open = '';  
            }}
            $menuGenerado .= '</ul></div>';
            $menuGenerado .= '</div></div>';
            
            $open = '';  
           }
           return $menuGenerado;
}

private function getHijosMenu($menuPadre  ,$tipo_menu ){
     $array = self::recuperarTodos('where PadreId = '.$menuPadre);
        $arrayMenus = array();
        $Hijos = array();
        if (!is_null($array['datos'])){            
            $arrayMenus = $array['datos'];
        } 
        $i =0 ;
        foreach ($arrayMenus as   $value) { 
             if ( in_array($value['idmenus'], $tipo_menu) ){
               $numHijos = 0 ;  
               $Hijos[$i] =  $value;
               
               $i++;
             }
        }
    return $Hijos;
}

private function Agregar_hijo_2($menuPadre  ,$tipo_menu )
{   $array = self::recuperarTodos('where PadreId = '.$menuPadre);
        $arrayMenus = array();
        if (!is_null($array['datos'])){            
            $arrayMenus = $array['datos'];
        }           
        foreach ($arrayMenus as   $value) { 
             $url = trim($value["Url"]);
            if ( in_array($value['idmenus'], $tipo_menu) ) {
                if ( $url === '' )
                    {
                self::$cont_hijos++;
                self::$hijos .= '<div class="card">'  
                        .'<div class="card-header" id="headingOne">'
                        .'<h2 class="mb-0">'
                        .'<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne'.self::$cont_hijos.'" aria-expanded="true" aria-controls="collapseOne">'
                        .$value["Nombre"]
                        .'</button>'
                        .'</h2></div>'
                        . '<div id="collapseOne'.self::$cont_hijos.'" class="collapse show" aria-labelledby="headingOne" 
                            data-parent="#navbarSupportedContent2"><div class="card-body">
                            <ul class="nav bd-sidenav">';
                self::Agregar_hijo_2($value['idmenus'],$tipo_menu );
                self::$hijos .= '</ul></div></div>';
                }
                        
                else{
                    self::$hijos .= '<li><a href="#" class="menuHijo" data-url="'.$value["Url"].'" >'
                                 .$value["Nombre"].'</a></li>';
                } 
                
                 
           
             }
        }
     
}

public function eliminarMenu()
    {self::$arrayHijos = array();
     self::set_array_son($this->idmenus);
     if (sizeof(self::$arrayHijos)==0) {
    TRY {
       $conexion =DataBase::getInstance(); 
      $_result =$conexion->eliminarDato(self::$TABLA,  $this->idmenus,'idmenus');
      switch ($_result[0]['result']){
           case '100':
                $result ='ok';  
           break;
           case '-1':
                $result ='_table';  
           break;   
           case '-2':
                $result ='_dato';  
           break;   
           case '-3':
                $result ='_COLUMNA';  
           break;   
       default :
                $result = $_result[0]['result'];
           break;
       }
      } catch (PDOException $e) {
        return 'Error de conexión: ' . $e->getMessage();
        exit;
     }}else{$result = 'No se puede eliminar el menú ya que posee otros menús hijos';}
     return $result;
    }
        
}
