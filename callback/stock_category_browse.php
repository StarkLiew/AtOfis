<?php
  session_start();
  include_once "base.php";
  
  $rowsPerPage=10;
  $offset=2;

  $sql = "SELECT stock_cat_code,stock_cat_desc,active FROM `stock_category` ORDER BY stock_cat_code ";
  $query = mysql_query($sql);
  if(!$query) die('MySQL Error: '.mysql_error());     
?>


<div class='form'>

<button onclick="open_menu('stock_category_form');"><span><a>+ Add New</a></span></button><br /><br />
<div class='browse tbody'>
   
   
    <table id="grid" width="100%" cellspacing="0" cellpadding="0">
      <thead>
         <tr><td width="150px">Code</td><td width="300px">Description</td><td></td></tr>
      <thead>
      <tbody>
         <?php 	while($line=mysql_fetch_array($query)){ ?>
              <tr><td><?php echo $line[0] ?></td><td><?php echo $line[1] ?></td><td><button  onclick="open_menu('stock_category_form',{action:'view',code:'<?php echo $line[0]; ?>'});">View</button>&nbsp;<button onclick="open_menu('stock_category_form',{action:'edit',code:'<?php echo $line[0]; ?>'});">Edit</button></td></tr>	
         <?php }?>
      </tbody> 
    </table>
 
     
     <br />
     <br />
    <script type="text/javascript">
      $(function(){
              // $("#grid").tableScroll({height:400,width:640});
          });
    </script>

<div>

