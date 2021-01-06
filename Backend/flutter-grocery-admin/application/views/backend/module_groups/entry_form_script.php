<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#group-form').validate({
			rules:{
				group_name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$group->id; ?>"
					
				},
				
			},
			messages:{
				group_name:{
					blankCheck : "<?php echo get_msg( 'err_group_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_group_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_group_exist' ) ;?>."
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

