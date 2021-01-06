<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#attribute_form').validate({


			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: {
		                url: '<?php echo site_url(). '/admin/attributes' .'/ajx_exists/'.@$attribute->id; ?>',
		                type: 'get',
		                data: {
		                    product_id: function () {
			                    return $("#product_id").val();
			                    return $("#name").css({"color": "red"});
			                }
		                } 

		            }
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_att_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_att_len' ) ;?>",
					remote:  "<?php echo get_msg( 'err_att_exist' ) ;?>",
				}
			}


		});
		// custom validation
		jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			   	
			    	return true;
			   };
		})
		
	}

	<?php endif; ?>

</script>