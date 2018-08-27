<!--==========================
     Tool
 ============================-->
            <?php
            if( isset($_GET["tool"]) && ( $_GET["tool"] == "new" || $_GET["tool"] == "edit" ) ){
                include('content/form.php');
            } elseif(isset($_GET["id"])) {
                include('content/display.php');
            } else {
                include('content/description.php');
            }
            ?>
<!-- #Header -->
