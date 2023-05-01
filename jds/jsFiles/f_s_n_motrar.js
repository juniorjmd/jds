// JavaScript Document

function Alternar(Seccion,Seccion2,Seccion3,Seccion4,h){ 
    if (Seccion.style.display=="none")
	{Seccion.style.display="inline";
	Seccion2.style.display="none";
	Seccion3.style.display="none";
	Seccion4.style.display="none";
	document.getElementById("imagen").style.display = "none";
	
	  switch(h)
	{
		case '1' :
	document.getElementById("1").style.color="#3366CC";
	document.getElementById("2").style.color="#333333";
	document.getElementById("3").style.color="#333333";
	document.getElementById("4").style.color="#333333";
	  break;
	  
	  case '2' :
	document.getElementById("2").style.color="#3366CC";
	document.getElementById("1").style.color="#333333";
	document.getElementById("3").style.color="#333333";
	document.getElementById("4").style.color="#333333";
	  break;
	  
	  case '3' :
	document.getElementById("3").style.color="#3366CC";
	document.getElementById("2").style.color="#333333";
	document.getElementById("1").style.color="#333333";
	document.getElementById("4").style.color="#333333";
	  break;
	  
	  case '4' :
	document.getElementById("4").style.color="#3366CC";
	document.getElementById("2").style.color="#333333";
	document.getElementById("3").style.color="#333333";
	document.getElementById("1").style.color="#333333";
	  break;
	  
	}
	}}
    
function Alternar2(r){ 
    switch(r)
	{
		case '1' :
	document.getElementById("imagen").style.display = "none";
	document.getElementById("menu_1").style.display = "inline";
	document.getElementById("menu_2").style.display = "none";
	document.getElementById("menu_3").style.display = "none";
	document.getElementById("menu_4").style.display = "none";
	document.getElementById("menu_5").style.display = "none";
	document.getElementById("salida1").style.color="#3366CC";
	document.getElementById("salida2").style.color="#333333";
	document.getElementById("salida3").style.color="#333333";
	document.getElementById("salida4").style.color="#333333";
	document.getElementById("salida5").style.color="#333333";
	
	  break;
	  
		case '2' :
	document.getElementById("menu_1").style.display = "none";
	document.getElementById("menu_3").style.display = "none";
	document.getElementById("menu_2").style.display = "inline";
	document.getElementById("menu_4").style.display = "none";
	document.getElementById("menu_5").style.display = "none";
	document.getElementById("imagen").style.display = "none";
	document.getElementById("salida1").style.color="#333333";
	document.getElementById("salida2").style.color="#3366CC";
	document.getElementById("salida3").style.color="#333333";
	document.getElementById("salida4").style.color="#333333";
	document.getElementById("salida5").style.color="#333333";
	 break;
	  
		case '3' :
	document.getElementById("imagen").style.display = "none";
	document.getElementById("menu_1").style.display = "none";
	document.getElementById("menu_2").style.display = "none";
	document.getElementById("menu_3").style.display = "inline";
	document.getElementById("menu_4").style.display = "none";
	document.getElementById("menu_5").style.display = "none";
	document.getElementById("salida1").style.color="#333333";
	document.getElementById("salida2").style.color="#333333";
	document.getElementById("salida3").style.color="#3366CC";
	document.getElementById("salida4").style.color="#333333";
	document.getElementById("salida5").style.color="#333333";
	 break;
	  
		case '4' :
	document.getElementById("imagen").style.display = "none";
	document.getElementById("menu_1").style.display = "none";
	document.getElementById("menu_2").style.display = "none";
	document.getElementById("menu_3").style.display = "none";
	document.getElementById("menu_4").style.display = "inline";
	document.getElementById("menu_5").style.display = "none";
	document.getElementById("salida1").style.color="#333333";
	document.getElementById("salida2").style.color="#333333";
	document.getElementById("salida3").style.color="#333333";
	document.getElementById("salida4").style.color="#3366CC";
	document.getElementById("salida5").style.color="#333333";
	 break;
	  
		case '5' :
	document.getElementById("imagen").style.display = "none";
	document.getElementById("menu_1").style.display = "none";
	document.getElementById("menu_2").style.display = "none";
	document.getElementById("menu_4").style.display = "none";
	document.getElementById("menu_3").style.display = "none";
	document.getElementById("menu_5").style.display = "inline";
	document.getElementById("salida1").style.color="#333333";
	document.getElementById("salida2").style.color="#333333";
	document.getElementById("salida3").style.color="#333333";
	document.getElementById("salida4").style.color="#333333";
	document.getElementById("salida5").style.color="#3366CC";
	break;
		}
	}
	
	
	function muestra_menu(r){ 
	if (document.getElementById(r).style.display == "none")
	{document.getElementById(r).style.display = "inline";
	document.getElementById("o/c").src="imagenes/flecha_abierto.png";}
	else
	{document.getElementById(r).style.display = "none";
	document.getElementById("o/c").src="imagenes/flecha_cerrado.png";
	}
	}
	
	function muestra_dimamico(r,m)
	{var num1;
	var num2;
	num1=parseInt(r);
	num2=parseInt(m);
	
	for(i=1;i<=num2;i++)
	{document.getElementById(i).className= "menu_normal";
	document.getElementById(i).name= "";
	}
	document.getElementById(r).className= "menu_click";
	document.getElementById(r).name= "ya";
	}
	
function reinicia(nombre,cant,lb,cant_lb){//alert("entre")
lb=lb||"none";
cant_lb=cant_lb||0;
//alert(cant+"_y el de lb "+cant_lb);
for(i=1;i<=cant;i++)
{borrar=nombre+"_"+i;
//alert (borrar)
document.getElementById(borrar).value="";

}

if(lb!="none")
{for(i=1;i<=cant_lb;i++)
{borrar="lb_"+nombre+"_"+i;	
//alert(borrar+" esto es antes de borrar");
document.getElementById(borrar).innerHTML="";
//alert(borrar);
}}
}


 function muestra_edit_suc(m,p,n,c,help)//funcion que cambia unos por otros al momento de editar
{	var str1='1';
	var str2;
	muestra_edit(m,p,n,help);
	str2=p+str1; 
	document.getElementById(str2).style.display = "";	
	str2=m+str1;
	document.getElementById(str2).style.display = "none";
	if (c=='0')
	{document.getElementById('b_edit').style.display = "none";
	document.getElementById('edit').style.display = "";
	document.getElementById('eraser_edit').style.display = "none";
	document.getElementById('cancel_edit').style.display = "";
	
	
	}
	else
	{document.getElementById('b_edit').style.display = "";
	document.getElementById('edit').style.display = "none";
	document.getElementById('cancel_edit').style.display = "none";
	document.getElementById('eraser_edit').style.display = "";
	}
		
}	
	
function muestra_edit(m,p,n,help)//funcion que cambia unos por otros al momento de editar
{	var num1;
	var str1;
	var str2;
	var str3;
	var dato;
	num1=parseInt(n);
	//alert(help+" estamos en muestra edit");
	for(i=1;i<=num1;i++)
	{	str1=i.toString();
		str2=p+str1;
		str3=m+str1
		//alert("str2 es igual a "+str2);
		document.getElementById(str2).style.display = "none";
		if (help==1)
		{if(i==1)
			{	//alert("el primero que es inner "+i+" y str2 = "+str2+" y str3 = "+str3);
				 dato=document.getElementById(str3).innerHTML;
				 //alert (dato);
				document.getElementById(str2).value=dato;}
			else{//alert("los demas que son value "+i+" "+str2);
				dato=document.getElementById(str2).value;}
			}
		else
		{if(i==1)
			{//alert("el primero que es  value "+i+" "+str2+" "+str3);
				dato=document.getElementById(str3).value;
				
				document.getElementById(str2).innerHTML=dato}
			else{//alert("los demas que son inner"+i+" "+str2);
				dato=document.getElementById(str2).innerHTML;}
		}
		//alert(dato);
		str2=m+str1; 
		if (help==1)
		{if(i>1)
			{document.getElementById(str2).innerHTML = dato;}}
		else
		{if(i>1)
			{document.getElementById(str2).value =dato;}}
		document.getElementById(str2).style.display = "inline";
		
		}
}



	function  Alternar3(n1,n2)
{	var num1;
	var str1;
	var str2;
	num1=parseInt(n1);
	for(i=1;i<=num1;i++)
		{str1=i.toString();
		str2='menu_'+str1; 
		//alert(str2);
		document.getElementById(str2).style.display = "none";	
		str2='salida'+str1;
		//alert(str2);
		document.getElementById(str2).style.color="#333333";}
	str2='menu_'+n2;
	//alert(str2);
	document.getElementById(str2).style.display = "inline";
	str2='salida'+n2;
	//alert(str2);
	document.getElementById(str2).style.color="#3366CC";
	document.getElementById("imagen").style.display = "none";
}    
		
		
function m()
{alert(document.getElementById('bt_color').value);}