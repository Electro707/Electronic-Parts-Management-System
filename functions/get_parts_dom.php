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
    // Create HTML table and selection stuff
    // TODO: Add parametric table for selection

    // Get each field's name from the result
    $finfo = $result->fetch_fields();
    // Create the table
    echo "<table id='parts_table'>";
    // Create the header
    echo "<tr>";
    foreach ($finfo as $val) {
        // If the key's value is not in the configuration file, ignore it
        if(in_array($val->name, $db_items_string) == FALSE){continue;}
        echo "<th>".$key_sett["DB Items"][$val->name]["name"]."</th>";
    }
    echo "</tr>";
    // Create the up/down arrows
    echo "<tr>";
    foreach ($finfo as $val) {
        // If the key's value is not in the configuration file, ignore it
        if(in_array($val->name, $db_items_string) == FALSE){continue;}
        $to_echo = "<td>
                        <div>
                            <button class=\"arrow_button\"><img src=\"resources/up.svg\" alt=\"up\"></button>
                            <button class=\"arrow_button\"><img src=\"resources/down.svg\" alt=\"down\"></button>
                        </div>
                    </td>";
        echo $to_echo;
    }
    echo "</tr>";
    // Create the other rows with the items from the database
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($finfo as $val) {
            // If the key's value is not in the configuration file, ignore it
            if(in_array($val->name, $db_items_string) == FALSE){continue;}
            // Echo what to add depending on how do we want to present the value as
            if($key_sett["DB Items"][$val->name]["shows_as"] == "engineering"){
                echo "<td>".number_to_eng($row[$val->name])."</td>";
            }
            else if($key_sett["DB Items"][$val->name]["shows_as"] == "percentage"){
                echo "<td>".number_to_percentage($row[$val->name])."</td>";
            }
            else{
                echo "<td>".$row[$val->name]."</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
?>