function cargaContinsert(funcion) {//empieza la peticion del ajax
datos_json=cargaDatos();
//alert(datos_json);
carga_insert(datos_json,funcion)

}




function verifica(a,b){
var c=a/b;
c=c.toString();
if (c.indexOf(".") != -1) 
{var p= c.substring(0,c.indexOf("."));
var i=parseInt(p);
return i+1;}
else
{return c;}
} 

//carga_revisar("grupos","id_grupo",id_grupo,modificarId)

function revisarIdKeyup(idKeyup,funcionRespuesta,tabla,columna,idAdicional){//esta funcion le carga a un imput para que se revise su existencia dentro de una base de datos cada ves que este sea digitado
	$(idKeyup).keyup(function (){
		var id_grupo2= $(this).get(0).value;
		if (idAdicional){
		var id_grupo1=document.getElementById(idAdicional).innerHTML;}
		else{var id_grupo1="";}
		var id_grupo=id_grupo2+id_grupo1;
		if(Trim(id_grupo2)==""){
		$(this).focus();
		}
		else{		
		carga_revisar(tabla,columna,id_grupo,funcionRespuesta);}
		});}
		
	

function carga_revisar(tabla,columna,dato,resp_revisar){
var respuesta="verificar";
datos_json= "respuesta=" + encodeURIComponent(respuesta) +
"&tabla=" + encodeURIComponent(tabla) +
"&columna=" + encodeURIComponent(columna) +
"&dato=" + encodeURIComponent(dato) +
"&nocache=" + Math.random();
 carga_crear_id(datos_json,resp_revisar)
}


function asignar(help,top,exploradorTablas){//donde help es a la cual se le va a aplicar la funcion click e (i) es el id de quien llama la funcion
 $(help).click(function (){
				var p=document.getElementById(this.id).id; 
				
				var corte=3+exploradorTablas.length;
				
				var i=parseInt(p.substring(corte));
				document.getElementById(exploradorTablas).value=i;
				for (h=1;h<=top;h++)//donde top es el numero de listas q se van a mostrar 
				{
				var id1=exploradorTablas+h;
				
				var p1=document.getElementById(id1); 
				if (navigator.appName == "Netscape"){ 
				p1.setAttribute('style','display:none'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				p1.style.setAttribute('display','none'); 
						} 
				}
				var p=document.getElementById(this.id);
				id1=exploradorTablas+i;
			
				var p2=document.getElementById(id1); 
				if (navigator.appName == "Netscape"){ 
				p2.setAttribute('style','display:inline'); 
				p.setAttribute('style','color:#CC0000');
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				p2.style.setAttribute('display','inline'); 
				p.style.setAttribute('color','#CC0000'); 
						} 
			})

}

function adelante(help,top,exploradorTablas)

{$(help).click(function (){
	var tope=parseInt(document.getElementById(exploradorTablas).value);
	if (tope<top)
	{tope=tope+1;
	var i="lb_"+exploradorTablas+tope;
	
	var p2=document.getElementById(i); 
			if (navigator.appName == "Netscape"){ 
			p2.setAttribute('style','color:#CC0000');
			} 
			else if (navigator.appName.indexOf("Explorer") != -1) { 
				p2.style.setAttribute('color','#CC0000');
			}
		for (h=1;h<=top;h++)//donde top es el numero de listas q se van a mostrar 
				{
				var id1=exploradorTablas+h;
				var p1=document.getElementById(id1); 
				if (navigator.appName == "Netscape"){ 
				p1.setAttribute('style','display:none'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				p1.style.setAttribute('display','none'); 
						} 
				}
	 
	document.getElementById(exploradorTablas).value=tope;
	var id2=exploradorTablas+tope;
	
	var p2=document.getElementById(id2); 
				if (navigator.appName == "Netscape"){ 
				p2.setAttribute('style','display:inline'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				p2.style.setAttribute('display','inline'); 
						} 
	
	}
	})	
	}
	
	
	function atras(help,top,exploradorTablas)

{$(help).click(function (){
	var tope=parseInt(document.getElementById(exploradorTablas).value);
	if (1<tope)
	{tope=tope-1;
	var i="lb_"+exploradorTablas+tope;
	var p2=document.getElementById(i); 
			if (navigator.appName == "Netscape"){ 
			p2.setAttribute('style','color:#CC0000');
			} 
			else if (navigator.appName.indexOf("Explorer") != -1) { 
				p2.style.setAttribute('color','#CC0000');
			}
		for (h=1;h<=top;h++)//donde top es el numero de listas q se van a mostrar 
				{var id1=exploradorTablas+h;
				var p1=document.getElementById(id1); 
				if (navigator.appName == "Netscape"){ 
				p1.setAttribute('style','display:none'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				p1.style.setAttribute('display','none'); 
						} 
				}
	 
	document.getElementById(exploradorTablas).value=tope;
	id1=exploradorTablas+tope;
	var p2=document.getElementById(id1); 
				if (navigator.appName == "Netscape"){ 
				p2.setAttribute('style','display:inline'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				p2.style.setAttribute('display','inline'); 
						} 
	
	}
	
	})	
	}
	
	//////////////////////////////funcion final que se encarga del proceso de edicion o borrado y del llamado al servidor con los datos a borrar o editar/////////////////////////////////////
function edirtar_borrar_linea(help)
{$(help).click(function (){
	var llamado=document.getElementById("llamado").value
	var id_busqueda=document.getElementById(llamado).value
	if(Trim(id_busqueda)==""){
			//alert("El ID se encuentra vacio... copie un dato para realizar la busqueda");
			$("input[id='cancel_edit']").trigger('click');
			document.getElementById(llamado).focus();
		}
	else{
		var confirmar= confirm("desea continuar");
	if(confirmar)
	{var p =document.getElementById("llamado").value;
	var p2 =document.getElementById("posicion").value;
		var opc=p.substring((p.length-2),0);
		var nomData = p.substring((p.length-1),0);
		var query;
		var funcion;
		if (Trim(opc)=='elimina')
		{var confirmar= confirm("la operacion a realizar conlleva a la perdida \nde informacion que será irecuperable mas adelante. \nesta completamente seguro que desea eliminar estos datos");}
		if(confirmar)
		{
		switch(p2){
			case  'sucursales':
				nombresColumnas=['nombre_suc','tel1','tel2','w_site','w_cam','dir','id_suc'];
				var dato = generaQueryEdit (opc,p2,nombresColumnas,nomData)
				if (Trim(opc)=='elimina')
				{query=" DROP TABLE `"+dato+"in`, `"+dato+"inventario`, `"+dato+"lin`, `"+dato+"lout`, `"+dato+"out`;";
				//alert (query);
				var datos_json=	"query=" + encodeURIComponent(query)+"&llamado=" +encodeURIComponent(opc)+"&nocache=" + Math.random();
				carga_borrarUpdate(datos_json,respuesta_limpiaTabla);}
				break;
				
			case  'grupos':
			nombresColumnas=['nom_gr','descripcion','id_grupo'];
				var dato = generaQueryEdit (opc,p2,nombresColumnas,nomData)
				break;
				
				
				case  'material':
			nombresColumnas=['nombre','descripcion','id_mate'];
				var dato = generaQueryEdit (opc,p2,nombresColumnas,nomData)
				break;
		}}
		 
	
	}
		}
	
})
						 
}

function generaQueryEdit (opc,tabla,nombresColumnas,nomData)
{var columnasNum=nombresColumnas.length-1;
	switch(Trim(opc)){
					case  'edit':
					var call
					var dato=new  Array();
					var ii=2;
					
					var query="columnasNum=" + encodeURIComponent(columnasNum)+"&";  
					
					//alert (columnasNum);
					for(i=0;i<columnasNum;i++){
						call =nomData+ii;
						//var call ="edit_"+ii;
						ii=ii+1;
						
					query=query+nombresColumnas[i]+"=" + encodeURIComponent(document.getElementById(call).value)+"&";  
						query=query+"nomCol"+i+"="+nombresColumnas[i]+"&"
						}
						//alert (query);
						call =nomData+'1';	
						dato=document.getElementById(call).value;
					var columna= nombresColumnas[columnasNum];
					reinicia(opc,parseInt(nombresColumnas.length),"lb",parseInt(nombresColumnas.length));
				
					
					break;
					case  'elimina':
					query="";
					nomData=nomData+'1';
					var dato =document.getElementById(nomData).value;
					var columna=nombresColumnas[columnasNum];
					reinicia(opc,1,"lb",parseInt(nombresColumnas.length));
					break;}
					var datos_json=	query+"tabla=" + encodeURIComponent(tabla)+
					"&columna="+encodeURIComponent(columna)+
					"&dato="+encodeURIComponent(dato)+
					"&llamado="+encodeURIComponent(opc)+"&nocache=" + Math.random();
						//alert(datos_json);
					carga_borrarUpdate(datos_json,respuesta_edicio_final);
					return dato;
	}


function ED_busqueda_res_suc()
{var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
var dato;
var texto="  ";
var p =document.getElementById("llamado").value;
var opc=p.substring((p.length-2),0);	

if (num_filas>0){
	nombresColumnas=['nombre_suc','tel1','tel2','w_site','w_cam','dir'];
	llenaFormularios(nombresColumnas,objeto_json);
	
	}
else{
texto="no existe nigun dato registrado bajo ese ID ";
	}
	if (Trim(opc)=='elimina')
			{$("#drText").html(texto);}
			if (Trim(opc)=='edit')
			{$("#editLabel").html(texto);}
	
	}
	
function ED_busqueda_res_grp()
{var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
var dato;
var texto="  ";
var disabled="disabled";
var p =document.getElementById("llamado").value;
var opc=p.substring((p.length-2),0);	
if (num_filas>0){
	nombresColumnas=['nom_gr','descripcion'];
	llenaFormularios(nombresColumnas,objeto_json);
 disabled="";
	}
else{
		texto="no existe nigun dato registrado bajo ese ID ";
			reinicia("elimina",0,"lb",3);
			reinicia("edit",0,"lb",3);
		}
			
		var f =document.getElementById("llamado").value;
		var llamado=f.substring((p.length-2),0);	
		var id="input[id='"+llamado+"']";
			$(id).attr('disabled', disabled);
		if (Trim(opc)=='elimina')
			{$("#drText").html(texto);
		
			}
			if (Trim(opc)=='edit')
			{$("#editLabel").html(texto);
			
			}
	}	
	
function ED_busqueda_res_mat()
{var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
var dato;
var texto="  ";
var disabled="disabled";
var p =document.getElementById("llamado").value;
var opc=p.substring((p.length-2),0);	
if (num_filas>0){
	nombresColumnas=['nombre','descripcion'];
	llenaFormularios(nombresColumnas,objeto_json);
	var disabled="";
	}
else{
texto="no existe nigun dato registrado bajo ese ID ";
		}
			var f =document.getElementById("llamado").value;
		var llamado=f.substring((p.length-2),0);	
		var id="input[id='"+llamado+"']";
			$(id).attr('disabled', disabled);
	if (Trim(opc)=='elimina')
			{$("#drText").html(texto);}
			if (Trim(opc)=='edit')
			{$("#editLabel").html(texto);}
	
	}	
	
function llenaFormularios(nombresColumnas,objeto_json)
{
var numColumnas = nombresColumnas.length;
var h=2;
	for (var i=0;i<numColumnas;i++)
		{var llamado=document.getElementById('llamado2').value;
		var id_;
		var nomColumna = nombresColumnas[i];
		dato=objeto_json.datos[0][nomColumna];
		id_=llamado+h;
		document.getElementById(id_).innerHTML=dato;
		h=h+1;
				}
		var p =document.getElementById("llamado").value;
		llamado=p.substring((p.length-2),0);
			var id="input[id='"+llamado+"']";
			
		edirtar_borrar_linea(id);

}
		
function inicio_busqueda(NumColumnas,NameDivList,NameDivIndice,w_tabla){
	limpia_linea(NameDivList,NameDivIndice);
	var tabla2=document.getElementById(w_tabla);
	var tr=tabla2.rows[0];
	var tabla = document.createElement("table");	
	tabla.setAttribute('width',tabla2.width);
	var elmTBODY=document.createElement("tbody");
	var help =1;
	var color;
	
	var td_w
	 for (var i=0; i<10; i++) {
		 if (help==1)
		 {color="#E5E5E5";
			 help=help+1;}
		 else
		 {help=help-1;
		 color="#A4C9F2";}
		 var dato="  ";
		 elmTR = elmTBODY.insertRow(i);

if (navigator.appName == "Netscape"){ 
				elmTR.setAttribute('style','bgcolor:'+color);
 
			} 
			else if (navigator.appName.indexOf("Explorer") != -1) { 
 elmTR.style.setAttribute('bgcolor',color);
				} 

		
         elmTD = elmTR.insertCell(0);
       	 elmText = document.createTextNode(dato);
			if(i==0)
			{
			elmTD.setAttribute('width','100%');}
			
			elmTD.setAttribute('height','17');
        	elmTD.appendChild(elmText);}
		tabla.appendChild(elmTBODY);
	
		var div_list= document.getElementById(NameDivList); 
		div_list.appendChild(tabla);
	
	}
	
function carga_busqueda_E_D(columna,tabla,dato,funcion,respuesta){
	var datos_json = "tabla="+ encodeURIComponent(tabla) +
	"&columna=" + encodeURIComponent(columna) +
	"&dato=" + encodeURIComponent(dato) +
	"&iqual=" + encodeURIComponent(true) +
	"&respuesta=" + encodeURIComponent(respuesta) +
	"&nocache=" + Math.random();
	
	//alert (datos_json)

		carga_listar(datos_json,funcion,"php/dbListarBusqueda.php");
	
}
	
	
function procesa_leave(id,columna,tabla,funcion,respuesta)
	{$(id).keyup(function (){						  
	var id_busqueda=document.getElementById(this.id).value;
	var id_2=this.id;
	if(Trim(id_busqueda)==""){
			//alert("El ID se encuentra vacio... copie un dato para realizar la busqueda");
			document.getElementById(id_2).focus();
			var texto=" ";
			$("#informe").html(texto);	

		}
	else{
		carga_busqueda_E_D(columna,tabla,Trim(id_busqueda),funcion,respuesta)
		}
	});}
	
	function busqueda(funcion,tabla,columna,dato,igual)
	{iqual=igual||null;
		var datos_json = "tabla=" + encodeURIComponent(tabla) +
	"&columna=" + encodeURIComponent(columna) +
	"&dato=" + encodeURIComponent(dato) +
	"&iqual=" + encodeURIComponent(iqual) +
	"&nocache=" + Math.random();
		carga_listar(datos_json,funcion,"php/dbListarBusqueda.php");
	}
	
	
	
	function respuesta_edicio_final()
	{
		var respuesta_json = this.req.responseText;
		alert(respuesta_json);
		$("input[id='cancel_edit']").trigger('click');
		}
	
	function respuesta_limpiaTabla()
	{
		var respuesta_json = this.req.responseText;
		
		}
	
	function limpia_linea(list,indice)
{

var nuevoDiv=document.createElement("div");////aqui borro el div tablas existente y lo reemplazo con uno nuevo donde se va a colocar las nuevas tablas
var borraDiv= document.getElementById(list);
var newAttrdiv = document.createAttribute("id");
newAttrdiv.nodeValue = list;
nuevoDiv.setAttributeNode(newAttrdiv);
borraDiv.parentNode.replaceChild(nuevoDiv, borraDiv);

nuevoDiv=document.createElement("div");////aqui borro el div tablas existente y lo reemplazo con uno nuevo donde se va a colocar las nuevas tablas
borraDiv= document.getElementById(indice);
newAttrdiv = document.createAttribute("id");
newAttrdiv.nodeValue = indice;
nuevoDiv.setAttributeNode(newAttrdiv);
newAttrdiv = document.createAttribute("align");
newAttrdiv.nodeValue = "center";
nuevoDiv.setAttributeNode(newAttrdiv);
borraDiv.parentNode.replaceChild(nuevoDiv, borraDiv);
	}
	
	
	
	

function listaDatos(funcion,tabla,columna,tablasLista,indiceLista,PHP,dato1,dato2,dato3){
	tablasLista=tablasLista||'tablasLista';
	indiceLista=indiceLista||'indiceLista';
	limpia_linea(tablasLista,indiceLista);
		if(!PHP){
		if(columna)	{
		query ="SELECT * FROM "+tabla+" ORDER BY  `"+columna+"` DESC " ;
		}else{query ="SELECT * FROM "+tabla ;}
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();}
		
		else{
			var datos_json = "tabla=" + encodeURIComponent(tabla) +
		"&columna=" + encodeURIComponent(columna) +
		"&dato1=" + encodeURIComponent(dato1) +
		"&dato2=" + encodeURIComponent(dato2) +
		"&dato3=" + encodeURIComponent(dato3) +
		"&nocache=" + Math.random();
			}
		//alert (datos_json)
		carga_listar(datos_json,funcion,PHP);




}

	
	