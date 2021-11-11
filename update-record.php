<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");

$tags = $_POST['tags'];
$tags = strtolower($tags);
$id = $_POST['id'];

$query = "UPDATE $db_list set tags = '$tags' where id = '$id'";
$query = $db->query($query);

$results =array($id,$tags);
echo json_encode($results);



?>