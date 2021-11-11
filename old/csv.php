<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");

$table = $_GET['table'];
$results = array();

$file = '';
$cols = array();
$query = "DESCRIBE $table";
$query = $db->query($query);
while($row = $query->fetch_assoc()) {
        $file .= $row['Field'] . ",";
        array_push($cols, $row['Field']);
}
$file = trim($file, ",");
$file .= "\r\n";

$query = "SELECT * from $table";
$query = $db->query($query);
while($row = $query->fetch_assoc()) { 
    foreach($cols as $c) { 
        $file .= $row[$c] . ",";
    }
    $file = trim($file, ",");
    $file .= "\r\n";


}

echo $file;


?>