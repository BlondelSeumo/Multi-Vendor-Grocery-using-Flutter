<div class='row my-3'>
	<div class='col-6'>
		<?php
			$attributes = array('class' => 'form-inline');
			echo form_open( $module_site_url .'/search/'.$product_id, $attributes);
		?>
			
		<div class="form-group" style="padding-right: 2px;">

			<?php echo form_input(array(
				'name' => 'searchterm',
				'value' => set_value( 'searchterm' ),
				'class' => 'form-control form-control-sm',
				'placeholder' => 'Search'
			)); ?>

	  	</div>

		<div class="form-group" style="padding-right: 3px;">
			<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id ?>">
		  	<button type="submit" class="btn btn-sm btn-primary">
		  		<?php echo get_msg( 'btn_search' )?>
		  	</button>
	  	</div>

	  	<div class="form-group">
		  	<a href="<?php echo $module_site_url .'/index' .'/' . $product_id; ?>" class="btn btn-sm btn-primary">
				<?php echo get_msg( 'btn_reset' ); ?>
			</a>
		</div>
		
		<?php echo form_close(); ?>

	</div>	

	<div class='col-6'>
		<a href='<?php echo $module_site_url .'/add' .'/' . $product_id;?>' class='btn btn-sm btn-primary pull-right'>
			<span class='fa fa-plus'></span> 
			<?php echo get_msg( 'att_add' )?>
		</a>
	</div>

</div>