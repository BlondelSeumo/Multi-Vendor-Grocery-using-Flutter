<?php
	$attributes = array( 'id' => 'paypal-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

<div class="container-fluid">
    <div class="col-sm-10"  style="padding: 30px 20px 20px 20px;">
    	<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('paypal_info')?></h3>
			</div>	

	        <!-- /.card-header -->
	        <div class="card-body">
	            <div class="row">
	             	<div class="col-md-12">
	            		<div class="form-group">
	                   		<label>
								<?php echo get_msg('price')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('price')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'price',
								'value' => set_value( 'price', show_data( @$paypal->price ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'price' ),
								'id' => 'price'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('currency_code')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('currency_code')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'currency_code',
								'value' => set_value( 'currency_code', show_data( @$paypal->currency_code ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'currency_code' ),
								'id' => 'currency_code'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('api_username')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('api_username')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'api_username',
								'value' => set_value( 'api_username', show_data( @$paypal->api_username ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'api_username' ),
								'id' => 'api_username'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('api_password')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('api_password')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'api_password',
								'value' => set_value( 'api_password', show_data( @$paypal->api_password ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'api_password' ),
								'id' => 'api_password'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('api_signature')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('api_signature')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'api_signature',
								'value' => set_value( 'api_signature', show_data( @$paypal->api_signature ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'api_signature' ),
								'id' => 'api_signature'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('application_id')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('application_id')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'application_id',
								'value' => set_value( 'application_id', show_data( @$paypal->application_id ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'application_id' ),
								'id' => 'application_id'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('developer_email_account')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('developer_email_account')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'developer_email_account',
								'value' => set_value( 'developer_email_account', show_data( @$paypal->developer_email_account ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'developer_email_account' ),
								'id' => 'developer_email_account'
							)); ?>
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('sandbox')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('sandbox')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<select id="sandbox" name="sandbox" class="form-control">
							   <option value="">Select Sandbox</option>
							   <option value="1" <?php if($paypal->sandbox == "true") {echo "selected";} ?>>True</option>
							   <option value="0" <?php if($paypal->sandbox == "false") {echo "selected";} ?>>False</option>
							</select>

						
	              		</div>

	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('api_version')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('api_version')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'api_version',
								'value' => set_value( 'api_version', show_data( @$paypal->api_version ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'api_version' ),
								'id' => 'api_version'
							)); ?>
	              		</div>

	                </div>
	                <!-- col-md-6 -->
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
       
    </div>
</div>
<!-- card info -->
	
<?php echo form_close(); ?>