<!--==========================
     Categories
 ============================-->
 <section id="categories">
    <div class="container">
        <header class="section-header">
            <h1 class="section-title">Categories</h1>
        </header>
        <div class="row">
            <div class="tagcloud">
            <script type="text/javascript">
            $(function() {
                //create list for tag links
                $("<ul>").attr("class", "taglist").appendTo(".tagcloud");

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
                    li.appendTo(".taglist");

                    //set tag size
                    var maxfont = 22;
                    var minfont = 8;
                    var fontunit = 'pt';

                    var spread = data.maxfreq - data.minfreq;
                    if(spread <= 0) spread = 1;

                    var fontspread = maxfont - minfont;
                    if(fontspread <= 0) fontspread = 1;

                    var fontstep = fontspread / spread;
                    var freq = val.freq ;

                    li
                        .children()
                        .css("fontSize", freq * spread * fontstep + fontunit);
                });
            });
            </script>
            </div>
        </div>
 </section>
<!-- #Header -->
