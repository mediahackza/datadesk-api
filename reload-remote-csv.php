<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");
$id = $_GET['id'];

$source = "";
$db_name = "";

$query = "SELECT db_name, source from $db_list where id = $id";

$query = $db->query($query);
while($row = $query->fetch_assoc()) { 
   $source = $row['source'];
   $db_name = $row['db_name'];

}

$source = file_get_contents($source);

file_put_contents("uploads/data.csv", $source);

// Remove old DB
$drop = "drop table $db_name";
$drop = $db->query($drop);


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
            
            $headers = "CREATE TABLE $db_name (ddesk_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY" . " " . $headers . ")";
            $query = $headers;
            $query = $db->query($query);
        }
        else { // Insert each row
            $num = count($data);
            $insert = "INSERT INTO $db_name (" . $columns . ") VALUES(NULL,"; 
            
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

// UPDATE DB LIST
$update = "UPDATE table $db_list set updated = NOW() WHERE id = $id";

$update = $db->query($update);
// Add table to table_list
// $query = "UPDATE $db_listINSERT INTO $db_list (db_name, table_name, type, source, original_file) VALUES ('$dbname', '$tablename', 'local', '$originalCsv', '$original')";
// // echo $query;
// $query = $db->query($query);

$result = 200; 
$result = json_encode($result); 
echo $result;
?>