<?php
	$attributes = array( 'id' => 'purchasedcategory-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

	<div class="row my-4 animated fadeInRight">
		<div class="col-6">
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><?php echo get_msg('cat_info')?></h3>
              </div>

            <form role="form">
                <div class="card-body">
					<div class="form-group">
						<label>
							<?php echo get_msg('cat_name')?>
						</label>

						<?php echo form_input( array(
							'name' => 'name',
							'value' => set_value( 'name', show_data( @$purchasedcategory->name), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => "Purchased Category Name",
							'id' => 'name',
							'readonly' => "true"
						)); ?>

					</div>

					<?php if ( !isset( $purchasedcategory )): ?>

					<div class="form-group">
						
						<label>
							<?php echo get_msg('cat_img')?> 
						</label>

						<br/>

					</div>

					<?php else: ?>
						<hr/>
						<label>
							<?php echo get_msg('cat_img')?>
						</label> 
						
						
						
						<?php
							$conds = array( 'img_type' => 'category', 'img_parent_id' => $purchasedcategory->id );
							
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
										
										
									</div>

								</div>

							<?php endforeach; ?>

							</div>
						
						<?php endif; ?>

					<?php endif; ?>	

					<?php if ( !isset( $purchasedcategory )): ?>

					<div class="form-group">
						
						<label>
							<?php echo get_msg('purchased_cat_icon')?> 
						</label>

						<br/>

						<input class="btn btn-sm" type="file" name="icon" id="icon">
					</div>

					
					<?php else: ?>
						<hr/>
						<label>
							<?php echo get_msg('purchased_cat_icon')?>
						</label>
						
						<?php
							$conds = array( 'img_type' => 'category-icon', 'img_parent_id' => $purchasedcategory->id );
							
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
										
										

									</div>

								</div>

							<?php endforeach; ?>

							</div>
						
						<?php endif; ?>

					<?php endif; ?>	

				</div>
			</div>
		</div>
	</div>

	
	
	

<?php echo form_close(); ?>

