<?php
  session_start();
  include_once "base.php";
  
  $rowsPerPage=10;
  $offset=2;

  $sql = "SELECT area_code,area_desc,active FROM `area` ORDER BY area_code ";
  $query = mysql_query($sql);
  if(!$query) die('MySQL Error: '.mysql_error());     
?>


<div class='form'>

<button onclick="open_menu('area_form');"><span><a>+ Add New</a></span></button><br /><br />
<div class='browse tbody'>
   
   
    <table width="100%" cellspacing="0" cellpadding="0">
      <thead>
         <tr><td width="150px">Code</td><td width="300px">Description</td><td></td></tr>
      <thead>
      <tbody>
         <?php 	while($line=mysql_fetch_array($query)){ ?>
              <tr><td><?php echo $line[0] ?></td><td><?php echo $line[1] ?></td><td><button  onclick="open_menu('area_form',{action:'view',code:'<?php echo $line[0]; ?>'});">View</button>&nbsp;<button onclick="open_menu('area_form',{action:'edit',code:'<?php echo $line[0]; ?>'});">Edit</button></td></tr>	
         <?php }?>
      </tbody> 
    </table>
 
     
     <br />
     <br />
 

<div>

