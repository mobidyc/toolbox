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
<H1>Description</H1>
<?php

if (isset($_GET["id"])){
	$id = $_GET["id"];
    $tool->get_tool_by_id($id);

    $tool->setId($id);
    $label_spans = "";
    foreach($tool->list_labels($tool->getLabels()) as $k => $v){
        $tag_color = $colors_available[$tool->getHashNameNumber($k) % count($colors_available)];
        $label_url = '<a class="label label-'.$tag_color.'" href="'.$url.'?label='.htmlspecialchars($k).'">'.htmlspecialchars($k).'</a>';
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
<div class="row panel panel-default">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Tool name</b> (<?php echo '<a href="'.htmlspecialchars($url).'?tool=edit&id='.$id.'">Edit</a>'; ?>):</div>
            <div class="col-md-10"><b><?php echo htmlspecialchars($tool->getToolname()); ?></b></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Short description</b></div>
            <div class="col-md-10"><?php echo nl2br(htmlspecialchars($tool->getShrtdesc())); ?></div>
        </div>
    </div>
<?php if(! empty($tool->getSeealso()) ){ ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>See also</b></div>
            <div class="col-md-10"><?php echo htmlspecialchars($tool->getSeealso()); ?></div>
        </div>
    </div>
<?php } ?>
<?php if(! empty($tool->getRisks()) ){ ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Risks</b></div>
            <div class="col-md-10 bg-danger panel-body"><?php echo nl2br(htmlspecialchars($tool->getRisks())); ?></div>
        </div>
    </div>
<?php } ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Categories</b></div>
            <div class="col-md-10 btn-toolbar"><?php echo $label_spans; ?></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Source</b></div>
            <div class="col-md-10 btn-toolbar"><span class="label label-success"><?php echo htmlspecialchars($tool->getSources()[0]["url"]); ?></span></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Maintainer</b></div>
            <div class="col-md-10 btn-toolbar"><span class="label label-success"><?php echo htmlspecialchars($tool->getMaintainer()[0]["name"]); ?></span></div>
        </div>
    </div>

</div>

<?php if(! empty($tool->getLongdesc())){ ?>
<div class="row panel panel-default">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Full description</b></div>
            <div class="col-md-10"><?php echo nl2br(htmlspecialchars($tool->getLongdesc())); ?></div>
        </div>
    </div>
</div>
<?php } ?>

<?php if(! empty($codetxt.$codecmd)){ ?>
<div class="row panel panel-default">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Usage</b></div>
            <div class="col-md-10"><code class="bash"><?php echo htmlspecialchars($codetxt); ?></code></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10"><pre><?php echo htmlspecialchars($codecmd); ?></pre></div>
        </div>
    </div>
</div>
<?php } ?>

<?php foreach($codesid as $k => $v){ ?>
<div class="row panel panel-default">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"><b>Example</b></div>
            <div class="col-md-10"><code><?php echo htmlspecialchars($v["txt"]); ?></code></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10"><pre><?php echo htmlspecialchars($v["cmd"]); ?></pre></div>
        </div>
    </div>
</div>
<?php } ?>
