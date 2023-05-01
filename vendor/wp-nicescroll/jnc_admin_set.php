<?php
  $opts = array();
  if (isset($_POST['_jnc_opts_color'])) {
    $opts = array(
      "maindom"=>isset($_POST['_jnc_opts_dom'])?$_POST['_jnc_opts_dom']:'',    
      "color"=>isset($_POST['_jnc_opts_color'])?$_POST['_jnc_opts_color']:'',
      "opacity"=>isset($_POST['_jnc_opts_opacity'])?$_POST['_jnc_opts_opacity']:'',
      "size"=>isset($_POST['_jnc_opts_size'])?$_POST['_jnc_opts_size']:''
    );    
    update_option('_jnc_opts',serialize($opts));
  } else {
    $oo = get_option("_jnc_opts");
    if ($oo!='') $oo = unserialize($oo);
    if (is_array($oo)) $opts = $oo;
  }
  function _myval($opts,$name) {
    return (isset($opts[$name])) ? $opts[$name] : '';
  }
?>
 <style>
.wrap *{
    font-family: Tahoma;
    letter-spacing: 1px;
}

input[type=text],textarea{
    width:100px;
    padding:5px;
}

input{
   padding: 7px; 
}
</style>

<div class="wrap">
    <div class="icon32" id="icon-edit"><br></div>
<h2>Nicescroll Settings</h2>

<form action="" method="post" enctype="multipart/form-data">
<table cellpadding="5" cellspacing="5">

<tr>
<td><nobr>Scroll element:</nobr></td>
<td><input size="90" type="text" value="<?php echo _myval($opts,"maindom"); ?>" name="_jnc_opts_dom" /></td>
<td>html/body or other element (as jquery selector)</td>
</tr>

<tr>
<td><nobr>cursor color:</nobr></td>
<td><input size="90" type="text" value="<?php echo _myval($opts,"color"); ?>" name="_jnc_opts_color" /></td>
<td>(#000000)</td>
</tr>

<tr>
<td><nobr>cursor opacity:</nobr></td>
<td><input size="90" type="text" value="<?php echo _myval($opts,"opacity"); ?>" name="_jnc_opts_opacity" /></td>
<td>(1)</td>
</tr>

<tr>
<td><nobr>cursor size:</nobr></td>
<td><input size="90" type="text" value="<?php echo _myval($opts,"size"); ?>" name="_jnc_opts_size" /></td>
<td>(8)</td>
</tr>

<tr>
<td></td>
<td align="right"><input type="submit" value="Update" accesskey="p" tabindex="5" id="publish" class="button-primary" name="publish"></td>
<td></td>
</tr>


</table>


</form>

</div>
