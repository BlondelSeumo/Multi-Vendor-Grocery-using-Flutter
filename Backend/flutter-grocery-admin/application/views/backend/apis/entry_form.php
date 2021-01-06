<?php
	$attributes = array( 'id' => 'api-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

<div class="container-fluid" style="padding: 30px 20px 20px 20px;">
	<div class="col-12">
		<div class="card earning-widget">
	        <div class="card-header" style="border-top: 2px solid red;">
				<h5><?php echo get_msg('api_info')?></h5>
			</div>
			<!-- /.card-header -->
	        <div class="card-body">
	        	<div class="table-responsive">
	        		<table class="table m-0 table-striped">

					<?php $count = $this->uri->segment(4) or $count = 0; ?>

					<?php if ( !empty( $apis ) && count( $apis->result()) > 0 ): ?>

						<?php foreach ( $apis->result() as $api ): ?>
							<?php if ( $api->type == "list") { ?>
								<tr>
									<td><?php echo ++$count;?></td>
									<td><?php echo $api->api_name;?></td>
									<td><?php echo get_msg( 'api_order_by' ); ?></td>
									
									<td>
									<?php 
										$options = $api_constants[$api->api_constant];

										echo form_dropdown(
											'order_by_field[]',
											$options,
											set_value( 'order_by_field[]', @$api->order_by_field ),
											'class="form-control form-control-sm mr-3" id="order_by_field"'
										);
									?>
									</td>

									<td>
									<?php 
										$options = array( 'asc' => 'Ascending', 'desc' => 'Descending');

										echo form_dropdown(
											'order_by_type[]',
											$options,
											set_value( 'order_by_type[]', @$api->order_by_type ),
											'class="form-control form-control" id="order_by_type"'
										);
									?>
									</td>

								</tr>

							<?php } else { ?>

								<tr>
									<td><?php echo ++$count;?></td>
									<td colspan="2"><?php echo $api->api_name;?></td>
									<td colspan="2">
										<?php 
											$options = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10');

											echo form_dropdown(
												'count[]',
												$options,
												set_value( 'count[]', @$api->count ),
												'class="form-control form-control-sm" id="count"'
											);
										?>
									</td>
								</tr>

							<?php } ?>

							<input type="hidden" name="api_id[]" value="<?php echo $api->api_id; ?>"/>

						<?php endforeach; ?>

					<?php else: ?>
							
						<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

					<?php endif; ?>

					</table>
	        	</div>	
			</div>
			<div class="card-footer">
				<button type="submit" name="save" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>
			</div>
		</div>
	</div>
</div>
	

<?php echo form_close(); ?>
