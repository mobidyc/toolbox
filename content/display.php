<script>
    $(document).ready(function() {
        hljs.configure({
            tabReplace: '   ',
            language: 'Bash'
        });
        $('pre, code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
<?php

if (isset($_GET["id"])){
	$id = $_GET["id"];
    $tool->get_tool_by_id($id);

    $tool->setId($id);
    $label_spans = "";
    foreach($tool->list_labels($tool->getLabels()) as $k => $v){
        $tag_color = $colors_available[$tool->getHashNameNumber($k) % count($colors_available)];
        $label_url = '<a class="" href="'.$url.'?label='.htmlspecialchars($k).'">'.htmlspecialchars($k).'</a>';
        $label_spans .= '<span>'.$label_url.'</span><span> </span>';
        //$label_spans .= '<span class="label label-'.$tag_color.'">'.htmlspecialchars($k).'</span><span> </span>';
    }
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
}

?>
<div class="w3-container w3-card w3-white w3-margin-bottom">
    <div class="w3-row">
        <div class="w3-col m2 w3-margin-top">
            <i class="fa fa-superscript fa-fw w3-xxlarge w3-text-teal"></i>
        </div>
        <div class="w3-col m10">
            <h2 class="w3-text-grey">
                <?php echo htmlspecialchars( $tool->getToolname() ); ?>
            </h2>
        </div>
    </div>
    <div class="w3-row padding-8">
        <div class="w3-col m2">&nbsp;</div>
        <div class="w3-col m10">
            <button class="w3-button w3-round-large w3-light-blue">
                <a href="<?php echo htmlspecialchars($url).'?tool=edit&id='.$id;?>">(click to edit)</a>
            </button>
        </div>
    </div>
</div>

<div class="w3-container w3-card w3-white w3-margin-bottom">
    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Short description</b></div>
        <div class="w3-col m10"><?php echo nl2br(htmlspecialchars($tool->getShrtdesc())); ?></div>
    </div>

    <?php if(! empty($tool->getSeealso()) ){ ?>
    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>See also</b></div>
        <div class="w3-col m10"><?php echo htmlspecialchars($tool->getSeealso()); ?></div>
    </div>
    <?php } ?>

    <?php if(! empty($tool->getRisks()) ){ ?>
    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Risks</b></div>
        <div class="w3-col m10 w3-text-red"><b><?php echo nl2br(htmlspecialchars($tool->getRisks())); ?></b></div>
    </div>
    <?php } ?>

    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Tags</b></div>
        <div class="w3-col m10"><?php echo $label_spans; ?></div>
    </div>

    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Source</b></div>
        <div class="w3-col m10"><span class=""><?php echo htmlspecialchars($tool->getSources()[0]["url"]); ?></span></div>
    </div>

    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Maintainer</b></div>
        <div class="w3-col m10"><span class=""><?php echo htmlspecialchars($tool->getMaintainer()[0]["name"]); ?></span></div>
    </div>
</div>

<?php if(! empty($tool->getLongdesc())){ ?>
<div class="w3-container w3-card w3-white w3-margin-bottom">
    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Full description</b></div>
        <div class="w3-col m10"><?php echo nl2br(htmlspecialchars($tool->getLongdesc())); ?></div>
    </div>
</div>
<?php } ?>

<?php if(! empty($codetxt.$codecmd)){ ?>
<div class="w3-container w3-card w3-white w3-margin-bottom">
    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Usage</b></div>
        <div class="w3-col m10"><code class="bash"><?php echo htmlspecialchars($codetxt); ?></code></div>
    </div>
    <div class="w3-row padding-8">
        <div class="w3-col m2">&nbsp;</div>
        <div class="w3-col m10"><pre><?php echo htmlspecialchars($codecmd); ?></pre></div>
    </div>
</div>
<?php } ?>

<?php foreach($codesid as $k => $v){ ?>
<div class="w3-container w3-card w3-white w3-margin-bottom">
    <div class="w3-row padding-8">
        <div class="w3-col m2"><b>Example</b></div>
        <div class="w3-col m10"><code><?php echo htmlspecialchars($v["txt"]); ?></code></div>
    </div>
    <div class="w3-row padding-8">
        <div class="w3-col m2">&nbsp;</div>
        <div class="w3-col m10"><pre><?php echo htmlspecialchars($v["cmd"]); ?></pre></div>
    </div>
</div>
<?php } ?>
