<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#detail_form').validate({


			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: {
		                url: '<?php echo $module_site_url .'/ajx_exists/'.@$attdetail->id; ?>',
		                type: 'get',
		                data: {
		                    header_id: function () {
			                    return $("#header_id").val();
			                    return $("#name").css({"color": "red"});
			                }

		                } 

		            }
				},
				additional_price:{
					blankCheck : ""
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_detail_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_detail_len' ) ;?>",
					remote:  "<?php echo get_msg( 'err_detail_exist' ) ;?>",
				},
				additional_price:{
					blankCheck : "<?php echo get_msg( 'err_price' ) ;?>"
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

		$('input[name="additional_price"]').keyup(function(e)
        {
		  if (/[^\d.-]/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/[^\d.-]/g, '');
		  }
		});
		
	}

	<?php endif; ?>

</script>