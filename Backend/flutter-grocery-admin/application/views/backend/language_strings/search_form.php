<div class='row my-3'>
	<?php 
	$language_id = $this->session->userdata('language_id');
	?>
	<div class='col-9'>
	<?php
		$attributes = array('class' => 'form-inline');
		echo form_open( $module_site_url .'/search', $attributes);
	?>
		
		<div class="form-group mr-3">

			<?php echo form_input(array(
				'name' => 'searchterm',
				'value' => set_value( 'searchterm', $searchterm ),
				'class' => 'form-control form-control-sm',
				'placeholder' => get_msg( 'btn_search' )
			)); ?>

	  	</div>

		<div class="form-group">
		  	<button type="submit" class="btn btn-sm btn-primary" name="submit" value="submit">
		  		<?php echo get_msg( 'btn_search' )?>
		  	</button>
	  	</div>

	  	<div class="row">
	  		<div class="form-group ml-3">
			  	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					  		<?php echo get_msg( 'btn_reset' ); ?>
				</a>
			</div>
		</div>
	
	<?php echo form_close(); ?>

	</div>	

	<div class='col-3'>
		<a href='<?php echo $module_site_url .'/add/'.$language_id;?>' class='btn btn-sm btn-primary pull-right'>
			<span class='fa fa-plus'></span> 
			<?php echo get_msg( 'lang_str_add' )?>
		</a>
	</div>

</div>

<div class="row my-3">
	<div class='col-9'>
	<?php
		$attributes = array('class' => 'form-inline','enctype' => 'multipart/form-data');
		echo form_open( $module_site_url .'/fileupload/' .$language_id, $attributes);
	?>
		
		<div class="form-group mr-2">

			<?php echo form_input(array(
				'name' => 'csv_file',
				'class' => 'form-control form-control-sm',
				'type' => 'file'
			)); ?>

	  	</div>

		<div class="form-group">
		  	<button type="submit" class="btn btn-primary">
		  		<?php echo get_msg( 'btn_import' )?>
		  	</button>
	  	</div>
	
	<?php echo form_close(); ?>

	</div>	
</div>
<div class="row">
	<div class="form-group">
		<label style="padding-left: 10px;">
			<a href="https://www.dropbox.com/s/p535xtm6xpugepz/multi-store(english).csv?dl=0" target="_blank">
				<?php echo get_msg('csv_symbol_link')?>
			</a>
		</label>
	</div>
</div>