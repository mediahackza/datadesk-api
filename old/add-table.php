<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
include("functions.php");
$result = "200";

$data = $_GET['data']; 
$schema = $data;

$randomInt = rand(100000, 10000000);

$data = json_decode( html_entity_decode( stripslashes ($data ) ) );
$tableName = $data->tableName . "_" . $randomInt; 
$tableReadableName = $data->dbName;



$createString = "CREATE TABLE $tableName (ddesk_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
foreach($data->dbSchema as $d) { 

    $columnName = $d->dbColumn;
    $fieldLength = $d->fieldSize; 
    $fieldType = $d->fieldType;

    $fieldValues = fieldSpec($fieldType, $fieldLength);
    
    $createString .= " " . $columnName . " " . $fieldValues . ",";
}

$createString = rtrim($createString, ",");
$createString .= ")";
// echo $createString;
if(!$db->query($createString)) { 
    $result = "error";
}

if($result == "200") { 
    $insert = "INSERT INTO table_list (db_name, table_name, the_schema) VALUES('$tableName', '$tableReadableName', '$schema')";

    if(!$db->query($insert)) { 
        $result = "error";
    } 
}

$result = json_encode($result);
echo $result;


?>