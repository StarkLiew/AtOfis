<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $termcode=mysql_real_escape_string($_POST['termcode']);
   	    $sql="DELETE  FROM `term` WHERE term_code='$termcode'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){

   	    $termcode=mysql_real_escape_string($_POST['termcode']);
   	    //check custcode availibilty
   	     if( is_term_code_exist($termcode)) {
   	     	 echo "This Term Code had been taken.";
   	     	 exit;
   	     } 
   	    $termdesc=mysql_real_escape_string($_POST['termdesc']);
   	    $termday=mysql_real_escape_string($_POST['termday']);
   	 
   	    
   	    $sql="INSERT INTO `term`(term_code,term_desc,term_day) VALUES ('$termcode','$termdesc',$termday)";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='update'){

   	    $termcode=mysql_real_escape_string($_POST['termcode']);
   	    $termdesc=mysql_real_escape_string($_POST['termdesc']);
   	    $termday=mysql_real_escape_string($_POST['termday']);

   	    $sql="UPDATE `term` SET term_desc='$termdesc',term_day=$termday WHERE term_code='$termcode'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT * from `term` WHERE term_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

   

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('terms_form',{action:'edit',code:'<?php echo $data[0]; ?>'});" type='submit'>Edit</button><button onclick="open_menu('terms_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
      <table>
      <tr><td>Terms Code:</td><td><label class="textbox"><?php echo $data['0']; ?></label></td></tr>
      <tr><td>Description:</td><td><label class="textbox"><?php echo $data['1']; ?></label></td></tr> 
      <tr><td>Day:</td><td><label class="textbox"><?php echo $data['2']; ?></label></td></tr> 
    
    </table>
   <br />
     <br />
      
     <br />
     <br />
<div>
</div>
<?php }elseif($_POST['action']=='edit'){ ?>
   <form id='frmTerms' name='frmTerms'>
<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('terms_browse');return false;">Cancel</button>

<div class='form body'>

 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Terms Code:</td><td><label class="textbox"><?php echo $data['0']; ?></label></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='termdesc' name='termdesc' value="<?php echo $data[1]; ?>" /></td></tr> 
      <tr><td>Day:</td><td><input maxlength='10' id='termday' name='termday' value="<?php echo $data[2]; ?>"  /></td></tr> 
      <tr><td></td><td> <button style="width:250px;" class='form deletebutton'>Delete Credit Term</button></td></tr>
    </table>
      <input type='hidden' id='action' name='action' value='update' />
      <input type='hidden' id='termcode' name='termcode' value='<?php echo $data['0']; ?>' />
   <script type='text/javascript'>

   
$(function(){
	$('#frmTerms').validate({
	  	debug:true,
		rules: {
			termdesc: {
				required: true
			},
		    termday: {
				required: true,digits:true
			}
			
		},
		messages:{
	    termdesc:"Please enter the description for this Term Code",
		termday:"Please enter number from 0 and above.",
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
        
		$.post('../callback/terms_form.php',{termcode:'<?php echo $data['0']; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('terms_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/terms_form.php',$('#frmTerms').serialize(),function(e){
	   	   
			   $('#savedialog').aodialog('close');
			   
  	   		   open_menu('terms_browse');
  	   		   	
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
     Delete this Credit Term?
</div>
 <div  id="savedialog">
     Save changes?
</div>
<div>
</div> </form>
<?php } else { ?>
<form id='frmTerms' name='frmTerms'>
<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('terms_browse');return false;">Cancel</button>

<div class='form body'>

 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Terms Code:</td><td><input maxlength='10' id='termcode' name='termcode'  /></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='termdesc' name='termdesc'  /></td></tr> 
      <tr><td>Day:</td><td><input maxlength='10' id='termday' name='termday'  /></td></tr> 
    
    </table>
 
     
     <br />
     <br />
     <input type='hidden' id='action' name='action' value='save' />
 
   <script type='text/javascript'>
$(function(){

	$('#frmTerms').validate({
	  	debug:true,
		rules: {
			termcode: {
				required: true
			},
			termdesc: {
				required: true
			},
		    termday: {
				required: true,digits:true
			}
			
		},
		messages:{
		termcode: "Please enter an unique Term Code.",
	    termdesc:"Please enter the description for this Term Code",
		termday:"Please enter number from 0 and above.",
	   },
	   submitHandler: function(form) {
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     
      	    $.post('../callback/terms_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='termcode' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('terms_browse');	
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