<?php
// die( "_POST: " . print_r($_POST) );

require_once('Tool.php');

// DEBUG
ini_set('display_errors',1); 
error_reporting(E_ALL);

$mytool = new Tool();

// If we edit a tool, load the existing info
if(isset($_POST['id']) and ! empty($_POST['id'])) {
    $mytool->setId( $_POST['id'] );
    $mytool->get_tool_by_id( $_POST['id'] );

    // update the code
    $mytool->addCode( $_POST['usagetxt'], $_POST['usagecmd'], $mytool->getTUsage() );
} else {
    // add new code
    $res = $mytool->addCode( $_POST['usagetxt'], $_POST['usagecmd'] );
    $mytool->setTusage($res);

}

$labels = isset($_POST['labels']) ? $_POST['labels'] : array();
$labels = implode(',', array_values($labels));
$mytool->setLabels( $labels );

$mytool->setToolname( $_POST['toolname'] );
$mytool->setShrtdesc( $_POST['shrtdesc'] );
$mytool->setLongdesc( $_POST['longdesc'] );
$mytool->setSeealso( $_POST['seealso'] );
$mytool->setRisks( $_POST['risks'] );
$mytool->setSources( $_POST['source'] );
$mytool->setMaintainer( $_POST['maintainer'] );

$mytool->setFinished( isset($_POST['finished']) );

/**
 * we have at least one empty code
 * $_POST["exampletxt"]
 * $_POST["examplecmd"]
 * $_POST["exampleid"]
 * Also remove empty codes
 */
$idcodes = Array();
if(isset($_POST["exampleid"])){
    foreach( $_POST["exampleid"] as $key => $val ) {
        if( ! empty($_POST["exampletxt"][$key].$_POST["examplecmd"][$key]) ) {
            $res = $mytool->addCode( $_POST["exampletxt"][$key], $_POST["examplecmd"][$key], $_POST["exampleid"][$key] );
            if( empty($_POST["exampleid"][$key])){
                $idcodes[] = $res;
            } else {
                $idcodes[] = $_POST["exampleid"][$key];
            }
        }
    }
}
$mytool->setCodesid(implode(", ", $idcodes));

// minimum information needed
if( empty($mytool->getShrtdesc()) )
	die("Empty short desc");

if( empty($mytool->getLabels()) )
	die("Empty label");

if( $mytool->addToolDB() ){
	echo "Success";
} else {
	echo "Failed";
}
?>
