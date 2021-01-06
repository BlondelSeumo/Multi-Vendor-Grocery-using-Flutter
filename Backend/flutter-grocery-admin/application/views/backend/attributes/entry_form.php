<?php
	$attributes = array( 'id' => 'attribute_form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

	<div class="content animated fadeInRight">
		<div class="col-6">
				
			<div class="card card-info">
	          <div class="card-header">
	            <h3 class="card-title"><?php echo get_msg('att_info')?></h3>
	          </div>

	        <form role="form">
	            <div class="card-body">
					<div class="form-group">
						<label>
							<?php echo get_msg('product_name')?>:
							<input type="hidden" id="product_id" name="product_id" value="<?php echo $this->Product->get_one($product_id)->id; ?>">
							<?php 
								$name = $this->Product->get_one($product_id)->name;
								echo $name;
							?>
						</label>
					</div>
				
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('att_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('att_name_tooltips_zg')?>">
								<i class="fa fa-info-circle"></i>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'name',
							'value' => set_value( 'name', show_data( @$attribute->name), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('att_name'),
							'id' => 'name'
						)); ?>
					</div>
					
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_save')?>
					</button>
					

					<a href="<?php echo site_url() . '/admin/attributes/index/'.$product_id ?>" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_cancel')?>
					</a>
				</div>

			</div>
		</div>		
	</div>
	
<?php echo form_close(); ?>