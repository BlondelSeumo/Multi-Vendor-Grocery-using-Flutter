<?php
	$attributes = array( 'id' => 'area-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>


<div class="content animated fadeInRight">
		<div class="card card-info">
          	<div class="card-header">
            	<h3 class="card-title"><?php echo get_msg('shp_area_info')?></h3>
        	</div>

        <form role="form">
            <div class="card-body">
            	<div class="row">
            		<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('shp_area_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shp_area_name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'area_name',
							'value' => set_value( 'area_name', show_data( @$area->area_name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'shp_area_name' ),
							'id' => 'area_name'
						)); ?>

					</div>

					<div class="form-group" style="padding-top: 50px;">
						<div class="form-check">

							<label>
							
								<?php echo form_checkbox( array(
									'name' => 'status',
									'id' => 'status',
									'value' => 'accept',
									'checked' => set_checkbox('status', 1, ( @$area->status == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>
								
								<?php echo get_msg( 'status' ); ?>
							</label>
						</div>
					</div>

				</div>

				<div class="col-md-6">
					<div class="form-group"> 
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('shp_area_price')?>
						</label>
						
						<?php echo form_input( array(
							'name' => 'price',
							'value' => set_value( 'price', show_data( @$area->price ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'price' ),
							'id' => 'price'
						)); ?>

					</div>
				</div>

			</div>

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
	
<?php echo form_close(); ?>