
/*
function carga_listar(datos_json,funcion,php)
{var php= php|| "php/db_listar.php"
 var cargador = new net.CargadorContenidos(php,funcion,null,"POST",datos_json,"application/x-www-form-urlencoded");
}*/
function carga_listar(datos_json,funcion,php)
{ if(!php){php="php/db_listar.php";}
    //    voteable = (age < 18) ? "Too young":"Old enough";
 var cargador = new net.CargadorContenidos(php,funcion,null,"POST",datos_json,"application/x-www-form-urlencoded");
 
 
}

function carga_insert(datos_json,funcion,php)
{var php= php|| "php/db_carga.php"
    console.log(JSON.stringify(datos_json))
 var cargador = new net.CargadorContenidos(php,funcion,null,"POST",datos_json,"application/x-www-form-urlencoded");
}

function carga_borrarUpdate(datos_json,funcion,php)
{var php= php|| "php/editar_eliminar.php";
 var cargador = new net.CargadorContenidos(php,funcion,null,"POST",datos_json,"application/x-www-form-urlencoded");
}

function carga_crear_id(datos_json,funcion,php)
{var php= php|| "php/crea_id_ai.php";
 var cargador = new net.CargadorContenidos(php,funcion,null,"POST",datos_json,"application/x-www-form-urlencoded");
}