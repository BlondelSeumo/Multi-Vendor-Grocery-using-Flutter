<?php
	$attributes = array( 'id' => 'language-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
<div class="container-fluid">
	<div class="col-sm-6" style="padding: 30px 20px 20px 20px;">
		<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('lang_info')?></h3>
			</div>

			<div class="card-body">
	            <div class="row">
	             	<div class="col-md-12">
	            		<div class="form-group">
	                   		<label>
								<?php echo get_msg('lang_symbol')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('lang_symbol')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php 
							if( isset( $lang ) ) {
								echo form_input( array(
									'name' => 'symbol',
									'value' => set_value( 'symbol', show_data( @$lang->symbol ), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg( 'lang_symbol' ),
									'id' => 'symbol',
									'readonly' => 'true'
								)); 
							} else {
								echo form_input( array(
									'name' => 'symbol',
									'value' => set_value( 'symbol', show_data( @$lang->symbol ), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg( 'lang_symbol' ),
									'id' => 'symbol'
								));
							}
							?>
	              		</div>
	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('lang_name')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('lang_name')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'name',
								'value' => set_value( 'name', show_data( @$lang->name ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'lang_name' ),
								'id' => 'name'
							)); ?>
	              		</div>
	              	</div>        		
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

<?php echo form_close(); ?>