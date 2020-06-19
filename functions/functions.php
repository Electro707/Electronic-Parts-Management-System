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

    function addRow($settings, $conn){
        if(empty($settings) or empty($conn)){
            exit();
        }
        // Get a list of item's keys from the database items to know what to add to the table (and it ignore the id column)
        $db_items_string = [];
        foreach($settings["DB Items"] as $key => $value){
            array_push($db_items_string, $key);
        }
        $table = $settings["Database Name"];

        foreach($db_items_string as $column){
            $sql = "SELECT * FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$column' AND table_schema = 'PartsList'";
            $res = $conn->query($sql);
            if($res->num_rows == 0){
                $sql = "ALTER TABLE {$table} ADD {$column} {$settings["DB Items"][$column]['db_type']}";
                $res = $conn->query($sql);
            }
        }
    }
?>