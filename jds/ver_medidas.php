<?php include 'php/inicioFunction.php';
verificaSession_2("login/");  
$db = new mysqli(N_HOST,N_USUARIODB,N_CLAVEDB,N_DATABASE);

IF(ISSET($_GET['ERDST']) && TRIM($_GET['ERDST'])!=''){
$consulta=mysqli_query($db,"DELETE FROM  tipos_medidas WHERE id = {$_GET['ERDST']}");
}
?><head> 
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
 
<style type="text/css">
<!--
.Estilo1 {font-size: 15px; font-family: "Arial Narrow"}
.Estilo2 {color: #CCCCCC}
.Estilo3 {font-size: 17px}
.Estilo5 {color: #993300}
-->
</style>
<script src="../vendor/jquery.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript"> 
    var open = '';
function confirmation(id) {
	if(confirm("Realmente desea eliminar?"))
		{window.location =("ver_medidas.php?ERDST="+id);
	}
}
//mostrar_grupo

$(document).ready(function(){
    $('.grupo_lineas').hide();
    $('.mostrar_grupo').click(function(){
        $('.grupo_lineas').hide();
        if (open != $(this).data('id')){
        var clase = '#'+$(this).data('id')
        $(clase).show()
        open = $(this).data('id');}
    })
    
   
          
          
    $('.save_grupos').click(function()
    {
        var clase = '.'+$(this).data('clase')
        var medida = $(this).data('medida')
         var contador = 0;
         var medida_nombre =$(this).data('medida_nombre')
         var arrayGrupos = new Array();
      $( clase).each(function(){
          if ($(this).prop('checked') == true){
              arrayGrupos[contador]=$(this).val();
              contador++;
          }
      })
            console.log(arrayGrupos +' - ' + arrayGrupos.length);
      if (arrayGrupos.length <= 0){
          if(!confirm("Realmente desea eliminar todos las relaciones con los grupo de la medida"+medida_nombre+"?")){
              
             return ;}} 
      var datosAjax = {action:'GUARDAR_RELACION_MEDIDAS_GRUPOS',
            medida : medida ,
            arrayGrupos : arrayGrupos
              };        
      $.ajax({
        url: 'php/action.php',  
        type: 'POST', 
       dataType: "json",
        data: datosAjax	,
         error: function(xhr, ajaxOptions, thrownError) {
                alert(JSON.stringify(xhr.status));
                alert(JSON.stringify(ajaxOptions));  
                alert(JSON.stringify(thrownError));},
        beforeSend: function() {
             // alert(JSON.stringify(datosAjax))
                $('#tablaResultado').hide()
                }, 
        statusCode: {
                404: function() { alert( "pagina no encontrada" ); },
                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                         },
        success: function(objeto_json) {
          //alert(JSON.stringify(objeto_json))
          $('#tablaResultado').show()
               var msg = '';  
             var error=objeto_json["error"]; 
             switch(error){
                 case  'ok':  
                      window.location =("ver_medidas.php");
                 break;
                 case  'not ok': 
                      msg = 'ERROR no se pudo ingresar la información en la base de datos. ';
                    alert(msg);
                 break;
             default  :
                 msg = 'ERROR  '+error+' ';
                    alert(msg);
                break; 
             }
        }	
    });
        })   
    });
</script>


 <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'lista_de_medidas';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
  <table  width="519" border="0" align="center">
  <tr align="center">
    <td width="22" bgcolor="#F9F9F9"><span class="Estilo9 Estilo1 Estilo3 Estilo5">No.</span></td>
    <td width="363" bgcolor="#F9F9F9"><span class="Estilo9 Estilo1 Estilo3 Estilo5">Medida</span></td>
    <td width="76" bgcolor="#F9F9F9"><span class="Estilo9 Estilo1 Estilo3 Estilo5">Codigo</span></td>
	<td width="18"></td>
  </tr>
  <tr>
  <?php
	/*$result2 = mysqli_query($db, "SELECT count(id) AS val_totalx FROM poblacion where edad_letras='$dato'"); 
    $row2 = mysqli_fetch_assoc($result2); 
    $ide = $row2['val_totalx']; */
    $x=1;
$lineas  = "<tr align='center'>";
$lineas  .= "<td width='40' bgcolor='#F9F9F9'><span class='Estilo9 Estilo1 Estilo3 Estilo5'>No.</span></td>";
$lineas  .= "<td width='363' bgcolor='#F9F9F9'><span class='Estilo9 Estilo1 Estilo3 Estilo5'>Medida</span></td>";
$lineas  .= "<td width='76' bgcolor='#F9F9F9'><span class='Estilo9 Estilo1 Estilo3 Estilo5'>Codigo</span></td>";
$lineas  .= "<td width='76' bgcolor='#F9F9F9'><span class='Estilo9 Estilo1 Estilo3 Estilo5'>Grupo</span></td>";
$lineas  .= "</tr>";

$res_ciclo= mysqli_query($db, "SELECT * FROM tipos_medidas ORDER BY medida ASC");
while ($rowc = mysqli_fetch_assoc($res_ciclo))
{ 
  $id="$rowc[id]";
  $codigo="$rowc[codigo]";
  $medida="$rowc[medida]";
  $m1="$rowc[m1]";
  $m2="$rowc[m2]";
  $m3="$rowc[m3]";
  $medida_nombre =$medida;
  
  $lineas .= "<tr>";
  $linea  =" <td><span class='Estilo12 Estilo1'>$x</span></td>
             <td><span class='Estilo12 Estilo1'>$medida</span></td>
             <td><span class='Estilo12 Estilo1'>$id</span></td>";
   
  
?>
    <td><span class="Estilo12 Estilo1"><?php echo $x; ?></span></td>
    <td><span class="Estilo12 Estilo1"><?php echo $medida; ?></span></td>
    <td><span class="Estilo12 Estilo1"><?php echo $id; ?></span></td>
 
<td align="center">
<img src="imagenes/b_drop.png" width="17" height="18" border="0" title="Eliminar Articulo" onClick="confirmation(<?php echo $id; ?>)" /></td> 
<td align="center"><button class="mostrar_grupo" data-id="grupo_<?php echo $id;?>">G</button>  </td>
  </tr>
  
  <tr class="grupo_lineas" id="grupo_<?php echo $id;?>">
      <td colspan="3">
          <table>
             <?php  
             $queryGrupos = "SELECT idGrupo, GRUPO, id_relacion, id_tipo_medida,   codigo, m1, m2, m3, total_pulgadas, total_pies, medida".
                     " FROM grupo g left join tipo_medida_grupo r on g.idGrupo = r.id_grupo and r.id_tipo_medida = $id".
                     " left join tipos_medidas t on t.id = r.id_tipo_medida ";
	 $res_grupos= mysqli_query($db, $queryGrupos );
         $grupos = '';
            while ($row_grupos = mysqli_fetch_assoc($res_grupos))
            { 
                $row_grupos['idGrupo'];
                $check = '';
                if ($row_grupos['id_relacion'] != '')
                {$check = 'checked';
                $grupos = "{$row_grupos['GRUPO']}";
                $lineas .= "$linea <td > <span class='Estilo12 Estilo1'>$grupos</span></td></tr>";
                }
                
               
             ?>
              <tr><td><input type="checkbox"  class="medida_<?php echo $id;?>"   value="<?php echo $row_grupos['idGrupo'] ;?>" <?php echo $check;?> > <span class="Estilo12 Estilo1"><?php echo $row_grupos['GRUPO'];?></span></td></tr>
                 <?php  
                  
            }
              if ($grupos == '')
              {$grupos = "NA";
                $lineas .= "$linea <td ><span class='Estilo12 Estilo1'>$grupos</span></td></tr>";}
            ?> 
          </table>
      </td>
      <td><button class="save_grupos" data-medida_nombre='<?php echo $medida_nombre;?>' data-medida='<?php echo $id;?>' data-clase="medida_<?php echo $id;?>">Guardar</button></td>
  </tr>
<tr>
    <td colspan="8" align="center"><span class="Estilo16 Estilo2">______________________________________________________________</span></td>
  </tr>
<?php

$x++;
} 
?>
</table>
<div style="display:none">
    <table id="tabla_resultados"><?php echo $lineas ;?></table>
</div>
<input name="prue" type="hidden" id="prue" size="10">
<input name="prue0" type="hidden" id="prue0" size="10">
<input name="prue1" type="hidden" id="prue1" size="10">

</head>