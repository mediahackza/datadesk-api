<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
$result = "200";

$id = $_GET['id'];
$query = "DELETE from africa_data WHERE id = $id"; 
if(!$db->query($query)) { 
    $result = 'error';
}

$result = json_encode($result); 
echo $result;

?>