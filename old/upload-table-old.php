<?php 
header('Access-Control-Allow-Origin: *');
// header('Content-Type: text/html; charset=utf-8');
// header('Content-Type: application/json');
include("conf.php");
$result = 200;
$error = "";


// $file = $_FILES['file']['tmp_name'];
// $tablename = $_POST['filename'];
// $description = "";

// move_uploaded_file($file, "uploads/data.csv");


// TESTING
$tablename = "test table";
$description = "";

$randomInt = rand(100000, 10000000);
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
        $c = rtrim($c); 
        $c = ltrim($c);
        $c = str_replace(" ", "_", $c);
        $c = str_replace("-", "_", $c);
        $headers .= ", " . $c . "_ varchar(3000)";
}
$headers .= ")";

echo $headers;


$query = $headers;
$query = $db->query($query);




$count = 1;
for($x = 1; $x < count($csv); $x++) { 
        
    $insert = "INSERT INTO $dbname values(NULL, ";
    foreach($csv[$x] as $c) { 
        $c
        $c = mysqli_real_escape_string($db, $c);
        $c = str_replace (array("\r\n", "\n", "\r"), ' ', $c);
       
        $c = utf8_decode($c);
        $c = str_replace("\\n", "", $c);
        $insert .= "\"$c\",";        
}
$insert = rtrim($insert, ',');
$insert .= ")";

#echo $insert . "<br/>";




if(!$db->query($insert)) { 
        if(strpos($db->error, "Column count doesn't match") !== false) { 
                $result = "Column mismatch";
        }
        echo $insert . "<br/><br />";
}


}

if($result == 200 || $result == "Column mismatch") { 
        $query = "INSERT INTO table_list (`db_name`, `table_name`, `description`) VALUES('$dbname', '$tablename', '$description')";
        $query = $db->query($query);
        
}
else { 
        // $delete = "DROP table $dbname";
        // $delete = $db->query($delete);

}

$result = json_encode($result); 
echo $result;


?>