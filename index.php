<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
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
                <p>Click a component to open it's stock</p>
                <?php
                    echo "<ul>";
                    $arr = json_decode(file_get_contents("database_index.json"), true);
                    foreach($arr as $key => $value){
                        echo "<li class='selector_item'>".$key."</li>";
                    }
                    echo "</ul>";
                ?>
            </div>
            <div id='parts'>
                <p class='title'>Parts: Table</p>
                <div id='parts_replacable'>

                </div>  
            </div>
        </div>

        <script>
            var div = document.getElementById("selection");
            var elementToReturn;
            for (var i=0; i < div.childNodes.length; i++) {
                if(div.childNodes[i].tagName == 'UL'){
                    var ul_node = div.childNodes[i]
                    for (var k=0; k < ul_node.childNodes.length; k++) {
                        elementToReturn = ul_node.childNodes[k];
                        if (elementToReturn.className == 'selector_item'){
                            //console.log(elementToReturn.innerHTML);
                            elementToReturn.addEventListener("click",function(s){
                                return function(){selectProduct(s);}
                            }(elementToReturn.innerHTML), false);
                        }
                    }
                    break;
                }
            }
        </script>
    </body>
</html>