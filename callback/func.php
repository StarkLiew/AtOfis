<?php 
//----------------------------------------------
//----------------------------------------------

    function Shorten_Text($text,$chars) {
        // Change to the number of characters you want to display
        if(empty($chars))$chars = 25;
        $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        return $text;
    }


//--------------------------------------------
// Customer Module
//--------------------------------------------
    function is_cust_code_exist($code){
         $result=mysql_query("SELECT acc_code FROM `customer` WHERE acc_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
//--------------------------------------------
// Supplier/Vendor Module
//--------------------------------------------
    function is_supp_code_exist($code){
         $result=mysql_query("SELECT acc_code FROM `supplier` WHERE acc_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }

//--------------------------------------------
// Stock/Inventory Module
//--------------------------------------------
       function get_stock_desc($code){
         $result=mysql_query("SELECT stock_desc FROM `stock` WHERE stock_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
       function is_stock_has_uom($code){
         $result=mysql_query("SELECT uom_code FROM `stock_uom` WHERE stock_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
    	      	return true;
  	      }     
         return false;
   } 
   
    function is_stock_has_openbal($code){
         $result=mysql_query("SELECT tran_detail_code FROM `tran_detail` WHERE stock_code='$code' AND openbal='Y'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
    	      	return true;
  	      }     
         return false;
   } 
   function is_stock_has_bom($code){
         $result=mysql_query("SELECT stock_code FROM `stock_bom` WHERE ref_stock_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
    	      	return true;
  	      }     
         return false;
   } 
          function get_stock_ref_cost($code,$uomcode){
         $result=mysql_query("SELECT uom_ref_cost FROM `stock_uom` WHERE stock_code='$code' AND uom_code='$uomcode'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   } 
   
   

    function get_stock_default_uom($code){
         $result=mysql_query("SELECT uom_code FROM `stock` WHERE stock_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
    }

       function is_stock_code_exist($code){
         $result=mysql_query("SELECT stock_code FROM `stock` WHERE stock_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
   //stock category
         function get_stock_category_desc($code){
         $result=mysql_query("SELECT stock_cat_desc FROM `stock_category` WHERE stock_cat_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   } 
    function is_stock_category_code_exist($code){
         $result=mysql_query("SELECT stock_cat_code FROM `stock_category` WHERE stock_cat_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
   //stock group
   
      function get_stock_group_desc($code){
         $result=mysql_query("SELECT stock_group_desc FROM `stock_group` WHERE stock_group_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   } 
   function is_stock_group_code_exist($code){
         $result=mysql_query("SELECT stock_group_code FROM `stock_group` WHERE stock_group_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
   
   //brand
   function get_brand_desc($code){
         $result=mysql_query("SELECT brand_desc FROM `brand` WHERE brand_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   } 
    function is_brand_code_exist($code){
         $result=mysql_query("SELECT brand_code FROM `brand` WHERE brand_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
 //------------------------------------------
 //  Security Module
 //------------------------------------------  
   function inventory_user_validate($userid,$password){
         $userid=mysql_real_escape_string($userid);
         $password_md5=md5(mysql_real_escape_string($password));
         $result=mysql_query("SELECT active FROM `user` WHERE userid='$userid' AND password='$password_md5' AND active='Y'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
 //------------------------------------------
 //  Tools Module
 //------------------------------------------  
   //Agent
    function is_agent_code_exist($code){
         $result=mysql_query("SELECT agent_code FROM `agent` WHERE agent_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
   function get_agent_desc($code){
         $result=mysql_query("SELECT agent_desc FROM `agent` WHERE agent_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
  //Location
     function get_location_desc($code){
         $result=mysql_query("SELECT location_desc FROM `location` WHERE location_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
    function is_location_code_exist($code){
         $result=mysql_query("SELECT location_code FROM `location` WHERE location_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
 //Area
      function get_area_desc($code){
         $result=mysql_query("SELECT area_desc FROM `area` WHERE area_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
    function is_area_code_exist($code){
         $result=mysql_query("SELECT area_code FROM `area` WHERE area_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
 //Tax
       function get_tax_desc($code){
         $result=mysql_query("SELECT tax_desc FROM `tax` WHERE tax_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
     function is_tax_code_exist($code){
         $result=mysql_query("SELECT tax_code FROM `tax` WHERE tax_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }  
 //Currency
      function get_currency_desc($code){
         $result=mysql_query("SELECT currency_desc FROM `currency` WHERE currency_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
    function is_currency_code_exist($code){
         $result=mysql_query("SELECT currency_code FROM `currency` WHERE currency_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
   
//Project 
     function get_project_desc($code){
         $result=mysql_query("SELECT project_desc FROM `project` WHERE project_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
   function is_project_code_exist($code){
         $result=mysql_query("SELECT project_code FROM `project` WHERE project_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }
   
 //Credit Terms
       function get_term_desc($code){
         $result=mysql_query("SELECT term_desc FROM `term` WHERE term_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
  	     if(mysql_num_rows($result)>0){
  	     	$row=mysql_fetch_array($result);
  	      	return $row[0];
  	      }     
         return "";
   }
   function term_row_count(){
   	 $sql = "SELECT COUNT(term_code) AS numrows FROM `term`";
     $query=mysql_query($sql);
     if(!$query)die('MySQL Error: '.mysql_error());
  	if(mysql_num_rows($query)>0) {
  	   $row=mysql_fetch_array($query);	
  	   return $row[0];
  	} 
     return 0;
  
   } 
   function is_term_code_exist($code){
         $result=mysql_query("SELECT term_code FROM `term` WHERE term_code='$code'");
  	     if(!$result) die("MySQL Error: ".mysql_error());
         if(mysql_num_rows($result)==1) return true;	     
         return false;
   }

   
?>