function hoverAsigna(elemento,entrada,salida,atrr,elemento2){
	$(elemento).hover(
  function () {
	  if(elemento2){$(elemento2).attr(atrr, entrada);
	  $(elemento2).css(atrr, entrada);}else{
    $(this).attr(atrr, entrada);
	$(this).css(atrr, entrada);}
  },
  function () { 
   if(elemento2){$(elemento2).attr(atrr,salida);
   $(elemento2).css(atrr,salida);
   }else{
	$(this).attr(atrr,salida);
	$(this).css(atrr,salida);
	}
  } 
);}


function OcultaYMuestra(clase1,clase2)
{if(Trim(clase1)!=""){	
$(clase1).each(function(){		  
			 $(this).css("display", "none")
			});}

	if(clase2){
		$(clase2).each(function(){
			 $(this).css("display", "block")						  	
			  });}
	}
