<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
$result = "200";

$dbName = $_GET['db-name'];
$query = "DELETE from table_list WHERE db_name = '$dbName'"; 

if(!$db->query($query)) { 
    $result = 'error';
}

$delete = "DROP TABLE $dbName";
if(!$db->query($delete)) { 
    $result = 'error';
}

$result = json_encode($result); 
echo $result;

?>