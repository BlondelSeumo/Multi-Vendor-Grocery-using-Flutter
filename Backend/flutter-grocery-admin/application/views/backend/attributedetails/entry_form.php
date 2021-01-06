<?php
	$attributes = array( 'id' => 'detail_form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

	<hr/>
	<br>

	<section class="content animated fadeInRight">
		<div class="card card-info">
		    <div class="card-header">
		        <h3 class="card-title"><?php echo get_msg('att_detail_info')?></h3>
		    </div>
	        <!-- /.card-header -->
	        <div class="card-body">
	            <div class="row">
	             	<div class="col-md-6">
						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('selected_product_name'); ?> : 
								<input type="hidden" id="product_id" name="product_id" value="<?php echo $this->Product->get_one($product_id)->id; ?>">
								<?php 
									$name = $this->Product->get_one($product_id)->name;
									echo $name;
								?>
							</label>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('selected_attribute_header'); ?> : 
								<input type="hidden" id="header_id" name="header_id" value="<?php echo $this->Attribute->get_one($header_id)->id; ?>">
								<?php 

									$name = $this->Attribute->get_one($header_id)->name;
									echo $name;

								?>
							</label>
						</div>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('att_detail_name')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('att_name_tooltips')?>">
									<i class="fa fa-info-circle"></i>
								</a>
							</label>
							<br>
							

							<?php echo form_input( array(
								'name' => 'name',
								'value' => set_value( 'name', show_data( @$attdetail->name), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg('pls_att_name'),
								'id' => 'name'
							)); ?>

						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('att_price')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('att_name_tooltip')?>">
									<i class="fa fa-info-circle"></i>
								</a>
							</label>
							<br>
							
							<i><label><?php echo get_msg('attribute_detail_extra_price'); ?></label></i>

							<?php echo form_input( array(
								'name' => 'additional_price',
								'value' => set_value( 'price', show_data( @$attdetail->additional_price), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg('att_price'),
								'id' => 'price'
							)); ?>

						</div>
					</div>
				</div>
			</div>	

			<div class="card-footer">
				<input type="hidden" id="product_id" name="header" value="$this->Product->get_one($product_id)->id">
				<button type="submit" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo site_url() . '/admin/attributedetails/index/'.$header_id . '/'.$product_id ?>" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_cancel')?>
				</a>
			</div>
		</div>
	</section>	

<?php echo form_close(); ?>