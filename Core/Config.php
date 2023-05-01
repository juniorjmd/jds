<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of config
 *
 * @author jdominguez
 */
class Config {
    //put your code here
    public function __construct() { 
        // Desactivar toda notificación de error
        //error_reporting(0);

// Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE);

        date_default_timezone_set("America/Bogota"); 
        define('DB_TYPE', 'mysql');          
      
        
        // echo 'si esta';
        define('PASS_INICIAL','jds_pass1');  
        //definicion  de coneccion a SAP 
       
        //define('URL_BASE','http://jds_mc.web'  );
        
                /*local*/
         if ( strtoupper($_SERVER['HTTP_HOST'])=='LOCALHOST')   {
        define('DB_HOST', 'localhost'); 
        define('DB_NAME_INICIO', 'jds_mc_20180708');         
        define('DB_USER', 'root');
        define('DB_PASS', 'juniorjmd');
        define('URL_BASE','https://localhost/mad_colombia/'  );        
        define('NOMBRE_SESSION','jds2020_PRINCIPAL_LOCAL'  );
         /*local*/
        }ELSE{
        /*web*/            
        define('DB_HOST', 'jdpsoluciones.com'); 
        define('DB_NAME_INICIO', 'jdpsoluc_jds_dm_4');         
        define('DB_USER', 'jdpsoluc_database');
        define('DB_PASS', 'prom2001josdom');
        define('URL_BASE','https://jds.dev.jdpsoluciones.com/');
        define('NOMBRE_SESSION','jds2020_PRINCIPAL_LOCAL'  );
         /*web*/
        
       }
        DEFINE("LOGO_USUARIO1", URL_BASE."/images/jds_ico.png");
        define("SERV_CORREO","");        
        //define ('PHP_OS', "Windows");
        ini_set('session_save_path', '/home/'.NOMBRE_SESSION.'/tmp');
        session_name(NOMBRE_SESSION);
        if(@session_start() == false){session_destroy();session_start(); }ELSE{
            
            foreach ($_SESSION as $key => $value) {
                IF (trim($key) !== 'pass')
                define(strtoupper($key) ,$value)  ;
            }
           
        }
        
    }
}
