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
    // Create mySql connection
    $conn = new mysqli("localhost", "phpmyadmin", "123", "PartsList");
    if($conn -> connect_error) {
        error_log("mySqli error = ".$conn->connect_error);
        exit();
    }
    $conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
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
    
    // Pack the returned result into an array, then return to JS as a JSON data
    $rows = array();
    while($r = $result->fetch_assoc()) {
        $rows[] = $r;
    }
    echo json_encode($rows);

    // After returning the JSON data, add any rows that are missing from the database that are in the configuation file
    addRow($key_sett, $conn);
    // Close the connection
    $conn->close();
?>