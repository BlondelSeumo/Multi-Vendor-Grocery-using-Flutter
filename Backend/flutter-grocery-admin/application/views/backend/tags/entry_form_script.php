<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {
		
		$('#tag-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$tag->id; ?>"
					
				},
				
				image:{
					required : true
				},
				icon:{
					required : true
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_tag_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_tag_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_tag_exist' ) ;?>."
				},
				
				image:{
					required : "<?php echo get_msg( 'err_image_missing' ) ;?>."
				},
				icon:{
					required : "<?php echo get_msg( 'err_icon_missing' ) ;?>."
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
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$tag->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});

	
</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'tag',
		'img_parent_id' => @$tag->id
	);
	
	$this->load->view( $template_path .'/components/photo_upload_modal', $data );
	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' );

	// replace icon modal
	$data = array(
		'title' => get_msg('upload_icon'),
		'img_type' => 'tag-icon',
		'img_parent_id' => @$tag->id
	);
		$this->load->view( $template_path .'/components/icon_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>