<?php
// We assume $tool object already exists from caller page

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
                useTabKey: true,
                selectionRenderer: function(data){
                    return '<span class="label label-' + colors_available[hashCode(data.name) % colors_available.length] + '">' + data.name + '</span>';
                }
            });
        });
    </script>
<H1>Edit mode <small class="bg-info">* Blue fields are mandatory</small></H1>
<form id="toolform" method="POST" action="connexion.php" class="form-horizontal">
	<div class="form-group">
        <label for="toolname" class="col-sm-2 control-label bg-info">Tool name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="toolname" value="<?php echo $tool->getToolname(); ?>">
        </div>
    </div>
	<div class="form-group">
        <label for="shrtdesc" class="col-sm-2 control-label bg-info">Short Description</label>
        <div class="col-sm-10">
		    <input type="text" class="form-control" name="shrtdesc" value="<?php echo $tool->getShrtdesc(); ?>"/>
        </div>
    </div>
	<div class="form-group">
        <label for="labels" class="col-sm-2 control-label bg-info">Categories</label>
        <div class="col-sm-10">
		    <input type="text" id="labelform" class="form-control" name="labels[]"/>
        </div>
    </div>
	<div class="form-group">
        <label for="longdesc" class="col-sm-2 control-label">Full Description</label>
        <div class="col-sm-10">
            <textarea name="longdesc" rows="1" class="form-control" placeholder="exhaustive info" name="longdesc"><?php echo $tool->getLongdesc(); ?></textarea>
        </div>
    </div>
	<div class="form-group">
        <label for="seealso" class="col-sm-2 control-label">See also</label>
        <div class="col-sm-10">
		    <input type="text" class="form-control" name="seealso" value="<?php echo $tool->getSeealso(); ?>"/>
        </div>
    </div>
	<div class="form-group">
        <label for="risks" class="col-sm-2 control-label">Risks</label>
        <div class="col-sm-10">
            <textarea name="risks" rows="1" class="form-control"><?php echo $tool->getRisks(); ?></textarea>
        </div>
    </div>
	<div class="form-group">
        <label for="usage" class="col-sm-2 control-label">Usage</label>
        <div class="col-sm-10">
            <textarea name="usagetxt" rows="1" class="form-control" placeholder="Comment about arguments"><?php echo $codetxt; ?></textarea>
            <textarea name="usagecmd" class="form-control" placeholder="Paste arguments usage"><?php echo $codecmd; ?></textarea>
        </div>
    </div>

    <?php
foreach( $codesid as $k => $v){
    ?>
	<div class="form-group">
        <label for="example[]" class="col-sm-2 control-label">Example</label>
        <div class="col-sm-10">
            <textarea name="exampletxt[]" class="form-control" placeholder="Information about the example you provide"><?php echo $v["txt"]; ?></textarea>
            <textarea name="examplecmd[]" class="form-control" placeholder="command and expected output"><?php echo $v["cmd"]; ?></textarea>
            <input type="hidden" name="exampleid[]" value="<?php echo $v["id"]; ?>" />
        </div>
    </div>
    <?php
}
    ?>

    <div class="input_fields_wrap">
        <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="add_field_button btn btn-info pull-right btn-xs">Add code example</button>
        </div>
        </div>
    </div>

	<div class="form-group">
        <label for="sources" class="col-sm-2 control-label">Source</label>
        <div class="col-sm-10">
		    <input type="text" class="form-control" name="source" placeholder="Where to find me" value="<?php echo $tool->getSources()[0]["url"]; ?>"/>
        </div>
    </div>
	<div class="form-group">
        <label for="maintainer" class="col-sm-2 control-label">Maintainer</label>
        <div class="col-sm-10">
		    <input type="text" class="form-control" name="maintainer" value="<?php echo $tool->getMaintainer()[0]["name"]; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input name="finished" type="checkbox" <?php echo $isfinished; ?>> Check this box if you finished the documentation, let it unchecked to have a reminder to finish the doc later.
                </label>
            </div>
        </div>
    </div>
	<input type="hidden" name="id" value="<?php echo $tool->getId(); ?>" />
	<input type="submit" name="submit" class="btn btn-primary pull-right" value="Validate" />
</form>

