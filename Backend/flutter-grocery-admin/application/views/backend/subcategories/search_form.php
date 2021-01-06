<div class='row my-3' style="padding: 10px 30px 10px 30px;">
	<div class='col-8'>
	<?php
		$attributes = array('class' => 'form-inline');
		echo form_open( $module_site_url .'/search', $attributes);
	?>
		
		<div class="form-group mr-3">

			<?php echo form_input(array(
				'name' => 'searchterm',
				'value' => set_value( 'searchterm' ),
				'class' => 'form-control form-control-sm',
				'placeholder' => get_msg( 'btn_search' )
			)); ?>

	  	</div>

	  	<div class="form-group" style="padding-right: 3px;">

			<?php
				$options=array();
				$conds['shop_id'] = $selected_shop_id;
				$options[0]=get_msg('Prd_search_cat');
				$categories = $this->Category->get_all_by($conds);
				foreach($categories->result() as $cat) {
					
						$options[$cat->id]=$cat->name;
				}

				echo form_dropdown(
					'cat_id',
					$options,
					set_value( 'cat_id', show_data( @$subcategories->cat_id), false ),
					'class="form-control form-control-sm" id="cat_id"'
				);
			?>

	  	</div>

	  	<div class="form-group" style="padding-right: 2px;">
		  	<button type="submit" class="btn btn-sm btn-primary">
		  		<?php echo get_msg( 'btn_search' )?>
		  	</button>
	  	</div>

	  	<div class="form-group">
		  	<a href='<?php echo $module_site_url; ?>' class='btn btn-sm btn-primary'>
				<?php echo get_msg( 'btn_reset' )?>
			</a>
	  	</div>

	<?php echo form_close(); ?>

	</div>	

	<div class='col-4'>
		<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
			<span class='fa fa-plus'></span> 
			<?php echo get_msg( 'subcat_add' )?>
		</a>
	</div>
	<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $selected_shop_id; ?>">

</div>

