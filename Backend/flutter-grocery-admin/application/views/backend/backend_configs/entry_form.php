<?php
$attributes = array('id' => 'backend-form','enctype' => 'multipart/form-data');
echo form_open( '', $attributes);
?>

<div class="container-fluid">
    <div class="col-12"  style="padding: 30px 20px 20px 20px;">
    	<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('backend_config_info_lable')?></h3>
			</div>
        <!-- /.card-header -->
        	<div class="card-body">
		        <div class="row">
		          	<div class="col-md-6">
		          		<div class="form-group">
							<label><?php echo get_msg('sender_name_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('sender_name_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'sender_name',
									'id' => 'sender_name',
									'class' => 'form-control',
									'placeholder' => get_msg('sender_name_label'),
									'value' => set_value( 'sender_name', show_data( @$backend->sender_name ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label><?php echo get_msg('receive_email_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('receive_email_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'email',
									'name' => 'receive_email',
									'id' => 'receive_email',
									'class' => 'form-control',
									'placeholder' => get_msg('receive_email_label'),
									'value' => set_value( 'receive_email', show_data( @$backend->receive_email ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label><?php echo get_msg('topics_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('topics_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'topics',
									'id' => 'topics',
									'class' => 'form-control',
									'placeholder' => get_msg('topics_label'),
									'value' => set_value( 'topics', show_data( @$backend->topics ), false )
								));
							?>
						</div>

		          	</div>

		          	<div class="col-md-6">
		          		<div class="form-group">
							<label><?php echo get_msg('sender_email_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('receive_email_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'email',
									'name' => 'sender_email',
									'id' => 'sender_email',
									'class' => 'form-control',
									'placeholder' => get_msg('sender_email_label'),
									'value' => set_value( 'sender_email', show_data( @$backend->sender_email ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label><?php echo get_msg('fcm_api_key_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('fcm_api_key_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'fcm_api_key',
									'id' => 'fcm_api_key',
									'class' => 'form-control',
									'placeholder' => get_msg('fcm_api_key_label'),
									'value' => set_value( 'fcm_api_key', show_data( @$backend->fcm_api_key ), false )
								));
							?>
						</div>
		          	</div>

		          	<legend class="ml-3"><?php echo get_msg('smtp_section')?></legend>
		          	<hr width="100%">
		          	<div class="col-md-6">
		          		<div class="form-group">
		          			<label><?php echo get_msg('smtp_host_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('fcm_api_key_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'smtp_host',
									'id' => 'smtp_host',
									'class' => 'form-control',
									'placeholder' => get_msg('smtp_host_placeholder'),
									'value' => set_value( 'smtp_host', show_data( @$backend->smtp_host ), false )
								));
							?>
		          		</div>

		          		<div class="form-group">
		          			<label><?php echo get_msg('smtp_port_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('smtp_port_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'smtp_port',
									'id' => 'smtp_port',
									'class' => 'form-control',
									'placeholder' => get_msg('smtp_port_label'),
									'value' => set_value( 'smtp_port', show_data( @$backend->smtp_port ), false )
								));
							?>
		          		</div>

		          		<div class="form-group" style="padding-top: 30px;">
							<div class="form-check">

								<label class="form-check-label">
								
									<?php echo form_checkbox( array(
										'name' => 'smtp_enable',
										'id' => 'smtp_enable',
										'value' => 'accept',
										'checked' => set_checkbox('smtp_enable', 1, ( @$backend->smtp_enable == 1 )? true: false ),
										'class' => 'form-check-input'
									));	?>
									<label><?php echo get_msg( 'smtp_enable' ); ?></label>
								</label>
							</div>
						</div>

                        <div class="form-group" style="padding-top: 30px;">
							<div class="form-check">

								<label class="form-check-label">
								
									<?php echo form_checkbox( array(
										'name' => 'email_verification_enabled',
										'id' => 'email_verification_enabled',
										'value' => 'accept',
										'checked' => set_checkbox('email_verification_enabled', 1, ( @$backend->email_verification_enabled == 1 )? true: false ),
										'class' => 'form-check-input'
									));	?>
									<label><?php echo get_msg( 'email_verification_enabled' ); ?></label>
								</label>
							</div>
						</div>     

		          	</div>

		          	<div class="col-md-6">
		          		<div class="form-group">
		          			<label><?php echo get_msg('smtp_user_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('smtp_user_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'smtp_user',
									'id' => 'smtp_user',
									'class' => 'form-control',
									'placeholder' => get_msg('smtp_user_label'),
									'value' => set_value( 'smtp_user', show_data( @$backend->smtp_user ), false )
								));
							?>
		          		</div>

		          		<div class="form-group">
		          			<label><?php echo get_msg('smtp_pass_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('smtp_pass_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'password',
									'name' => 'smtp_pass',
									'id' => 'smtp_pass',
									'class' => 'form-control',
									'placeholder' => get_msg('smtp_pass_label'),
									'value' => set_value( 'smtp_pass' )
								));
							?>
		          		</div>
		          	</div>

		          	<legend class="ml-3"><?php echo get_msg('img_section')?></legend>
		            <div class="col-md-6">
		            	 <?php if ( !isset( $backend )): ?>

							<div class="form-group">
							
								<label>
									<?php echo get_msg('backend_logo')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<br/>

								<input class="btn btn-sm" type="file" name="icon" id="icon">
							</div>

							<?php else: ?>

							<label>
								<?php echo get_msg('backend_logo')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label> 
							
							<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadlogo">
								<?php echo get_msg('btn_replace_photo')?>
							</div>
							
							<hr/>
						
							<?php
								$conds = array( 'img_type' => 'backend-logo', 'img_parent_id' => $backend->id );
								$images = $this->Image->get_all_by( $conds )->result();
							?>
								
							<?php if ( count($images) > 0 ): ?>
								
								<div class="row">

								<?php $i = 0; foreach ( $images as $img ) :?>

									<?php if ($i>0 && $i%3==0): ?>
											
									</div><div class='row'>
									
									<?php endif; ?>
										
									<div class="col-md-4" style="height:100">

										<div class="thumbnail">

											<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">

											<br/>
											
											<p class="text-center">
												
												<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
													image="<?php echo $img->img_path; ?>">
													Remove
												</a>
											</p>

										</div>

									</div>

								<?php $i++; endforeach; ?>

								</div>
							
							<?php endif; ?>

						<?php endif; ?>	
						<!-- End nav icon -->
		            </div>

		            <div class="col-md-6">
		            	 <?php if ( !isset( $backend )): ?>

							<div class="form-group">
							
								<label>
									<?php echo get_msg('backend_fav_icon')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<br/>

								<input class="btn btn-sm" type="file" name="fav" id="fav">
							</div>

							<?php else: ?>

							<label>
								<?php echo get_msg('backend_fav_icon')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label> 
							
							<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadFav">
								<?php echo get_msg('btn_replace_photo')?>
							</div>
							
							<hr/>
						
							<?php
								$conds = array( 'img_type' => 'fav-icon', 'img_parent_id' => $backend->id );
								$images = $this->Image->get_all_by( $conds )->result();
							?>
								
							<?php if ( count($images) > 0 ): ?>
								
								<div class="row">

								<?php $i = 0; foreach ( $images as $img ) :?>

									<?php if ($i>0 && $i%3==0): ?>
											
									</div><div class='row'>
									
									<?php endif; ?>
										
									<div class="col-md-4" style="height:100">

										<div class="thumbnail">

											<img src="<?php echo $this->ps_image->upload_url . $img->img_path; ?>">

											<br/>
											
											<p class="text-center">
												
												<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
													image="<?php echo $img->img_path; ?>">
													Remove
												</a>
											</p>

										</div>

									</div>

								<?php $i++; endforeach; ?>

								</div>
							
							<?php endif; ?>

						<?php endif; ?>	
						<!-- End fav icon -->

						<?php if ( !isset( $backend )): ?>

							<div class="form-group">
								<label><?php echo get_msg('backend_login_img')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<br/>

								<input class="btn btn-sm" type="file" name="images1">
							</div>

							<?php else: ?>
							
							<label><?php echo get_msg('backend_login_img')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label> 
							
							<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
								<?php echo get_msg('btn_replace_photo')?>
							</div>
							
							<hr/>
							
			                <?php
								$conds = array( 'img_type' => 'login-image', 'img_parent_id' => $backend->id );
								$images = $this->Image->get_all_by( $conds )->result();
							?>
								
							<?php if ( count($images) > 0 ): ?>
								
								<div class="row">

								<?php $i = 0; foreach ( $images as $img ) :?>

									<?php if ($i>0 && $i%3==0): ?>
											
									</div><div class='row'>
									
									<?php endif; ?>
										
									<div class="col-md-4" style="height:100">

										<div class="thumbnail">

											<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">

											<br/>
											<p class="text-center">
												
												<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
													image="<?php echo $img->img_path; ?>">
													Remove
												</a>
											</p>

										</div>

									</div>

								<?php $i++; endforeach; ?>

								</div>
							
							<?php endif; ?>

						<?php endif; ?>	
						<!-- login image -->
		            </div>
		            <!-- End Icon -->

		   			 <legend class="ml-3"><?php echo get_msg('img_configuration')?></legend>
		        <hr width="100%">
		        <div class="col-md-6">
	        		<h5>Original Image Size</h5>
		        	<div class="form-group">
						<label><?php echo get_msg('land_width_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('land_height_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'landscape_width',
								'id' => 'landscape_width',
								'class' => 'form-control',
								'placeholder' => get_msg('land_width_label'),
								'value' => set_value( 'landscape_width', show_data( @$backend->landscape_width ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('potrait_height_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('potrait_width_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'potrait_height',
								'id' => 'potrait_height',
								'class' => 'form-control',
								'placeholder' => get_msg('potrait_height_label'),
								'value' => set_value( 'potrait_height', show_data( @$backend->potrait_height ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('square_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('square_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'square_height',
								'id' => 'square_height',
								'class' => 'form-control',
								'placeholder' => get_msg('square_label'),
								'value' => set_value( 'square_height', show_data( @$backend->square_height ), false )
							));
						?>
					</div>

		        </div>

		        <div class="col-md-6">
		        	<h5>Thumbnail Image Size</h5>
		        	<div class="form-group">
						<label><?php echo get_msg('land_width_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('land_height_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'landscape_thumb_width',
								'id' => 'landscape_thumb_width',
								'class' => 'form-control',
								'placeholder' => get_msg('land_width_label'),
								'value' => set_value( 'landscape_thumb_width', show_data( @$backend->landscape_thumb_width ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('potrait_height_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('potrait_width_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'potrait_thumb_height',
								'id' => 'potrait_thumb_height',
								'class' => 'form-control',
								'placeholder' => get_msg('potrait_height_label'),
								'value' => set_value( 'potrait_thumb_height', show_data( @$backend->potrait_thumb_height ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('square_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('square_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'square_thumb_height',
								'id' => 'square_thumb_height',
								'class' => 'form-control',
								'placeholder' => get_msg('square_label'),
								'value' => set_value( 'square_thumb_height', show_data( @$backend->square_thumb_height ), false )
							));
						?>
					</div>
                    <br><br><br><br>
		        </div>

		          <legend class="ml-3"><?php echo get_msg('deeplink_section')?></legend>
		        <hr width="100%">
	            <div class="col-md-6">
	            	<div class="form-group">
						<label><?php echo get_msg('dyn_link_key_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_key_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'dyn_link_key',
								'id' => 'dyn_link_key',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_key_label'),
								'value' => set_value( 'dyn_link_key', show_data( @$backend->dyn_link_key ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('dyn_link_url_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_url_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'dyn_link_url',
								'id' => 'dyn_link_url',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_url_label'),
								'value' => set_value( 'dyn_link_url', show_data( @$backend->dyn_link_url ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('dyn_link_package_name_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_package_name_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'dyn_link_package_name',
								'id' => 'dyn_link_package_name',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_package_name_label'),
								'value' => set_value( 'dyn_link_package_name', show_data( @$backend->dyn_link_package_name ), false )
							));
						?>
					</div>
	            </div>

	            <div class="col-md-6">
	            	<div class="form-group">
						<label><?php echo get_msg('dyn_link_domain_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_domain_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'dyn_link_domain',
								'id' => 'dyn_link_domain',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_domain_label'),
								'value' => set_value( 'dyn_link_domain', show_data( @$backend->dyn_link_domain ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('dyn_link_deep_url_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_deep_url_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'dyn_link_deep_url',
								'id' => 'dyn_link_deep_url',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_deep_url_label'),
								'value' => set_value( 'dyn_link_deep_url', show_data( @$backend->dyn_link_deep_url ), false )
							));
						?>
					</div>

					 <div class="form-group">
						<label><?php echo get_msg('dyn_link_package_name_ios')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_package_name_ios')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'ios_boundle_id',
								'id' => 'ios_boundle_id',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_package_name_ios'),
								'value' => set_value( 'ios_boundle_id', show_data( @$backend->ios_boundle_id ), false )
							));
						?>
					</div>

					<div class="form-group">
						<label><?php echo get_msg('dyn_link_ios_appstore_id')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('dyn_link_ios_appstore_id')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<?php 
							echo form_input( array(
								'type' => 'text',
								'name' => 'ios_appstore_id',
								'id' => 'ios_appstore_id',
								'class' => 'form-control',
								'placeholder' => get_msg('dyn_link_ios_appstore_id'),
								'value' => set_value( 'ios_appstore_id', show_data( @$backend->ios_appstore_id ), false )
							));
						?>
					</div>
				</div>
		    </div>
	        <!-- /.card-body -->
	        <div class="card-footer">
				<button type="submit" name="save" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
			</div>
			<!-- /.card footer-->
	    
        </div>
    </div>
</div>

<?php echo form_close(); ?>