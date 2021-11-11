<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
// header('Content-Type: application/json');
include("conf.php");

$table = $_GET['table'];
$results = array();

$query = "SELECT source from $db_list WHERE db_name = '$table'";

$query = $db->query($query);
$result = $query->fetch_row();
$file = file_get_contents($result[0]);



echo $file;


?>