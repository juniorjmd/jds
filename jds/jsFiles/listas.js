 
let formatoMoneda = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
};
 
let T_find = new Object();

T_find.CargadorContenidos = function(objeto_json,encabezados,exploradorTablas,NameDivList,NameDivIndex,wTabla,num_inicio,num_intervalos,elimina_id,dirEliminar,edit_id,dirEditar,funcion,dirlink,funcion2,funcion3,orden,title) {	
this.wTabla = wTabla;//id de la tabla cabecera del listado para obtener el ancho de cada celda
this.num_inicio = num_inicio;//hace referencia a si la tabla tiene o no dos imagenes de eliminado y editado su valor es 0 o 2
this.NameDivList = NameDivList;//este hace referencias a al nombre del div donde va la lista...
this.NameDivIndex = NameDivIndex;//este hace referencias a al nombre del div donde van los indices para recorer las listas...
this.objeto_json = objeto_json;//es el resultado de la consulta a la base de datos ya pasado a Json
this.num_intervalos = num_intervalos;//cuantas filas por tabla se van a mostrar... si de 10 en 10 o 20 en 20 su valor es un numero entero
this.exploradorTablas = exploradorTablas;
this.eliminaId="#"+elimina_id
this.encabezados=encabezados;
this.numCabezas=encabezados.length;
this.top;
this.dirEliminar;
this.NdirEliminar
this.edit_id;
this.editId;
this.dirEditar;
this.NdirEditar;
this.num_filas;
this.elmTBODY; 
this.elmTR;
this.elmTD;
this.elmText;
this.datoProcesar;
this.orden;
this.AuxTitle
this.title=title;
this.onload = funcion;
this.dirlink=dirlink;
this.funcion2=funcion2;
this.funcion3=funcion3;
this.datosParaEnvio;
this.cargador_tabla(objeto_json, dirEliminar, edit_id, dirEditar,orden);

}

T_find.CargadorContenidos.prototype = {
	
cargador_tabla: function(objeto_json,dirEliminar,edit_id,dirEditar,orden )	
{
if(orden)
{this.orden=this.objeto_json.datos[0][orden];
this.exploradorTablas=this.orden+this.exploradorTablas;
	}else{this.orden=false;}
if(document.getElementById(this.exploradorTablas))
{var p=document.getElementById(this.exploradorTablas);
document.body.removeChild(p);
//alert("se quito");
}

var exploradorTablasId=this.exploradorTablas;
var exploradorTablas = document.createElement("hidden");
var newAttr2 = document.createAttribute("id");

newAttr2.nodeValue = exploradorTablasId;
exploradorTablas.setAttributeNode(newAttr2);
exploradorTablas.value='1';
document.body.appendChild(exploradorTablas);

	
	if(dirEliminar){this.dirEliminar="#"+dirEliminar;
	this.NdirEliminar=dirEliminar;
	}
	if(edit_id){
	this.editId="#"+edit_id;
	}
	if(dirEditar){this.dirEditar="#"+dirEditar;
	this.NdirEditar=dirEditar;
	}
this.num_filas = objeto_json.filas;
var h=0
var inicio_filas=0;

var loader = this;
loader.limpia_linea.call(loader);//listo

if (this.num_filas<=this.num_intervalos)
{this.top=1;
final=this.num_filas;
}
else
{
	var loader2 = this;
	this.top=loader2.verifica.call(loader2);//listo
final=this.num_intervalos;
}


		
/////////////////////////bloque de atras///////////////////////////////////////////
var loaderBack = this;
var LabelIdAtras =loaderBack.crea_atras.call(loaderBack);//listo
//////////////////////bloque generador de las tablas////////////////////////////////////////////////////
	for(var n_table=1; n_table<=this.top; n_table++)
	{h=0;
	  if((n_table==this.top)&&(this.num_filas>this.num_intervalos))
		{final=this.num_filas;
		}
/////////////bloque de creacion de la lista///////////////////////////////////////////////
		var help =1;
		var color;
		var dato;
		var loader_tabla = this;
		this.elmTBODY= loader_tabla.crea_tabla.call(loader_tabla,n_table);//listo
		for (var nFila=inicio_filas; nFila<final; nFila++) {
		if (help==1)
		 {color="#E5E5E5";
		 help=help+1;}
		 else
		 {help=help-1;
		 color="#A4C9F2";}
		 this.elmTR = this.elmTBODY.insertRow(h);
		 var loader_lista = this;
			loader_lista.crea_listar.call(loader_lista,nFila,color);//listo
		h=h+1;
		}//final del segundo for
		inicio_filas=final;
		final=final+this.num_intervalos;
		///////////////indice de acceso directo a cada bloque de busqueda/////////////////////////
		var loader_indice = this;
		loader_indice.crea_indice.call(loader_indice,n_table);
		
			if(n_table==1){
				var id4='lb_'+this.exploradorTablas+'1'
				var p4=document.getElementById(id4); 
				if (navigator.appName == "Netscape"){ 
					p4.setAttribute('style','color:#CC0000');
				} 
				else {
					if (navigator.appName.indexOf("Explorer") != -1) { 
					p4.style.setAttribute('color','#CC0000');
					}
				}
			}
	
		///////////////////////////////////////////////////////////////////////////////////////////
	}
	////////////////////////////////////////////bloque de reversa////////////////////////////////////////////////
		var LabelIdAdelante=this.crea_adelante.call(this);
		 var idDiv="div[id='"+exploradorTablasId+1+"']"
		
		$(document).unbind('keydown');		
		$(document).keydown(function(tecla){
			var r=tecla.keyCode;
			if(r==37){
			$(LabelIdAtras).trigger('click');
			}
			if(r==39){
			$(LabelIdAdelante).trigger('click');
			}
			
			});
			$(idDiv).focus();
			},

//////////////////////////////////////////////////

crea_atras : function ()
{ texto='<span  id="'+this.exploradorTablas+'atras"  ><<< </span>'
	$("#"+this.NameDivIndex).append(texto)
	var help="#"+this.exploradorTablas+"atras";
	$(help).css("cursor","pointer")
	atras(help,this.top,this.exploradorTablas);
	return help;
	},
	
crea_indice : function (n_table)	
{
	texto='<span id="lb_'+this.exploradorTablas+n_table+'" >'+n_table+" "+'</span>'
	$("#"+this.NameDivIndex).append(texto)
		var help="#lb_"+this.exploradorTablas+n_table;
		$(help).css("cursor","pointer")
		asignar(help,this.top,this.exploradorTablas);
	},
	
 crea_adelante : function()
{texto='<span  id="'+this.exploradorTablas+'adelante"> >>> </span>'
	$("#"+this.NameDivIndex).append(texto)
	var help="#"+this.exploradorTablas+"adelante";
	$(help).css("cursor","pointer")
		adelante(help,this.top,this.exploradorTablas);	
		return help;
	},
	
 crea_tabla : function(n_table)//listo
{
		var tabla = document.createElement("table");	
	 	var elmTBODY=document.createElement("tbody");
		var div = document.createElement("div");
		tabla.setAttribute('align','center');
			//tabla.setAttribute('cellspacing','2');
			
		tabla.setAttribute('border','0');
		//tabla.setAttribute('bordercolor','#71D8E3');
		var tabla2=document.getElementById(this.wTabla);
		//alert (this.wTabla);
		tabla.setAttribute('width','100%');
                tabla2.setAttribute('class','table');
		tabla.setAttribute('class','listadoGeneral table');
		div.setAttribute('class','infoContainer');
		tabla.appendChild(elmTBODY);
		div.appendChild(tabla);
		var newAttr2 = document.createAttribute("id");
		newAttr2.nodeValue = this.exploradorTablas+n_table;
		div.setAttributeNode(newAttr2); 
		document.getElementById(this.NameDivList).appendChild(div);
		if(n_table>1){
			if (navigator.appName == "Netscape"){ 
				div.setAttribute('style','display:none');
			} 
			else if (navigator.appName.indexOf("Explorer") != -1) { 
				div.style.setAttribute('display','none');} 
		}
			
		return elmTBODY ; 
	},
	
	
 prepara_link_busqueda : function(dato,nFila,datoOrden,DatosProcesar)//eliminar sera utilizado en dos casos diferentes ... el primero cuando se le asigna el vinculo a toda una linea y se le colocara de donde fue llamada la funci�n ya sea el bloque de eliminacion o de edicion o en el caso de que exista en el de solo ver el articulo... . el segundo caso sera cuando sean asignados dos link a cada imagen drop y edit... en ese caso eliminar llevara el nombre equivalente a el id del bloque de eliminacion.... lo mismo  ocurre con elimina_id... la cual representara en el primer caso nombrado el id de la casilla de id del bloque de donde fue llamada la funcion... en el otro caso llevara el id de la casilla de id del bloque de eliminacion...
{var help_2;
var id_tr;
 var id_td_0;
 var id_td_1;
 
	switch(this.num_inicio){
		case  0:
		
		if(this.eliminaId){
			if(this.orden){
			id_tr=datoOrden+'_tr_'+nFila;}
			else{id_tr='tr_'+nFila;}
			this.elmTR.setAttribute('id',id_tr);
                        this.elmTR.setAttribute('class','tr_lista_opr');
			help_2 ="tr[id='"+id_tr+"']";
			if(this.title){
				$(help_2).attr("title",this.objeto_json.datos[nFila][this.title]);
                               $('#'+id_tr).tooltip();
				//$(help_2).tipsy({gravity: $.fn.tipsy.autoNS,opacity: 1});
                                
				}
			
			//alert(help_2)
		if(!this.onload)
		{this.procesar_linea(help_2,dato,this.eliminaId,this.dirEliminar);}
		else{
		loaderLink=this;
			loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.onload,DatosProcesar);
		}
			
			if (navigator.appName == "Netscape"){ 
					 this.elmTR.setAttribute('style','cursor:pointer'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				 this.elmTR.style.setAttribute('cursor','pointer'); 
						} 
		}
			return this.num_inicio
			break;
			
		case  2:
		id_td_0='td_0_'+nFila;//se crea el id de editar
		id_td_1='td_1_'+nFila;//se crea el id de eliminar
		elmTD = this.elmTR.insertCell(0);
		var tabla2=document.getElementById(this.wTabla);
		var tr=tabla2.rows[0];
		var td_w=tr.cells[0].width;
		elmTD.setAttribute('width',td_w);
		
		elmTD.setAttribute('class',"ui-widget-content");
		elmTD.setAttribute('align','center');
                
	    elmTD.innerHTML='<img src="imagenes/b_edit.png" id="'+id_td_0+'" align="top" width="10" class="imagen1" />&nbsp;&nbsp;<img class="imagen2"  src="imagenes/b_drop.png" id="'+id_td_1+'" align="top" width="10" />';
		
		if (navigator.appName == "Netscape"){ 
				 elmTD.setAttribute('style','cursor:pointer'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				 elmTD.style.setAttribute('cursor','pointer'); 
						}
		help_2 ="#"+id_td_0;
		if(!this.funcion2)
			{	this.procesar_linea(help_2,dato,this.editId,this.dirEditar);}
		else{
		loaderLink=this;
		loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.funcion2,DatosProcesar);
		
		}
	
		
		help_2 ="#"+id_td_1;		
				if(!this.onload)
		{this.procesar_linea(help_2,dato,this.eliminaId,this.dirEliminar);}
		else{
		loaderLink=this;
		loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.onload,DatosProcesar);
		}
		var numInicio=this.num_inicio-1;
	
			if(this.title){
			id_tr='tr_'+nFila;
			this.elmTR.setAttribute('id',id_tr);
			help_2 ="tr[id='"+id_tr+"']";
				$(help_2).attr("title",this.objeto_json.datos[nFila][this.title]);
                               $('#'+id_tr).tooltip();
                                 //$(help_2).tipsy({gravity: $.fn.tipsy.autoNS,opacity: 1});
				}
		return 1;
		break;
		
		case  1:
		id_td_0='td_0_'+nFila;//se crea el id de eliminar
		elmTD = this.elmTR.insertCell(0);
		var tabla2=document.getElementById(this.wTabla);
		var tr=tabla2.rows[0];
		//alert (tabla2.id);
		var td_w=tr.cells[0].width;
		td_w=parseInt(td_w);
		elmTD.setAttribute('width',td_w);
		elmTD.setAttribute('id',id_td_0);
		elmTD.setAttribute('align','center');
		if(!this.dirlink)
		{elmTD.innerHTML='<img src="imagenes/b_drop.png" width="13" height="16" />';
		if (navigator.appName == "Netscape"){ 
				 elmTD.setAttribute('style','cursor:pointer'); 
				} 
				else if (navigator.appName.indexOf("Explorer") != -1) { 
				 elmTD.style.setAttribute('cursor','pointer'); 
						}
		help_2 ="td[id='"+id_td_0+"']";
		loaderLink=this;
		loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.onload,DatosProcesar);}
		else{
			elmTD.innerHTML='<a href="'+this.dirlink+'&dato='+dato+'" target="_blank"><img src="imagenes/b_drop.png"  width="13" height="16" /></a>';
			
			}
		var numInicio=this.num_inicio;
		if(this.title){
			id_tr='tr_'+nFila;
			this.elmTR.setAttribute('id',id_tr);
			help_2 ="tr[id='"+id_tr+"']";
				$(help_2).attr("title",this.objeto_json.datos[nFila][this.title])
                                $('#'+id_tr).tooltip();
                               // $('#'+id_tr).data('placement' , "bottom");
                                 //$(help_2).tipsy({gravity: $.fn.tipsy.autoNS,opacity: 1});
				}
		return numInicio;
		break;
		
		
		case  3:
		id_td_0='td_0_'+nFila;//se crea el id de eliminar
		id_td_1='td_1_'+nFila;//se crea el id de eliminar
		id_td_2='td_2_'+nFila;//se crea el id de eliminar
		
		elmTD = this.elmTR.insertCell(0);
		elmTD.setAttribute('width','13');
		elmTD.innerHTML='<img id="'+id_td_0+'" src="imagenes/entrada.png" align="top" width="20" height="20" style="cursor:pointer"title="Eliminar Cita" /><img id="'+id_td_1+'"  align="top"  width="20" height="20" src="imagenes/ui-icons_lapiz.png"align="top" style="cursor:pointer"title="Edicion de Citas "/><img id="'+id_td_2+'" src="imagenes/ui-icons_nota.png" align="top"  width="20" height="20" src="imagenes/entrada.png" align="top" style="cursor:pointer"title="Atender a Paciente"/>';
	help_2 ="img[id='"+id_td_0+"']";
		loaderLink=this;
		loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.onload,DatosProcesar);
			help_2 ="img[id='"+id_td_1+"']";	
				loaderLink=this;
		loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.funcion2,DatosProcesar);
			
		help_2 ="img[id='"+id_td_2+"']";
		
		loaderLink=this;
		loaderLink.procesarlinea.call(loaderLink,help_2,dato,loaderLink.funcion3,DatosProcesar);
		
		var numInicio=this.num_inicio-2
		
		if(this.title){
			id_tr='tr_'+nFila;
			this.elmTR.setAttribute('id',id_tr);
			help_2 ="tr[id='"+id_tr+"']";
				$(help_2).attr("title",this.objeto_json.datos[nFila][this.title]);
                                $('#'+id_tr).tooltip();
                                //$('#'+id_tr).data('placement' , "bottom");
                                 //$(help_2).tipsy({gravity:$.fn.tipsy.autoNS,opacity: 1});
				}
		
		return numInicio;
		break;
		}
	},



crea_listar : function (nFila,color)
{	  
		var elmText
		var elmTD ;
		if(this.num_inicio>0)
		{var num_inicio=1;}
		else{var num_inicio=0;}
		var NumeroCeldas;
		var cabDato
		var datoOrden
		if(this.orden)//esto en el caso de que envie orden en verdadero entonces estoy diciendo que la ultima pocicion de las cabezas sera el id para la busqueda no el primero
		{NumeroCeldas=this.numCabezas-1;
		cabDato = this.encabezados[NumeroCeldas];
		  datoOrden=this.orden;
		//alert("estp es numero de celdas "+NumeroCeldas)
		}else{
				NumeroCeldas=this.numCabezas;
			cabDato = this.encabezados[0];	
			}
			
				//alert("el numero de fila es  "+this.objeto_json)
		var dato=this.objeto_json.datos[nFila][cabDato];
		var DatosProcesar=this.objeto_json.datos[nFila]
		var tabla2=document.getElementById(this.wTabla);
		var tr=tabla2.rows[0];	
		//alert(dato)
		
		loaderLink=this;
		var numInicio=loaderLink.prepara_link_busqueda.call(loaderLink,dato,nFila,datoOrden,DatosProcesar);//funcion que le da a la linea o a los dibujos para donde tienen que ir cuando le dan click
		
		//alert(numInicio);
		
		for (var i=0;i<NumeroCeldas;i++){
			elmTD = this.elmTR.insertCell(num_inicio);
			cabDato = this.encabezados[i]
			dato=this.objeto_json.datos[nFila][cabDato];
			//alert(dato)
			elmText = document.createTextNode(dato);
			//alert(numInicio)
			if(tr.cells[numInicio].width){
			td_w=tr.cells[numInicio].width;
                        //alert( tr.cells[numInicio].getAttribute('class'));
                       
			//td_w=parseInt(td_w);
			elmTD.setAttribute('width',td_w);}
			if (!this.orden){
					elmTD.setAttribute('class',"ui-widget-content");
			if(cabDato!="c_n_hex"){
			elmTD.setAttribute('bgcolor',color);
			}
			else
			{elmTD.setAttribute('bgcolor',dato);
			}
			}
		
			if(i>0){
			elmTD.setAttribute('align','center');}
			 if (tr.cells[numInicio].getAttribute('class') === 'moneda'){ 
                            elmText = document.createTextNode(formatoMoneda.new( dato, "$")  );
                        }
			elmTD.appendChild(elmText);
			
			num_inicio=num_inicio+1;
			numInicio=numInicio+1;
			}
		
		
	},
	
	
	
verifica : function (){
//alert("esto es a => "+a+" esto es b => "+b);
var c=this.num_filas/this.num_intervalos;
//alert(c);
c=c.toString();
if (c.indexOf(".") != -1) 
{var p= c.substring(0,c.indexOf("."));
var i=parseInt(p)+1;
//alert("tiene punto y la parte sin punto es "+p);
//alert ("esto es lo que retorno de verifica "+i);
return i}
else
{return parseInt(c);}
} ,	

limpia_linea : function ()//listo
{
var nuevoDiv=document.createElement("div");////aqui borro el div tablas existente y lo reemplazo con uno nuevo donde se va a colocar las nuevas tablas
//alert(this.NameDivList );
var borraDiv= document.getElementById(this.NameDivList );
var newAttrdiv = document.createAttribute("id");
newAttrdiv.nodeValue = this.NameDivList ;
nuevoDiv.setAttributeNode(newAttrdiv);
borraDiv.parentNode.replaceChild(nuevoDiv, borraDiv);
if(this.NameDivIndex){
nuevoDiv=document.createElement("div");////aqui borro el div tablas existente y lo reemplazo con uno nuevo donde se va a colocar las nuevas tablas
borraDiv= document.getElementById(this.NameDivIndex);
newAttrdiv = document.createAttribute("id");
newAttrdiv.nodeValue = this.NameDivIndex;
nuevoDiv.setAttributeNode(newAttrdiv);
newAttrdiv = document.createAttribute("align");
newAttrdiv.nodeValue = "center";
nuevoDiv.setAttributeNode(newAttrdiv);
borraDiv.parentNode.replaceChild(nuevoDiv, borraDiv);}

},

procesar_linea : function (help,dato,llamado,destino, )
{
	//alert("estoy en procesar linea y help es igua a "+help+"llamado y destino es respectivamente "+llamado+" "+destino)
	 
        $(help).data('close' ,   this.NameDivList ) ;
	$(help).click(()=>{
            
            if(jQuery.colorbox){ 
		try {jQuery.colorbox.close();	
                        } catch (error) {
                      console.error(error); 
                       }
                   }
                     
                $('[data-targer_modal="'+$(help).data('close')+'"]').trigger('click');
	
		if (destino){//ojo este destino equivale a la pesta�a que se va a abrir despues que le des click osea... si estas en listar y tiene la x y le das el destino sera eliminar si tiene el lapiz y le das se va para editar::: y asi susesivamente
		$(destino).trigger('click');
		$(destino).dialog('open');
		}
		$(llamado).val(dato);
		$(llamado).trigger('blur');//este llamado2 equivale al input que se va a llenar con el dato que contiene la linea sobre la que des click::: no importa de donde llames la clase listas el te va a llenar el input que tu le diste para que llenara.... por lo tanto aqui va a accionar el evento de leave y si hubiese una accion para ese evento esto la va a ejecutar si no simplenente no...
		$(llamado).trigger('keyup');//este por el contrario va a ejecutar el evento keyup osea... el evento que escucha si se presiona una tecla... si hay alguna accion relacionada a este eveneto aqui se va a ejecutar.... si no simplemente no...
		$(llamado).trigger('keydown');//este por el contrario va a ejecutar el evento keydown osea... el evento que escucha si se presiona una tecla... si hay alguna accion relacionada a este eveneto aqui se va a ejecutar.... si no simplemente no...
		//$(llamado).trigger('keypress');
                
                var e = jQuery.Event("keypress");
                e.which = 13; // # Some key code value
                $(llamado).trigger(e);
		}); 
},


procesarlinea : function (help,dato,funcion,datosEnvio)
{	
$(help).data('close' ,   this.NameDivList ) ;
$(help).click(function (){
		this.datosParaEnvio=datosEnvio;
		if(jQuery.colorbox){
                    try {jQuery.colorbox.close();	
                        } catch (error) {
                      console.error(error); 
                       } }
                   $('[data-targer_modal="'+$(help).data('close')+'"]').trigger('click');
		this.datoProcesar=dato;
		funcion.call(this);
		});
}



};


	