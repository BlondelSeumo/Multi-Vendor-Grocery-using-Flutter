<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#transtatus-form').validate({
			rules:{
				
				title:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$trans_status->id; ?>"
				}
			},
			messages:{
				
				title:{
					blankCheck : "<?php echo get_msg( 'err_trans_status_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_trans_status_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_trans_status_exist' ) ;?>."
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

	function runAfterJQ() {

		// colorpicker
		$('.my-colorpicker2').colorpicker()

      	
	}

</script>