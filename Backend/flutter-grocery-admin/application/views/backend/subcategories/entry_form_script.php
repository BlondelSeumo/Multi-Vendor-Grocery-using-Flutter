<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#subcategory-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$subcategory->id; ?>"
				},
				cat_id: {
		       		indexCheck : ""
		      	}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_subcat_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_subcat_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_subcat_exist' ) ;?>."
				},
				cat_id:{
			       indexCheck: "<?php echo $this->lang->line('f_item_cat_required'); ?>"
			    }
			}
		});
		
		jQuery.validator.addMethod("indexCheck",function( value, element ) {
			
			   if(value == 0) {
			    	return false;
			   } else {
			    	return true;
			   };

			   
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

		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$subcategory->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});

</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'sub_category',
		'img_parent_id' => @$subcategory->id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );
	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 

	// replace icon icon modal
	$data = array(
		'title' => get_msg('upload_icon'),
		'img_type' => 'subcat_icon',
		'img_parent_id' => @$subcategory->id
	);
		$this->load->view( $template_path .'/components/icon_upload_modal', $data );
		// delete icon photo modal
		$this->load->view( $template_path .'/components/delete_icon_modal' ); 
?>