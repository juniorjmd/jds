<?php

namespace  Class_php ;

use PDO;

class DataBase  {
    /*define('DB_TYPE', 'mysql');*/
   private $servidor=   DB_HOST;
   private $usuario=    DB_USER;
   private $password=   DB_PASS;
   private $base_datos= DB_NAME_INICIO;
   private $DB_TYPE = DB_TYPE;
   protected $link;
   private $stmt;
   private $array;
   private $NumDatos;

   static $_instance;

   /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
   private function __construct($servidor=null, $usuario= null,$password=null ,$base_datos = null){
     /*  if (!is_null($servidor)){ $this->servidor=$servidor;}
       if (!is_null($usuario)){$this->usuario=$usuario;}
       if (!is_null($password)){$this->password=$password;}
       if (!is_null($base_datos)){ $this->base_datos = $base_datos;}*/
       
       if (!is_null($servidor)){ $this->servidor=$servidor;}else{
            if ( defined('N_HOST') && trim(N_HOST) != ''  ){
                $this->servidor= N_HOST;
              
            } 
       }
       if (!is_null($usuario)){$this->usuario=$usuario;}else{
            if ( defined('N_USUARIODB') && trim(N_USUARIODB) != ''  ){
                $this->usuario = N_USUARIODB;
            } 
       }
       if (!is_null($password)){$this->password=$password;}else{
            if ( defined('N_CLAVEDB') && trim(N_CLAVEDB) != ''  ){
               $this->password = N_CLAVEDB;
                 
            } 
       }
       if (!is_null($base_datos)){ $this->base_datos = $base_datos;}else{
            if ( defined('N_DATABASE')  && trim(N_DATABASE) != ''  ){
                  $this->base_datos =  N_DATABASE;
            } 
       }
       
       
       
      if ($this->conectar())
      { return true;}else{return false;}
   }

   /*Evitamos el clonaje del objeto. Patrón Singleton*/
   private function __clone(){ }
   
    public  function where($tabla,$where = null){        
       $query = "select * from $tabla $where"; 
       $consulta = $this->link->prepare($query);
         $consulta->execute(); 
         $array =  $consulta->fetchAll();
         return $array;
   }
   public  function truncateTable($tabla){  
       $consulta = $this->link->prepare("call `truncate_table`( :TABLA   )");
      $consulta->bindParam(':TABLA', $tabla); 
         $consulta->execute(); 
         $array =  $consulta->fetchAll();
         return $array;
   }

   /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
   public static function getInstance($servidor=null, $usuario= null,$password=null ,$base_datos = null){
      if (!(self::$_instance instanceof self)){ 
         self::$_instance=new self();
      }
      return self::$_instance;
   }
    public function getLink(){
        return $this->link;
    }
    public function getlastInsertId(){
        return $this->link->lastInsertId() ;
    }
    public function eliminarDato($tabla ,$dato , $columna){
        $consulta = $this->link->prepare("call `sp_eliminar_elemento`(:USER , :TABLA , :DATO , :COLUMNA )");
       // echo "call `sp_eliminar_elemento`('{$_SESSION["usuario_logeado"]}' ,'$tabla', '$dato' , '$columna' )";
         $consulta->bindParam(':USER', $_SESSION["usuario_logeado"] );
         $consulta->bindParam(':TABLA', $tabla);
         $consulta->bindParam(':DATO', $dato);
         $consulta->bindParam(':COLUMNA', $columna);
         $consulta->execute(); 
         $array =  $consulta->fetchAll();
         return $array;
    }
    /*Realiza la conexión a la base de datos.*/
   private function conectar(){
        $CAD =$this->DB_TYPE.':host='.$this->servidor.';dbname='.$this->base_datos;
      $this->link= new PDO( $CAD, $this->usuario ,$this->password  );
      $this->link->query("SET NAMES 'utf8'");
   } 
}