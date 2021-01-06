<?php
	
	$attributes = array( 'id' => 'version-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
<section class="content animated fadeInRight" style="padding: 30px 20px 20px 20px;">
	<div class="card">
	    <?php flash_msg(); ?>
	    <div class="card-header" style="border-top: 2px solid red;">
	        <h3 class="card-title"><?php echo get_msg('ver_info')?></h3>
	    </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
             	<div class="col-md-6">
             		<legend><?php echo get_msg('restaurant_version')?></legend>
                		<div class="form-group">
	                   		<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('ver_no_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'version_no',
								'value' => set_value( 'version_no', show_data( @$version->version_no ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'ver_no_label' ),
								'id' => 'version_no'
							)); ?>
                  		</div>

	                  	<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('ver_msg_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_description_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<textarea class="form-control" name="version_message" placeholder="<?php echo get_msg('ver_msg_label')?>" rows="5"><?php echo $version->version_message; ?></textarea>
						</div>

	                </div>

                  	<div class="col-md-6"  style="padding-right: 50px; padding-top: 40px;">
		              	<div class="form-group">
	                   		<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('ver_title_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('ver_title_label')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'version_title',
								'value' => set_value( 'version_title', show_data( @$version->version_title ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'ver_title_label' ),
								'id' => 'version_title'
							)); ?>
                  		</div>

                  		<div class="form-group">
							<div class="form-check">
								<label class="form-check-label">
								
								<?php 

									if( $version->version_force_update == 1 ) {
										echo form_checkbox( array(
											'name' => 'version_force_update',
											'id' => 'version_force_update',
											'value' => 'accept',
											'checked' => true,
											'class' => 'form-check-input'
										));	
									
									}  else {

										echo form_checkbox( array(
											'name' => 'version_force_update',
											'id' => 'version_force_update',
											'value' => 'accept',
											'checked' => false,
											'class' => 'form-check-input'
										));	
									}

									echo get_msg( 'ver_force_update' ); 

								?>

								</label>
							</div>
						</div>

						<div class="form-group">
							<div class="form-check">
								<label class="form-check-label">
								
								<?php 
								
								if( $version->version_need_clear_data == 1 ) {

									echo form_checkbox( array(
										'name' => 'version_need_clear_data',
										'id' => 'version_need_clear_data',
										'value' => 'accept',
										'checked' => true,
										'class' => 'form-check-input'
									));	

								} else {

									echo form_checkbox( array(
										'name' => 'version_need_clear_data',
										'id' => 'version_need_clear_data',
										'value' => 'accept',
										'checked' => false,
										'class' => 'form-check-input'
									));	

								}

								echo get_msg( 'ver_need_data' ); 

								?>

								</label>
							</div>
						</div>
			
                  	</div>
                  	<!--  col-md-6  -->

            </div>
            <hr>
            <!-- /.row -->
             <div class="row">
             	<div class="col-md-6">
             		<legend><?php echo get_msg('deliboy_version')?></legend>
                		<div class="form-group">
	                   		<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('ver_no_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'deli_boy_version_no',
								'value' => set_value( 'deli_boy_version_no', show_data( @$version->deli_boy_version_no ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'ver_no_label' ),
								'id' => 'deli_boy_version_no'
							)); ?>
                  		</div>

	                  	<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('ver_msg_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('about_description_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<textarea class="form-control" name="deli_boy_version_message" placeholder="<?php echo get_msg('ver_msg_label')?>" rows="5"><?php echo $version->deli_boy_version_message; ?></textarea>
						</div>

	            </div>

              	<div class="col-md-6"  style="padding-left: 50px; padding-top: 40px;">
	              	<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('ver_title_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('ver_title_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'deli_boy_version_title',
							'value' => set_value( 'deli_boy_version_title', show_data( @$version->deli_boy_version_title ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'ver_title_label' ),
							'id' => 'deli_boy_version_title'
						)); ?>
              		</div>

              		<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
							
							<?php 

								if( $version->deli_boy_version_force_update == 1 ) {
									echo form_checkbox( array(
										'name' => 'deli_boy_version_force_update',
										'id' => 'deli_boy_version_force_update',
										'value' => 'accept',
										'checked' => true,
										'class' => 'form-check-input'
									));	
								
								}  else {

									echo form_checkbox( array(
										'name' => 'deli_boy_version_force_update',
										'id' => 'deli_boy_version_force_update',
										'value' => 'accept',
										'checked' => false,
										'class' => 'form-check-input'
									));	
								}

								echo get_msg( 'ver_force_update' ); 

							?>

							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
							
							<?php 
							
							if( $version->deli_boy_version_need_clear_data == 1 ) {

								echo form_checkbox( array(
									'name' => 'deli_boy_version_need_clear_data',
									'id' => 'deli_boy_version_need_clear_data',
									'value' => 'accept',
									'checked' => true,
									'class' => 'form-check-input'
								));	

							} else {

								echo form_checkbox( array(
									'name' => 'deli_boy_version_need_clear_data',
									'id' => 'deli_boy_version_need_clear_data',
									'value' => 'accept',
									'checked' => false,
									'class' => 'form-check-input'
								));	

							}

							echo get_msg( 'ver_need_data' ); 

							?>

							</label>
						</div>
					</div>
		
              	</div>
              	<!--  col-md-6  -->

            </div>
        </div>
        <!-- /.card-body -->

		<div class="card-footer">
            <button type="submit" class="btn btn-sm btn-primary">
				<?php echo get_msg('btn_save')?>
			</button>

			<a href="<?php echo site_url('/admin/versions/add'); ?>" class="btn btn-sm btn-primary">
				<?php echo get_msg('btn_cancel')?>
			</a>
        </div>
       
    </div>
    <!-- card info -->
</section>
				

	
	

<?php echo form_close(); ?>