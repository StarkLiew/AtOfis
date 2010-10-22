<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $sql="DELETE  FROM `location` WHERE location_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    //check custcode availibilty
   	     if( is_location_code_exist($code)) {
   	     	 echo "This Location Code had been taken.";
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
   	    $active=mysql_real_escape_string($_POST['active']);
   	 
   	    if($active) $active='Y';
   	    else $active='N';
   	    $sql="INSERT INTO `location`(location_code,location_desc,location_address1,location_address2,location_address3,location_address4,location_contact,location_telno,location_telno2,location_faxno,location_email,active) VALUES ('$code','$desc','$address1','$address2','$address3','$address4','$contact','$telno','$telno2','$faxno','$email','$active')";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
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
   	    $active=mysql_real_escape_string($_POST['active']);
  	    if($active) $active='Y';
   	    else $active='N';
   	    $sql="UPDATE `location` SET ".
   	         "location_desc='$desc',".
   	         "location_address1='$address1',".
   	         "location_address2='$address2',".
   	         "location_address3='$address3',".
   	         "location_address4='$address4',".
   	         "location_contact='$contact',".
   	         "location_telno='$telno',".
   	         "location_telno2='$telno2',".
      	     "location_faxno='$faxno',".
   	         "location_email='$email',".	         
             "active='$active'". 
   	         "WHERE location_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT location_code,location_desc,location_address1,location_address2,location_address3,location_address4,location_contact,location_telno,location_telno2,location_faxno,location_email,active from `location` WHERE location_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

   

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('location_form',{action:'edit',code:'<?php echo $data[0]; ?>'});" type='submit'>Edit</button><button onclick="open_menu('location_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
      <table>
      <tr><td>location Code:</td><td><label class="textbox"><?php echo $data[0]; ?></label></td></tr>
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
      <tr><td>Staus:</td><td><label class="textbox"><?php if($data[11]=='Y') echo 'ACTIVE'; else echo 'IN-ACTIVE'; ?></label></td></tr> 
    
    </table>
   <br />
     <br />
      
     <br />
     <br />
<div>
</div>
<?php }elseif($_POST['action']=='edit'){ ?>
   <form id='frm' name='frm'>

<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('location_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
     <input type='checkbox' <?php if($data[11]=='Y')echo 'checked="checked"'; ?> id='active' name='active'></input><label for='CustActive'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Location Code:</td><td><label class="textbox"><?php echo $data[0]; ?></label></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc' value="<?php echo $data[1]; ?>" /></td></tr> 
   
      <tr><td>Address:</td>
      <td>
      <div class="addressbox">
      <input class='address' maxlength='150' id='address1' name='address1' value="<?php echo $data[2]; ?>" /><br/>
      <input class='address' maxlength='150' id='address2' name='address2'  value="<?php echo $data[3]; ?>" /><br/>
      <input class='address' maxlength='150' id='address3' name='address3' value="<?php echo $data[4]; ?>"  /><br/>
      <input class='address' maxlength='150' id='address4' name='address4'  value="<?php echo $data[5]; ?>" /></td></tr>
      </div>
   
      </td></tr>
      <tr><td>Contact Person:</td><td><input maxlength='150' id='contact' name='contact' value="<?php echo $data[6]; ?>" /></td></tr> 
      <tr><td>Phone:</td><td><input maxlength='150' id='telno' name='telno' value="<?php echo $data[7]; ?>" /></td></tr> 
      <tr><td>Phone 2:</td><td><input maxlength='150' id='telno2' name='telno2' value="<?php echo $data[8]; ?>" /></td></tr> 
      <tr><td>Fax:</td><td><input maxlength='150' id='faxno' name='faxno' value="<?php echo $data[9]; ?>" /></td></tr> 
      <tr><td>Email:</td><td><input maxlength='150' id='email' name='email' value="<?php echo $data[10]; ?>" /></td></tr> 
      
       <tr><td></td><td> <button style="width:250px;" class='form deletebutton'>Delete location</button></td></tr>
    </table>
      <input type='hidden' id='action' name='action' value='update' />
      <input type='hidden' id='code' name='code' value='<?php echo $data[0]; ?>' />
   <script type='text/javascript'>

   
$(function(){
	$('#frm').validate({
	  	debug:true,
		rules: {
			desc: {
				required: true
			}			
		},
		messages:{
	    desc:"Please enter the description for this Location Code",
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
        
		$.post('../callback/location_form.php',{code:'<?php echo $data[0]; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('location_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/location_form.php',$('#frm').serialize(),function(e){
	   	   
			   $('#savedialog').aodialog('close');
			   
  	   		   open_menu('location_browse');
  	   		   	
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
});

	


</script>   

      <br />
     <br />
 <div  id="deletedialog">
     Delete this location?
</div>
 <div  id="savedialog">
     Save changes?
</div>
<div>
</div> </form>
<?php } else { ?>
<form id='frm' name='frm'>

<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('location_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
     <input type='checkbox' checked="checked" id='active' name='active'></input><label for='CustActive'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
 <table>
       <tr><td>Location Code:</td><td><input maxlength='150' id='code' name='code' /></td></tr> 
       <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc'  /></td></tr> 
     
      <tr><td>Address:</td>
      <td>
      <div class="addressbox">
      <input class='address' maxlength='150' id='address1' name='address1' /><br/>
      <input class='address' maxlength='150' id='address2' name='address2' /><br/>
      <input class='address' maxlength='150' id='address3' name='address3' /><br/>
      <input class='address' maxlength='150' id='address4' name='address4' /></td></tr>
      </div>
   
      </td></tr>
      <tr><td>Contact Person:</td><td><input maxlength='150' id='contact' name='contact' /></td></tr> 
      <tr><td>Phone:</td><td><input maxlength='150' id='telno' name='telno' /></td></tr> 
      <tr><td>Phone 2:</td><td><input maxlength='150' id='telno2' name='telno2' /></td></tr> 
      <tr><td>Fax:</td><td><input maxlength='150' id='faxno' name='faxno' /></td></tr> 
      <tr><td>Email:</td><td><input maxlength='150' id='email' name='email' /></td></tr> 
      
       <tr><td></td><td> <button style="width:250px;" class='form deletebutton'>Delete location</button></td></tr>
    </table>
 
     
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
			}
			
		},
		messages:{
		code: "Please enter an unique Location Code.",
	    desc:"Please enter the description for this Location Code",
	   },
	   submitHandler: function(form) {
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     
      	    $.post('../callback/location_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('location_browse');	
      	     	}
      	       	
      	       unload_busy('.contentbox .c');	
      	     });
      	   }
     });	 
	
});
</script>
<div>
</div> </form>
<?php } ?>