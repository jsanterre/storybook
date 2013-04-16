<?php 
require("constants.php");
//$db = mysql_connect('localhost','umsanter','boubou99'); 
$db = mysql_connect(DB_SERVER, DB_USER, DB_PASS); 
if (!$db) { 
	die('Database connection failed: ' . mysql_error()); 
} 

$db_select = mysql_select_db(DB_NAME, $db);
if(!$db_select) {
	die('Database selection failed: ' . mysql_error()); 
}
?> 