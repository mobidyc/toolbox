<?php
// init
$codetxt = "";
$codecmd = "";
$labels = "";
$codesid = Array();
$mylabel_arr = "";
$isfinished = "";

if (isset($_GET["id"])){
	$id = $_GET["id"];
    $tool->get_tool_by_id($id);

    $tool->setId($id);

    $mylabel_ids = $tool->getLabels();
    $mylabel_keys = $tool->list_labels( $mylabel_ids );

    $mylabel_names = array();
    foreach( $mylabel_keys as $k => $v){
        $mylabel_names[] = "'".$k."'";
    }
    $mylabel_arr = implode(',', array_values($mylabel_names));


    foreach( explode(',', $tool->getCodesid()) as $k ){
        if(! empty($k) ) {
            $codesid[$k] = $tool->get_code($k);
        }
    }

    if( ! empty($tool->getTusage()) ){
        $code = $tool->get_code( $tool->getTusage() );
        $codetxt = $code["txt"];
        $codecmd = $code["cmd"];
    }

    if( $tool->getFinished() ){
        $isfinished = "checked";
    }
}

?>
    <script type="text/javascript">
        $(document).ready(function(){
            // for color randomization
            var colors_available = [ "default", "primary", "success", "info", "warning", "danger", "facebook", "google", "twitter", "pinterest", "tumblr", "phaedra-default", "phaedra-primary", "phaedra-success", "phaedra-info", "phaedra-warning" ];
            function myrandom(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
            function hashCode(str){
                var hash = 0;

                for (i = 0; i < str.length; i++) {
                    char = str.charCodeAt(i);
                    hash += char;
                }
                return hash;
            }

            // tags
            $('#labelform').magicSuggest({
                data: 'list.php?labels',
                value: [<?php echo $mylabel_arr; ?>],
                valueField: 'name',
                displayField: 'name',
                placeholder: 'Add a label',
                toggleOnClick: true,
                useTabKey: true,
                cls: 'w3-input w3-border',
                selectionRenderer: function(data){
                    return '<span class="label btn-' + colors_available[hashCode(data.name) % colors_available.length] + '">' + data.name + '</span>';
                }
            });
        });
    </script>

<div class="w3-container w3-card w3-white w3-margin-bottom">
    <h2 class="w3-text-grey w3-padding-16">
        <i class="fa fa-edit fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
        Edit mode
        <b class="w3-text-light-blue">*</b>
        <small class="w3-small">Mandatory fields</small>
    </h2>
</div>

<form id="toolform" method="POST" action="connexion.php">
    <div class="w3-container w3-card w3-white w3-margin-bottom padding-8">
        <label for="toolname"><b class="w3-text-light-blue">*</b> Tool name</label>
        <input type="text" class="w3-input w3-border" name="toolname" placeholder="program name." value="<?php echo $tool->getToolname(); ?>">

        <label for="shrtdesc"><b class="w3-text-light-blue">*</b> Short Description</label>
		<input type="text" class="w3-input w3-border" name="shrtdesc" placeholder="Will be used by the search engine." value="<?php echo $tool->getShrtdesc(); ?>"/>

        <label for="labels"><b class="w3-text-light-blue">*</b> Categories</label>
        <input type="text" id="labelform" class="w3-input w3-border" name="labels[]"/>

        <label for="sources">Source</label>
	    <input type="text" class="w3-input w3-border w3-light-gray" name="source" placeholder="Where to find me" value="<?php echo $tool->getSources()[0]["url"]; ?>"/>

        <label for="maintainer">Maintainer</label>
		<input type="text" class="w3-input w3-border w3-light-gray" name="maintainer" value="<?php echo $tool->getMaintainer()[0]["name"]; ?>"/>
    </div>

    <div class="w3-container w3-card w3-white w3-margin-bottom padding-8">
        <label for="longdesc">Full Description</label>
        <textarea name="longdesc" rows="1" class="w3-input w3-border w3-light-gray" placeholder="exhaustive info" name="longdesc"><?php echo $tool->getLongdesc(); ?></textarea>

        <label for="seealso">See also</label>
        <input type="text" class="w3-input w3-border w3-light-gray" name="seealso" value="<?php echo $tool->getSeealso(); ?>"/>

        <label for="risks">Risks</label>
        <textarea name="risks" rows="1" class="w3-input w3-border w3-light-gray"><?php echo $tool->getRisks(); ?></textarea>

        <label for="usage">Usage</label>
        <textarea name="usagetxt" rows="1" class="w3-input w3-border w3-light-gray" placeholder="Comment about arguments"><?php echo $codetxt; ?></textarea>
        <textarea name="usagecmd" class="w3-input w3-border w3-light-gray" placeholder="Paste arguments usage"><?php echo $codecmd; ?></textarea>
    </div>

    <?php foreach( $codesid as $k => $v){ ?>
    <div class="w3-container w3-card w3-white w3-margin-bottom padding-8">
        <label for="example[]">Example</label>
        <textarea name="exampletxt[]" class="w3-input w3-border" placeholder="Information about the example you provide"><?php echo $v["txt"]; ?></textarea>
        <textarea name="examplecmd[]" class="w3-input w3-border" placeholder="command and expected output"><?php echo $v["cmd"]; ?></textarea>
        <input type="hidden" name="exampleid[]" value="<?php echo $v["id"]; ?>" />
    </div>
    <?php } ?>

    <div class="input_fields_wrap w3-container w3-card w3-white w3-margin-bottom padding-8">
        <button class="add_field_button w3-button w3-block w3-light-blue">Add code example</button>
    </div>

    <div class="w3-container w3-card w3-white w3-margin-bottom padding-8">
        <input name="finished" type="checkbox" class="w3-check" <?php echo $isfinished; ?>>
        <label>Check this box if you finished the documentation, let it unchecked to have a reminder to finish the doc later.</label>
    </div>

    <div class="w3-container w3-card w3-white w3-margin-bottom padding-8">
	    <input type="hidden" name="id" value="<?php echo $tool->getId(); ?>" />
	    <input type="submit" name="submit" class="w3-btn w3-block w3-round-large w3-green" value="Validate" />
    </div>
</form>

