<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $sql="DELETE  FROM `stock_group` WHERE stock_group_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    //check custcode availibilty
   	     if( is_stock_group_code_exist($code)) {
   	     	 echo "This Stock Item Grouping Code had been taken.";
   	     	 exit;
   	     } 
   	    $desc=mysql_real_escape_string($_POST['desc']);
   	    $active=mysql_real_escape_string($_POST['active']);
   	 
   	    if($active) $active='Y';
   	    else $active='N';
   	    $sql="INSERT INTO `stock_group`(stock_group_code,stock_group_desc,active) VALUES ('$code','$desc','$active')";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='update'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $desc=mysql_real_escape_string($_POST['desc']);
   	    $active=mysql_real_escape_string($_POST['active']);
  	    if($active) $active='Y';
   	    else $active='N';
   	    $sql="UPDATE `stock_group` SET stock_group_desc='$desc',active='$active' WHERE stock_group_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT stock_group_code,stock_group_desc,active from `stock_group` WHERE stock_group_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

   

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('stock_group_form',{action:'edit',code:'<?php echo $data[0]; ?>'});" type='submit'>Edit</button><button onclick="open_menu('stock_group_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
      <table>
      <tr><td>Group Code:</td><td><label class="textbox"><?php echo $data['0']; ?></label></td></tr>
      <tr><td>Description:</td><td><label class="textbox"><?php echo $data['1']; ?></label></td></tr> 
      <tr><td>Staus:</td><td><label class="textbox"><?php if($data['2']=='Y') echo 'ACTIVE'; else echo 'IN-ACTIVE'; ?></label></td></tr> 
    
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
<button onclick="open_menu('stock_group_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
     <input type='checkbox' <?php if($data[2]=='Y')echo 'checked="checked"'; ?> id='active' name='active'></input><label for='CustActive'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Group Code:</td><td><label class="textbox"><?php echo $data[0]; ?></label></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc' value="<?php echo $data[1]; ?>" /></td></tr> 
       <tr><td></td><td> <button style="width:250px;" class='form deletebutton'>Delete stock_group</button></td></tr>
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
	    desc:"Please enter the description for this stock_group Code",
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
        
		$.post('../callback/stock_group_form.php',{code:'<?php echo $data[0]; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('stock_group_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/stock_group_form.php',$('#frm').serialize(),function(e){
	   	   
			   $('#savedialog').aodialog('close');
			   
  	   		   open_menu('stock_group_browse');
  	   		   	
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
     Delete this Grouping?
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
<button onclick="open_menu('stock_group_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
     <input type='checkbox' checked="checked" id='active' name='active'></input><label for='CustActive'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Group Code:</td><td><input maxlength='10' id='code' name='code'  /></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc'  /></td></tr> 
    
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
		code: "Please enter an unique stock_group Code.",
	    desc:"Please enter the description for this stock_group Code",
	   },
	   submitHandler: function(form) {
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     
      	    $.post('../callback/stock_group_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('stock_group_browse');	
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