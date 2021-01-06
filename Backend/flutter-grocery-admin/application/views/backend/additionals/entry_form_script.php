<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {
		
		$('#additional-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$add->id; ?>"
					
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_food_add_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_food_add_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_food_add_exist' ) ;?>."
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
		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$add->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});


		$('input[name="price"]').keyup(function(e)
	                                {
		  if (/[^\d.-]/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/[^\d.-]/g, '');
		  }
		});
	}
</script>
<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'food-additional',
		'img_parent_id' => @$add->id
	);
	
	$this->load->view( $template_path .'/components/photo_upload_modal', $data );
	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
	
?>