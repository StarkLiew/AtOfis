<?php 
include_once "../config.php";

//$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ  
//$dbname = "divbox_inventory"; // the name of the database that you are going to use for this project  
//$dbuser = "root"; // the username that you created, or were given, to access your database  
//$dbpass = "1111"; // the password that you created, or were given, to access your database  

mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die("MySQL Error: " . mysql_error());
mysql_select_db(DB_NAME) or die("MySQL Error: " . mysql_error());

?>