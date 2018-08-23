<!DOCTYPE html>
<html lang="en">
<?php require("content/meta.php"); ?>
<body>

<?php
require_once('Tool.php');
$url = $_SERVER["SCRIPT_NAME"];
$tool = new Tool();
$toolnames = $tool->list_tools_and_status();
$all_labels = $tool->list_labels();
ksort($all_labels, 4);

$colors_available = array( "default", "primary", "success", "info", "warning", "facebook", "google", "twitter", "pinterest", "tumblr", "phaedra-default", "phaedra-primary", "phaedra-success", "phaedra-info", "phaedra-warning" );
?>

<?php require("content/header.php"); ?>

<div class="container well">

    <?php require("content/categories.php"); ?>
    <?php require("content/list.php"); ?>
    <?php require("content/tool.php"); ?>

</div> <!-- End container -->

</body>
</html>
