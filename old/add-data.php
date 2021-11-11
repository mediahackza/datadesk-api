<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
$result = "200";

$data = $_GET['data'];
$data = json_decode( html_entity_decode( stripslashes ($data ) ) );



$name = mysqli_real_escape_string($db, $data->name);
$csv = mysqli_real_escape_string($db, $data->csv);
$json = mysqli_real_escape_string($db, $data->json);
$credit = mysqli_real_escape_string($db, $data->credit);
$description = mysqli_real_escape_string($db, $data->description);


$query = "INSERT into africa_data (name, csv, json, credit, description) VALUES('$name', '$csv', '$json', '$credit', '$description')";

if(!$db->query($query)) { 
    $result = "error";
}

$result = json_encode($result); 
echo $result;

?>