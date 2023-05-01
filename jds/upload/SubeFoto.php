<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () {
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'archivos[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
  
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
//Adicionamos el Link
   nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) {
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>
<style type="text/css">
body {	font: 13px Arial, Helvetica, Sans-serif;}
a{color:#CC9900; font-size:14px";}

</style>
 </head>

 <body bgcolor="#333333" style="color:#CCCC00; padding-left:100px"><div style=" margin-left:70%; "> <a  href="../facebookPaciente.php"    class="nuevolink"  style="color:#CC9900; font-size:14px">Volver a inicio</a></div>
	<h1 >Cargar Imagen</h1>
 <form name="formu" id="formu" action="upload.php" method="post" enctype="multipart/form-data">
     <dl>
   <dt><label>Archivos a Subir:</label></dt>
        <!-- Esta div contendrá todos los campos file que creemos -->
   <dd><div id="adjuntos">
        <!-- Hay que prestar atención a esto, el nombre de este campo debe siempre terminar en []
        como un vector, y ademas debe coincidir con el nombre que se da a los campos nuevos
        en el script -->
   <input type="file" name="archivos[]" /><br />
   </div></dd>
   <dt><a href="#" onClick="addCampo()" class="nuevolink"  style="color:#CC9900; font-size:14px">Subir otro archivo</a></dt>
   <dd><input type="submit" value="Enviar" id="envia" name="envia" /></dd>
     </dl>
</form>
 </body>
</html>
