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
				<?php if ( !isset( $user )): ?>
				user_password:{
					required: true,
					minlength: 4
				},
				conf_password:{
					required: true,
					equalTo: '#user_password'
				},
				<?php endif; ?>
				"permissions[]": { 
					required: true, 
					minlength: 1 
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
				<?php if ( !isset( $user )): ?>
				user_password:{
					required: "<?php echo get_msg( 'err_user_pass_blank' ); ?>",
					minlength: "<?php echo get_msg( 'err_user_pass_len' ); ?>"
				},
				conf_password:{
					required: "<?php echo get_msg( 'err_user_pass_conf_blank' ); ?>",
					equalTo: "<?php echo get_msg( 'err_user_pass_conf_not_match' ); ?>"
				},
				<?php endif; ?>
				"permissions[]": "<?php echo get_msg( 'err_permission_blank' ); ?>"
			},
			errorPlacement: function(error, element) {
				console.log( $(error).text());
				if (element.attr("name") == "permissions[]" ) {
					console.log( $(error).text());
					$("#perm_err label").html($(error).text());
					$("#perm_err").show();
				} else {
					error.insertAfter(element);
				}
			}
		});
	}
	$(document).ready(function() {
		$("input[type=checkbox]").attr("disabled", true);
	});	
	<?php endif; ?>

</script>