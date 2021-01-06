<script>

	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
	
	function jqvalidate() {
		$('#deliboy-form').validate({
			rules:{
				user_name:{
					required: true,
					minlength: 4
				},
				<?php if ( !isset( $deliboy )): ?>
				user_password:{
					required: true,
					minlength: 4
				},
				conf_password:{
					required: true,
					equalTo: '#user_password'
				},
				<?php endif; ?>
				
			},
			messages:{
				user_name:{
					required: "<?php echo get_msg( 'err_user_name_blank' ); ?>",
					minlength: "<?php echo get_msg( 'err_user_name_len' ); ?>"
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
				
			},
			
		});
	}
	$(document).ready(function() {
		$("input[type=checkbox]").attr("disabled", true);
	});	
	<?php endif; ?>

</script>