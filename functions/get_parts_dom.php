<?php
    // Get key for which part to select
    $key = $_GET['table'];
    // Get json file
    $json = json_decode(file_get_contents("../database_index.json"), true);
    
    // Create mySql connection
    $conn = new mysqli("localhost", "phpmyadmin", "123", "PartsList");
    if($conn -> connect_error) {
        error_log("mySqli error = ".$conn->connect_error);
        exit();
    }
    // Create sql query
    $sql = "SELECT * FROM ".$json[$key]["Database Name"];
    $result = $conn->query($sql);
    $conn->close();
    
    if($result === false){
        error_log("result form query error");
        exit();
    }
    
    // Create HTML table and selection stuff
    // TODO: Add parametric table for selection

    
    
    $finfo = $result->fetch_fields();

    echo "<table id='parts_table'>";
    echo "<tr>";
    foreach ($finfo as $val) {
        echo "<th>".$val->name."</th>";
    }
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($finfo as $val) {
            echo "<td>".$row[$val->name]."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
?>