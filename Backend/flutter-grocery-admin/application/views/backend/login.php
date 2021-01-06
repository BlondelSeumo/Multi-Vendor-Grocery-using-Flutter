<p class="" style="font-size: 14px;padding-right: 10px;font-weight: bold;color : #fff;"><?php echo get_msg( 'ver_no_label' ); ?> : <?php echo $this->config->item('version_no');?></p>
<div class="login-page">
  <div class="form1">
    	<?php
    		$attributes = array('id' => 'login-form','method' => 'POST');
    		echo form_open(site_url('login'), $attributes);
    	?>
    	<h2 class="mb-3">
    		<label class="login-title"><?php echo $site_name; ?></label>
    	</h2>
    	<?php flash_msg(); ?>
	      <input type="text" placeholder="<?php echo get_msg( 'user_email' ); ?>" name='email' value="<?php echo set_value( 'email' ); ?>">
	      <input type="password" placeholder="<?php echo get_msg( 'user_password' ); ?>" name='password' value="<?php echo set_value( 'password' ); ?>">
	      <button type="submit"><?php echo get_msg( 'sign_in' ); ?></button>
	      <?php echo form_close();  ?>
	      <hr>

		<a href="<?php echo site_url( 'reset_request' ); ?>">Forgot Password?</a>
  </div>
</div>

<script>
	function jqvalidate() {
		$(document).ready(function(){
			$('#login-form').validate({
				rules:{
					email: "required",
					password: "required"
				},
				messages:{
					email: "Please fill username.",
					password: "Please fill password"
				}
			});
		});
	}
</script>