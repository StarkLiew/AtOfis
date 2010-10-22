<?php
  session_start();
  include_once "base.php";
  
  $rowsPerPage=10;
  $offset=2;

  $sql = "SELECT stock_group_code,stock_group_desc,active FROM `stock_group` ORDER BY stock_group_code ";
  $query = mysql_query($sql);
  if(!$query) die('MySQL Error: '.mysql_error()); 
  
      
?>


<div class='form'>

<button onclick="open_menu('stock_group_form');"><span><a>+ Add New</a></span></button>
<h2 style="margin-left:5px;display:inline-block;color:#069;">Stock Item Grouping</h2> 
<br />
<div class='tbody'>
   <script>
     $(function(){
     	 $(".xrow").click(function(){
     	 	if(!$(this).hasClass("xselected")){
     	 		$(".xrow").removeClass("xselected");
     	 		$(this).addClass("xselected");
     	 	}
     	 });
     });
</script>
   
   <div class="layout2"> 
<div class="xGrid">
   <div class="xheader">
   
     <table cellspacing="0">
        <tr>
          <td style="width:120px">Id</td>
          <td style="width:200px">Group Description</td>

          
        </tr>        
     </table>
   </div>
   <div class="xbody">
   
   <?php 	while($line=mysql_fetch_array($query)){ ?>
   	      <div class="xrow">
         <table cellspacing="0">
        <tr>
          <td style="width:120px"><?php echo $line[0] ?></td>
          <td style="width:200px"><?php echo $line[1] ?></td>
          <td style="width:80px;"><button  style="height:14px" onclick="open_menu('stock_group_form',{action:'view',code:'<?php echo $line[0]; ?>'});">View</button></td>
          <td style="width:80px;"><button style="height:14px" onclick="open_menu('stock_group_form',{action:'edit',code:'<?php echo $line[0]; ?>'});">Edit</button></td>
         </tr>   
       </table>     
    </div>   
    <?php }?>


    
 
   </div>
      <div class="xfooter" >
         <span>First</span>&nbsp;<span>Prv</span>&nbsp;Page:<input style="width:20px;" /> of 3&nbsp;<span>Next</span>&nbsp;<span>Last</span>
      </div>

  </div>
</div>
   

 

<div>

