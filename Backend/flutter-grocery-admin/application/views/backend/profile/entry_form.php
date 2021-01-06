<?php
	$attributes = array('id' => 'user-form');
	echo form_open( '', $attributes );
?>

<div class="container-fluid" style="padding-left: 20px;">
	<h5 style="padding-bottom: 10px;padding-top: 10px;"><?php echo get_msg('user_info')?></h5>
		
	<div class="row">
		<div class="col-6">
				<div class="form-group">
					<label><?php echo get_msg('user_name')?></label>

					<?php echo form_input(array(
						'name' => 'user_name',
						'value' => set_value( 'user_name', show_data( @$user->user_name ), false ),
						'class' => 'form-control form-control-sm',
						'placeholder' => get_msg('user_name'),
						'id' => 'name'
					)); ?>

				</div>
				
				<div class="form-group">
					<label><?php echo get_msg('user_email')?></label>

					<?php echo form_input(array(
						'name' => 'user_email',
						'value' => set_value( 'user_email', show_data( @$user->user_email ), false ),
						'class' => 'form-control form-control-sm',
						'placeholder' => get_msg('user_email'),
						'id' => 'user_email'
					)); ?>

				</div>
				
				<?php if ( @$user->user_is_sys_admin == 1 ): ?>

				<div class="form-group">
					<label><?php echo get_msg('user_password')?></label>

					<?php echo form_input(array(
						'type' => 'password',
						'name' => 'user_password',
						'value' => set_value( 'user_password' ),
						'class' => 'form-control form-control-sm',
						'placeholder' => get_msg('user_password'),
						'id' => 'user_password'
					)); ?>
				</div>
							
				<div class="form-group">
					<label><?php echo get_msg('conf_password')?></label>
					
					<?php echo form_input(array(
						'type' => 'password',
						'name' => 'conf_password',
						'value' => set_value( 'conf_password' ),
						'class' => 'form-control form-control-sm',
						'placeholder' => get_msg('conf_password'),
						'id' => 'conf_password'
					)); ?>
				</div>

				<?php endif; ?>

				<label><?php echo get_msg('profile_img')?>
					<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
						<span class='glyphicon glyphicon-info-sign menu-icon'>
					</a>
				</label> 
				
				<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadProfile">
					<?php echo get_msg('btn_replace_photo')?>
				</div>
				
				<hr/>
				
				<div class="row">

				<?php if ($i>0 && $i%3==0): ?>
						
				</div><div class='row'>
				
				<?php endif; ?>
					
				<div class="col-md-4" style="height:100">

					<div class="thumbnail">
						<?php $logged_in_user = $this->ps_auth->get_user_info(); ?>
						<img src="<?php echo img_url( 'thumbnail/'. $logged_in_user->user_profile_photo ); ?>" width="150px">

						<br/>
						
						<p class="text-center">
							
							<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
								image="<?php echo $img->img_path; ?>">
								<?php echo get_msg('remove_label'); ?>
							</a>
						</p>

					</div>

				</div>

			</div>
		</div>

	</div>
	
	<div class="my-3">
		<button type="submit" class="btn btn-sm btn-primary"><?php echo get_msg('btn_save')?></button>
		<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary"><?php echo get_msg('btn_cancel')?></a>
	</div>
</div>	

<?php echo form_close(); ?>