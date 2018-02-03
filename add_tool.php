<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
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
						console.log(e);
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

<?php
include('form.php');
?>
