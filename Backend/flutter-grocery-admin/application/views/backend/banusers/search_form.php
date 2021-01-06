<div class='row my-3' style="padding: 10px 30px 10px 30px;">
	<div class='col-9'>
		<?php
			$attributes = array('class' => 'form-inline');
				
			echo form_open( $module_site_url . '/search', $attributes );
		?>
			<div class="form-group mr-3">
				
				<?php echo form_input(array(
					'name' => 'searchterm',
					'value' => set_value( 'searchterm' , $searchterm ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'btn_search' ),
					'id' => ''
				)); ?>

		  	</div>

			
			<div class="form-group" style="padding-right: 2px;">
			  	<button type="submit" class="btn btn-sm btn-primary" name="submit" value="submit">
			  		<?php echo get_msg( 'btn_search' )?>
			  	</button>
		  	</div>
		
			<div class="form-group">
			  	<a href='<?php echo $module_site_url .'/index';?>' class='btn btn-sm btn-primary'>
					<?php echo get_msg( 'btn_reset' )?>
				</a>
		  	</div>
				
		<?php echo form_close(); ?>

	</div>


</div>