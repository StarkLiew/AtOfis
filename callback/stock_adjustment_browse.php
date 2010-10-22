<?php
  session_start();
  include_once "base.php";
  
  $rowsPerPage=10;
  $offset=2;

  $sql = "SELECT tran_no,tran_date,net_amt FROM `transaction` WHERE doc_type_code='AJ' ORDER BY tran_no ";
  $query = mysql_query($sql);
  if(!$query) die('MySQL Error: '.mysql_error());     
?>


<div class='form'>

<button onclick="open_menu('stock_adjustment_form');"><span><a>+ Add New</a></span></button>
<h2 style="margin-left:5px;display:inline-block;color:#069;">Stock Ajustment</h2> 
<br />
<div class='scrollTable browse tbody'>
   
   
    <table width="100%" cellspacing="0" cellpadding="0">
      <thead>
         <tr><td width="150px">Serial No.</td><td>Date</td><td>Amount</td><td></td></tr>
      <thead>
      <tbody>
         <?php 	while($line=mysql_fetch_array($query)){ ?>
              <tr><td><?php echo $line[0] ?></td><td><?php echo date('d/m/Y', strtotime($line['tran_date'])) ?></td><td><?php echo $line[2] ?></td><td><button  onclick="open_menu('stock_form',{action:'view',code:'<?php echo $line[0]; ?>'});">View</button>&nbsp;<button onclick="open_menu('stock_form',{action:'edit',code:'<?php echo $line[0]; ?>'});">Edit</button></td></tr>	
         <?php }?>
      </tbody> 

    </table>
 
     
     <br />
     <br />
 

<div>

