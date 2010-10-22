<?php 


class MySQLDB
{
	
   private $connection;          // The MySQL database connection

   /* Class constructor */
   function MySQLDB(){
   	//  include_once "../config.php";

      /* Make connection to database */
      
     // $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
     // mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
   }

   /* Transactions functions */

   function begin(){
      $null = mysql_query("START TRANSACTION");
      return mysql_query("BEGIN");
   }

   function commit(){
      return mysql_query("COMMIT");
   }
  
   function rollback(){
      return mysql_query("ROLLBACK");
   }


   function transaction($q_array){
         $retval = 1;

      $this->begin();

         foreach($q_array as $qa){
            $result = mysql_query($qa['query']);
            if(!$result) die("MySQL Error: ".mysql_error().$qa['query']);
            //echo("MySQL Line: ".mysql_error().$qa['query']);
            if(mysql_affected_rows() == 0){ $retval = 0; }
             
         }
 
      if($retval == 0){
         $this->rollback();
         return false;
      }else{
         $this->commit();
         return true;
      }
   }

};
?>
