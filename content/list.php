<!--==========================
     List
 ============================-->
 <section id="tools">
    <div class="container">
        <header class="section-header">
            <h1 class="section-title">Tools
            <a class="btn btn-primary btn-xs" href="<?php echo $url; ?>?tool=new">Add a tool description</a>
            </h1>
        </header>
        <div class="row">
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
 </section>
<!-- #Header -->
