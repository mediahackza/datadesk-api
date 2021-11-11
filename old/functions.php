<?php 

function csvtojson($file,$delimiter)
{
    if (($handle = fopen($file, "r")) === false)
    {
            die("can't open the file.");
    }
    $csv_headers = fgetcsv($handle, 4000, $delimiter);
    $csv_json = array();

    while ($row = fgetcsv($handle, 4000, $delimiter))
    {
            $csv_json[] = array_combine($csv_headers, $row);
    }
    fclose($handle);
    return json_encode($csv_json);
}



function fieldSpec($fieldType, $fieldLength) {
    $count; 
    switch($fieldLength) { 
        case "1char": 
            $count = 1;
            break; 
        
        case "2char2": 
            $count = 2;
            break;
            
        case "tiny": 
            $count = 5;
            break;
            
        case "small": 
            $count = 20;
            break; 

        case "medium": 
            $count = 255;
            break; 

        case "large": 
            $count = null;
            break; 

    }

    if($fieldType == "string") { 
        $fieldValues = "varchar (" . $count . ")";
    }
    elseif($fieldType == "number") { 
        $fieldValues = "int (" . $count . ")";
    }
    elseif($fieldType == "date") { 
        $fieldValues = "date";
    }
    if($fieldLength == "large") { 
        $fieldValues = "TEXT";
    }
    return $fieldValues;

}

?>