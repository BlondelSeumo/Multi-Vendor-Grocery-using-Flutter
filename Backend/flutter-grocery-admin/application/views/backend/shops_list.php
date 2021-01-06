<div class="row mt-3" style="padding: 10px 0px;">
	<div class="col-md-4 offset-md-4">
		<?php
			$attributes = array('class' => 'form-inline');
			echo form_open( $module_site_url .'/search', $attributes);
		?>
		  	<div class="form-group" style="padding-right: 3px;">
			    <label class="sr-only" for="shopname"><?php echo $this->lang->line('lbl_shop_name'); ?></label>

				<?php echo form_input(array(
					'name' => 'searchterm',
					'value' => set_value( 'searchterm' ),
					'class' => 'form-control',
					'placeholder' => 'Enter Shop Name',
					'id' => 'shopname',
				)); ?>
			</div>
			<div class="form-group" style="padding-right: 2px;">
			  	<button type="submit" class="btn btn-primary"> &#10148;
			  		<?php echo get_msg( 'lbl_search_shop' )?>
			  	</button>
		  	</div>
		  	<div class="form-group">
			  	<a href='<?php echo $module_site_url .'/index';?>' class='btn btn-primary'>
					<?php echo get_msg( 'btn_reset' )?>
				</a>
		  	</div>
		  
	</div>
</div>

<?php 
 $this->load->view( $template_path .'/components/summary_shop_panel', $data ); 
?>

