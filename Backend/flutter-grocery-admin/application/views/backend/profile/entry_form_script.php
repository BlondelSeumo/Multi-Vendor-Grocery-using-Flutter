<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
	
	function jqvalidate() {
		$('#user-form').validate({
			rules:{
				user_name:{
					required: true,
					minlength: 4
				},
				user_email:{
					required: true,
					email: true,
					remote: '<?php echo $module_site_url ."/ajx_exists/". @$user->user_id ; ?>'
				},
				user_password:{
					minlength: 4
				},
				conf_password:{
					equalTo: '#user_password'
				}
			},
			messages:{
				user_name:{
					required: "<?php echo get_msg( 'err_user_name_blank' ); ?>",
					minlength: "<?php echo get_msg( 'err_user_name_len' ); ?>"
				},
				user_email:{
					required: "<?php echo get_msg( 'err_user_email_blank' ); ?>",
					email: "<?php echo get_msg( 'err_user_email_invalid' ); ?>",
					remote: "<?php echo get_msg( 'err_user_email_exist' ); ?>"
				},
				user_password:{
					minlength: "<?php echo get_msg( 'err_user_pass_len' ); ?>"
				},
				conf_password:{
					equalTo: "<?php echo get_msg( 'err_user_pass_conf_not_match' ); ?>"
				}
			}
		});
	}

	<?php endif; ?>

	function runAfterJQ() {

		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_profile_photo/'; ?>' + id + '<?php echo @$user->user_id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
		});
	}

</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_parent_id' => @$user->user_id
	);

	$this->load->view( $template_path .'/components/profile_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>