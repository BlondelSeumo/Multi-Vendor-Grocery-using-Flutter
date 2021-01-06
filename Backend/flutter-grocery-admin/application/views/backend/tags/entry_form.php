<?php
	$attributes = array( 'id' => 'tag-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	
<section class="content animated fadeInRight" style="padding: 30px 20px 20px 20px;">
	<div class="card">
	    <div class="card-header" style="border-top: 2px solid red;">
	        <h3 class="card-title"><?php echo get_msg('tag_info')?></h3>
	    </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
             	<div class="col-md-6">
            		<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('tag_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'name',
							'value' => set_value( 'name', show_data( @$tag->name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'tag_name' ),
							'id' => 'name'
						)); ?>
                  	</div>

              		<div class="form-group">
						<div class="form-check">

							<label class="form-check-label">
							
								<?php echo form_checkbox( array(
									'name' => 'status',
									'id' => 'status',
									'value' => 'accept',
									'checked' => set_checkbox('status', 1, ( @$tag->status == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>
								<label><?php echo get_msg( 'status' ); ?></label>
							</label>
						</div>
					</div>

                </div>

              	<div class="col-md-6"  style="padding-left: 50px;">
	                <?php if ( !isset( $tag )): ?>

					<div class="form-group">
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('tag_img')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('tag_photo_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<br/>

						<input class="btn btn-sm" type="file" name="cover" id="cover">
					</div>

					<?php else: ?>

					<label> <span style="font-size: 17px; color: red;">*</span>
						<?php echo get_msg('tag_img')?>
						<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('tag_photo_tooltips')?>">
							<span class='glyphicon glyphicon-info-sign menu-icon'>
						</a>
					</label> 
					
					<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
						<?php echo get_msg('btn_replace_photo')?>
					</div>
					
					<hr/>
				
					<?php
						$conds = array( 'img_type' => 'tag', 'img_parent_id' => $tag->id );
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
				<!-- End tag cover photo -->
				<?php if ( !isset( $tag )): ?>

					<div class="form-group">
						
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('tag_icon')?> 
						</label>

						<br/>

						<input class="btn btn-sm" type="file" name="icon" id="icon">
					</div>

				<?php else: ?>

					<label> <span style="font-size: 17px; color: red;">*</span>
						<?php echo get_msg('tag_icon')?>
					</label> 
					
					
					<div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadIcon">
						<?php echo get_msg('btn_replace_icon')?>
					</div>
					
					<hr/>
					
					<?php

						$conds = array( 'img_type' => 'tag-icon', 'img_parent_id' => $tag->id );
						
						//print_r($conds); die;
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

						<?php endforeach; ?>

						</div>
					
					<?php endif; ?>

				<?php endif; ?>	
		
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