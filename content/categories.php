 <div class="w3-container">
    <p class="w3-large">
        <b>
        <i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>
        Tags
        </b>
    </p>
    <div class="tagCloud">
        <script type="text/javascript">
        $(function() {
            //create list for tag links
            $("<ul>").attr("class", "tagList").appendTo(".tagCloud");
            data = <?php echo $tool->list_label_freq(); ?>
            //create tags
            $.each(data.tags, function(i, val) {
                //create item
                var li = $("<li>");
                //create link
                if(val.freq > 1) {
                    var title = "See the "+val.freq+" tools tagged with "
                } else {
                    var title = "See the tool tagged with "
                }
                $("<a>")
                    .text(val.tag)
                    .attr({
                        title: title + '"' + val.tag + '"',
                        href: '<?php echo $url;?>?label=' + val.tag
                    })
                    .appendTo(li)
                
                //add to list
                li.appendTo(".tagList");
                //set tag size
                var minfont = 0.8;
                var maxfont = 2.5
                var fontunit = 'em';
                var maxfontstep = (maxfont - minfont) / 10;
                li
                    .children()
                    .css("fontSize", minfont + maxfontstep/((data.maxfreq - val.freq + 1) / 10) + fontunit);
            });
        });
        </script>
    </div>
</div>
