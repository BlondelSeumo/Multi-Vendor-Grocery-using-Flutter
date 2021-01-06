<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {
		
		$('#branch-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$branch->id; ?>"
					
				},
				description:{
					required: true, 
					
				},
				address:{
					required: true, 
					
				},
				phone:{
					required: true, 
					
				},
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_branch_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_branch_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_branch_exist' ) ;?>."
				},
				description:{
					required : "<?php echo get_msg( 'err_branch_description' ) ;?>."
				},
				address:{
					required : "<?php echo get_msg( 'err_branch_address' ) ;?>."
				},
				phone:{
					required : "<?php echo get_msg( 'err_branch_phone' ) ;?>."
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

	

		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$branch->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});

	
</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'grocery-branch',
		'img_parent_id' => @$branch->id
	);
	
	$this->load->view( $template_path .'/components/photo_upload_modal', $data );
	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
	
?>