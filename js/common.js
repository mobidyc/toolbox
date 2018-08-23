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
