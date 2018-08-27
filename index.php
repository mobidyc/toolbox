<!DOCTYPE html>
<!-- https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_templates_cv&stacked=h -->
<html lang="en">
<?php require("content/meta.php"); ?>
<body class="w3-light-grey">

<?php
require_once('Tool.php');
$url = $_SERVER["SCRIPT_NAME"];
$tool = new Tool();
$toolnames = $tool->list_tools_and_status();
$all_labels = $tool->list_labels();
ksort($all_labels, 4);

$colors_available = array( "default", "primary", "success", "info", "warning", "facebook", "google", "twitter", "pinterest", "tumblr", "phaedra-default", "phaedra-primary", "phaedra-success", "phaedra-info", "phaedra-warning" );
?>

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">
    <!-- The Grid -->
    <div class="w3-row-padding">

        <div class="w3-third">
            <div class="w3-white w3-text-grey w3-card-4">
                <?php include("content/header.php"); ?>
                <?php include("content/categories.php"); ?>
                <?php include("content/list.php"); ?>
            </div>
        </div>
        
        <div class="w3-twothird">
            <?php include("content/tool.php"); ?>
        </div>

    <!-- End Grid -->
    </div>
<!-- End Page Container -->
</div>
</body>
</html>
