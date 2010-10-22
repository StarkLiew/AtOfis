<?php
 session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $sql="DELETE  FROM `supplier` WHERE acc_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){
 	    $code=mysql_real_escape_string($_POST['code']);
   	    //check supplier code availibilty
   	     if( is_supp_code_exist($code)) {
   	     	 echo "This Supplier Account Code had been taken.";
   	     	 exit;
   	     } 
     	$desc=mysql_real_escape_string($_POST['desc']);
   	    $address1=mysql_real_escape_string($_POST['address1']);
   	    $address2=mysql_real_escape_string($_POST['address2']);
   	    $address3=mysql_real_escape_string($_POST['address3']);
   	    $address4=mysql_real_escape_string($_POST['address4']);
   	    $contact=mysql_real_escape_string($_POST['contact']);
   	    $telno=mysql_real_escape_string($_POST['telno']);
   	    $telno2=mysql_real_escape_string($_POST['telno2']);
   	    $faxno=mysql_real_escape_string($_POST['faxno']);
   	    $email=mysql_real_escape_string($_POST['email']);
   	    $website=mysql_real_escape_string($_POST['website']);
   	    $areacode=mysql_real_escape_string($_POST['areacode']);
   	    $agentcode=mysql_real_escape_string($_POST['agentcode']);
   	    $termcode=mysql_real_escape_string($_POST['termcode']);
   	    $currencycode=mysql_real_escape_string($_POST['currencycode']);
   	    $creditlimit=mysql_real_escape_string($_POST['creditlimit']);
   	    $ingorecreditlimit=mysql_real_escape_string($_POST['ingorecreditlimit']);
   	    $active=mysql_real_escape_string($_POST['active']);
   	     if(empty($creditlimit)) $creditlimit=0;
   	    if(empty($outstanding)) $outstanding=0;
   	    if($active) $active='Y'; else $active='N';
   	    if($ingorecreditlimit) $ingorecreditlimit='Y'; else $ingorecreditlimit='N';
   	    $sql="INSERT INTO supplier".
             "(acc_code, supp_desc,".
             " supp_telno, supp_telno2,".
             " supp_fax, supp_contact,".
             " supp_email, supp_website,".
             " active,".
             " area_code, agent_code,".
             " currency_code, term_code,".
             " credit_limit,".
             " ingore_credit_limit,supp_address1,".
             " supp_address2, supp_address3,".
             " supp_address4) VALUES (".
             " '$code','$desc','$telno','$telno2','$faxno','$contact',".
             " '$email','$website','$active',".
             " '$areacode','$agentcode','$currencycode','$termcode',".
             " $creditlimit,'$ingorecreditlimit',".
             " '$address1','$address2','$address3','$address4')";         
   
   	     $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error().$sql);
   	    
   	    exit;
   	    
   }
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='update'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $desc=mysql_real_escape_string($_POST['desc']);
   	    $address1=mysql_real_escape_string($_POST['address1']);
   	    $address2=mysql_real_escape_string($_POST['address2']);
   	    $address3=mysql_real_escape_string($_POST['address3']);
   	    $address4=mysql_real_escape_string($_POST['address4']);
   	    $contact=mysql_real_escape_string($_POST['contact']);
   	    $telno=mysql_real_escape_string($_POST['telno']);
   	    $telno2=mysql_real_escape_string($_POST['telno2']);
   	    $faxno=mysql_real_escape_string($_POST['faxno']);
   	    $email=mysql_real_escape_string($_POST['email']);
   	    $website=mysql_real_escape_string($_POST['website']);
   	    $areacode=mysql_real_escape_string($_POST['areacode']);
   	    $agentcode=mysql_real_escape_string($_POST['agentcode']);
   	    $termcode=mysql_real_escape_string($_POST['termcode']);
   	    $currencycode=mysql_real_escape_string($_POST['currencycode']);
   	    $creditlimit=mysql_real_escape_string($_POST['creditlimit']);
   	    $ingorecreditlimit=mysql_real_escape_string($_POST['ingorecreditlimit']);
   	    $active=mysql_real_escape_string($_POST['active']);
   	     if(empty($creditlimit)) $creditlimit=0;
   	    if(empty($outstanding)) $outstanding=0;
   	    if($active) $active='Y'; else $active='N';
   	    if($ingorecreditlimit) $ingorecreditlimit='Y'; else $ingorecreditlimit='N';
   	   
   	    $sql="UPDATE supplier SET ".
             " supp_desc='$desc',".
             " supp_telno='$telno', " .
             " supp_telno2='$telno2',".
             " supp_fax='$faxno', " .
             " supp_contact='$contact',".
             " supp_email='$email', " .
             " supp_website='$website',".
             " active='$active'," .
             " area_code='$areacode'," .
             " agent_code='$agentcode',".
             " currency_code='$currencycode', " .
             " term_code='$termcode',".
             " credit_limit='$creditlimit',".
             " ingore_credit_limit='$ingorecreditlimit'," .
             " supp_address1='$address1',".
             " supp_address2='$address2'," .
             " supp_address3='$address3',".
             " supp_address4='$address4'" .
             " WHERE acc_code='$code'";
             

   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error().$sql);
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT".
    	     " acc_code, supp_desc,".
    	     " supp_address1, supp_address2,".
             " supp_address3, supp_address4,".
             " supp_contact,supp_telno,".
             " supp_telno2, supp_fax, ".
             " supp_email, supp_website,".
             " active,".
             " area_code, term_code, agent_code,".
             " currency_code,".
             " credit_limit,ingore_credit_limit ".
    	     " from `supplier` WHERE acc_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('supplier_form',{action:'edit',code:'<?php echo $data[0]; ?>'});return false;">Edit</button><button onclick="open_menu('supplier_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
      <table>
      <tr><td>Account Code:</td><td><label class="textbox"><?php echo $data[0]; ?></label></td></tr>
     <tr><td>Description:</td><td><label class="textbox"><?php echo $data[1]; ?></label></td></tr>
           <tr><td>Address:</td>
      <td>
      <div class="addressbox">
      <label class="address"><?php echo $data[2]; ?></label>
      <label class="address"><?php echo $data[3]; ?></label>
      <label class="address"><?php echo $data[4]; ?></label>
      <label class="address"><?php echo $data[5]; ?></label>
      
        </div>
   
      </td></tr>
     <tr><td>Contact Person:</td><td><label class="textbox"><?php echo $data[6]; ?></label></td></tr> 
     <tr><td>Phone:</td><td><label class="textbox"><?php echo $data[7]; ?></label></td></tr> 
     <tr><td>Phone 2:</td><td><label class="textbox"><?php echo $data[8]; ?></label></td></tr> 
     <tr><td>Fax:</td><td><label class="textbox"><?php echo $data[9]; ?></label></td></tr> 
     <tr><td>Email:</td><td><label class="textbox"><?php echo $data[10]; ?></label></td></tr>
     <tr><td>Website:</td><td><label class="textbox"><?php echo $data[11]; ?></label></td></tr>
      
     <tr><td>Active:</td><td><label class="textbox"><?php if($data[12]=='Y') echo 'YES'; else echo 'NO'; ?></label></td></tr> 
     <tr><td colspan="2"><hr /> <td></tr>
      <tr><td>
      <label for='areacode'>Area:</label></td><td>
         <label class="textbox"><?php echo  get_area_desc($data[13]); ?></label>
      </td>     
      </tr>
      <tr> <td>
            <label for='termcode'>Credit Terms:</label></td><td>
             <label class="textbox"><?php echo get_term_desc($data[14]); ?></label>
      </td>
      
      </tr>
      <tr><td>
      <label for='agentcode'>Agent:</label></td><td>
       <label class="textbox"><?php echo get_agent_desc($data[15]); ?></label>
      </td>  </tr>
      <tr>
     </tr>
      <tr>
      <td>
         <label for='currencycode'>Currency:</label></td><td>
        <label class="textbox"><?php echo $data[16]; ?></label>
      </td>
      </tr> 

 
      <tr><td colspan="2"> <hr /></td></tr>
      <tr><td>
     <label for='creditlimit'>Credit Limit:</label>
     </td><td>
     <label class="textbox"><?php echo $data[17]; ?></label>
     </td></tr>
       </table>
     <?php if($data[18]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?>&nbsp;<label>Ingore Credit Limit</label><br />
         
     <br />
     <br />
<div>
</div>
<?php }elseif($_POST['action']=='edit'){ ?>
	   <form id='frm' name='frm'>
	<div class='form'>
<button style='float:right;' type="submit">Save</button>
<button  onclick="open_menu('supplier_browse');return false;">Cancel</button>

<div class='form body'>
 <div style='float:right'>
     <input type='checkbox' <?php if($data[12]=='Y')echo 'checked="checked"'; ?> id='active' name='active'></input><label for='active'>Active</label>
    </div>
    
    <table>
      <tr><td width="150px">Account Code:</td><td><input maxlength='10' id='code' name='code' value="<?php echo $data[0]; ?>" /></td></tr>
      <tr><td>supplier Name:</td><td><input maxlength='150' id='desc' name='desc' value="<?php echo $data[1]; ?>"  /></td></tr> 
      <tr><td>Address:</td><td>
      <div class="addressbox">
      <input class='address' maxlength='150' id='address1' name='address1'  value="<?php echo $data[2]; ?>"  /><br/>
      <input class='address' maxlength='150' id='address2' name='address2' value="<?php echo $data[3]; ?>"  /><br/>
      <input class='address' maxlength='150' id='address3' name='address3' value="<?php echo $data[4]; ?>"  /><br/>
      <input class='address' maxlength='150' id='address4' name='address4' value="<?php echo $data[5]; ?>"   /></td></tr>
      </div>
      <tr><td>Contact Person:</td><td><input maxlength='150' id='contact' name='contact' value="<?php echo $data[6]; ?>"  /></td></tr>
      <tr><td>Phone:</td><td><input maxlength='150' id='telno' name='telno' value="<?php echo $data[7]; ?>"  /></td></tr>
      <tr><td>Phone 2:</td><td><input maxlength='150' id='telno2' name='telno2' value="<?php echo $data[8]; ?>"  /></td></tr>
      <tr><td>Fax:</td><td><input maxlength='150' id='faxno' name='faxno' value="<?php echo $data[9]; ?>"  /></td></tr>
      <tr><td>Email:</td><td><input maxlength='255' id='email' name='email' value="<?php echo $data[10]; ?>"   /></td></tr>
      <tr><td>Website:</td><td><input maxlength='255' id='website' name='website' value="<?php echo $data[11]; ?>"  /></td></tr>
       </table>
       <hr />
      <table>
      <tr><td>
      <label for='areacode'>Area:</label></td><td>
      <Select  id='areacode'  name='areacode' >
      <option selected="selected" value="">Select One</option>
             <?php 
        $area=mysql_query("SELECT * FROM `area` ORDER BY area_desc");
        while($line = mysql_fetch_object($area)){
        	if($data[13]==$line->area_code) $selected="selected='selected'";
            else $selected="";
        	echo "<option ".$selected." value='$line->area_code'>".$line->area_desc."</option>";
        }
        ?>
      </Select>
      </td>
      <td>
            <label for='termcode'>Credit Terms:</label></td><td>
      <Select  id='termcode'  name='termcode' >
       <option selected="selected" value="">Select One</option>
        <?php 
        $terms=mysql_query("SELECT * FROM `term` ORDER BY term_day");
        while($line = mysql_fetch_object($terms)){
            if($data[14]==$line->term_code) $selected="selected='selected'";
            else $selected="";
        	echo "<option ".$selected." value='$line->term_code'>".$line->term_desc."</option>";
        }
        ?>
      </Select>
      </td>
      
      </tr>
      <tr><td>
      <label for='agentcode'>Agent:</label></td><td>
      <Select  id='agentcode'  name='agentcode' >
      <option selected="selected" value="">Select One</option>
                 <?php 
        $agent=mysql_query("SELECT * FROM `agent` ORDER BY agent_desc");
        while($line = mysql_fetch_object($agent)){
        	  if($data[15]==$line->agent_code) $selected="selected='selected'";
            else $selected="";
        	echo "<option ".$selected." value='$line->agent_code'>".$line->agent_desc."</option>";
        }
        ?>
      </Select>
      </td>
     
      <td>
         <label for='currencycode' >Currency:</label></td><td>
      <Select  id='currencycode' name='currencycode' >
       <option value="">Select One</option>
                      <?php 
        $currency=mysql_query("SELECT * FROM `currency` ORDER BY currency_code");
        while($line = mysql_fetch_object($currency)){
        	
            if($data[16]==$line->currency_code) $selected="selected='selected'";
            else $selected="";
        	 
        	echo "<option ".$selected." value='$line->currency_code'>".$line->currency_code."</option>";
        }
        ?>
      </Select>
      </td>
      </tr> 

    </table>
    <hr />
     <label for='creditlimit'>Credit Limit:</label><input value="<?php echo $data[17]; ?>"  class="form num" maxlength='10' id='creditlimit' name='creditlimit'  />
     <input type='checkbox' <?php if($data[18]=='Y')echo 'checked="checked"'; ?> checked="checked"  id='ingorecreditlimit' name='ingorecreditlimit'></input><label for='ingorecreditlimit'>Ingore Credit Limit</label><br />
  <br />
       <button style="width:250px;" class='form deletebutton'>Delete Supplier</button>
     
         <input type='hidden' id='action' name='action' value='update' />
      <input type='hidden' id='code' name='code' value='<?php echo $data[0]; ?>' />
   <script type='text/javascript'>

   
$(function(){
	$('#frm').validate({
	  	debug:true,
		rules: {
			desc: {
				required: true
			},			
			termcode: {
				required: true
			},
			currencycode: {
				required: true
			},	
			creditlimit: {
				number: true
			}	
		},
		messages:{
	    desc:"Please enter the description for this Account Code",
	    termcode:"Please select one Credit Term",
	    currencycode:"Please select one Currency"
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
        
		$.post('../callback/supplier_form.php',{code:'<?php echo $data[0]; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('supplier_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/supplier_form.php',$('#frm').serialize(),function(e){
	   	        $('#savedialog').aodialog('close');
	   	     
	   	      if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	 	   open_menu('supplier_browse');
      	     	}
			
			   
  	   	
  	   		   	
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
});

	


</script>   
     <br />
     <br />
        <br />
     <br />
  <div  id="deletedialog">
     Delete this Supplier?
</div>
 <div  id="savedialog">
     Save changes?
</div>


<div>
</div>
 </form>
<?php }else{ ?>
<form id='frm' name='frm'>
<div class='form'>
<button style='float:right;'>Save</button>
<button onclick="open_menu('supplier_browse');return false;">Cancel</button>

<div class='form body'>
 <div style='float:right'>
     <input type='checkbox' checked="checked" id='active' name='active'></input><label for='active'>Active</label>
   </div>
    
    <table>
      <tr><td width="150px">Account Code:</td><td><input maxlength='10' id='code' name='code'  /></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc'  /></td></tr> 
      <tr><td>Address:</td><td>
      <div class="addressbox">
      <input class='address' maxlength='150' id='address1' name='address1'  /><br/>
      <input class='address' maxlength='150' id='address2' name='address2'  /><br/>
      <input class='address' maxlength='150' id='address3' name='address3'  /><br/>
      <input class='address' maxlength='150' id='address4' name='address4'  /></td></tr>
      </div>
      <tr><td>Contact Person:</td><td><input maxlength='150' id='contact' name='contact'  /></td></tr>
      <tr><td>Phone:</td><td><input maxlength='150' id='telno' name='telno'  /></td></tr>
      <tr><td>Phone 2:</td><td><input maxlength='150' id='telno2' name='telno2'  /></td></tr>
      <tr><td>Fax:</td><td><input maxlength='150' id='faxno' name='faxno'  /></td></tr>
      <tr><td>Email:</td><td><input maxlength='255' id='email' name='email'  /></td></tr>
      <tr><td>Website:</td><td><input maxlength='255' id='website' name='website'  /></td></tr>

    </table>
     <hr />
    <table>
      <tr><td>
      <label for='areacode'>Area:</label></td><td>
      <Select  id='areacode' name='areacode' >
       <option selected="selected" value="">Select One</option>
             <?php 
        $area=mysql_query("SELECT * FROM `area` ORDER BY area_desc");
        while($line = mysql_fetch_object($area)){
        	echo "<option value='$line->area_code'>".$line->area_desc."</option>";
        }
        ?>
      </Select>
      </td>
      <td>
            <label for='termcode'>Credit Terms:</label></td><td>
      <Select  id='termcode' name='termcode' >
       <option selected="selected" value="">Select One</option>
        <?php 
        $terms=mysql_query("SELECT * FROM `term` ORDER BY term_day");
        while($line = mysql_fetch_object($terms)){
        	echo "<option value='$line->term_code'>".$line->term_desc."</option>";
        }
        ?>
      </Select>
      </td>
      
      </tr>
      <tr><td>
      <label for='agentcode'>Agent:</label></td><td>
      <Select  id='agentcode' name='agentcode' >
       <option selected="selected" value="">Select One</option>
                 <?php 
        $agent=mysql_query("SELECT * FROM `agent` ORDER BY agent_desc");
        while($line = mysql_fetch_object($agent)){
        	echo "<option value='$line->agent_code'>".$line->agent_desc."</option>";
        }
        ?>
      </Select>
      </td>

      <td>
         <label for='currencycode'>Currency:</label></td><td>
      <Select  id='currencycode' name='currencycode' >
       <option selected="selected" value="">Select One</option>
                      <?php 
        $currency=mysql_query("SELECT * FROM `currency` ORDER BY currency_code");
        while($line = mysql_fetch_object($currency)){
        	echo "<option value='$line->currency_code'>".$line->currency_code."</option>";
        }
        ?>
      </Select>
      </td>
      </tr> 

    </table>
    <hr />
     <label for='creditlimit'>Credit Limit:</label><input class="form num" maxlength='10' id='creditlimit' name='creditlimit'  />
       <input type='checkbox' id='ingorecreditlimit' name='ingorecreditlimit'></input><label for='ingorecreditlimit'>Ingore Credit Limit</label>
      <br />
     <br />
     <input type='hidden' id='action' name='action' value='save' />
 
   <script type='text/javascript'>
$(function(){

	$('#frm').validate({
	  	debug:true,
		rules: {
			code: {
				required: true
			},
			desc: {
				required: true
			},
			termcode: {
				required: true
			},
			currencycode: {
				required: true
			},
			creditlimit: {
				number: true
			}
		},
		messages:{
		code: "Please enter an unique Account Code.",
	    desc:"Please enter the description for this Account Code",
	    termcode:"Please select one Credit Term",
	    currencycode:"Please select one Currency"
	   },
	   submitHandler: function(form) {
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     
      	    $.post('../callback/supplier_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('supplier_browse');	
      	     	}
      	       	
      	       unload_busy('.contentbox .c');	
      	     });
      	   }
     });	 
	
});
</script>
 


<div>
</div>
 </form>
 <?php } ?>