<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  
  	 include_once "../callback/base.php";
  	 include_once "../callback/func.php";
	 $stockcode = mysql_real_escape_string($_POST['stockcode']);
  	 $hidestockcode = mysql_real_escape_string($_POST['hidestockcode']);
  	 $search =trim(mysql_real_escape_string($_POST['search']));
  	 $catcode= mysql_real_escape_string($_POST['catcode']);
  	 $groupcode= mysql_real_escape_string($_POST['groupcode']);
  	 $brandcode= mysql_real_escape_string($_POST['brandcode']);
  	 
  	 
  	 $sql = "SELECT stock_code,stock_desc,stock_cat_desc,stock_group_desc,brand_desc,uom_code".
  	        " FROM `stock` ".
  	        " LEFT JOIN `stock_category` ON `stock`.stock_cat_code=`stock_category`.stock_cat_code".
  	        " LEFT JOIN `stock_group` ON `stock`.stock_group_code=`stock_group`.stock_group_code".
  	        " LEFT JOIN `brand` ON `stock`.brand_code=`brand`.brand_code".
  	        " WHERE `stock`.active='Y' AND stock_control='Y'";
  	         
  	        
  	        if(!empty($stockcode)){
  	          $where .= " AND stock_code LIKE '%$stockcode%'";
  	        }
  	        if(!empty($search)){
  	          $where .= " AND stock_desc LIKE '%$search%'";
  	        }
  	        if(!empty($catcode)){
  	          $where .= " AND `stock`.stock_cat_code = '$catcode'";
  	        }
  	        if(!empty($groupcode)){
  	          $where .= " AND `stock`.stock_group_code = '$groupcode'";
  	        }
  	        if(!empty($brandcode)){
  	          $where .= " AND brand_code = '$brandcode'";
  	        }
  	        if(!empty($hidestockcode)){
  	           $where .= $sql." stock_code <> '$hidestockcode'";
  	         }
  	        
  	
  	        
  	        $result = mysql_query($sql.$where." ORDER BY stock_code");
  	        if(!$result) die("MySQL Error:".mysql_error().$sql.$where." ORDER BY stock_code");
  	        
  	 
            
  	 
?>

<div id="findstock" style="font-size:85%;width:600px;">
 <form id="searchform">
  <script type='text/javascript'>

 $(function(){

      $('#findItemTable').tableScroll({height:220,width:580});

 	$("#cmdfind").click(function(){

  	    //load_busy('#itemlookup .browse .tbody');
  	     	  
  		$.post("../include/findstock.php",$("#searchform").serialize(),
  		function(e){
  			$("#itemlookup").html(e);
  			//unload_busy('#itemlookup .browse .tbody');
  		});
  	return false;
  });

});


    
</script>
 <div style="background-color:#eee;margin:2px;padding:5px;">
  <h3>Filter</h3>
  <div style="padding-bottom:5px;"> 
  <label>Stock Code:</label><input id="stockcode" name="stockcode" ></input>&nbsp;<label>Search:</label><input id="search" name="search" ></input>
  </div>
  <select style="width:155px;padding:2px;" id="catcode" name="catcode" >
          <option selected="selected" value="">- Category -</option>
                        <?php 
        $stockcat=mysql_query("SELECT * FROM `stock_category` ORDER BY stock_cat_code");
        while($line = mysql_fetch_object($stockcat)){
          	 echo "<option  value='$line->stock_cat_code'>".$line->stock_cat_desc."</option>";
        }
        ?>
       </select>
  <select style="width:155px;padding:2px;" id="groupcode" name="groupcode" >
          <option selected="selected" value="">- Group -</option>
                        <?php 
        $stockgroup=mysql_query("SELECT * FROM `stock_group` ORDER BY stock_group_code");
        while($line = mysql_fetch_object($stockgroup)){
          	 echo "<option  value='$line->stock_group_code'>".$line->stock_group_desc."</option>";
        }
        ?>
       </select>
   <select style="width:155px;padding:2px;" id="brandcode" name="brandcode" >
          <option selected="selected" value="">- Brand -</option>
                        <?php 
        $brand=mysql_query("SELECT * FROM `brand` ORDER BY brand_code");
        while($line = mysql_fetch_object($brand)){
          	 echo "<option  value='$line->brand_code'>".$line->brand_desc."</option>";
        }
        ?>
       </select><button  id="cmdfind">Refresh</button></form></div>
 <div class='browse'>
    <table id="findItemTable"  cellspacing="0" cellpadding="0"  >
      <thead>
         <tr>
         <td style="width:45px">Code</td>
         <td style="width:145px">Description</td>
         <td style="width:100px">Brand</td>
         <td style="width:100px">Category</td>
         <td style="width:100px">Group</td>
         </tr>
      </thead>
      <tbody>
          <tr class='firstrow'><td></td><td></td><td></td><td></td><td></td></tr>
         <?php 
          if($result){
         	while($line=mysql_fetch_array($result)){ ?>
              <tr onclick="set_selected(this);">
              <td  id="code"><?php echo $line[0] ?></td>
              <td id="desc"><?php echo $line[1] ?></td>
              <td><?php echo $line[4] ?></td>
              <td><?php echo $line[2] ?></td>
              <td><?php echo $line[3] ?></td>

              </tr>	
         <?php }}?>
      </tbody> 

    </table>
 
     
     <br />
     <br />
   
   
</div>
<script type="text/javascript">

function set_selected(row){
	 $(row).parent().find(".selected").removeClass("selected");
	 $(row).addClass("selected");
	 return false;
}

</script>

