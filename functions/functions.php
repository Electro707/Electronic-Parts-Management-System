<?php
    // Function that create a new table in the database
    function createDB($settings, $conn){
        if(empty($settings) or empty($conn)){
            exit();
        }
    $sql = "CREATE TABLE {$settings["Database Name"]} (";
    $sql .= "id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
    foreach($settings["DB Items"] as $key => $value){
        $sql .= $key . " " . $value["db_type"] . ",";
    }
    $sql = rtrim($sql, ", ");
    $sql .= ")";

    $res = $conn->query($sql);
    return $res;
    }

    // A function that turns a number to an engineering notation with the right suffix
    function number_to_eng($numb){
        $big_notation_letter = ['', 'k', 'M'];
        $little_notation_number = ['m', 'u', 'n', 'p'];

        if($numb == NULL){
            return FALSE;
        }
        if($numb < 1){
            $notation_dig = ceil(log10($numb)/3);
            $return_str = $numb . $little_notation_number[$notation_dig];
        }
        else{
            $notation_dig = floor(log10($numb)/3);
            $return_str = $numb . $big_notation_letter[$notation_dig];
        }
        return $return_str;
    }
    
    // A function that takes a number and return a percentage string
    function number_to_percentage($numb){
        return ($numb*100) . " %";
    }
?>