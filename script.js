// Global object storing all of the configuration file from the Json file
var db_config_json = null;
var config_json = null;
// Global object storing the current key ('Resistor', 'Rapacitor', etc...)
var current_key = null;
// Global variable that stores the last returned JSON from the database (to use to create tables and whatnot)
var global_table = null;

function selectProduct(key){
    if(key == ""){
        return;
    }
    current_key = key;

    // Create an AJAX request
    $.ajax({
        url: "functions/get_parts_dom.php",
        type: 'get',
        data: {table: key},
        datatype: 'json',
        success: function(res){
            global_table = JSON.parse(res);
            convert_query_to_types(global_table);
            createTable(global_table);
            alert_low_quantity();
        }
    });
    
}
function createTable(json){
    // Clear the parts div
    $("#parts_replacable").empty();
    // A variable that stores the dictionary of the database items for the current key
    var config_items = db_config_json[current_key]["DB Items"];
    // A variable that stores an array of possible keys
    var config_keys = Object.keys(config_items);
    // Debug shit
    console.log(config_keys);
    console.log(json);

    // Create the table
    var content = "<table id='parts_table'>";
    // Create the header
    content += "<tr>";
    for(var column of config_keys){
        content += "<th>"+config_items[column]["name"]+"</th>";
    }
    content += "</tr>";
    // Create the arrow / 2nd row.
    content += "<tr>";
    //for(var info in json[0]){
    for(var column of config_keys){
        content += "<td><div>";
        content += `<button class=\"sort_button\" data-type=\"up\" data-row=\"${column}\" class=\"arrow_button\"><img src=\"resources/up.svg\" alt=\"up\"></button>`;
        content += `<button class=\"sort_button\" data-type=\"down\" data-row=\"${column}\" class=\"arrow_button\"><img src=\"resources/down.svg\" alt=\"down\"></button>`;
        content +="</div></td>";
    }
    content += "</tr>";
    // Create the table's content
    for(var row of json){
        content += "<tr>";
        for(var column of config_keys){ // Only take the valid keys from each row
            if(row[column] == null || isNaN(row[column])){
                content += "<td></td>";
                continue;
            }
            else if(config_items[column]["shows_as"] == "engineering"){
                content += "<td>"+number_to_eng(row[column])+"</td>";
            }
            else if(config_items[column]["shows_as"] == "percentage"){
                content += "<td>"+number_to_percentage(row[column])+"</td>";
            }
            else{
                content += "<td>"+row[column]+"</td>";
            }
        }
        content += "</tr>";
    }
    content += "</table>";
    document.getElementById("parts_replacable").innerHTML = content;

    // Create event listeners for the sort buttons
    for(var bt of document.getElementsByClassName("sort_button")){
        bt.addEventListener("click", function(s1, s2){
            return function(){sort_table(s1, s2);}
        }(bt.getAttribute('data-row'), bt.getAttribute('data-type')), false);
    }
}
// A function that turns a number to an engineering notation with the right suffix
function number_to_eng(numb){
    big_notation_letter = ['', 'k', 'M'];
    little_notation_number = ['m', 'u', 'n', 'p'];
    var return_str = null;
    if(numb == null){
        return false;
    }
    if(numb < 1){
        var notation_dig = Math.ceil(Math.log10(numb)/3);
        return_str = new String(numb) + new String(little_notation_number[notation_dig]);
    }
    else{
        var notation_dig = Math.floor(Math.log10(numb)/3);
        return_str = new String(numb) + new String(big_notation_letter[notation_dig]);
    }
    return return_str;
}

// A function that takes a number and return a percentage string
function number_to_percentage(numb){
    return (numb*100) + " %";
}

// Function that takes a database query and converts it's object to float or ints depending on the
// database config
function convert_query_to_types(orig_obj){
    // A variable that stores the dictionary of the database items for the current key
    var config_items = db_config_json[current_key]["DB Items"];
    // A variable that stores an array of possible keys
    var config_keys = Object.keys(config_items);
    for(var part of orig_obj){
        for(var key in part){
            if(config_keys.includes(key) == false){continue;}
            if(config_items[key]['db_type'].includes('INT')){
                part[key] = parseInt(part[key]);
            }
            else if(config_items[key]['db_type'].includes('FLOAT')){
                part[key] = parseFloat(part[key]);
            }
        }
    }
}

// Function that will sort the table
function sort_table(row, direction){
    // A variable that stores the dictionary of the database items for the current key
    var config_items = db_config_json[current_key]["DB Items"];
    // A variable that stores an array of possible keys
    var config_keys = Object.keys(config_items);
    // If the row is invalid, log it and return
    if(config_keys.includes(row) == false){
        console.error("Invalid row given to the sort_table function");
        return;
    }
    // Create a new array that will be used to 'sort' the table
    var new_db_array = $.extend(true, [], global_table);
    // https://flaviocopes.com/how-to-sort-array-of-objects-by-property-javascript/
    if(direction == 'up'){new_db_array.sort((a, b) => (a[row] > b[row]) ? 1 : -1);}
    else if(direction == 'down'){new_db_array.sort((a, b) => (a[row] > b[row]) ? -1 : 1);}
    createTable(new_db_array);
}

// Create a toast (with toastr) when the stock is bellow a certain quantity
function alert_low_quantity(){
    for(var part of global_table){
        if(part['stock'] <= config_json["Low Stock Quantity"]){
            // TODO: CHange 'value' to a part description/manufacturer ID
            toastr.warning(`Low quantity (${part['stock']}) for ${part['value']}`);
        }
    }
}

// Start...get JSON file
$.getJSON("database_index.json", function(json) {
    // console.log(json); // this will show the info it in firebug console
    db_config_json = json;
});

$.getJSON("configuration.json", function(json) {
    // console.log(json); // this will show the info it in firebug console
    config_json = json;
});

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "500",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};