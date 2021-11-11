<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");

$id = $_GET['id'];
$results = array();

$query = "SELECT * from $db_list WHERE id = '$id'";
$query = $db->query($query);
while($row = $query->fetch_assoc()) { 
    $results[] = $row;

}

$results = json_encode($results);
echo $results;



?>