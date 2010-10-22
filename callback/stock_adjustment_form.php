<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  	 include_once "base.php";
     include_once "class.php";
  	 include_once "func.php";

  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){
  include_once "base.php";
  include_once "func.php";
        $q = array(); 
   	    $docno=mysql_real_escape_string($_POST['docno']);

   	      $q[] = array("query"=>"DELETE  FROM `tranaction` WHERE tran_no='$docno'");
        if(is_stock_has_tran_detail($code))
   	     $q[] = array("query"=>"DELETE  FROM `tran_detail` WHERE tran_no='$docno' AND openbal='N'");
   	    
   	    $database = new MySQLDB;
        $database->transaction($q);
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){


  	
  	//PREPARE TRANSACTION SCRIPT
  	    $q = array ();
       //stock
        list($dd,$mm,$yy)=split("/",mysql_real_escape_string($_POST['trandate']));
        $trandate = strtotime($mm."/".$dd."/".$yy);
   	    $reason=mysql_real_escape_string($_POST['reason']);
   	    $remark=mysql_real_escape_string($_POST['remark']);
   	    $writeoff=mysql_real_escape_string($_POST['writeoff']);
   	    $authorisedby=mysql_real_escape_string($_POST['authorisedby']);
   	    $netamt=(double)mysql_real_escape_string($_POST['netamt']);
   	    $trantype="R";
   	    $doctypecode="AJ";
   	    $countable="Y";
   	    $childdata=stripslashes(mysql_real_escape_string($_POST['childdata']));


   	    if($writeoff)$writeoff='Y';
   	    else $writeoff='N';    

   	    $sql="INSERT INTO `transaction`(".
             "tran_no," .
             "tran_date,".
             "reason,".
             "remark,".
             "write_off,".
             "tran_type,".
             "doc_type_code,".
             "countable,authorised_by,gross_amt,net_amt".
             ") VALUES (@serial,FROM_UNIXTIME('$trandate'),'$reason','$remark','$writeoff','$trantype','$doctypecode','$countable','$authorisedby',$netamt,$netamt)";
         
        $q[] = array("query"=>"UPDATE `doc_no` SET last_no = (@next := last_no + 1) WHERE doc_type_code = '$doctypecode'");
        $q[] = array("query"=>"SELECT @serial:=CONCAT(`prefix`,LPAD(@next,lead_zero,0)) FROM doc_no WHERE `doc_type_code` = '$doctypecode'");
        $q[] = array("query"=>$sql);
        
        $data=json_decode($childdata);


        foreach ($data as $name=>$value) {
          switch($name){
           	case 'detail':
          	   foreach ($value as $line) {
          	   	
                   $stockcode=mysql_real_escape_string($line->stockcode);
               	   $locationcode=mysql_real_escape_string($line->locationcode);
                   $projectcode=mysql_real_escape_string($line->projectcode);
                   $cost=(double)mysql_real_escape_string($line->cost);
                   $uomcode=(double)mysql_real_escape_string($line->uomcode);
                   $qty=(double)mysql_real_escape_string($line->qty);
                   $subtotal=(double)mysql_real_escape_string($line->subtotal);
                   if($line->rowversion=="new"){
              
           
   	                  $sql="INSERT INTO `tran_detail`(tran_no,stock_code,stock_desc,location_code,project_code,uom_code,qty,price,subtotal) ".
   	                        "VALUES (@serial,'$stockcode','$desc','$locationcode','$projectcode','$uomcode',$qty,$cost,$subtotal)";
                      $q[] = array("query"=>$sql);	
      	              }
   	             	 
              }
          	  break;
        
          }
         
        }
   	    
   	   

   	    $database = new MySQLDB;
        $database->transaction($q);
   	   //if(!$result) die("MySQL Error: ".mysql_error().$sql1);
   	    exit;
   	    
   }
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='update'){

   	  	
  	//PREPARE TRANSACTION SCRIPT
  	    $q = array ();
       //stock
   	    $tranno=mysql_real_escape_string($_POST['tranno']);
        $trandate=mysql_real_escape_string($_POST['trandate']);
   	    $reason=mysql_real_escape_string($_POST['reason']);
   	    $remark=mysql_real_escape_string($_POST['remark']);
   	    $wtiteoff=mysql_real_escape_string($_POST['writeoff']);
   	    $authorisedby=mysql_real_escape_string($_POST['authorisedby']);
   	    $netamt=mysql_real_escape_string($_POST['netamt']);
   	    $childdata=stripslashes(mysql_real_escape_string($_POST['childdata']));

        $data=json_decode($childdata);
   	   
   	   //Test row version
   	     $version=mysql_query("SELECT tran_no FROM `transaction` WHERE ".
   	                   "tran_no = '$tran_no' AND ".
   	                   "tran_date = FROM_UNIXTIME('$trandate') AND ".
                       "reason = '$reason' AND ".
                       "remark = '$remark' AND authorised_by='$authorisedby' AND ".
                       "write_off='$writeoff' AND gross_amt=$netamt AND net_amt=$netamt");
      
        if(mysql_num_rows($version)==0){      

   	    $sql="UPDATE `transaction` SET ".
             "tran_date = FROM_UNIXTIME('$trandate'),".
             "reason = '$reason',".
             "remark = '$remark',".
             "write_off='$writeoff',".
             "gross_amt=$netamt,".
             "net_amt=$netamt,".
             " WHERE tran_code='$trancode'";

           $q[] = array("query"=>$sql);     
        }
   	     foreach ($data as $name=>$value) {
          switch($name){
          	case 'detail':
          	  foreach ($value as $line) {
          	  	      $lineno=(int)mysql_real_escape_string($line->lineno);
          	  	      $tranno=(int)mysql_real_escape_string($line->tranno);
                      $stockcode=mysql_real_escape_string($line->stockcode);
                      $desc=mysql_real_escape_string($line->desc);
               	      $locationcode=mysql_real_escape_string($line->locationcode);
                      $projectcode=mysql_real_escape_string($line->projectcode);
                      $cost=(double)mysql_real_escape_string($line->cost);
                      $uomcode=(double)mysql_real_escape_string($line->uom);
                      $qty=(double)mysql_real_escape_string($line->qty);
                      $subtotal=(double)mysql_real_escape_string($line->subtotal);
                    if($line->rowversion=="new"){
                    
   	                  $sql="INSERT INTO `tran_detail`(tran_no,stock_code,stock_desc,location_code,project_code,uom_code,qty,price,subtotal) ".
   	                        "VALUES (@serialno,'$code','$desc','$locationcode','$projectcode','$uomcode',$qty,$cost,$subtotal)";
                      $q[] = array("query"=>$sql);	
      	              }
      	             if($line->rowversion=="update"){
      	             	$version=mysql_query("SELECT tran_detail_code FROM `tran_detail WHERE ".
      	             	         " tran_detail_code=$lineno AND ".
      	             	         " tran_no=$tran_no AND ".
      	             	         " stock_code=$stockcode AND ".
      	             	         " stock_desc='$desc' AND ".
      	             	         " location_code='$locationcode' AND ".
      	             	         " project_code='$projectcode' AND ".
      	             	         " uom_code='$uomcode' AND ".
      	             	         " qty=$qty AND ".
      	             	         " price=$price AND ".
      	             	         " authorised_by='$authorisedby' AND ".
      	             	         " subtotal=$subtotal ");
      	             	         
      	             	  if(mysql_num_rows($version)==0){      
      	             	  	$sql="UPDATE tran_detail_code SET ".
      	             	         " stock_code=$stockcode , ".
      	             	         " stock_desc='$desc' , ".
      	             	         " location_code='$locationcode' , ".
      	             	         " project_code='$projectcode' , ".
      	             	         " uom_code='$uomcode' , ".
      	             	         " qty=$qty , ".
      	             	         " price=$price , ".
      	             	         " subtotal=$subtotal ".
      	             	         " WHERE tran_detail_code=$lineno";
      	             	       $q[] = array("query"=>$sql);   
      	             	  }         
      	             	           
      	             	
      	             }
      	             if($line->rowversion=="delete"){
      	                $sql="DELETE FROM `tran_detail` WHERE tran_detail_code=$lineno";
      	                $q[] = array("query"=>$sql);	
      	              }
      	             }
   	             	
          	  break;
          }
         
        }


   	    
   	   

   	    $database = new MySQLDB;
        $database->transaction($q);
   	   //if(!$result) die("MySQL Error: ".mysql_error().$sql1);
   	    exit;
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$tranno=$_POST['tranno'];
    	$sql="SELECT tran_no," .
             "tran_date,".
             "remark,reason,".
             "location_code,project_code,write_off,gross_amt,net_amt,authorised_by".
             " FROM `transaction` WHERE tran_no='$tranno'";
        $sql2="SELECT tran_detail_code,tran_no,stock_code,stock_desc,location_code,project_code,uom_code,qty,price,subtotal FROM `tran_detail` WHERE tran_no='$tranno'";
            
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	$result2=mysql_query($sql2);
    	if(!$result2) die('MySql Error: '.mysql_error());
    	//if(mysql_num_rows($result2)<=0) echo "Record Not Found";
    	
        	
    }
    
?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('stock_form',{action:'edit',code:'<?php echo $data[0]; ?>'});" type='submit'>Edit</button><button onclick="open_menu('stock_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
    <div style='float:right'>
     <label for='stockcontrol'>Stock Control</label>&nbsp;<?php if($data['stock_control']=='Y') echo "<img src='../images/checked.gif' />"; else echo "<img src='../images/unchecked.gif' />"; ?> 
     <label for='active'>Active</label>&nbsp;<?php if($data['active']=='Y') echo "<img src='../images/checked.gif' />"; else echo "<img src='../images/unchecked.gif' />"; ?> 
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Stock Code:</td><td><label class="textbox"><?php echo $data['stock_code']; ?></label></td></tr>
      <tr><td>Description:</td><td><label class="textbox"><?php echo $data['stock_desc']; ?></label></td></tr> 
       <tr><td>Brand:</td>
   <td>
     <label class="textbox"><?php echo get_brand_desc($data['brand_code']); ?></label>
   </td>
    </table>
    <hr />
 <table>
   <tr><td>Category:</td>
   <td>
    <label class="textbox" style="width:150px;"><?php echo get_stock_category_desc($data['stock_cat_code']); ?></label>
   </td>
   <td>Reorder Level:</td><td>
    <label class="textbox num" style="width:150px;"><?php echo $data['stock_reorder_level']; ?></label>
   
   </td></tr>
   <tr><td>Group:</td>
   <td>
   <label class="textbox" style="width:150px;"><?php echo get_stock_group_desc($data['stock_group_code']); ?></label>
   </td>
   <td>Reorder Qty:</td><td>
   <label class="textbox num" style="width:150px;"><?php echo $data['stock_reorder_qty']; ?></label>
   </td></tr>
   
   <tr><td>Shelf:</td><td>
   <label class="textbox" style="width:150px;"><?php echo $data['stock_shelf']; ?></label>
   </td>
   <td>Sales Tax:</td>
   <td>
         <label class="textbox" style="width:150px;"><?php echo get_tax_desc($data['tax_code']); ?></label>
   </td></tr>
 </table>
  <label>Remark:</label><br />
   <label class="textbox" style="width:80%;"><?php echo get_tax_desc($data['remark']); ?></label>
     <hr />
     
 <div class="subform" id="subform">
   <ul class="subform tab">
      <li class="active"><a href="#uom">UOM</a></li>
      <li><a href="#openbal">Open Bal</a></li>
      <li><a href="#bom">BOM</a></li>
      
   </ul>
   
    <div class="childform" id="uom" style="display:block;">
      <label>Default UOM:</label><label  id="defaultuomlabel" name="defaultuomlabel" class="textbox" style="width:80px"><?php echo $data['uom_code']; ?></label><input value="<?php echo $data['uom_code']; ?>" type="hidden" name="uomid" id="uomid"/>
      <table id="uomtable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td>UOM</td><td>Rate</td><td>Ref Cost</td><td>Ref Price</td><td>Min Price</td></tr>
           </thead>
        <tbody>
            <?php while($line = mysql_fetch_array($result2)){ ?>
            	  <tr rowversion="current">
            	  <td class="uomcode"><?php echo $line['uom_code']; ?></td>
            	  <td class="uomrate"><?php echo $line['uom_rate']; ?></td>
            	  <td class="uomrefcost"><?php echo $line['uom_ref_cost']; ?></td>
            	  <td class="uomrefprice"><?php echo $line['uom_ref_price']; ?></td>
             	  <td class="uomminprice"><?php echo $line['uom_min_price']; ?></td>
             	  </tr>
            <?php } ?>
            
        </tbody>
    
      </table>

   </div> 
    <div class="childform" id="openbal">
      <table id="openbaltable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td>Location</td><td>Project</td><td>Cost</td><td>Qty</td><td>Total</td></tr>
       </thead>
        <tbody>
                    <?php while($line = mysql_fetch_array($result3)){ ?>
            	  <tr rowversion="current" lineno="<?php echo $line['tran_detail_code']; ?>">
               	  <td class="openballocationcode"><label><?php echo $line['location_code']; ?></label><br /><?php echo get_location_desc($line['location_code']); ?></td>
            	  <td class="openbalprojectcode"><label><?php echo $line['project_code']; ?></label><br /><?php echo get_project_desc($line['project_code']); ?></td>
            	  <td class="openbalcost"><?php echo $line['price']; ?></td>
            	  <td class="openbalqty"><?php echo $line['qty']; ?></td>
            	  <td class="openbalsubtotal"><?php echo $line['price']*$line['qty']; ?></td>
               	  </tr>
            <?php } ?>
        </tbody>
    
      </table>


   </div> 
    <div class="childform" id="bom">
      <label>Production Time:</label>
         &nbsp; <label>Production Cost:</label> <label class="textbox num" style="width:80px;"><?php echo $data['bom_time']; ?></label>
      &nbsp; <label>Production Cost:</label>&nbsp; <label class="textbox num" style="width:80px;"><?php echo $data['bom_cost']; ?></label>
   
               <table id="bomtable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td>Item</td><td>Location</td><td>Qty</td><td>UOM</td><td>Unit Cost</td></tr>
               </thead>
        <tbody>
               <?php echo mysql_num_rows($result4) ?>
               <?php while($line = mysql_fetch_array($result4)){ ?>
            	  <tr rowversion="current" bomid="<?php echo $line['bom_id']; ?>">
               	  <td class="bomstockcode"><label><?php echo $line['stock_code']; ?></label><br /><?php echo get_stock_desc($line['stock_code']); ?></td>
            	  <td class="bomlocationcode"><label><?php echo $line['location_code']; ?></label><br /><?php echo get_location_desc($line['location_code']); ?></td>
            	  <td class="bomqty"><?php echo $line['qty']; ?></td>
            	  <td class="bomuom"><?php echo $line['uom_code']; ?></td>
            	  <td class="bomcost"><?php echo get_stock_ref_cost($line['stock_code'],$line['uom_code']); ?></td>
              	  </tr>
            <?php } ?>
        </tbody>
    
      </table>  
    <script type="text/javascript">
       $(function(){
          $(".subform .tab li  a").click(function(){
          	    $(".subform .tab li").removeClass("active");
          	    $(".childform:visible").hide();   
          	    $(this).parent().addClass("active"); 
                 var _tabid=$(this).attr("href");
                 $(_tabid).show();   
     
                 return false;       	 
          });
            });
    </script>

   
    

   </div> 
   <br />
<?php }elseif($_POST['action']=='edit'){ ?>
<form id='frm' name='frm'>

<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('stock_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
      <input type='checkbox' <?php if($data['stock_control']=='Y') echo "checked='checked'"; ?> id='stockcontrol' name='stockcontrol'></input><label for='stockcontrol'>Stock Control</label>
     <input type='checkbox' <?php if($data['active']=='Y') echo "checked='checked'"; ?>  id='active' name='active'></input><label for='active'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Stock Code:</td><td><label class="textbox"><?php echo $data['stock_code']; ?></label><input type="hidden" id="code" name="code" value="<?php echo $data['stock_code']; ?>" /></td></tr>
      <tr><td>Description:</td><td><input value='<?php echo $data['stock_desc']; ?>' maxlength='150' id='desc' name='desc'  /></td></tr> 
       <tr><td>Brand:</td>
   <td>
       <select style="width:155px;padding:2px;" id="brandcode" name="brandcode" >
          <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $brand=mysql_query("SELECT * FROM `brand` ORDER BY brand_code");
        while($line = mysql_fetch_object($brand)){
        	if($data['brand_code']==$line->brand_code) $selected="selected='selected'";
            else $selected="";	
        	echo "<option ".$selected." value='$line->brand_code'>".$line->brand_desc."</option>";
        }
        ?>
       </select>
   </td>
    </table>
    <hr />
 <table>
   <tr><td>Category:</td>
   <td>
         <select style="width:155px;padding:2px;" id="catcode" name="catcode" >
          <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $stockcat=mysql_query("SELECT * FROM `stock_category` ORDER BY stock_cat_code");
        while($line = mysql_fetch_object($stockcat)){
        	if($data['stock_cat_code']==$line->stock_cat_code) $selected="selected='selected'";
            else $selected="";	
        	echo "<option ".$selected." value='$line->stock_cat_code'>".$line->stock_cat_desc."</option>";
        }
        ?>
       </select>
   </td>
   <td>Reorder Level:</td><td><input value="<?php echo $data['stock_reorder_level']; ?>" value="0" class="num" id='reorderlevel' name='reorderlevel'  /></td></tr>
   <tr><td>Group:</td>
   <td>
       <select style="width:155px;padding:2px;" id="groupcode" name="groupcode" >
          <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $stockgroup=mysql_query("SELECT * FROM `stock_group` ORDER BY stock_group_code");
        while($line = mysql_fetch_object($stockgroup)){
        	if($data['stock_group_code']==$line->stock_group_code) $selected="selected='selected'";
            else $selected="";	
        	echo "<option ".$selected." value='$line->stock_group_code'>".$line->stock_group_desc."</option>";
        }
        ?>
       </select>
   </td>
   <td>Reorder Qty:</td><td><input value="0" value="<?php echo $data['stock_reorder_qty']; ?>" class="num" id='reorderqty' name='reorderqty'  /></td></tr>
   
   <tr><td>Shelf:</td><td><input style="width:155px;" value="<?php echo $data['stock_shelf']; ?>" maxlength="150" id='shelf' name='shelf'  /></td>
   <td>Sales Tax:</td>
   <td>
          <select style="width:90px;padding:2px;" id="taxcode" name="taxcode" >
          <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $tax=mysql_query("SELECT * FROM `tax` ORDER BY tax_code");
        while($line = mysql_fetch_object($tax)){
        	   if($data['tax_code']==$line->tax_code) $selected="selected='selected'";
            else $selected="";	
        	echo "<option ".$selected." value='$line->tax_code'>".$line->tax_desc."</option>";
        }
        ?>    </select>
   </td></tr>
 </table>
  <label>Remark:</label><br />
  <textarea id="remark" name="remark" maxlength="255" style="width:50%"><?php echo $data['remark']; ?></textarea>
     <hr />
     
 <div class="subform" id="subform">
   <ul class="subform tab">
      <li class="active"><a href="#uom">UOM</a></li>
      <li><a href="#openbal">Open Bal</a></li>
      <li><a href="#bom">BOM</a></li>
      
   </ul>
   
    <div class="childform" id="uom" style="display:block;">
      <label>Default UOM:</label><label  id="defaultuomlabel" name="defaultuomlabel" class="textbox" style="width:80px"><?php echo $data['uom_code']; ?></label><input value="<?php echo $data['uom_code']; ?>" type="hidden" name="uomid" id="uomid"/>
      <table id="uomtable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td>UOM</td><td>Rate</td><td>Ref Cost</td><td>Ref Price</td><td>Min Price</td><td>Default?</td></tr>
            <tr>
              <td><input id="uomcode" name="uomcode" maxlength="5" style="width:50px" /></td>
              <td><input class="num" id="uomrate" name="uomrate" maxlength="10" style="width:50px" /></td>
              <td><input class="num" id="uomrefcost" name="uomrefcost" maxlength="10" style="width:50px" /></td>
              <td><input class="num" id="uomrefprice" name="uomrefprice" maxlength="10" style="width:50px" /></td>
              <td><input class="num" id="minprice" name="minprice" maxlength="10" style="width:80px" /></td>
              <td><input type="checkbox" id="defaultuom" name="defaultuom" /></td>
              <td><button onclick="add_new_uom();return false;" id="adduom">+</button></td></tr>  
        </thead>
        <tbody>
            <?php while($line = mysql_fetch_array($result2)){ ?>
            	  <tr rowversion="current">
            	  <td class="uomcode"><?php echo $line['uom_code']; ?></td>
            	  <td class="uomrate"><?php echo $line['uom_rate']; ?></td>
            	  <td class="uomrefcost"><?php echo $line['uom_ref_cost']; ?></td>
            	  <td class="uomrefprice"><?php echo $line['uom_ref_price']; ?></td>
            	  <td class="uomminprice"><?php echo $line['uom_min_price']; ?></td>
            	  <td class="defaultuom"><input type="checkbox" onclick="set_default_uom(this);" <?php if($line['uom_code']==$data['uom_code']) echo "checked='checked'"; ?>  /> </td>
            	  <td><button onclick='del_row(this);return false;' class='deletebutton'>-</button></td></tr>
            	  </tr>
            <?php } ?>
            
        </tbody>
    
      </table>

   </div> 
    <div class="childform" id="openbal">
      <table id="openbaltable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td>Location</td><td>Project</td><td>Cost</td><td>Qty</td><td>Total</td></tr>
            <tr>
            <td>
            <select id="openballocationcode" name="openballocationcode" style="width:150px;padding:2px;" >
                   <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $location=mysql_query("SELECT * FROM `location` ORDER BY location_code");
        while($line = mysql_fetch_object($location)){
        	echo "<option value='$line->location_code'>".$line->location_desc."</option>";
        }
        ?></select>
            </td><td>
            <select id="openbalprojectcode" name="openbalprojectcode" style="width:150px;padding:2px;" >
                        <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $project=mysql_query("SELECT * FROM `project` ORDER BY project_code");
        while($line = mysql_fetch_object($project)){
        	echo "<option value='$line->project_code'>".$line->project_desc."</option>";
        }
        ?>
            </select>
            
            </td><td><input class="num" id="openbalcost" name="openbalcost" maxlength="10" style="width:50px" /></td>
            <td><input class="num" id="openbalqty" name="openbalqty" maxlength="10" style="width:50px" /></td><td width="80px"><label class="num" id="subtotal"></label></td>
            <td><button onclick="add_new_openbal();return false;" id="addopenbal">+</button></td>
            </tr>  
        </thead>
        <tbody>
                    <?php while($line = mysql_fetch_array($result3)){ ?>
            	  <tr rowversion="current" lineno="<?php echo $line['tran_detail_code']; ?>">
               	  <td class="openballocationcode"><label><?php echo $line['location_code']; ?></label><br /><?php echo get_location_desc($line['location_code']); ?></td>
            	  <td class="openbalprojectcode"><label><?php echo $line['project_code']; ?></label><br /><?php echo get_project_desc($line['project_code']); ?></td>
            	  <td class="openbalcost"><?php echo $line['price']; ?></td>
            	  <td class="openbalqty"><?php echo $line['qty']; ?></td>
            	  <td class="openbalsubtotal"><?php echo $line['price']*$line['qty']; ?></td>
             	  <td><button onclick='del_row(this);return false;' class='deletebutton'>-</button></td></tr>
            	  </tr>
            <?php } ?>
        </tbody>
    
      </table>


   </div> 
    <div class="childform" id="bom">
      <label>Production Time:</label><input id="bomtime" name="bomtime" class="num" value="0" />
      &nbsp; <label>Production Cost:</label><input id="bomcost" name="bomcost" class="num" value="0" />
               <table id="bomtable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td>Item</td><td>Location</td><td>Qty</td><td>UOM</td><td>Unit Cost</td></tr>
            <tr>
              <td>
                 <label desc="" class="textbox" id="bomstockcode" style="width:130px;"></label>
                 <button onclick="select_stock();return false;" style="min-width:20px;font-weight:bold">...</button>
            
            </td>
            <td>
            
            <select id="bomlocationcode" name="bomlocationcode" style="width:150px;padding:2px;" >
                   <option selected="selected" value="">- Not Applicable -</option>
                        <?php 
        $location=mysql_query("SELECT * FROM `location` ORDER BY location_code");
        while($line = mysql_fetch_object($location)){
        	echo "<option value='$line->location_code'>".$line->location_desc."</option>";
        }
        ?></select>
            </td>
            
                 <td><input class="num" id="bomqty" name="bomqty" maxlength="10" value="0" style="width:50px" />
      
            <td>
            <select id="bomuom" name="bomuom" style="width:60px;padding:2px;" >
                     
            </select>
           
             </td><td width="80px"><label class="num" id="bomunitcost"></label></td>
            <td><button onclick="add_new_bom();return false;" id="addopenbal">+</button></td>
            </tr>  
        </thead>
        <tbody>
               <?php echo mysql_num_rows($result4) ?>
               <?php while($line = mysql_fetch_array($result4)){ ?>
            	  <tr rowversion="current" bomid="<?php echo $line['bom_id']; ?>">
               	  <td class="bomstockcode"><label><?php echo $line['stock_code']; ?></label><br /><?php echo get_stock_desc($line['stock_code']); ?></td>
            	  <td class="bomlocationcode"><label><?php echo $line['location_code']; ?></label><br /><?php echo get_location_desc($line['location_code']); ?></td>
            	  <td class="bomqty"><?php echo $line['qty']; ?></td>
            	  <td class="bomuom"><?php echo $line['uom_code']; ?></td>
            	  <td class="bomcost"><?php echo get_stock_ref_cost($line['stock_code'],$line['uom_code']); ?></td>
             	  <td><button onclick='del_row(this);return false;' class='deletebutton'>-</button></td></tr>
            	  </tr>
            <?php } ?>
        </tbody>
    
      </table>  
    

   
    

   </div> 
   <br />
 <button style="width:250px;" class='form deletebutton'>Delete Stock Item</button>
 
   <script type='text/javascript'>
function replacer(key, value) {
    if (typeof value === 'number' && !isFinite(value)) {
        return String(value);
    }
    
    return value;
}


   function select_stock(){
   	 $("#itemlookup").aodialog("open");
   	 return false;
   }
   function set_default_uom(checkbox){
   	 
   	 var uomcode = $(checkbox).parent().parent().find(".uomcode").html();
   	 $("#uomtable tbody tr td input:checked").attr("checked","");
   	 $(checkbox).attr("checked",true);
   	 $("#defaultuomlabel").text(uomcode);
   	 $("#uomid").val(uomcode);
   	 return false;
   }
   
     function del_row(button){
          var data=$(button).parent().parent();
          $current_version=$(data).attr("rowversion");
          $(data).attr("rowversion","delete");
          if($(data).find("input:checkbox").is(":checked")){
        	  	$("#defaultuomlabel").text("");
       	        $("#uomid").val("");
              }
           if($current_version=="new") $(data).remove();
           else $(data).hide();
          return false;
     }
     function IsNumeric(input){
           return (input - 0) == input && input.length > 0;
     }
     
     function add_new_uom(){
     	
     	var _uomcode = $("#uomcode").val();
     	if($("#uomtable tbody tr td").is(":contains('"+_uomcode+"')"))return false;
     	var _uomrate = $("#uomrate").val();
     	var _uomrefcost = $("#uomrefcost").val();
     	var _uomrefprice=$("#uomrefprice").val();
     	var _minprice = $("#minprice").val();
      	if(_uomcode=="") return false;
      	
      	if(_uomrate<1 || !IsNumeric(_uomrate)) return false;
      	if(_uomrefcost<0 || !IsNumeric(_uomrefcost)) return false;
      	if(_uomrefprice<0 ||!IsNumeric(_uomrefprice)) return false;
      	if(_minprice<0 || !IsNumeric(_minprice)) return false;
      	
      	 var uomcode = "<td class='uomcode'>"+_uomcode+"</td>";
         var uomrate = "<td class='uomrate'>"+_uomrate+"</td>";
         var uomrefcost = "<td class='uomrefcost'>"+_uomrefcost+"</td>";
         var uomrefprice = "<td class='uomrefprice'>"+_uomrefprice+"</td>";
         var minprice = "<td class='uomminprice'>"+_minprice+"</td>";
         
         if($("#defaultuom").attr("checked")){
         	_defaultuom="<input checked='checked' type='checkbox' onclick='set_default_uom(this);' />";
         	$("#defaultuomlabel").text(_uomcode);
   	        $("#uomid").val(_uomcode);
   	        $("#uomtable tbody tr .defaultuom input:checkbox").attr("checked","");
            $("#uomtable tbody tr .defaultuom").attr("value","false");
            
            
         } 
         else {
               	 _defaultuom="<input type='checkbox' onclick='set_default_uom(this);' />";
         }
         
         var defaultuom = "<td class='defaultuom' value='false'>"+_defaultuom+"</td>";
         
         $("#uomtable tbody").append("<tr rowversion='new'>"+uomcode+uomrate+uomrefcost+uomrefprice+minprice+defaultuom+"<td><button onclick='del_row(this);' class='deletebutton'>-</button></td></tr>");
         $("#uomcode").val("");
         $("#uomrate").val("");
         $("#uomrefcost").val("");
         $("#uomrefprice").val("");
         $("#minprice").val("");
         $("#defaultuom").attr("checked","");
	     return false;
      }    
       function add_new_openbal(){
      	var _openballocationcode = $("#openballocationcode").val();
      	var _openballocationdesc = $("#openballocationcode option[value='"+_openballocationcode+"']").text();
       	var _openbalprojectcode = $("#openbalprojectcode").val();
       	var _openbalprojectdesc = $("#openbalprojectcode option[value='"+_openbalprojectcode+"']").text();
     	var _openbalcost = $("#openbalcost").val();
     	var _openbalqty=$("#openbalqty").val();
      	var _openbalsubtotal=_openbalqty*_openbalcost;
      	
      	if(_openbalcost<1 || !IsNumeric(_openbalcost)) return false;
      	if(_openbalqty<0 || !IsNumeric(_openbalqty)) return false;
      	
      	 var openballocationcode = "<td class='openballocationcode'><label>"+_openballocationcode+"</label><br />"+_openballocationdesc+"</td>";
         var openbalprojectcode = "<td class='openbalprojectcode'><label>"+_openbalprojectcode+"</label><br />"+_openbalprojectdesc+"</td>";
         var openbalcost = "<td class='openbalcost'>"+_openbalcost+"</td>";
         var openbalqty = "<td class='openbalqty'>"+_openbalqty+"</td>";
         var openbalsubtotal = "<td class='openbalsubtotal'>"+_openbalsubtotal+"</td>";
           
         $("#openbaltable tbody").append("<tr rowversion='new'>"+openballocationcode+openbalprojectcode+openbalcost+openbalqty+openbalsubtotal+"<td><button onclick='del_row(this);' class='deletebutton'>-</button></td></tr>");
         $("#openballocationcode").val("");
         $("#openbalprojectcode").val("");
         $("#openbalcost").val("");
         $("#openbalqty").val("");
        
	     return false;
      }
      function add_new_bom(){
      	var _bomstockcode = $("#bomstockcode").text();
      	var _bomstockdesc = $("#bomstockcode").attr("desc");
       	var _bomlocationcode = $("#bomlocationcode").val();
       	var _bomlocationdesc = $("#bomlocationcode option[value='"+_bomlocationcode+"']").text();
       	var _bomuom=$("#bomuom").val();
     	var _bomqty = $("#bomqty").val();
        var _bomcost=$("#bomuom option[value='"+_bomuom+"']").attr('cost');
      	
      	if(_bomstockcode=="") return false;
      	if(_bomuom=="") return false;
      	if(_bomqty<1 || !IsNumeric(_bomqty)) return false;
      	
      	 var bomstockcode = "<td class='bomstockcode'><label>"+_bomstockcode+"</label><br />"+_bomstockdesc+"</td>";
         var bomlocationcode = "<td class='bomlocationcode'><label>"+_bomlocationcode+"</label><br />"+_bomlocationdesc+"</td>";
         var bomqty = "<td class='bomqty'>"+_bomqty+"</td>";
         var bomuom = "<td class='bomuom'>"+_bomuom+"</td>";

         var bomcost = "<td class='bomcost'>"+_bomcost+"</td>";
           
         $("#bomtable tbody").append("<tr rowversion='new'>"+bomstockcode+bomlocationcode+bomqty+bomuom+bomcost+"<td><button onclick='del_row(this);' class='deletebutton'>-</button></td></tr>");
         $("#bomstockcode").text("");
         $("#bomlocationcode").val("");
         $("#bomqty").val("");
         $("#bomuom").val("");
        
	     return false;
      } 
      $(function(){
          $(".subform .tab li  a").click(function(){
          	    $(".subform .tab li").removeClass("active");
          	    $(".childform:visible").hide();   
          	    $(this).parent().addClass("active"); 
                 var _tabid=$(this).attr("href");
                 $(_tabid).show();   
     
                 return false;       	 
          });
          

      });
       </script>
   
   
   </div>  

     <input type='hidden' id='action' name='action' value='update' />
     <input type='hidden' id='childdata' name='childdata' value='' />
   
          
 <script type='text/javascript'>
$(function(){
	$.validator.addMethod("uom", function(value, element, params) {  
		if($.trim($("#uomid").val())=="") return false;
		else return true;  
     }, "Please select a default UOM.");
	 
	$('#frm').validate({
	  	debug:true,
		rules: {
			desc: {
				required: true
			},
			reorderlevel: {
				number: true
			},
			reorderqty: {
				number: true
			},
			uomid:{
				uom:true
			}

		},
		messages:{
	    desc:"Please enter the description for this Stock Code"
	   },
	   submitHandler: function(form) {
        
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     $('#savedialog').aodialog('open');
	   	   
      	   }
     });	
      $('.form.deletebutton').click(function(){
   	    $('#deletedialog').aodialog('open');
		return false;	
   });
  $('#deletedialog').aodialog({
  	okay: function(){
        
		$.post('../callback/stock_form.php',{code:'<?php echo $data['stock_code']; ?>',action:'delete'},function(e){

			   $('#deletedialog').aodialog('close');
   	       
  	   		   open_menu('stock_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	});  
	$('#savedialog').aodialog({
  	okay: function(){
          var p=$('#frm').serialize();
	   	     var arr={uom:[],openbal:[],bom:[]};

             var row=[];
             var index=0;
	   	     $("#uomtable tbody tr").each(function(){
	 
	   	     	if($(this).attr('rowversion')!='current'){
  	     	  	 row[index]={rowversion:$(this).attr('rowversion'),uomcode:$(this).find(".uomcode").html(),uomrate:$(this).find(".uomrate").html(),uomrefcost:$(this).find(".uomrefcost").html(),uomrefprice:$(this).find(".uomrefprice").html(),uomminprice:$(this).find(".uomminprice").html()};	 
  	     	  	 index=index+1;
	   	     	} 
	   	     });
	   	     arr.uom=row;
	         
	         var row=[];
             var index=0;
	   	    $("#openbaltable tbody tr").each(function(){
	   	      if($(this).attr('rowversion')!='current'){
	   	     	row[index]={rowversion:$(this).attr('rowversion'),lineno:$(this).attr('lineno'),openballocationcode:$(this).find(".openballocationcode label").text(),openbalprojectcode:$(this).find(".openbalprojectcode label").text(),openbalqty:$(this).find(".openbalqty").html(),openbalcost:$(this).find(".openbalcost").html()};
	   	       index=index+1; }
	   	     });
	   	    arr.openbal=row;
	   	     var row=[];
             var index=0;
	   	    $("#bomtable tbody tr").each(function(){
	   	      if($(this).attr('rowversion')!='current'){
	   	     	row[index]={rowversion:$(this).attr('rowversion'),bomid:$(this).attr('bomid'),bomstockcode:$(this).find(".bomstockcode label").text(),bomlocationcode:$(this).find(".bomlocationcode label").text(),bomqty:$(this).find(".bomqty").html(),bomuom:$(this).find(".bomuom").html()};
	   	       index=index+1; }
	   	     });
	   	    arr.bom=row;
	   	    $("#childdata").val(JSON.stringify(arr,replacer));

      	    $.post('../callback/stock_form.php',$('#frm').serialize(),function(e){
      	    	 $('#savedialog').aodialog('close'); 
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('stock_browse');	
      	     	}
      	    	
      	       unload_busy('.contentbox .c');	
      	     });
	
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
$("#itemlookup").aodialog({
	        okay:function(){
	        	$("#bomstockcode").text($("#findstock .browse.tbody .selected #code").html());
	        	$("#bomstockcode").attr('desc',$("#findstock .browse.tbody .selected #desc").html());
	            $("#bomuom").hide();
	            $("#bomuom").html("");
	        	$("#bomuom").after("<span id='wait'><img src='../images/waitingx16.gif'></span>");
	        	$.post("../callback/get_stock_uom_options.php",{stockcode:$("#bomstockcode").text()},
	        	function(e){
	         		$("#bomuom").html(e);
	        	    $("#wait").remove();
	        	    $("#bomuom").show();
	        	});
	         	$("#itemlookup").aodialog("close");
	         	
	        },
	        height:220,
	        width:620,
	        okayText:'Use',
	        cancelText:'Close'
	});	
});
</script>
<div>
</div> 

</form>
    
 <div  id="deletedialog">
     Delete this Stock Item?
</div>
 <div  id="savedialog">
     Save changes?
</div>
<div>
</div>
  
     <br />
     <br />
   <div id="itemlookup">
    <?php include "../include/findstock.php"; ?>
</div>   
<?php  //- END OF EDIT FORM -?>
<?php } else { ?>
<form id='frm' name='frm'>

<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('stock_adjustment_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
       <label>Stk Adj #:</label><label class="textbox" style="width:80px">&lt;&lt;NEW&gt;&gt;</label><br/>
       <input type="checkbox" id="writeoff" name="writeoff" /><label for="writeoff">Write Off</label>
     </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Adj Date:</td><td><input maxlength='45' class="dt" id='trandate' name='trandate' /></td></tr>
      <tr><td>Reason:</td><td><input maxlength='255' id='reason' name='reason'  /></td></tr> 
      <tr><td>Authorised by:</td><td><input maxlength='150' id='authorisedby' name='authorisedby'  /></td></tr> 

 </table>
  <label>Remark:</label><br />
  <textarea id="remark" name="remark" maxlength="255" style="width:50%" />
     <hr />
     
 <div class="subform" id="subform">
   
    <div class="browse">
      <table id="detailTable" cellpadding="0" cellspacing="0">
        <thead>
            <tr><td width="170">Item</td><td>Location</td><td>Project</td><td width="50">Cost</td><td width="50">Qty</td><td>UOM</td><td width="80">Total</td><td></td></tr>
       <tr>
             <td>
                 <label desc="" class="textbox" id="stockcode" style="width:130px;"></label>
                 <button onclick="select_stock();return false;" style="min-width:20px;font-weight:bold">...</button>
            
            </td>   
            <td>
            <select id="locationcode" name="locationcode" style="width:50px;padding:2px;" >
                   <option selected="selected" value="">- N/A -</option>
                        <?php 
        $location=mysql_query("SELECT * FROM `location` ORDER BY location_code");
        while($line = mysql_fetch_object($location)){
        	echo "<option value='$line->location_code'>".$line->location_desc."</option>";
        }
        ?></select>
            </td><td>
            <select id="projectcode" name="projectcode" style="width:50px;padding:2px;" >
                        <option selected="selected" value="">- N/A -</option>
                        <?php 
        $project=mysql_query("SELECT * FROM `project` ORDER BY project_code");
        while($line = mysql_fetch_object($project)){
        	echo "<option value='$line->project_code'>".$line->project_desc."</option>";
        }
        ?>
            </select>
            
            </td><td><input class="num" id="cost" name="cost" maxlength="10" style="width:40px" /></td>
            <td><input class="num" id="qty" name="qty" maxlength="10" style="width:40px" /></td>
            <td><select id="uom" name="uom" style="width:40px;padding:2px;"></select></td>
            <td><label class="num" id="subtotal"></label></td>
            
            <td><button onclick="add_new_detail();return false;" id="add">+</button></td>
            </tr>  
        </thead>
            <tbody >
                 <tr class="firstrow"><td ></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            </tbody>
        <tfoot>
            <tr><td>Records:</td><td></td><td></td><td></td><td></td><td>Total:</td><td class="num"><label  id="nettotal"></label><input type="hidden" id="netamt" name="netamt" value="" /></td><td></td></tr>
        </tfoot>
    
      </table>
    
       </div> 
   </div> 

   <script type='text/javascript'>
function replacer(key, value) {
    if (typeof value === 'number' && !isFinite(value)) {
        return String(value);
    }
    
    return value;
}
   function select_stock(){
   	 $("#itemlookup").dialog("open");

   	 return false;
   }
   
     function del_row(button){
          var data=$(button).parent().parent();
          $(data).attr("rowversion","delete");
         $(data).remove();
          return false;
     }
     function IsNumeric(input){
           return (input - 0) == input && input.length > 0;
     }
     
     function add_new_detail(){
        var _stockcode = $("#stockcode").text();
      	var _stockdesc = $("#stockcode").attr("desc");
      	var _locationcode = $("#locationcode").val();
      	var _locationdesc = $("#locationcode option[value='"+_locationcode+"']").text();
       	var _projectcode = $("#projectcode").val();
       	var _projectdesc = $("#projectcode option[value='"+_projectcode+"']").text();
     	var _cost = $("#cost").val();
     	var _qty=$("#qty").val();
        var _uom=$("#uom").val();
      	var _subtotal=_qty*_cost;
      	
      	   

      	if(_stockcode=="") return false;
      	if(!IsNumeric(_cost)) return false;
      	if(_qty==0 || !IsNumeric(_qty)) return false;
      	
         var hasMerge = false;
         //merge if exist
         $("#detailTable tbody tr .stockcode:contains("+_stockcode+")").each(function(){
         	 var tr=$(this).parent();
         	 if($(tr).find(".locationcode").text()==_locationcode && $(tr).find(".projectcode").text()==_projectcode && $(tr).find(".cost").text()==_cost && $(tr).find(".uomcode").text()==_uom){
         	 	  var eqty= parseFloat($(tr).find(".qty").text());
         	 	  var ecost= parseFloat($(tr).find(".cost").text());
         	 	  
         	 	  eqty=parseFloat(_qty)+parseFloat(eqty);
         	 	  $(tr).find(".qty").text(eqty);
         	 	  $(tr).find(".subtotal").text(ecost*eqty);
         	 	  hasMerge=true;
         	 }
         }); 
         
        if(!hasMerge){
      	
      	 var stockcode = "<td class='stockcode'><label>"+_stockcode+"</label><br />"+_stockdesc+"</td>"; 
      	 var locationcode = "<td class='locationcode'><label>"+_locationcode+"</label><br /></td>";
         var projectcode = "<td class='projectcode'><label>"+_projectcode+"</label><br /></td>";
         var cost = "<td class='cost num'>"+_cost+"</td>";
         var qty = "<td class='qty num'>"+_qty+"</td>";
         var uom = "<td class='uomcode'>"+_uom+"</td>";
         var subtotal = "<td class='subtotal num'>"+_subtotal+"</td>";
       
           
          var _newrow= $("#detailTable tbody").append("<tr rowversion='new'>"+stockcode+locationcode+projectcode+cost+qty+uom+subtotal+"<td><button onclick='del_row(this);' class='deletebutton'>-</button></td></tr>");

        }
           $(".subtotal").format({format:"#.00"});
       
        var sum=0;
         $("#detailTable tbody tr .subtotal").each(function(){
         	 var subtotal=parseFloat($(this).text());
         	 sum=sum+subtotal;
         });
         $("#nettotal").text(sum);
         $("#netamt").val(sum);
         $("#nettotal").format({format:"#,###.00"});
         $("#stockcode").text("");
         $("#locationcode").val("");
         $("#projectcode").val("");
         $("#cost").val("");
         $("#qty").val("");
         $("#uom").val("");
	     return false;
      }
      
       </script>

   </div>  

     <input type='hidden' id='action' name='action' value='save' />
     <input type='hidden' id='childdata' name='childdata' value='' />
 
 <script type='text/javascript'>
$(function(){
	
	         $("#uom").change(function(){
	               $(this).parent().parent().find("#cost").val($(this).find("option[value='"+$(this).val()+"']").attr("cost"));
	                 
	         }); 
	         $("#cost").blur(function(){
	                 $(this).format({format:"#.00"});
	         }); 
	
    $("#trandate").datepicker({dateFormat:"dd/mm/yy"});
    $("#detailTable").tableScroll({height:'140',width:'600'});

     $.validator.addMethod(
    "DMY",
    function(value, element) {

        if(!value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/)){
           return false;
        }	
        try{
         var USdate = $.datepicker.parseDate('dd/mm/yy',value);
        }catch(e){
        	return false;
        }
        if(USdate>=new Date("1/1/1900") && USdate<= new Date("12/31/9999")){
                return true;
         }
             
       return false;
       
    },
    "Please enter a date in the format dd/mm/yyyy"
    );
     
	$('#frm').validate({
	  	debug:true,
		rules: {
			trandate: {
				required: true,
				DMY:true
			}

		},
	   submitHandler: function(form) {
	      


	   
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     var p=$(form).serialize();
	   	     var arr={detail:[]};
             
             var row=[];
             var index=0;
             
	   	     $("#detailTable tbody tr:gt(0)").each(function(){  
	      	 	   row[index]={rowversion:$(this).attr('rowversion'),stockcode:$(this).find(".stockcode label").text(),locationcode:$(this).find(".locationcode label").text(),projectcode:$(this).find(".projectcode label").text(),cost:$(this).find(".cost").html(),qty:$(this).find(".qty").html(),uomcode:$(this).find(".uomcode").html(),subtotal:$(this).find(".subtotal").html()};
  	     	  	   index=index+1;

	   	     });
	   	     arr.detail=row;
	   	    $("#childdata").val(JSON.stringify(arr,replacer));

      	    $.post('../callback/stock_adjustment_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('stock_adjustment_browse');	
      	     	}
      	       	
      	       unload_busy('.contentbox .c');	
      	     });
      	   }
     });	 
     
    $("#itemlookup").dialog("destroy");
	$("#itemlookup").dialog({
		open: function(event, ui){
			$.post("../callback/findstock.php",{},function(e){
				$("#itemlookup").html(e);
			});
		},
		 buttons:{
		 	'Close':function(){
	        	  	$(this).dialog("close");
	        }, 	
	        'Use':function(){
	        	$("#stockcode").text($("#findstock #findItemTable .selected #code").html());
	        	$("#stockcode").attr('desc',$("#findstock #findItemTable .selected #desc").html());
	            $("#uom").hide();
	            $("#uom").html("");
	        	$("#uom").after("<span id='wait'><img src='../images/waitingx16.gif'></span>");
	        	$.post("../callback/get_stock_uom_options.php",{stockcode:$("#stockcode").text()},
	        	function(e){
	         		$("#uom").html(e);
	         	    $("#cost").val($("#uom option[value='"+$("#uom").val()+"']").attr("cost"));
	        	    $("#wait").remove();
	        	    $("#uom").show();
	        	    $("#qty").focus();
	        	});
	         	$(this).dialog("close");
	         	
	        }
	        },
	        autoOpen: false,
	        height:540,
	        width:660,
	        modal:true
	});
	
});
</script>
<div>
</div> 

</form>
    

  
     <br />
     <br />

 <div id="itemlookup">

</div>

<?php } ?>