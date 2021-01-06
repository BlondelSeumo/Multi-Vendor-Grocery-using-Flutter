<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#paymentstatus-form').validate({
			rules:{
				
				title:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$pay_status->id; ?>"
				}
			},
			messages:{
				
				title:{
					blankCheck : "<?php echo get_msg( 'err_pay_status_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_pay_status_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_pay_status_exist' ) ;?>."
				}
			}
		});
		// custom validation
		jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			    	return true;
			   }
		})
	}

	<?php endif; ?>

</script>