function selectProduct(key){
    if(key == ""){
        return;
    }
    // Clear the parts div
    $("#parts_replacable").empty();
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("parts_replacable").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "functions/get_parts_dom.php?table="+key, true);
    xhttp.send();
}