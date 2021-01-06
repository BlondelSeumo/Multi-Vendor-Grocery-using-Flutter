<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#string-form').validate({
			rules:{
				key:{
					blankCheck : "",
					minlength: 3,
					remote: {
		                url: '<?php echo $module_site_url .'/ajx_exists/'.@$langstr->id; ?>',
		                type: 'get',
		                data: {
		                    language_id: function () {
			                    return $("#language_id").val();
			                    return $("#name").css({"color": "red"});
			                }
		                } 

		            }
				}
			},
			messages:{
				key:{
					blankCheck : "<?php echo get_msg( 'err_lang_str_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_lang_str_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_lang_str_exist' ) ;?>."
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