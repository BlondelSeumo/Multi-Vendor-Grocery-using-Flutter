<div class='row my-3'>

	<div class='col-md-12'>
		<?php
			$attributes = array('class' => 'form-inline');
			echo form_open( $module_site_url .'/search', $attributes);
		?>
			<div class="form-group">

			<?php echo form_input(array(
				'name' => 'search_term',
				'value' => set_value( 'search_term', $search_term ),
				'class' => 'form-control form-control-sm',
				'placeholder' => get_msg( 'btn_search' ),
				'id' => '',
				'style' => 'float: left; margin-right: 10px;'
			)); ?>

	  		</div>
					  	
	  		<div class="form-group mr-3">
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
										'size' => '30',
										'readonly' => 'readonly'
									)); ?>

		 		</div>
	  		</div>

  			<div class="form-group mr-3">
				<?php
					$options=array();
					$options[0]=get_msg('Prd_search_cat');
					$conds['shop_id'] = $selected_shop_id;
					
					$categories = $this->Category->get_all_by($conds);
					foreach($categories->result() as $cat) {
						
							$options[$cat->id]=$cat->name;
					}
					
					echo form_dropdown(
						'cat_id',
						$options,
						set_value( 'cat_id', show_data( $cat_id ), false ),
						'class="form-control form-control-sm mr-3" id="cat_id"'
					);
				?> 
			</div>

  			<div class="form-group">

			<?php
				if($selected_cat_id != "") {

					$options=array();
					$options[0]=get_msg('Prd_search_subcat');
					$conds['cat_id'] = $selected_cat_id;
					$sub_cat = $this->Subcategory->get_all_by($conds);
					foreach($sub_cat->result() as $subcat) {
						$options[$subcat->id]=$subcat->name;
					}
					echo form_dropdown(
						'sub_cat_id',
						$options,
						set_value( 'sub_cat_id', show_data( $sub_cat_id ), false ),
						'class="form-control form-control-sm mr-3" id="sub_cat_id"'
					);

				} else {

					$conds['cat_id'] = $selected_cat_id;
					$options=array();
					$options[0]=get_msg('Prd_search_subcat');

					echo form_dropdown(
						'sub_cat_id',
						$options,
						set_value( 'sub_cat_id', show_data( $sub_cat_id ), false ),
						'class="form-control form-control-sm mr-3" id="sub_cat_id"'
					);
				}
			?>

	  	</div>
	</div>

	<div class="row mt-3 mb-3 ml-3">
		<div class="form-group">
			<button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">
			<?php echo get_msg( 'btn_search' )?>
			</button>
		</div>

  		<div class="form-group ml-3">
		  	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
				  		<?php echo get_msg( 'btn_reset' ); ?>
			</a>
		</div>
	</div>
	  	
	  	
	  	<?php echo form_close(); ?>	
	</div>	


<script>
	
<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
	function jqvalidate() {
	$('#cat_id').on('change', function() {
			

			var catId = $(this).val();
			
			$.ajax({
				url: '<?php echo $module_site_url . '/get_all_sub_categories/';?>' + catId,
				method: 'GET',
				dataType: 'JSON',
				success:function(data){
					$('#sub_cat_id').html("");
					$.each(data, function(i, obj){
					    $('#sub_cat_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
					});
					$('#name').val($('#name').val() + " ").blur();
				}
			});
		});
}
	<?php endif; ?>
</script>