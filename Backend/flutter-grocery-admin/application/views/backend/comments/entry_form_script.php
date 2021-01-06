<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#comm-form').validate({
			rules:{
				detail_comment:{
					required: true,
					minlength: 1
				}
			},
			messages:{
				detail_comment_desc:{
					required: "Please Fill Push Message.",
					minlength: "The length of message must be greater than 1"
				}
			}
		});

	}

<?php endif; ?>
		

		var textFieldInFocus;
		function handleOnFocus(form_element)
		{
		   textFieldInFocus = form_element;
		}
		function handleOnBlur()
		{
		   textFieldInFocus = null;
		}

</script>