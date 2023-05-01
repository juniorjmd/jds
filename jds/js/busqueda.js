(function($){
	$.fn.extend({
		buscador: function(nombreBusqueda,options,estruct){
			this.each(function(){
				var $this = $(this);
				 var settings = $.extend({
					// These are the defaults.
					width: '100%',
					height: "",
					marginTop:'170px',
					marginLeft:'auto',
					marginRight:'auto',
				}, options );
				if (typeof estruct == "undefined")
					{estruct= new Array()
					estruct=[{columna:'col_prueba1',placeholder:'prueba1'},
					{columna:'col_prueba2',placeholder:'prueba2'},
					{columna:'col_prueba3',placeholder:'prueba3'},]
				}
				$this.css('width',settings.width)
				$this.css('height',settings.height)
				$this.css('marginLeft',settings.marginLeft)
				$this.css('marginRight',settings.marginRight)
				$this.css('marginTop',settings.marginTop)
				$this.attr('class','panel panel-default')
				var auxDiv=$('<div>')
				auxDiv.attr('id','cabecera')
				auxDiv.attr('class','panel-heading')
				auxTitle = $('<div>')
				auxTitle.css('float','right');
				auxTitle.appendTo(auxDiv)
				auxTitle.append('busqueda de '+nombreBusqueda)
				auxTitle = $('<div>')
				auxTitle.appendTo(auxDiv)
				auxTitle.append('segunda parte de '+nombreBusqueda)				
				var auxInput = $('<input>');
				auxInput.attr('type','button')
				auxInput.attr('value','revisar')
				auxInput.attr('class','buscar')	
				auxInput.appendTo(auxDiv)
				$this.append(auxDiv)
				auxTable = $('<table>');
				auxTable.attr('class','table')
				auxTD ='<tr>'
				var datosRequeridos = new Array();
				for (var i=0; i<estruct.length;i++)
				{ datos	= estruct[i] 
					datosRequeridos[i] = datos.columna
					auxTD = auxTD+'<td>'+ datos.placeholder+'</td>'
				}
				var datosAjax = {tabla: 'sucursales',
				inicio: '',
				dataBase:'jkou_124569piokmd',
				datosRequeridos:['nombre_suc','id_suc','nom_database']};	
				auxTD = auxTD+'</tr>'
				auxTable.append(auxTD);
				auxTable.append(auxTD);
				auxTable.append(auxTD)
				 pl
				
			 
				$this.append(auxTable);
				var item1 = $( "<input>" )[ 0 ];
				$this.find('.buscar').bind("click",function($this,estruct){
					for (var i=0; i<$this.estruct.length;i++)
				{ /*datos	= estruct[i] 
					datosRequeridos[i] = datos.columna*/
					auxTD = auxTD+'<td>hola</td>'
				}auxTD = auxTD +'<td>hola</td><td>hola</td><td>hola</td>'
					$this.find('table').append(auxTD)
					$this.append('dinamico<br/>')})
				
				
			})
		}
	});
	
})(jQuery)