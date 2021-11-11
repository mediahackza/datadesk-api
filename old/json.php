<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");

$table = $_GET['table'];
$results = array();
$query = "SELECT * from $table";
$query = $db->query($query);
while($row = $query->fetch_assoc()) { 
    $row = array_map("utf8_encode", $row );
    $results[] = $row;

}

$results = json_encode($results); 
echo $results; 


?>