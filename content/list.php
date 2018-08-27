<div class="w3-container padding-8">
    <p class="w3-large">
        <a href="<?php echo $url; ?>?tool=new">
            <i class="fa fa-plus-square fa-fw w3-margin-right w3-text-teal"></i>
            Add a new script.
        </a>
    </p>

    <?php
    if (isset($_GET["label"])){
        $tool_list = $tool->getToolsByLabel($_GET["label"]);
        if( ! empty($tool_list) ){
            foreach( $tool_list as $k => $v ){
                if( $v["status"] != "1" ){
                    $tool_color = "btn-danger";
                } else {
                    $tool_color = "btn-default";
                }
                 $tool_url = '<a class="btn '.
                    $tool_color.
                    ' btn-sm" href="'. $url.
                    '?id='.$v["id"].
                    '">'.
                    $v["toolname"].
                    '</a>';
                $tool_url = '<span>'.$tool_url.'</span><span> </span>';
                echo $tool_url;
            }
        }
    } else {
        foreach ($toolnames as $key => $value) {
            $tool_color = "btn-default";
            if( $value["status"] != "1" ){
                $tool_color = "btn-danger";
            }
            $tool_url = '<a class="btn '.
                $tool_color.
                ' btn-sm" href="'. $url.
                '?id='.$value["id"].
                '">'.
                $key.
                '</a>';
            $tool_url = '<span>'.$tool_url.'</span><span> </span>';
            echo $tool_url;
        }
    }
    ?>
</div>
