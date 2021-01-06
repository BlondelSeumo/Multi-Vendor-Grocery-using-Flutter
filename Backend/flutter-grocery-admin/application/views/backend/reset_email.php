<div class='container mt-5'>
	<div class='row justify-content-center'>
		<div class='col-8 col-md-5'>

    		<?php
    		$attributes = array('id' => 'reset-email-form','method' => 'POST');
    		echo form_open( site_url( 'reset_email/'. $code ), $attributes);
    		?>

			<h2>
				<label class="reset-title"><?php echo get_msg( 'reset_password' ); ?></label>
			</h2>

			<hr/>
			
			<?php flash_msg(); ?>

			<div class="form-group">
				<label><?php echo get_msg('user_password')?></label>

				<?php echo form_input(array(
					'type' => 'password',
					'name' => 'password',
					'value' => set_value( 'password' ),
					'class' => 'form-control form-control-sm',
					'placeholder' => 'Password',
					'id' => 'password'
				)); ?>
			</div>
						
			<div class="form-group">
				<label><?php echo get_msg('conf_password')?></label>
				
				<?php echo form_input(array(
					'type' => 'password',
					'name' => 'conf_password',
					'value' => set_value( 'conf_password' ),
					'class' => 'form-control form-control-sm',
					'placeholder' => 'Conf Password',
					'id' => 'conf_password'
				)); ?>
			</div>
					
			<button class="btn btn-primary" type="submit"><?php echo get_msg( 'Reset' ); ?></button>
									
			<?php echo form_close();  ?>

		</div>
	</div>
</div>
<script>
<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
	
	function jqvalidate() {
		$('#reset-email-form').validate({
			rules:{
				password:{
					required: true,
					minlength: 4
				},
				conf_password:{
					required: true,
					equalTo: '#password'
				}
			},
			messages:{
				password:{
					required: "<?php echo get_msg( 'err_user_pass_blank' ); ?>",
					minlength: "<?php echo get_msg( 'err_user_pass_len' ); ?>"
				},
				conf_password:{
					required: "<?php echo get_msg( 'err_user_pass_conf_blank' ); ?>",
					equalTo: "<?php echo get_msg( 'err_user_pass_conf_not_match' ); ?>"
				}
			}
		});
	}

	<?php endif; ?>
</script>