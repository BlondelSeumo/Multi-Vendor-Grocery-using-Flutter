<?php
	$attributes = array( 'id' => 'coupon-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>


<div class="content animated fadeInRight">
		<div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><?php echo get_msg('coupon_info')?></h3>
          </div>

        <form role="form">
            <div class="card-body">
            	<div class="row">
            		<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('coupon_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('coupon_name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'coupon_name',
							'value' => set_value( 'coupon_name', show_data( @$coupon->coupon_name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'coupon_name' ),
							'id' => 'coupon_name'
						)); ?>

					</div>

					
					<div class="form-group" style="padding-top: 50px;">
						<div class="form-check">
							<label>
							
							<?php echo form_checkbox( array(
								'name' => 'is_published',
								'id' => 'is_published',
								'value' => 'accept',
								'checked' => set_checkbox('is_published', 1, ( @$coupon->is_published == 1 )? true: false ),
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
							<?php echo get_msg('coupon_code')?>
						</label>
						<br>
						( <i><?php echo get_msg('coupon_code_message'); ?></i> )
						<?php echo form_input( array(
							'name' => 'coupon_code',
							'value' => set_value( 'coupon_code', show_data( @$coupon->coupon_code ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'coupon_code' ),
							'id' => 'coupon_code'
						)); ?>

					</div>

					<div class="form-group">
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('coupon_amount')?>
						</label>
						<br>
						( <i><?php echo get_msg('coupon_amount_message'); ?></i> )
						<?php echo form_input( array(
							'name' => 'coupon_amount',
							'value' => set_value( 'coupon_amount', show_data( @$coupon->coupon_amount ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'coupon_amount' ),
							'id' => 'coupon_amount'
						)); ?>

					</div>
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

