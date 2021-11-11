<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');
include("conf.php");

$results = array();

$query = "SELECT * from $db_list order by updated DESC"; 


$query = $db->query($query);
$rows = $query->num_rows;


if($rows > 0) { 

while($row = $query->fetch_assoc()) { 
    
//     if($row['type'] != 'remote') { 
//         $count = "SELECT count(*) as count from " . $row['db_name'];
//         $count = $db->query($count);
//         $count = $count->fetch_row();
//         $row['count'] = $count[0];
//     }
    $results[] = $row;

}



}

$results = json_encode($results); 
echo $results;



?>