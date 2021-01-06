<div class='container mt-5'>
	<div class='row justify-content-center'>
		<div class='col-8 col-md-5'>

    		<?php
    		$attributes = array('id' => 'reset-form','method' => 'POST');
    		echo form_open(site_url('reset_request'), $attributes);
    		?>

			<h2>
				<label class="reset-title"><?php echo get_msg( 'reset_password' ); ?></label>
			</h2>

			<hr/>
			
			<?php flash_msg(); ?>
					
			<div class="form-group">
				<label><font color="#000"><?php echo get_msg( 'user_email' ); ?></font></label>
				<input class="form-control" type="text" placeholder="<?php echo get_msg( 'user_email' ); ?>" name='email' value="<?php echo set_value( 'email' ); ?>">
			</div>
					
			<button class="btn btn-primary" type="submit"><?php echo get_msg( 'reset' ); ?></button>
									
			<?php echo form_close();  ?>

		</div>
	</div>
</div>
<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
	
	function jqvalidate() {
		$(document).ready(function(){
			$('#reset-form').validate({
				rules:{
					email: "required"
				},
				messages:{
					email: "Please fill email address."
				}
			});
		});
	}

	<?php endif; ?>
</script>