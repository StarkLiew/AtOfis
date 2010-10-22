<?php
   session_start();
  if(empty($_SESSION['userid'])) exit;
  include_once "base.php";
  include_once "func.php";
  
  
  $stockcode=mysql_real_escape_string($_POST['stockcode']);
  $defaultuom=get_stock_default_uom($stockcode);
  
  echo "<option selected='selected' cost='0' value=''>...</option>";
  
  $options=mysql_query("SELECT uom_code,uom_ref_cost FROM `stock_uom` WHERE stock_code='$stockcode'");
      while($line = mysql_fetch_object($options)){
      	if ($defaultuom==$line->uom_code) $selected="selected='selected'";
      	else $selected="";
        echo "<option ".$selected." cost='$line->uom_ref_cost' value='$line->uom_code'>".$line->uom_code."</option>";
  } 

	

?>
