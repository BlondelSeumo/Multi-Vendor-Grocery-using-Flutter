<?php
$attributes = array('id' => 'about-form','enctype' => 'multipart/form-data');
echo form_open( '', $attributes);
?>
 <div class="container-fluid">
    <div class="col-12"  style="padding: 30px 20px 20px 20px;">
    	 <?php flash_msg(); ?>
    	<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('about_info')?></h3>
			</div>
        <!-- /.card-header -->

        	<div class="card-body">
	            <div class="row">
	              	<div class="col-md-6">
		              	<legend><?php echo get_msg('app_info_lable')?></legend>
		               	<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_title_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_title_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'about_title',
									'id' => 'about_title',
									'class' => 'form-control',
									'placeholder' => 'Title',
									'value' => set_value( 'about_title', show_data( @$about->about_title ), false )
								));
							?>
						</div>
	                	<!-- /.form-group -->
			            <div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('description_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_description_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<textarea class="form-control" name="about_description" placeholder="Description" rows="9"><?php echo $about->about_description; ?></textarea>
						</div>
	                	<!-- /.form-group -->
			            <div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_email_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_email_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'about_email',
									'id' => 'about_email',
									'class' => 'form-control',
									'placeholder' => 'Email',
									'value' => set_value( 'about_email', show_data( @$about->about_email ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_phone_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_phone_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'about_phone',
									'id' => 'about_phone',
									'class' => 'form-control',
									'placeholder' => 'Phone',
									'value' => set_value( 'about_phone', show_data( @$about->about_phone ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_website_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_website_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'about_website',
									'id' => 'about_website',
									'class' => 'form-control',
									'placeholder' => 'Website',
									'value' => set_value( 'about_website', show_data( @$about->about_website ), false )
								));
							?>
						</div>
	        	  	</div>
	              <!-- /.col -->
	              	<div class="col-md-6">
	              		<!-- <legend><?php echo get_msg('about_ads_analyt')?></legend>

						<div class="form-group">
							<div class="form-check">
								<label class="form-check-label">
								
								<?php echo form_checkbox( array(
									'name' => 'ads_on',
									'id' => 'ads_on',
									'value' => 'accept',
									'checked' => set_checkbox('ads_on', 1, ( @$about->ads_on == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>

								<?php echo get_msg( 'about_ads_on' ); ?>

								</label>
							</div>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_ads_client')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_ads_client_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'ads_client',
									'id' => 'ads_client',
									'class' => 'form-control',
									'placeholder' => 'Ads Client',
									'value' => set_value( 'ads_client', show_data( @$about->ads_client ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_ads_slot')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_ads_slot_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'ads_slot',
									'id' => 'ads_slot',
									'class' => 'form-control',
									'placeholder' => 'Ads Slot',
									'value' => set_value( 'ads_slot', show_data( @$about->ads_slot ), false )
								));
							?>
						</div>

						<div class="form-group">
							<div class="form-check">
								<label class="form-check-label">
								
								<?php echo form_checkbox( array(
									'name' => 'analyt_on',
									'id' => 'analyt_on',
									'value' => 'accept',
									'checked' => set_checkbox('analyt_on', 1, ( @$about->analyt_on == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>

								<?php echo get_msg( 'about_analyt_on' ); ?>

								</label>
							</div>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_analyt_track_id')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_analyt_track_id_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'analyt_track_id',
									'id' => 'analyt_track_id',
									'class' => 'form-control',
									'placeholder' => 'Analytic Tracking Id',
									'value' => set_value( 'analyt_track_id', show_data( @$about->analyt_track_id ), false )
								));
							?>
						</div> -->
		                <!-- /.form-group -->
		                <?php if ( !isset( $about )): ?>

						<div class="form-group">
						
							<label>
								<?php echo get_msg('about_img')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<br/>

							<input class="btn btn-sm" type="file" name="cover" id="cover">
						</div>

						<?php else: ?>

						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('about_img')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label> 
						
						<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
							<?php echo get_msg('btn_replace_photo')?>
						</div>
						
						<hr/>
					
						<?php
							$conds = array( 'img_type' => 'about', 'img_parent_id' => $about->id );
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
					<!-- End About cover photo -->
		            </div>
		            <!-- /.col -->
		            <legend class="ml-3"><?php echo get_msg('about_social_section')?></legend>
		            <div class="col-md-6">
	              		<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_facebook_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_facebook_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'facebook',
									'id' => 'facebook',
									'class' => 'form-control',
									'placeholder' => 'Facebook',
									'value' => set_value( 'facebook', show_data( @$about->facebook ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_gplus_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_gplus_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'google_plus',
									'id' => 'google_plus',
									'class' => 'form-control',
									'placeholder' => 'Google+',
									'value' => set_value( 'google_plus', show_data( @$about->google_plus ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_instagram_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_instagram_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'instagram',
									'id' => 'instagram',
									'class' => 'form-control',
									'placeholder' => 'Instagram',
									'value' => set_value( 'instagram', show_data( @$about->instagram ), false )
								));
							?>
						</div>
	        	  	</div>
	         		<!-- /.col -->
	          		<div class="col-md-6">
						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_youtube_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_instagram_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'youtube',
									'id' => 'youtube',
									'class' => 'form-control',
									'placeholder' => 'Youtube',
									'value' => set_value( 'youtube', show_data( @$about->youtube ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_pinterest_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_pinterest_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'pinterest',
									'id' => 'pinterest',
									'class' => 'form-control',
									'placeholder' => 'Pinterest',
									'value' => set_value( 'pinterest', show_data( @$about->pinterest ), false )
								));
							?>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('about_twitter_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_twitter_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'twitter',
									'id' => 'twitter',
									'class' => 'form-control',
									'placeholder' => 'Twitter',
									'value' => set_value( 'twitter', show_data( @$about->twitter ), false )
								));
							?>
						</div>
	                <!-- /.form-group -->
	            	</div>
	            <!-- /.col -->
	            </div>
	            <!-- /.row -->
          	
			</div>

			<div class="card-footer">
    	
				<button type="submit" name="save" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
		    </div>
			<!-- card body -->
    	</div><!-- card -->
    </div>
</div><!-- /.container-fluid -->
<?php echo form_close(); ?>