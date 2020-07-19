<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="resources/toastr.css">
        <link rel="stylesheet" type="text/css" href="resources/micromodal.css">
        <script src="resources/jquery-3.5.1.min.js"></script>
        <script src="resources/toastr.js"></script>
        <script src="resources/micromodal.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <h1>Electro707's Electronics Part Management</h1>
        <div id='main_page'>
            <div id='top'>
                <button class='top_options' data-micromodal-trigger="modal-1">Add/Remove Parts to stock</button>
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
                <p class='title'>Parts Table:</p>
                <div id='parts_replacable'>

                </div>  
            </div>
        </div>

        <!-- The modal for adding a part to the database -->
        <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">Add a part</h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <p>No part is selected</p>
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn modal__btn-primary">Add part</button>
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
                </footer>
            </div>
            </div>
        </div>
        
        <!-- After page is loaded script -->
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

            MicroModal.init({
                disableScroll: true, // [6]
                disableFocus: false, // [7]
                awaitOpenAnimation: false, // [8]
                awaitCloseAnimation: false, // [9]
                debugMode: false // [10]
            });
        </script>

    </body>
</html>