<?php
	$attributes = array( 'id' => 'branch-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	
<section class="content animated fadeInRight">
	<div class="card card-info">
	    <div class="card-header">
	        <h3 class="card-title"><?php echo get_msg('branch_info')?></h3>
	    </div>
        <!-- /.card-header -->
        <form role="form">
        <div class="card-body">
            <div class="row">
             	<div class="col-md-6">
            		<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('branch_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'name',
							'value' => set_value( 'name', show_data( @$branch->name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'branch_name' ),
							'id' => 'name'
						)); ?>
              		</div>

              		<div class="form-group">
						<label><span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('branch_description_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('branch_description_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<textarea class="form-control" name="description" placeholder="<?php echo get_msg('branch_description_label')?>" rows="5"><?php echo $branch->description; ?></textarea>
					</div>

              		<?php if ( !isset( $branch )): ?>

					<div class="form-group">
					
						<label>
							<?php echo get_msg('branch_img')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<br/>

						<input class="btn btn-sm" type="file" name="cover" id="cover">
					</div>

					<?php else: ?>

					<label> <span style="font-size: 17px; color: red;">*</span>
						<?php echo get_msg('branch_img')?>
						<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
							<span class='glyphicon glyphicon-info-sign menu-icon'>
						</a>
					</label> 
					
					<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
						<?php echo get_msg('btn_replace_photo')?>
					</div>
					
					<hr/>
				
					<?php
						$conds = array( 'img_type' => 'grocery-branch', 'img_parent_id' => $branch->id );
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
											<?php echo get_msg('remove_label'); ?>
										</a>
									</p>

								</div>

							</div>

						<?php $i++; endforeach; ?>

						</div>
					
					<?php endif; ?>

				<?php endif; ?>	
				<!-- End Category cover photo -->

              	</div>

              	<div class="col-md-6">
              		<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('branch_address_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'address',
							'value' => set_value( 'address', show_data( @$branch->address ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'branch_address_label' ),
							'id' => 'address'
						)); ?>
              		</div>

              		<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('branch_phone_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'phone',
							'value' => set_value( 'phone', show_data( @$branch->phone ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'branch_phone_label' ),
							'id' => 'phone'
						)); ?>
              		</div>

              		<div class="form-group" style="padding-top: 30px;">
						<div class="form-check">

							<label>
							
								<?php echo form_checkbox( array(
									'name' => 'status',
									'id' => 'status',
									'value' => 'accept',
									'checked' => set_checkbox('status', 1, ( @$branch->status == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>

								<?php echo get_msg( 'status' ); ?>
							</label>
						</div>
					</div>
		
              	</div>
              	<!--  col-md-6  -->

            </div>
            <!-- /.row -->
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
    <!-- card info -->
</section>
				

	
	

<?php echo form_close(); ?>