<?php
  session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $currencycode=mysql_real_escape_string($_POST['currencycode']);
   	    $sql="DELETE  FROM `currency` WHERE currency_code='$currencycode'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){

   	    $currencycode=mysql_real_escape_string($_POST['currencycode']);
   	    //check custcode availibilty
   	     if( is_currency_code_exist($currencycode)) {
   	     	 echo "This Currency Code had been taken.";
   	     	 exit;
   	     } 
   	    $currencydesc=mysql_real_escape_string($_POST['currencydesc']);
   	    $currencysymbol=mysql_real_escape_string($_POST['currencysymbol']);
   	    $buyrate=mysql_real_escape_string($_POST['buyrate']);
   	    $sellrate=mysql_real_escape_string($_POST['sellrate']);
   	 
   	    
   	    $sql="INSERT INTO `currency`(currency_code,currency_desc,currency_symbol,sell_rate,buy_rate) VALUES ('$currencycode','$currencydesc','$currencysymbol',$buyrate,$sellrate)";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='update'){

   	    $currencycode=mysql_real_escape_string($_POST['currencycode']);
   	 	 $currencydesc=mysql_real_escape_string($_POST['currencydesc']);
   	    $currencysymbol=mysql_real_escape_string($_POST['currencysymbol']);
   	    $buyrate=mysql_real_escape_string($_POST['buyrate']);
   	    $sellrate=mysql_real_escape_string($_POST['sellrate']);
   	    $sql="UPDATE `currency` SET currency_desc='$currencydesc',currency_symbol='$currencysymbol',buy_rate=$buyrate,sell_rate=$sellrate WHERE currency_code='$currencycode'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT * from `currency` WHERE currency_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

   

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('currency_form',{action:'edit',code:'<?php echo $data['currency_code']; ?>'});" type='submit'>Edit</button><button onclick="open_menu('currency_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
<div class='form body'>
      <table>
      <tr><td>Currency Code:</td><td><label class="textbox"><?php echo $data['currency_code']; ?></label></td></tr>
      <tr><td>Description:</td><td><label class="textbox"><?php echo $data['currency_desc']; ?></label></td></tr> 
      <tr><td>Symbol:</td><td><label class="textbox"><?php echo $data['currency_symbol']; ?></label></td></tr>
      <tr><td>Buy Rate:</td><td><label class="textbox"><?php echo $data['buy_rate']; ?></label></td></tr>
      <tr><td>Sell Rate:</td><td><label class="textbox"><?php echo $data['sell_rate']; ?></label></td></tr> 
    
    </table>
   <br />
     <br />
      
     <br />
     <br />
<div>
</div>
<?php }elseif($_POST['action']=='edit'){ ?>
   <form id='frmCurrency' name='frmCurrency'>
<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('currency_browse');return false;">Cancel</button>

<div class='form body'>

 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Currency Code:</td><td><label class="textbox"><?php echo $data['0']; ?></label></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='currencydesc' name='currencydesc' value="<?php echo $data['currency_desc']; ?>" /></td></tr> 
      <tr><td>Symbol:</td><td><input maxlength='10' id='currencysymbol' name='currencysymbol' value="<?php echo $data['currency_symbol']; ?>"  /></td></tr>
      <tr><td>Buy Rate:</td><td><input class="num" maxlength='10' id='buyrate' name='buyrate' value="<?php echo $data['buy_rate']; ?>"  /></td></tr> 
      <tr><td>Sell Rate:</td><td><input class="num" maxlength='10' id='sellrate' name='sellrate' value="<?php echo $data['sell_rate']; ?>"  /></td></tr> 
    
      <tr><td></td><td> <button style="width:250px;" class='form deletebutton'>Delete Currency</button></td></tr>
    </table>
      <input type='hidden' id='action' name='action' value='update' />
      <input type='hidden' id='currencycode' name='currencycode' value='<?php echo $data['currency_code']; ?>' />
   <script type='text/javascript'>

   
$(function(){
	$('#frmCurrency').validate({
	  	debug:true,
		rules: {
			currencydesc: {
				required: true
			},
		    currencysymbol: {
				required: true
			},
	        buyrate: {
				required: true,number:true
			},
		    sellrate: {
				required: true,number:true
			}
			
		},
		messages:{
	    currencydesc:"Please enter the description for this Term Code",
		currencysymbol:"Please provide the currency symbol.",
		buyrate:"Please enter the current BUY rate in digit.",
		sellrate:"Please enter the current SELL rate in digit.",
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
        
		$.post('../callback/currency_form.php',{currencycode:'<?php echo $data['currency_code']; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('currency_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/currency_form.php',$('#frmCurrency').serialize(),function(e){
			   $('#savedialog').aodialog('close'); 
  	   		   open_menu('currency_browse');
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
<form id='frmCurrency' name='frmCurrency'>
<div class='form'>
<button style='float:right;' type='submit'>Save</button>
<button onclick="open_menu('currency_browse');return false;">Cancel</button>

<div class='form body'>

 <div style='float:right'>
      </div>
    
    <table>
      <tr><td>Currencys Code:</td><td><input maxlength='10' id='currencycode' name='currencycode'  /></td></tr>
      <tr><td>Description:</td><td><input maxlength='150' id='currencydesc' name='currencydesc'  /></td></tr> 
      <tr><td>Symbol:</td><td><input maxlength='150' id='currencysymbol' name='currencysymbol'  /></td></tr> 
      <tr><td>Buy Rate:</td><td><input class="num" maxlength='150' id='buyrate' name='buyrate'  /></td></tr> 
        <tr><td>Sell Rate:</td><td><input class="num" maxlength='10' id='sellrate' name='sellrate'  /></td></tr> 
    
    </table>
 
     
     <br />
     <br />
     <input type='hidden' id='action' name='action' value='save' />
 
   <script type='text/javascript'>
$(function(){

	$('#frmCurrency').validate({
	  	debug:true,
			rules: {
    		currencycode: {
				required: true
			},
			currencydesc: {
				required: true
			},
		    currencysymbol: {
				required: true
			},
	        buyrate: {
				required: true,number:true
			},
		    sellrate: {
				required: true,number:true
			}
			
		},
		messages:{
	    currencycode:"Please enter the description for this Currency Code",
		currencysymbol:"Please provide the currency symbol.",
		buyrate:"Please enter the current BUY rate in digit.",
		sellrate:"Please enter the current SELL rate in digit.",
	   },
	   submitHandler: function(form) {
	   	     load_busy('.contentbox .c');
	   	     $(".error").remove();
	   	     
      	    $.post('../callback/currency_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='currencycode' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('currency_browse');	
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