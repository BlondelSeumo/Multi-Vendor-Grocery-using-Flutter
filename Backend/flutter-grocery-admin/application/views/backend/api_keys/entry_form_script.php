<script>
	function jqvalidate() {

		$(document).ready(function(){
			$('#apikey-form').validate({
				rules:{
					key:{
						required: true,
						minlength: 4
					}
				},
				messages:{
					key:{
						required: "Please fill key.",
						minlength: "The length of key must be greater than 4"
					}
				}
			});
		});
	}

</script>