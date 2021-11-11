<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
$result = "200";

$table = $_GET['table']; 
$results = array();
$query = "DESCRIBE $table"; 
$query = $db->query($query); 
while($row = $query->fetch_assoc()){ 
    $results[] = $row; 

}

$results = json_encode($results); 
echo $results;


?>