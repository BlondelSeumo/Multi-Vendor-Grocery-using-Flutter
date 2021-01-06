<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
	
	function jqvalidate() {
	
		$('#gcm-form').validate({
			rules:{
				message:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$noti->id; ?>"
					
				}
			},
			messages:{
				message:{
					blankCheck : "<?php echo get_msg( 'err_noti_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_noti_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_noti_exist' ) ;?>."
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

	$(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'noti',
		'img_parent_id' => @$noti->id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>