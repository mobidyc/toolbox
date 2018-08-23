<!--==========================
     Tool
 ============================-->
 <section id="tool">
    <div class="container">
        <header class="section-header">
            <h1 class="section-title">Content</h1>
        </header>
        <div class="row">
            <?php
            if( isset($_GET["tool"]) && ( $_GET["tool"] == "new" || $_GET["tool"] == "edit" ) ){
                include('form.php');
            } elseif(isset($_GET["id"])) {
                include('display.php');
            } else {
                include('description.php');
            }
            ?>
        </div>
 </section>
<!-- #Header -->
