<?php
    //Include some used php functions
    if((include "functions.php") == FALSE){
        exit();
    }
    // Get key for which part to select
    $key = $_GET['table'];
    if($key == ''){
        exit();
    }
    // Get json file
    $json = json_decode(file_get_contents("../database_index.json"), true);
    // Get the dictionary from the json file specific to the selected part
    $key_sett = $json[$key];
    // Get a list of item's keys from the database items to know what to add to the table (and it ignore the id column)
    $db_items_string = [];
    foreach($key_sett["DB Items"] as $key => $value){
        array_push($db_items_string, $key);
    }
    // Create mySql connection
    $conn = new mysqli("localhost", "phpmyadmin", "123", "PartsList");
    if($conn -> connect_error) {
        error_log("mySqli error = ".$conn->connect_error);
        exit();
    }
    $conn->options('MYSQLI_OPT_INT_AND_FLOAT_NATIVE');
    // Create sql query
    $sql = "SELECT * FROM ".$key_sett["Database Name"];
    $result = $conn->query($sql);
    
    // Database doesn't exit...create it and requery it
    if($result == FALSE){
        $res = createDB($key_sett, $conn);
        if ($res === TRUE) {
            error_log("Table created successfully");
        } else {
            error_log("Error creating table: " . $conn->error);
            exit();
        }
        $result = $conn->query($sql);
    }
    
    $conn->close();
    
    $rows = array();
    while($r = $result->fetch_assoc()) {
        $rows[] = $r;
    }

    echo json_encode($rows);
?>