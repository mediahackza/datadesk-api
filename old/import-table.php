<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
$result = 200;



$randomInt = rand(100000, 10000000);
$csv = $_GET['source'];
$sourceFile = $csv;
$tablename = $_GET['tablename'];
$description = $_GET['description'];
$description = mysqli_real_escape_string($db, $description);
$csv = file_get_contents($csv);
file_put_contents("uploads/data.csv", $csv);
$dbname = str_replace(" ", "_", $tablename);
$dbname = strtolower($dbname);
$dbname = str_replace("'", "", $dbname);
$dbname = str_replace("(", "", $dbname);
$dbname = str_replace(")", "", $dbname);
$dbname = str_replace("#", "", $dbname);
$dbname = $dbname . "_" . $randomInt;

$csv = array_map('str_getcsv', file("uploads/data.csv"));


$headers = "CREATE TABLE $dbname (ddesk_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
foreach($csv[0] as $c) { 
        $c = str_replace(" ", "_", $c);
        $c = str_replace("-", "_", $c);
        $c = str_replace("\x{0D}", "", $c);
        $c = str_replace(",", "", $c);        
        if($c == "") { $c = 'nd_' . rand(100000, 10000000); }

        $headers .= ", " . $c . "_ varchar(3000)";
      
}
$headers .= ")";

// echo $headers;
// ADD HEADERS
$query = $headers;
$query = $db->query($query);




// // ADD DATA

$count = 1;
for($x = 1; $x < count($csv); $x++) { 
    $insert = "INSERT INTO $dbname values(NULL, ";
    foreach($csv[$x] as $c) { 
        $c = mysqli_real_escape_string($db, $c);
        $c = str_replace (array("\r\n", "\n", "\r"), ' ', $c);
       
        $c = utf8_decode($c);
        $c = str_replace("\\n", "", $c);
        $c = str_replace("\x{0D}", "", $c);
        $insert .= "\"$c\",";        
}
$insert = rtrim($insert, ',');
$insert .= ")";
// echo $insert;
// $db->query($insert);
if(!$db->query($insert)) { 
        // ADD TO TABLE_LIST
        $result = 400;
//     $result = "error";
    echo $db->error;
}
else { 
        
}




}

if($result == 200) { 
        $query = "INSERT INTO table_list (`db_name`, `table_name`, `description`, `source`) VALUES('$dbname', '$tablename', '$description', '$sourceFile')";
        $query = $db->query($query);
}
         

$result = json_encode($result); 
echo $result;

?>