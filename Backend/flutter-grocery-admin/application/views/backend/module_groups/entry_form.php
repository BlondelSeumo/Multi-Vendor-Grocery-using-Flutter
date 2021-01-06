<?php
	$attributes = array( 'id' => 'group-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

<div class="container-fluid">
    <div class="col-12"  style="padding: 30px 20px 20px 20px;">
    	<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('group_info')?></h3>
			</div>

            <div class="card-body">
            	<div class="row">
            		<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('group_name')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('coupon_name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'group_name',
							'value' => set_value( 'group_name', show_data( @$group->group_name ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'group_name' ),
							'id' => 'group_name'
						)); ?>

					</div>

				</div>

				<div class="col-md-6">
					<div class="form-group"> 
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('group_icon')?>
						</label>
						
						<?php echo form_input( array(
							'name' => 'group_icon',
							'value' => set_value( 'group_icon', show_data( @$group->group_icon ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'group_icon' ),
							'id' => 'group_icon'
						)); ?>

					</div>

					<div class="form-group">
					
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('group_lang_key')?>
						</label>
						
						<?php echo form_input( array(
							'name' => 'group_lang_key',
							'value' => set_value( 'group_lang_key', show_data( @$group->group_lang_key ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'group_lang_key' ),
							'id' => 'group_lang_key'
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