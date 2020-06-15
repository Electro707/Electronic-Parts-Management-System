<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <h1>Electro707's Electronics Part Management</h1>
        <div id='main_page'>
            <div id='top'>
                <button class='top_options'>Add/Remove Parts to stock</button>
                <button class='top_options'>Import PCB</button>
                <button class='top_options'>Import BOM</button>
            </div>
            <div id='selection'>
                <p class='title'>Part Selection: </p>
                <?php
                    $arr = json_decode(file_get_contents("database_index.json"), true);
                    foreach($arr as $key => $value){
                        #echo "<p class='selector_item' onclick='selectProduct('".$key."')'>".$key."</p>";
                        echo "<p class='selector_item'>".$key."</p>";
                    }
                ?>
            </div>
            <div id='parts'>
                <p class='title'>Selection Table</p>
                <div id='parts_replacable'>

                </div>  
            </div>
        </div>

        <script>
            var div = document.getElementById("selection");
            var elementToReturn
            for (var i=0; i < div.childNodes.length; i++) {
                elementToReturn = div.childNodes[i];
                if (elementToReturn.className == 'selector_item'){
                    //console.log(elementToReturn.innerHTML);
                    elementToReturn.addEventListener("click",function(s){
                        return function(){selectProduct(s);}
                    }(elementToReturn.innerHTML), false);
                }
            }
        </script>
    </body>
</html>