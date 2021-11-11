<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("functions.php");
include("conf.php");

$table = $_GET['table'];
$results = array();
$query = "SELECT source from $db_list where db_name = '$table'";
// echo $query;
$query = $db->query($query);
$result = $query->fetch_row();

// $result = file_get_contents($result[0]);

$result = csvtojson($result[0], ","); 

#$results = json_encode($results); 
echo $result; 


?>