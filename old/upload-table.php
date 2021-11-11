<?php
header('Access-Control-Allow-Origin: *');
include("conf.php");
$randomInt = rand(100000, 10000000);

$file = $_FILES['file']['tmp_name'];
$tablename = $_POST['filename'];
$description = "";

move_uploaded_file($file, "uploads/data.csv");


// Clean up tablename - Testing
// $tablename = "fgetcsv table";
$dbname = $tablename;
$dbname = str_replace(" ", "_", $dbname);
$dbname = str_replace("-", "_", $dbname);
$dbname = strtolower($dbname); 
$dbname = $dbname . "_" . $randomInt;
$columns = "ddesk_id,";

$row = 1;
if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($row == 1) {  // Create table if this is the header row
            $headers = "";
            foreach($data as $d) { 
                $d = str_replace("-", "_", $d);
                $d = str_replace(" ", "_", $d);
                $d = strtolower($d);
                $d = rtrim($d, " ");
                $d = ltrim($d, " ");
                
                $headers .= "," . $d . " varchar(3000)";
                $columns .= $d . ",";
            }
            $columns = rtrim($columns, ",");
            // Set up insert
            
            $headers = "CREATE TABLE $dbname (ddesk_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY" . " " . $headers . ")";
            $query = $headers;
            $query = $db->query($query);
        }
        else { // Insert each row
            $num = count($data);
            $insert = "INSERT INTO $dbname (" . $columns . ") VALUES(NULL,"; 
            
            for ($c=0; $c < $num; $c++) { 
                // $data[$c] = utf8_decode($data[$c]);
                $data[$c] = mysqli_real_escape_string($db, $data[$c]);
                $insert .= "'" . $data[$c] . "',";
            }
            $insert = rtrim($insert, ",");
            $insert .= ")";
            $query = $db->query($insert);
        }
        $row++;
    }

    fclose($handle);
}
// Add table to table_list
$query = "INSERT INTO table_list (db_name, table_name, type) VALUES ('$dbname', '$tablename', 'local')";
// echo $query;
$query = $db->query($query);

$result = 200; 
$result = json_encode($result); 
echo $result;
?>