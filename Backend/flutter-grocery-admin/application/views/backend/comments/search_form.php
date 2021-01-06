 <div class="row my-3" style="margin-left: 5px;">
 <?php
	$attributes = array('class' => 'form-inline');
	echo form_open( $module_site_url .'/search', $attributes);
?>


	<div class="form-group">
		<?php echo form_input(array(
			'name' => 'searchterm',
			'value' => set_value( 'searchterm',$searchterm ),
			'class' => 'form-control form-control-sm',
			'placeholder' => get_msg( 'btn_search' ),
			'style' => 'float: left; margin-right: 20px;'
		)); ?>
	</div>

	<!-- Date range -->
	<div class="form-group" style="padding-right: 3px;">
		<div class="input-group">
		    <div class="input-group-prepend">
		      <span class="input-group-text">
		        <i class="fa fa-calendar"></i>
		      </span>
		    </div>
			   <?php echo form_input(array(
					'name' => 'date',
					'value' => set_value( 'date',$date ),
					'class' => 'form-control',
					'placeholder' => '',
					'id' => 'reservation',
					'size' => '40',
					'readonly' => 'readonly'
				)); ?>

		</div>
	<!-- /.input group -->
	</div>

    <!-- /.form group -->


	<div class="form-group" style="padding-right: 2px;">
	  	<button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">
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