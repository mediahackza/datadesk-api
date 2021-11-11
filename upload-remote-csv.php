<?php
header('Access-Control-Allow-Origin: *');
include("conf.php");
$randomInt = rand(100000, 10000000);

$source = $_POST['source'];
$originalCsv = $source;
$source = file_get_contents($source);
$original = $_POST['original'];
$tablename = $_POST['tablename'];
// $description = "";



file_put_contents("uploads/data.csv", $source);


// Clean up tablename - Testing
// $tablename = "fgetcsv table";
$dbname = $tablename;
$dbname = str_replace(" ", "_", $dbname);
$dbname = str_replace("-", "_", $dbname);
$dbname = str_replace(".xls", "", $dbname);
$dbname = str_replace(".csv", "", $dbname);
$dbname = str_replace(".xlsx", "", $dbname);
$dbname = strtolower($dbname); 
$dbname = "dd_" . $dbname;
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
                $d = str_replace("?", "_q_", $d);
                $d = strtolower($d);
                $d = rtrim($d, " ");
                $d = ltrim($d, " ");
                $d = mysqli_real_escape_string($db, $d);
                
                $headers .= "," . $d . " varchar(2000)";
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
else { 
    echo "Error";
}
// Add table to table_list
$query = "INSERT INTO $db_list (db_name, table_name, type, source, original_file) VALUES ('$dbname', '$tablename', 'local', '$originalCsv', '$original')";
// echo $query;
$query = $db->query($query);

$result = 200; 
$result = json_encode($result); 
echo $result;
?>