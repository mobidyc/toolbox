<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toolbox</title>

    <!-- CSS reset -->
    <link rel="stylesheet" href="normalize.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Syntax color -->
    <!-- https://highlightjs.org/usage/ -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

    <!-- Autosize -->
    <script src="autosize.min.js"></script>

    <!-- Auto tags http://nicolasbize.com/magicsuggest -->
    <link href="lib/magicsuggest/magicsuggest.css" rel="stylesheet">
    <script src="lib/magicsuggest/magicsuggest.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            // Autosize textareas
            $('textarea').each(function(){
                autosize(this);
            }).on('autosize:resized', function(){
                console.log('textarea height updated');
            });

            var wrapper     = $(".input_fields_wrap");
            var add_button  = $(".add_field_button");

            $(add_button).click(function(e){
                e.preventDefault();

                $(wrapper).prepend('<div class="form-group">' +
                    '<label for="example[]" class="col-sm-2 control-label remove_field">' +
                    '<a>Remove</a>' +
                    '</label>' +
                    '<div class="col-sm-10">' +
                    '<textarea name="exampletxt[]" rows="1" class="form-control"></textarea>' +
                    '<textarea name="examplecmd[]" class="form-control"></textarea>' +
                    '<input type="hidden" name="exampleid[]" value="" />' +
                    '</div>' +
                    '</div>'
                );
                autosize($('textarea'));
            });

            $(wrapper).on("click",".remove_field", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
            });

            var frm = $("#toolform");
     
            frm.submit(function(e){
                e.preventDefault(); // avoid to execute the actual submit of the form.
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    contentType: "application/x-www-form-urlencoded",
                    data: frm.serialize(), // serializes the form's elements.
                    success: function(e) {
                        if(e == "Success") {
                            url = location.href.replace(/&?tool=([^&]$|[^&]*)/i, "");
                            console.log(e + " [" + url + "]");
                            window.location.replace(url);
                        } else {
                            console.log("["+e+"]");
                            alert(e)
                        }
                    },
                    error: function (e) {
                        alert('An error occurred.');
                    }
                });
            });
        });
     </script>

    <style>
        body {
            background-color: #333;
        }
        .well {
            overflow:hidden;
        }
        .btn-facebook {
            background-color:#3b5998;
            color:#fff;
        }
        .btn-google {
            background-color:#dd4b39;
            color:#fff;
        }
        .btn-twitter {
            background-color:#2ba9e1;
            color:#fff;
        }
        .btn-pinterest {
            background-color:#cb2027;
            color:#fff;
        }
        .btn-tumblr {
            background-color:#2c4762;
            color:#fff;
        }
        .btn-phaedra-default {
            background-color:#7f8c8d;
            color:#000;
        }
        .btn-phaedra-primary {
            background-color:#007D68;
            color:#000;
        }
        .btn-phaedra-success {
            background-color:#659E78;
            color:#000;
        }
        .btn-phaedra-info {
            background-color:#A5CC8A;
            color:#000;
        }
        .btn-phaedra-warning {
            background-color:#D1D181;
            color:#000;
        }
    </style>

</head>
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

<div class="container well">

    <div class="row">
        <H1>Categories</H1>
        <?php
foreach ($all_labels as $key => $value) {
    $tag_color = $colors_available[$tool->getHashNameNumber($key) % count($colors_available)];
    $label_url = '<a class="btn btn-xs btn-'.$tag_color.' role="button" href="'.$url.'?label='.$key.'">'.$key.'</a> ';
    echo $label_url;
}
?>
    </div>

    <div class="row">
        <H1>Tool list <a class="btn btn-primary btn-xs" href="<?php echo $url; ?>?tool=new">Add a tool description</a></H1>

        <?php
    include_once("list_tools.php");
        ?>
    </div>

    <div class="center-block">
        <div class="row">
            <div class="center-block">
                <?php
                    if( isset($_GET["tool"]) && ( $_GET["tool"] == "new" || $_GET["tool"] == "edit" ) ){
                        include('form.php');
                    } elseif(isset($_GET["id"])) {
                        include('display.php');
                    } else {
                        include('description.php');
                    }
                ?>
            </div>
        </div>
    </div>

</div> <!-- End container -->

</body>
</html>
