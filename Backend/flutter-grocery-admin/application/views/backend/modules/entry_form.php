<?php
	$attributes = array( 'id' => 'module-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

<div class="container-fluid">
    <div class="col-12"  style="padding: 30px 20px 20px 20px;">
    	<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('module_info')?></h3>
			</div>

       
            <div class="card-body">
            	<div class="row">
            		<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('module_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('module_name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'module_name',
							'value' => set_value( 'module_name', show_data( @$mod->module_name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'module_name' ),
							'id' => 'module_name'
						)); ?>

					</div>

					<div class="form-group">
						<label><?php echo get_msg('module_desc')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('module_desc_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<textarea class="form-control" name="module_desc" placeholder="<?php echo get_msg('module_desc')?>" rows="3"><?php echo $mod->module_desc; ?></textarea>
					</div>

					<div class="form-group" style="padding-top: 30px;">
						<div class="form-check">
							<label>
								<?php echo form_checkbox( array(
									'name' => 'is_show_on_menu',
									'id' => 'is_show_on_menu',
									'value' => 'accept',
									'checked' => set_checkbox('is_show_on_menu', 1, ( @$mod->is_show_on_menu == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>

								<?php echo get_msg( 'is_show_on_menu' ); ?>
							</label>
						</div>
					</div>

				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('group_name')?>
						</label>

						<?php
							$options=array();
							$options[0]=get_msg('module_select_group');
							$groups = $this->Module_group->get_all( );
								foreach($groups->result() as $group) {
									$options[$group->group_id]=$group->group_name;
							}

							echo form_dropdown(
								'group_id',
								$options,
								set_value( 'group_id', show_data( @$mod->group_id), false ),
								'class="form-control form-control-sm mr-3" id="group_id"'
							);
						?>

					</div>

					<div class="form-group">
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('module_lang_key')?>
						</label>
						
						<?php echo form_input( array(
							'name' => 'module_lang_key',
							'value' => set_value( 'module_lang_key', show_data( @$mod->module_lang_key ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'module_lang_key' ),
							'id' => 'module_lang_key'
						)); ?>

					</div>

					<div class="form-group">
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('module_ordering')?>
						</label>
						
						<?php echo form_input( array(
							'name' => 'ordering',
							'value' => set_value( 'ordering', show_data( @$mod->ordering ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'ordering' ),
							'id' => 'ordering'
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
</div>
	
<?php echo form_close(); ?>