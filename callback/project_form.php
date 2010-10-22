<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $sql="DELETE  FROM `project` WHERE project_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    //check custcode availibilty
   	     if( is_project_code_exist($code)) {
   	     	 echo "This Project Code had been taken.";
   	     	 exit;
   	     } 
   	    $desc=mysql_real_escape_string($_POST['desc']);
   	    $projectvalue=mysql_real_escape_string($_POST['projectvalue']);
   	    $projectcost=mysql_real_escape_string($_POST['projectcost']);
   	    $active=mysql_real_escape_string($_POST['active']);
   	    
   	    if($active) $active='Y';
   	    else $active='N';
   	    $sql="INSERT INTO `project`(project_code,project_desc,project_value,project_cost,active) VALUES ('$code','$desc',$projectvalue,$projectcost,'$active')";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error().$sql);
   	    exit;
   	    
   }
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='update'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $desc=mysql_real_escape_string($_POST['desc']);
   	    $projectvalue=mysql_real_escape_string($_POST['projectvalue']);
   	    $projectcost=mysql_real_escape_string($_POST['projectcost']);
   	    $active=mysql_real_escape_string($_POST['active']);
  	    if($active) $active='Y';
   	    else $active='N';
   	    $sql="UPDATE `project` SET project_desc='$desc',project_value=$projectvalue,project_cost=$projectcost,active='$active' WHERE project_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT project_code,project_desc,project_value,project_cost,active from `project` WHERE project_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

   

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('project_form',{action:'edit',code:'<?php echo $data[0]; ?>'});" type='submit'>Edit</button><button onclick="open_menu('project_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
      <table>
      <tr><td>Project Code:</td><td><label class="textbox"><?php echo $data['0']; ?></label></td></tr>
      <tr><td>Description:</td><td><label class="textbox"><?php echo $data['1']; ?></label></td></tr>
       <tr><td>Project Value:</td><td><label class="textbox"><?php echo $data['2']; ?></label></td></tr>
       <tr><td>Project Cost:</td><td><label class="textbox"><?php echo $data['3']; ?></label></td></tr> 
      <tr><td>Staus:</td><td><label class="textbox"><?php if($data['4']=='Y') echo 'ACTIVE'; else echo 'IN-ACTIVE'; ?></label></td></tr> 
    
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
<button onclick="open_menu('project_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
     <input type='checkbox' <?php if($data[4]=='Y')echo 'checked="checked"'; ?> id='active' name='active'></input><label for='CustActive'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Project Code:</td><td><label class="textbox"><?php echo $data[0]; ?></label></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc' value="<?php echo $data[1]; ?>" /></td></tr>
      <tr><td>Project Value:</td><td><input maxlength='10' class="num" id='projectvalue' name='projectvalue' value="<?php echo $data[2]; ?>" /></td></tr>
       <tr><td>Project Cost:</td><td><input maxlength='10' class="num" id='projectcost' name='projectcost' value="<?php echo $data[3]; ?>" /></td></tr> 
     
       <tr><td></td><td> <button style="width:250px;" class='form deletebutton'>Delete Project</button></td></tr>
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
			},			
			projectvalue:
			{number:true},
		    projectcost:
			{number:true}
		},
		messages:{
	    desc:"Please enter the description for this Project Code",
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
        
		$.post('../callback/project_form.php',{code:'<?php echo $data[0]; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('project_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/project_form.php',$('#frm').serialize(),function(e){
	   	   
			   $('#savedialog').aodialog('close');
			   
  	   		   open_menu('project_browse');
  	   		   	
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
     Delete this project?
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
<button onclick="open_menu('project_browse');return false;">Cancel</button>

<div class='form body'>
    <div style='float:right'>
     <input type='checkbox' checked="checked" id='active' name='active'></input><label for='CustActive'>Active</label>
    </div>
 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Project Code:</td><td><input maxlength='10' id='code' name='code'  /></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='desc' name='desc'  /></td></tr> 
      <tr><td>Project Value:</td><td><input class="num" maxlength='10' id='projectvalue' name='projectvalue'  /></td></tr>
      <tr><td>Project Cost:</td><td><input class="num" maxlength='10' id='projectcost' name='projectcost'  /></td></tr>
    
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
			},
			projectvalue:{number:true},
			projectcost:{number:true}
		},
		messages:{
		code: "Please enter an unique Project Code.",
	    desc:"Please enter the description for this Project Code",
	   },
	   submitHandler: function(form) {
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     
      	    $.post('../callback/project_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('project_browse');	
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