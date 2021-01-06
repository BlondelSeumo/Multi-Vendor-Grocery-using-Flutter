<?php
	$attributes = array( 'id' => 'string-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
<div class="container-fluid">
	<div class="col-sm-6" style="padding: 30px 20px 20px 20px;">
		<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('lang_string_info')?></h3>
			</div>

			<div class="card-body">
	            <div class="row">
	             	<div class="col-md-12">
	             		<div class="form-group">
							<label>
								<?php echo get_msg('select_language')?>:
								<input type="hidden" id="language_id" name="language_id" value="<?php echo $this->Language->get_one($language_id)->id; ?>">
								<?php 
									$name = $this->Language->get_one($language_id)->name;
									echo $name;
								?>
							</label>
						</div>

	            		<div class="form-group">
	                   		<label>
								<?php echo get_msg('lang_string_key')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('lang_string_key')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php 
							if( isset( $langstr ) ) {
								echo form_input( array(
									'name' => 'key',
									'value' => set_value( 'key', show_data( @$langstr->key ), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg( 'lang_string_key' ),
									'id' => 'key',
									'readonly' => 'true'
								)); 
							} else {
								echo form_input( array(
									'name' => 'key',
									'value' => set_value( 'key', show_data( @$langstr->key ), false ),
									'class' => 'form-control form-control-sm',
									'placeholder' => get_msg( 'lang_string_key' ),
									'id' => 'key'
								));
							}
							?>
	              		</div>
	              		<div class="form-group">
	                   		<label>
								<?php echo get_msg('lang_string_value')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('lang_string_value')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_input( array(
								'name' => 'value',
								'value' => set_value( 'value', show_data( @$langstr->value ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'lang_string_value' ),
								'id' => 'value'
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