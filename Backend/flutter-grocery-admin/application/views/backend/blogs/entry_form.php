<?php
	$attributes = array( 'id' => 'feed-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>


<div class="content animated fadeInRight">
	
	<div class="col-md-9">		
		<div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><?php echo get_msg('feed_info')?></h3>
          </div>

        <form role="form">
            <div class="card-body">
            	<div class="col-md-8">
            		<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('feed_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('feed_name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'name',
							'value' => set_value( 'name', show_data( @$feed->name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'feed_name' ),
							'id' => 'name'
						)); ?>

					</div>
            	</div>
				
            	<div class="col-md-8">
            		<div class="form-group">
				
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('feed_desc')?>
						</label>
						
						<?php echo form_textarea( array(
									'name' => 'description',
									'value' => set_value( 'description', show_data( @$feed->description), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg('feed_desc'),
									'id' => 'description',
								)); ?>
					</div>
            	</div>
				
				
					<div class="form-group" style="margin-left: 10px;">
						<div class="form-check">
							<label>
							
							<?php echo form_checkbox( array(
								'name' => 'status',
								'id' => 'status',
								'value' => 'accept',
								'checked' => set_checkbox('status', 1, ( @$feed->status == 1 )? true: false ),
								'class' => 'form-check-input'
							));	?>

							<?php echo get_msg( 'status' ); ?>

							</label>
						</div>
					</div>

		
			</div>

			<div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_save')?>
				</button>

				<button type="submit" name="gallery" id="gallery" class="btn btn-sm btn-primary">
				<?php echo get_msg('btn_save_gallery')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
            </div>

		</div>
	</div>
</div>
	
<?php echo form_close(); ?>

