<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#module-form').validate({
			rules:{
				module_name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$mod->module_id; ?>"
					
				},
				
			},
			messages:{
				module_name:{
					blankCheck : "<?php echo get_msg( 'err_module_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_module_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_module_exist' ) ;?>."
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
		});

	}
	

	<?php endif; ?>

</script>