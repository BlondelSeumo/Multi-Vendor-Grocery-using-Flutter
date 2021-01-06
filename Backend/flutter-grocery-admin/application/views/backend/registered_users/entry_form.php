<?php
	$attributes = array('id' => 'user-form');
	echo form_open( '', $attributes );
?>

<div class="container-fluid">
	<div class="col-12"  style="padding: 30px 20px 20px 20px;">
		<?php flash_msg(); ?>
		<div class="card earning-widget">
		    <div class="card-header" style="border-top: 2px solid red;">
		        <h3 class="card-title"><?php echo get_msg('user_info')?></h3>
		    </div>

	  		<div class="card-body">
	    		<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo get_msg('user_name'); ?></label>
							<?php echo form_input( array(
								'name' => 'user_name',
								'value' => set_value( 'user_name', show_data( @$user->user_name ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'user_name' ),
								'id' => 'user_name'
							)); ?>
						</div>
						<?php if($user->verify_types == 1): ?>
						<div class="form-group">
							<label><?php echo get_msg('user_email'); ?></label>
							<?php echo form_input( array(
								'name' => 'user_email',
								'value' => set_value( 'user_email', show_data( @$user->user_email ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'user_email' ),
								'id' => 'user_email'
							)); ?>
						</div>
						<?php endif; ?>

						<?php if($user->verify_types == 4): ?>
						<div class="form-group">
							<label><?php echo get_msg('phone_label'); ?></label>
							<?php echo form_input( array(
								'name' => 'user_phone',
								'value' => set_value( 'user_phone', show_data( @$user->user_phone ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'phone_label' ),
								'id' => 'user_phone'
							)); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-md-6">
						<div class="form-group">	
							<label><?php echo get_msg('address_label'); ?></label>
							<?php echo form_input( array(
								'name' => 'user_address',
								'value' => set_value( 'user_address', show_data( @$user->user_address ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'address_label' ),
								'id' => 'user_address'
							)); ?>
						</div>
						
						<div class="form-group">	
							<label><?php echo get_msg('about_me'); ?></label>
							<?php echo form_input( array(
								'name' => 'user_about_me',
								'value' => set_value( 'user_about_me', show_data( @$user->user_about_me ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'about_me' ),
								'id' => 'user_about_me'
							)); ?>
						</div>
					</div>
				</div>
			</div>
			 <!-- /.card-body -->

			<div class="card-footer">
	            <button type="submit" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
	        </div>
	    </div>
	</div>
</div>

<?php echo form_close(); ?>