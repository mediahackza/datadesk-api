<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$hostname = ""; 
$mysql_login = "";
$mysql_password = "";
$database = "";

$db = new mysqli($hostname, $mysql_login, $mysql_password, $database);
if($db->connect_errno > 0){ 
    $date = date('Y-m-d H:i:s');
    error_log("\n\10" . $date . " - Failed to connect to database [" . $db->connect_error ."]", 3, "errors.log"); 
    $msg = $date . " - Failed to connect to database [" . $db->connect_error ."]";
    $to = "a";
    $subject = "";
    mail($to, $subject, $msg);
}
else { 
    // echo "Connected to DB";
    
}
?>