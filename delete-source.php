<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");

$id = $_GET['id']; 

$query = "update $db_list set deleted = 'true' WHERE id = '$id'"; 
$query = $db->query($query);

$results = '200'; 
$results = json_encode($results); 
echo $results;

?>