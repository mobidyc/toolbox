<?php
require_once('Tool.php');

$tool = new Tool();

if (isset($_GET['labels'])){
    $return_arr = array();
    $all_labels = $tool->list_labels();
    foreach ($all_labels as $key => $value) {
        $return_arr[] = array("name" => $key, "id" => $value);
    }
    echo json_encode($return_arr);
}

?>
