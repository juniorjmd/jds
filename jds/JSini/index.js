$(document).ready(function(){
$(".menu1").each(function(){
			$(this).click(function(){
				var src=$(this).attr("name");
				if(Trim(src)!=""){
				$("#framePrincipal").attr('src', src);}
			});
	});
});

