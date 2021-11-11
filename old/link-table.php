<?php
header('Access-Control-Allow-Origin: *');
include("conf.php");
$randomInt = rand(100000, 10000000);

// $file = $_FILES['file']['tmp_name'];
$tablename = $_POST['tablename'];
$source = $_POST['source'];
$description = "";

// move_uploaded_file($file, "uploads/data.csv");


// Clean up tablename - Testing
// $tablename = "fgetcsv table";
$dbname = $tablename;
$dbname = str_replace(" ", "_", $dbname);
$dbname = str_replace("-", "_", $dbname);
$dbname = strtolower($dbname); 
$dbname = $dbname . "_" . $randomInt;
$columns = "ddesk_id,";


// Add table to table_list
$query = "INSERT INTO table_list (db_name, table_name, type, source) VALUES ('$dbname', '$tablename', 'remote', '$source')";
// echo $query;
$query = $db->query($query);

$result = 200; 
$result = json_encode($result); 
echo $result;
?>