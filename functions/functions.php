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
?>