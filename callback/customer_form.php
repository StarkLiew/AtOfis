<?php
 session_start();
  if(empty($_SESSION['userid'])) exit;
  
  include_once "base.php";
  include_once "func.php";
  
    if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='delete'){

   	    $code=mysql_real_escape_string($_POST['code']);
   	    $sql="DELETE  FROM `customer` WHERE acc_code='$code'";
   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error());
   	    exit;
   	    
   }
  if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['action']=='save'){
 	    $code=mysql_real_escape_string($_POST['code']);
   	    //check custcode availibilty
   	     if( is_cust_code_exist($code)) {
   	     	 echo "This Customer Account Code had been taken.";
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
   	    $pricetagcode=mysql_real_escape_string($_POST['pricetagcode']);
   	    $creditlimit=mysql_real_escape_string($_POST['creditlimit']);
   	    $outstanding=mysql_real_escape_string($_POST['outstanding']);
   	    $creditcontrol=mysql_real_escape_string($_POST['creditcontrol']);
   	    $includepd=mysql_real_escape_string($_POST['includepd']);
   	    $crccrqt=mysql_real_escape_string($_POST['crccrqt']);
   	    $crccrso=mysql_real_escape_string($_POST['crccrso']);
   	    $crccrdo=mysql_real_escape_string($_POST['crccrdo']);
   	    $crccrinv=mysql_real_escape_string($_POST['crccrinv']);
   	    $crccrcs=mysql_real_escape_string($_POST['crccrcs']);
   	    $crccrdn=mysql_real_escape_string($_POST['crccrdn']);
   	    $crcodqt=mysql_real_escape_string($_POST['crcodqt']);
   	    $crcodso=mysql_real_escape_string($_POST['crcodso']);
   	    $crcoddo=mysql_real_escape_string($_POST['crcoddo']);
   	    $crcodinv=mysql_real_escape_string($_POST['crcodinv']);
   	    $crcodcs=mysql_real_escape_string($_POST['crcodcs']);
   	    $crcoddn=mysql_real_escape_string($_POST['crcoddn']);
   	    $crcsusodqt=mysql_real_escape_string($_POST['crcsusodqt']);
   	    $crcsusodso=mysql_real_escape_string($_POST['crcsusodso']);
   	    $crcsusoddo=mysql_real_escape_string($_POST['crcsusoddo']);
   	    $crcsusodinv=mysql_real_escape_string($_POST['crcsusodinv']);
   	    $crcsusodcs=mysql_real_escape_string($_POST['crcsusodcs']);
   	    $crcsusoddn=mysql_real_escape_string($_POST['crcsusoddn']);
   	    $active=mysql_real_escape_string($_POST['active']);
   	    $suspend=mysql_real_escape_string($_POST['suspend']);
   	    if(empty($creditlimit)) $creditlimit=0;
   	    if(empty($outstanding)) $outstanding=0;
   	    if($active) $active='Y'; else $active='N';
   	    if($suspend) $suspend='Y'; else $suspend='N';
   	    if($creditcontrol) $creditcontrol='Y'; else $creditcontrol='N';
   	    if($includepd) $includepd='Y'; else $includepd='N';
   	    if($crccrqt) $crccrqt='Y'; else $crccrqt='N';
   	    if($crccrso) $crccrso='Y'; else $crccrso='N';
   	    if($crccrdo) $crccrdo='Y'; else $crccrdo='N';
   	    if($crccrinv) $crccrinv='Y'; else $crccrinv='N';
   	    if($crccrcs) $crccrcs='Y'; else $crccrcs='N';
   	    if($crccrdn) $crccrdn='Y'; else $crccrdn='N';
   	    if($crcodqt) $crcodqt='Y'; else $crcodqt='N';
   	    if($crcodso) $crcodso='Y'; else $crcodso='N';
   	    if($crcoddo) $crcoddo='Y'; else $crcoddo='N';
   	    if($crcodinv) $crcodinv='Y'; else $crcodinv='N';
   	    if($crcodcs) $crcodcs='Y'; else $crcodcs='N';
   	    if($crcoddn) $crcoddn='Y'; else $crcoddn='N';
   	    if($crcsusodqt) $crcsusodqt='Y'; else $crcsusodqt='N';
   	    if($crcsusodso) $crcsusodso='Y'; else $crcsusodso='N';
   	    if($crcsusoddo) $crcsusoddo='Y'; else $crcsusoddo='N';
   	    if($crcsusodinv) $crsuscodinv='Y'; else $crcsusodinv='N';
   	    if($crcsusodcs) $crcsusodcs='Y'; else $crcsusodcs='N';
   	    if($crcsusoddn) $crcsusoddn='Y'; else $crcsusoddn='N'; 
   	    $sql="INSERT INTO customer".
             "(acc_code, cust_desc,".
             " cust_telno, cust_telno2,".
             " cust_fax, cust_contact,".
             " cust_email, cust_website,".
             " active, suspend, cr_control,include_pd,".
             " area_code, agent_code,".
             " currency_code, term_code,".
             " price_tag_code, credit_limit,".
             " overdue_limit, cust_address1,".
             " cust_address2, cust_address3,".
             " cust_address4, crc_cr_qt, crc_cr_so,".
             " crc_cr_do, crc_cr_inv, crc_cr_cs,".
             " crc_cr_dn, crc_od_qt, crc_od_so,".
             " crc_od_do, crc_od_inv, crc_od_cs,".
             " crc_od_dn, crc_sus_od_qt, crc_sus_od_so,".
             " crc_sus_od_do, crc_sus_od_inv,".
             " crc_sus_od_cs, crc_sus_od_dn) VALUES (".
             " '$code','$desc','$telno','$telno2','$faxno','$contact',".
             " '$email','$website','$active','$suspend','$creditcontrol',".
             " '$includepd','$areacode','$agentcode','$currencycode','$termcode',".
             " '$pricetagcode',$creditlimit,$outstanding,".
             " '$address1','$address2','$address3','$address4',".
             " '$crccrqt','$crccrso','$crccrdo','$crccrinv','$crccrcs','$crccrdn',".
             " '$crcodqt','$crcodso','$crcoddo','$crcodinv','$crcodcs','$crcoddn',".
             " '$crcsusodqt','$crcsusodso','$crcsusoddo','$crcsusodinv','$crcsusodcs','$crcsusoddn')";         
   
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
   	    $pricetagcode=mysql_real_escape_string($_POST['pricetagcode']);
   	    $creditlimit=mysql_real_escape_string($_POST['creditlimit']);
   	    $outstanding=mysql_real_escape_string($_POST['outstanding']);
   	    $creditcontrol=mysql_real_escape_string($_POST['creditcontrol']);
   	    $crccrqt=mysql_real_escape_string($_POST['crccrqt']);
   	    $crccrso=mysql_real_escape_string($_POST['crccrso']);
   	    $crccrdo=mysql_real_escape_string($_POST['crccrdo']);
   	    $crccrinv=mysql_real_escape_string($_POST['crccrinv']);
   	    $crccrcs=mysql_real_escape_string($_POST['crccrcs']);
   	    $crccrdn=mysql_real_escape_string($_POST['crccrdn']);
   	    $crcodqt=mysql_real_escape_string($_POST['crcodqt']);
   	    $crcodso=mysql_real_escape_string($_POST['crcodso']);
   	    $crcoddo=mysql_real_escape_string($_POST['crcoddo']);
   	    $crcodinv=mysql_real_escape_string($_POST['crcodinv']);
   	    $crcodcs=mysql_real_escape_string($_POST['crcodcs']);
   	    $crcoddn=mysql_real_escape_string($_POST['crcoddn']);
   	    $crcsusodqt=mysql_real_escape_string($_POST['crcsusodqt']);
   	    $crcsusodso=mysql_real_escape_string($_POST['crcsusodso']);
   	    $crcsusoddo=mysql_real_escape_string($_POST['crcsusoddo']);
   	    $crcsusodinv=mysql_real_escape_string($_POST['crcsusodinv']);
   	    $crcsusodcs=mysql_real_escape_string($_POST['crcsusodcs']);
   	    $crcsusoddn=mysql_real_escape_string($_POST['crcsusoddn']);
   	    $active=mysql_real_escape_string($_POST['active']);
   	    $suspend=mysql_real_escape_string($_POST['suspend']);
   	    if(empty($creditlimit)) $creditlimit=0;
   	    if(empty($outstanding)) $outstanding=0;
   	    if($active) $active='Y'; else $active='N';
   	    if($suspend) $suspend='Y'; else $suspend='N';
   	    if($creditcontrol) $creditcontrol='Y'; else $creditcontrol='N';
   	    if($includepd) $includepd='Y'; else $includepd='N';
     	if($crccrqt) $crccrqt='Y'; else $crccrqt='N';
   	    if($crccrso) $crccrso='Y'; else $crccrso='N';
   	    if($crccrdo) $crccrdo='Y'; else $crccrdo='N';
   	    if($crccrinv) $crccrinv='Y'; else $crccrinv='N';
   	    if($crccrcs) $crccrcs='Y'; else $crccrcs='N';
   	    if($crccrdn) $crccrdn='Y'; else $crccrdn='N';
   	    if($crcodqt) $crcodqt='Y'; else $crcodqt='N';
   	    if($crcodso) $crcodso='Y'; else $crcodso='N';
   	    if($crcoddo) $crcoddo='Y'; else $crcoddo='N';
   	    if($crcodinv) $crcodinv='Y'; else $crcodinv='N';
   	    if($crcodcs) $crcodcs='Y'; else $crcodcs='N';
   	    if($crcoddn) $crcoddn='Y'; else $crcoddn='N';
   	    if($crcsusodqt) $crcsusodqt='Y'; else $crcsusodqt='N';
   	    if($crcsusodso) $crcsusodso='Y'; else $crcsusodso='N';
   	    if($crcsusoddo) $crcsusoddo='Y'; else $crcsusoddo='N';
   	    if($crcsusodinv) $crsuscodinv='Y'; else $crcsusodinv='N';
   	    if($crcsusodcs) $crcsusodcs='Y'; else $crcsusodcs='N';
   	    if($crcsusoddn) $crcsusoddn='Y'; else $crcsusoddn='N'; 	 
   	    $sql="UPDATE customer SET ".
             " cust_desc='$desc',".
             " cust_telno='$telno', " .
             " cust_telno2='$telno2',".
             " cust_fax='$faxno', " .
             " cust_contact='$contact',".
             " cust_email='$email', " .
             " cust_website='$website',".
             " active='$active'," .
             " suspend='$suspend', " .
             " cr_control='$creditcontrol'," .
             " include_pd='$includepd',".
             " area_code='$areacode'," .
             " agent_code='$agentcode',".
             " currency_code='$currencycode', " .
             " term_code='$termcode',".
             " price_tag_code='$pricetagcode', " .
             " credit_limit='$creditlimit',".
             " overdue_limit='$outstanding'," .
             " cust_address1='$address1',".
             " cust_address2='$address2'," .
             " cust_address3='$address3',".
             " cust_address4='$address4'," .
             " crc_cr_qt='$crccrqt'," .
             " crc_cr_so='$crccrso',".
             " crc_cr_do='$crccrdo'," .
             " crc_cr_inv='$crccrinv', " .
             " crc_cr_cs='$crccrcs',".
             " crc_cr_dn='$crccrdn', " .
             " crc_od_qt='$crcodqt', " .
             " crc_od_so='$crcodso',".
             " crc_od_do='$crcoddo', " .
             " crc_od_inv='$crcodinv', " .
             " crc_od_cs='$crcodcs',".
             " crc_od_dn='$crcoddn'," .
             " crc_sus_od_qt='$crcsusodqt'," .
             " crc_sus_od_so='$crcsusodso',".
             " crc_sus_od_do='$crcsusoddo'," .
             " crc_sus_od_inv='$crcsusodinv',".
             " crc_sus_od_cs='$crcsusodcs'," .
             " crc_sus_od_dn='$crcsusoddn'".
             " WHERE acc_code='$code'";
             

   	    $result=mysql_query($sql);
   	    if(!$result) die("MySQL Error: ".mysql_error().$sql);
   	    exit;
   	    
   }   
    if($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['action']=='view' || $_POST['action']=='edit')){
    	$code=$_POST['code'];
    	$sql="SELECT".
    	     " acc_code, cust_desc,".
    	     " cust_address1, cust_address2,".
             " cust_address3, cust_address4,".
             " cust_contact,cust_telno,".
             " cust_telno2, cust_fax, ".
             " cust_email, cust_website,".
             " active, suspend, ".
             " area_code, term_code, agent_code,".
             " price_tag_code,currency_code,".
             " credit_limit,overdue_limit, ".
             " cr_control,include_pd, crc_cr_qt, crc_cr_so,".
             " crc_cr_do, crc_cr_inv, crc_cr_cs,".
             " crc_cr_dn, crc_od_qt, crc_od_so,".
             " crc_od_do, crc_od_inv, crc_od_cs,".
             " crc_od_dn, crc_sus_od_qt, crc_sus_od_so,".
             " crc_sus_od_do, crc_sus_od_inv,".
             " crc_sus_od_cs, crc_sus_od_dn ".
    	      " from `customer` WHERE acc_code='$code'";
    	$result=mysql_query($sql);
    	if(!$result) die('MySql Error: '.mysql_error());
    	if(mysql_num_rows($result)>0){
    	 $data = mysql_fetch_array($result);
    	}else{echo "Record Not Found";}
    	
    	
    }

?>
<?php if($_POST['action']=='view'){ ?>
<div class='form'>
<button style='float:right;' onclick="open_menu('customer_form',{action:'edit',code:'<?php echo $data[0]; ?>'});return false;">Edit</button><button onclick="open_menu('customer_browse');" ><img src='../images/back.gif' width="12px" height="12px" align="absmiddle" />&nbsp;Back</button>
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
     <tr><td>Suspend:</td><td><label class="textbox"><?php if($data[13]=='Y') echo 'YES'; else echo 'NO'; ?></label></td></tr> 
       <tr><td colspan="2"><hr /> <td></tr>
      <tr><td>
      <label for='areacode'>Area:</label></td><td>
         <label class="textbox"><?php echo  get_area_desc($data[14]); ?></label>
      </td>     
      </tr>
      <tr> <td>
            <label for='termcode'>Credit Terms:</label></td><td>
             <label class="textbox"><?php echo get_term_desc($data[15]); ?></label>
      </td>
      
      </tr>
      <tr><td>
      <label for='agentcode'>Agent:</label></td><td>
       <label class="textbox"><?php echo get_agent_desc($data[16]); ?></label>
      </td>  </tr>
      <tr>
      <td>
      <label for='pricetagcode'>Price Tag:</label> </td><td>
        <label class="textbox"><?php echo $data[17]; ?></label>
      
      </td>  </tr>
      <tr>
      <td>
         <label for='currencycode'>Currency:</label></td><td>
        <label class="textbox"><?php echo $data[18]; ?></label>
      </td>
      </tr> 

 
      <tr><td colspan="2"> <hr /></td></tr>
      <tr><td>
     <label for='creditlimit'>Credit Limit:</label>
     </td><td>
     <label class="textbox"><?php echo $data[19]; ?></label>
     </td></tr>
        <tr><td>
     <label for='outstanding'>Outstanding:</label>
          </td><td>
     <label class="textbox"><?php echo $data[20]; ?></label>
          </td></tr>
      </table>
     <?php if($data[21]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?>&nbsp;<label>Credit Control</label><br />
     <?php if($data[22]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?>&nbsp;<label for='includepd'>Include Post-Dated Cheque to Credit Limit</label>
 <br /> <br />
        <table cellpadding='0' cellspacing='0' class='credit_control_table'>
      <thead>
        <tr><td>Description</td><td>Quotation</td><td>Sales Order</td><td>Delivery Order</td><td>Invoice</td><td>Cash Sales</td><td>Debit Note</td></tr>
       </thead>
       <tbody>
        <tr><td>Block on Exceed Credit Limit</td>
        <td><?php if($data[23]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[24]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[25]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[26]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[27]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[28]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td></tr>
        <tr><td>Block on Overdue Limit</td>
        <td><?php if($data[29]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[30]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[31]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[32]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[33]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[34]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td></tr>
        <tr><td>Suspend on Overdue Limit</td>
        <td><?php if($data[35]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[36]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[37]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[38]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[39]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td>
        <td><?php if($data[40]=='Y')echo '<img src="../images/checked.gif"/>';else echo '<img src="../images/unchecked.gif"/>'; ?></td></tr>
      </tbody>
  
     </table> 
      
     <br />
     <br />
<div>
</div>
<?php }elseif($_POST['action']=='edit'){ ?>
	   <form id='frm' name='frm'>
	<div class='form'>
<button style='float:right;' type="submit">Save</button>
<button  onclick="open_menu('customer_browse');return false;">Cancel</button>

<div class='form body'>
 <div style='float:right'>
     <input type='checkbox' <?php if($data[12]=='Y')echo 'checked="checked"'; ?> id='active' name='active'></input><label for='active'>Active</label>
     <input type='checkbox'<?php if($data[13]=='Y')echo 'checked="checked"'; ?> id='suspend' name='suspend'></input><label for='suspend'>Suspend</label>
  </div>
    
    <table>
        <tr><td>Account Code:</td><td><label class="textbox"><?php echo $data[0]; ?></label></td></tr>
    <tr><td>Customer Name:</td><td><input maxlength='150' id='desc' name='desc' value="<?php echo $data[1]; ?>"  /></td></tr> 
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
        	if($data[14]==$line->area_code) $selected="selected='selected'";
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
            if($data[15]==$line->term_code) $selected="selected='selected'";
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
        	  if($data[16]==$line->agent_code) $selected="selected='selected'";
            else $selected="";
        	echo "<option ".$selected." value='$line->agent_code'>".$line->agent_desc."</option>";
        }
        ?>
      </Select>
      </td>
      <td>
      <label for='pricetagcode'>Price Tag:</label> </td><td>
      <Select  id='pricetagcode' value="<?php echo $data[17]; ?>"  name='pricetagcode' >
       <option selected="selected" value="">Select One</option>
      </Select>
      
      </td>
      <td>
         <label for='currencycode' >Currency:</label></td><td>
      <Select  id='currencycode' value="<?php echo $data[18]; ?>" name='currencycode' >
       <option value="">Select One</option>
                      <?php 
        $currency=mysql_query("SELECT * FROM `currency` ORDER BY currency_code");
        while($line = mysql_fetch_object($currency)){
        	
            if($data[18]==$line->currency_code) $selected="selected='selected'";
            else $selected="";
        	 
        	echo "<option ".$selected." value='$line->currency_code'>".$line->currency_code."</option>";
        }
        ?>
      </Select>
      </td>
      </tr> 

    </table>
    <hr />
     <label for='creditlimit'>Credit Limit:</label><input value="<?php echo $data[19]; ?>"  class="form num" maxlength='10' id='creditlimit' name='creditlimit'  />
     <label for='outstanding'>Outstanding:</label><input value="<?php echo $data[20]; ?>"  class="form num" maxlength='10' id='outstanding' name='outstanding'  /><br />
     <input type='checkbox' <?php if($data[21]=='Y')echo 'checked="checked"'; ?> checked="checked"  id='creditcontrol' name='creditcontrol'></input><label for='creditcontrol'>Credit Control</label><br />
     <input type='checkbox' <?php if($data[22]=='Y')echo 'checked="checked"'; ?> id='includepd' name='includepd'></input><label for='includepd'>Include Post-Dated Cheque to Credit Limit</label>
 <br /> <br />
        <table cellpadding='0' cellspacing='0' class='credit_control_table'>
      <thead>
        <tr><td>Description</td><td>All</td><td>Quotation</td><td>Sales Order</td><td>Delivery Order</td><td>Invoice</td><td>Cash Sales</td><td>Debit Note</td></tr>
       </thead>
       <tbody>
        <tr><td>Block on Exceed Credit Limit</td>
        <td><input onclick="crc_check_all(this);"  type='checkbox' id='' name=''></td>
        <td><input <?php if($data[23]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crccrqt' name='crccrqt'></td>
        <td><input <?php if($data[24]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crccrso' name='crccrso'></td>
        <td><input <?php if($data[25]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crccrdo' name='crccrdo'></td>
        <td><input <?php if($data[26]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crccrinv' name='crccrinv'></td>
        <td><input <?php if($data[27]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crccrcs' name='crccrcs'></td>
        <td><input <?php if($data[28]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crccrdn' name='crccrdn'></td></tr>
        <tr><td>Block on Overdue Limit</td>
        <td><input onclick="crc_check_all(this);" type='checkbox' id='' name=''></td>
        <td><input <?php if($data[29]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcodqt' name='crcodqt'></td>
        <td><input <?php if($data[30]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcodso' name='crcodso'></td>
        <td><input <?php if($data[31]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcoddo' name='crcoddo'></td>
        <td><input <?php if($data[32]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcodinv' name='crcodinv'></td>
        <td><input <?php if($data[33]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcodcs' name='crcodcs'></td>
        <td><input <?php if($data[34]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcoddn' name='crcoddn'></td></tr>
        <tr><td>Suspend on Overdue Limit</td>
        <td><input onclick="crc_check_all(this);" type='checkbox' id='' name=''></td>
        <td><input <?php if($data[35]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcsusodqt' name='crcsusodqt'></td>
        <td><input <?php if($data[36]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcsusodso' name='crcsusodso'></td>
        <td><input <?php if($data[37]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcsusoddo' name='crcsusoddo'></td>
        <td><input <?php if($data[38]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcsusodinv' name='crcsusodinv'></td>
        <td><input <?php if($data[39]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcsusodcs' name='crcsusodcs'></td>
        <td><input <?php if($data[40]=='Y')echo 'checked="checked"'; ?> type='checkbox' id='crcsusoddn' name='crcsusoddn'></td></tr>
      </tbody>
  
     </table> <br />
       <button style="width:250px;" class='form deletebutton'>Delete Customer</button>
     
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
			},	
			outstanding: {
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
        
		$.post('../callback/customer_form.php',{code:'<?php echo $data[0]; ?>',action:'delete'},function(e){
			   $('#deletedialog').aodialog('close');
	   	       
  	   		   open_menu('customer_browse');	
  	   		   
  	   	});
  	   	return false;
     },
      height:80,width:280,okayText:'Yes',cancelText:'No'
	}); 
	$('#savedialog').aodialog({
  	okay: function(){
        
	   $.post('../callback/customer_form.php',$('#frm').serialize(),function(e){
	   	        $('#savedialog').aodialog('close');
	   	     
	   	      if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	 	   open_menu('customer_browse');
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
     Delete this Customer?
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
<button onclick="open_menu('customer_browse');return false;">Cancel</button>

<div class='form body'>
 <div style='float:right'>
     <input type='checkbox' checked="checked" id='active' name='active'></input><label for='active'>Active</label>
     <input type='checkbox' id='suspend' name='suspend'></input><label for='suspend'>Suspend</label>
  </div>
    
    <table>
      <tr><td width="150px">Account Code:</td><td><input maxlength='10' id='code' name='code'  /></td></tr>
      <tr><td>Customer Name:</td><td><input maxlength='150' id='desc' name='desc'  /></td></tr> 
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
      <label for='pricetagcode'>Price Tag:</label> </td><td>
      <Select  id='pricetagcode' name='pricetagcode' >
       <option selected="selected" value="">Select One</option>
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
     <label for='outstanding'>Outstanding:</label><input class="form num" maxlength='10' id='outstanding' name='outstanding'  /><br />
     <input type='checkbox' checked="checked"  id='creditcontrol' name='creditcontrol'></input><label for='creditcontrol'>Credit Control</label><br />
     <input type='checkbox' id='includepd' name='includepd'></input><label for='includepd'>Include Post-Dated Cheque to Credit Limit</label>
 <br /> <br />
        <table cellpadding='0' cellspacing='0' class='credit_control_table'>
      <thead>
        <tr><td>Description</td><td>All</td><td>Quotation</td><td>Sales Order</td><td>Delivery Order</td><td>Invoice</td><td>Cash Sales</td><td>Debit Note</td></tr>
       </thead>
       <tbody>
        <tr><td>Block on Exceed Credit Limit</td><td><input onclick="crc_check_all(this);"  type='checkbox' ></td><td><input type='checkbox' id='crccrqt' name='crccrqt'></td><td><input type='checkbox' id='crccrso' name='crccrso'></td><td><input type='checkbox' id='crccrdo' name='crccrdo'></td><td><input type='checkbox' id='crccrinv' name='crccrinv'></td><td><input type='checkbox' id='crccrcs' name='crccrcs'></td><td><input type='checkbox' id='crccrdn' name='crccrdn'></td></tr>
        <tr><td>Block on Overdue Limit</td><td><input onclick="crc_check_all(this);" type='checkbox'></td><td><input type='checkbox' id='crcodqt' name='crcodqt'></td><td><input type='checkbox' id='crcodso' name='crcodso'></td><td><input type='checkbox' id='crcoddo' name='crcoddo'></td><td><input type='checkbox' id='crcodinv' name='crcodinv'></td><td><input type='checkbox' id='crcodcs' name='crcodcs'></td><td><input type='checkbox' id='crcoddn' name='crcoddn'></td></tr>
        <tr><td>Suspend on Overdue Limit</td><td><input onclick="crc_check_all(this);" type='checkbox' ></td><td><input type='checkbox' id='crcsusodqt' name='crcsusodqt'></td><td><input type='checkbox' id='crcsusodso' name='crcsusodso'></td><td><input type='checkbox' id='crcsusoddo' name='crcsusoddo'></td><td><input type='checkbox' id='crcsusodinv' name='crcsusodinv'></td><td><input type='checkbox' id='crcsusodcs' name='crcsusodcs'></td><td><input type='checkbox' id='crcsusoddn' name='crcsusoddn'></td></tr>
      </tbody>
  
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
			termcode: {
				required: true
			},
			currencycode: {
				required: true
			},
			creditlimit: {
				number: true
			},
			outstanding: {
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
	   	     
      	    $.post('../callback/customer_form.php',$(form).serialize(),function(e){
      	     	if($.trim(e)!=""){
      	     	   $('.form .body').prepend("<br /><label for='code' generated='true' class='error'>"+e+"</label><br /><br />");  
      	     	}else{
      	     	  open_menu('customer_browse');	
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