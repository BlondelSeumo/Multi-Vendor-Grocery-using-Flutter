
<?php
	$attributes = array( 'id' => 'product-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);

	$currency_symbol = $this->Shop->get_one($selected_shop_id)->currency_symbol;
	
?>


<section class="content animated fadeInRight">
			
	<div class="card card-info">
      	<div class="card-header">
        	<h3 class="card-title"><?php echo get_msg('prd_info')?></h3>
      	</div>

    <form role="form">
        <div class="card-body">
        	<div class="row">
        		<div class="col-md-6">
	        		<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('product_name')?>
						</label>

						<?php echo form_input( array(
							'name' => 'name',
							'value' => set_value( 'name', show_data( @$product->name), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_prd_name'),
							'id' => 'name'
						)); ?>

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('Prd_search_cat')?>
						</label>

						<?php
							$options=array();
							$options[0]=get_msg('Prd_search_cat');
							$categories = $this->Category->get_all();
							foreach($categories->result() as $cat) {
									$options[$cat->id]=$cat->name;
							}

							echo form_dropdown(
								'cat_id',
								$options,
								set_value( 'cat_id', show_data( @$product->cat_id), false ),
								'class="form-control form-control-sm mr-3" id="cat_id"'
							);
						?>
					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('Prd_search_subcat')?>
						</label>

						<?php
							if(isset($product)) {
								$options=array();
								$options[0]=get_msg('Prd_search_subcat');
								$conds['cat_id'] = $product->cat_id;
								$sub_cat = $this->Subcategory->get_all_by($conds);
								foreach($sub_cat->result() as $subcat) {
									$options[$subcat->id]=$subcat->name;
								}
								echo form_dropdown(
									'sub_cat_id',
									$options,
									set_value( 'sub_cat_id', show_data( @$product->sub_cat_id), false ),
									'class="form-control form-control-sm mr-3" id="sub_cat_id"'
								);

							} else {
								$conds['cat_id'] = $selected_cat_id;
								$options=array();
								$options[0]=get_msg('Prd_search_subcat');

								echo form_dropdown(
									'sub_cat_id',
									$options,
									set_value( 'sub_cat_id', show_data( @$product->sub_cat_id), false ),
									'class="form-control form-control-sm mr-3" id="sub_cat_id"'
								);
							}
							
						?>

					</div>

					<div class="form-group">
	                  	<label>
	                  		<?php echo get_msg('prd_addon_label') ?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_tags')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<div class="dropdown-sin-2">
			                <select class="form-control" multiple="multiple" placeholder="Select" name="foodaddon" id="foodaddon">
		                       	<?php
									//$options=array();
									$addons = $this->Additional->get_all()->result();

									$i = 1;
									foreach ($addons as $add) {

										if($product->id != "") {
											$conds['product_id'] = $product->id;
										} else {
											$conds['product_id'] = '0';
										}
										
										$conds['add_on_id'] = $add->id;


											
										$food_addon_id = $this->Food_additional->get_one_by($conds)->add_on_id;
										
										$selected_value = "";
										if($food_addon_id == "" ) {
											$selected_value = "";
										} else {
											$selected_value = "selected";
										}
										echo $selected_value . $i;
										echo '<option  '.$selected_value.' name="'.$add->name.'" value="'.$add->id.'">'.$add->name.'</option>';

										$i++;
									}

									if($product->id != "") {
											$conds1['product_id'] = $product->id;
										} else {
											$conds1['product_id'] = '0';
										}
									$existing_addon_ids = "";	
									$food_addon_id = $this->Food_additional->get_all_by($conds1)->result();
									
									foreach ($food_addon_id as $food_addon) {

										$existing_addon_ids .= $food_addon->add_on_id .",";


									}

								?>
								<input type="hidden"  id="addonselect" name="addonselect">
								<input type="hidden"  id="existing_addonselect" name="existing_addonselect" value="<?php echo $existing_addon_ids; ?>">
			                </select>
			            </div>
	                </div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('prd_high_info')?>
						</label>

						<?php echo form_textarea( array(
							'name' => 'highlight_information',
							'value' => set_value( 'info', show_data( @$product->highlight_information), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_highlight_info'),
							'id' => 'info',
							'rows' => "3"
						)); ?>

					</div>


					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('prd_code')?>
						</label>

						<?php echo form_input( array(
							'name' => 'code',
							'value' => set_value( 'code', show_data( @$product->code), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_code'),
							'id' => 'code'
						)); ?>

					</div>

					<div class="form-group">
						<label>
							<?php echo get_msg('prd_ordering')?>
						</label>

						<?php echo form_input( array(
							'name' => 'ordering',
							'value' => set_value( 'ordering', show_data( @$product->ordering), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('prd_ordering'),
							'id' => 'ordering'
						)); ?>

					</div>

					<div class="form-group">
						<label>
							<?php echo get_msg('prd_ingredient')?>
						</label>

						<?php echo form_textarea( array(
							'name' => 'ingredient',
							'value' => set_value( 'ingredient', show_data( @$product->ingredient), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('prd_ingredient'),
							'id' => 'ingredient',
							'rows' => "5"
						)); ?>

					</div>

					<div class="form-group">
						<label>
							<?php echo get_msg('prd_nutrient')?>
						</label>

						<?php echo form_input( array(
							'name' => 'nutrient',
							'value' => set_value( 'nutrient', show_data( @$product->nutrient), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('prd_nutrient'),
							'id' => 'nutrient'
						)); ?>

					</div>
                    <br><br>

                     <div class="form-group">
		              <label> <span style="font-size: 17px; color: red;"></span>
		                <?php echo get_msg('prd_dynamic_link_label') ." : ".$product->dynamic_link; ?>
		              </label>
		            </div>
                    <br><br>
                    
            	</div>

            	<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('original_price') . '('. $currency_symbol . ')'; ?> 
							
						</label>

						<?php  

							$original_price = $product->original_price;

							$original_price = round($original_price, 2) ;

				 		?>

							<?php echo form_input( array(
								'name' => 'original_price',
								'value' => set_value( 'original_price', show_data( @$original_price ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg('pls_unit_price'),
								'id' => 'original_price'
							)); ?> 
							
							<span style="color: red;">
								
									<?php 

										if ($is_discount == 1) {
									 	
									 		echo '( Discount : ' . $discount->percent * 100 . '% Off ) ';

									 		?>

											
										<?php

										} 

									?> 

									<label id="discount_label">	

										<?php 
										
										echo ' ( ' . get_msg('unit_price') . '(' . $currency_symbol . ')'.  " : " . $product->unit_price . ' )'; ?>

									</label>

								
							</span>

							<input type="hidden" name="discount_percent" id="discount_percent" value="<?php echo $discount->percent; ?>">
							<input type="hidden" name="unit_price" id="unit_price" value="<?php echo $product->unit_price ?>">
						

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('minimum_order')?>
						</label>

						<?php echo form_input( array(
							'name' => 'minimum_order',
							'value' => set_value( 'minimum_order', show_data( @$product->minimum_order ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_minimum_order'),
							'id' => 'minimum_order'
						)); ?>

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('maximum_order')?>
						</label>

						<?php echo form_input( array(
							'name' => 'maximum_order',
							'value' => set_value( 'maximum_order', show_data( @$product->maximum_order ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_maximum_order'),
							'id' => 'maximum_order'
						)); ?>

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('prd_unit_value')?>
						</label>

						<?php echo form_input( array(
							'name' => 'product_unit_value',
							'value' => set_value( 'product_unit_value', show_data( @$product->product_unit_value ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_prd_unit_value'),
							'id' => 'product_unit_value'
						)); ?>

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('prd_unit')?>
						</label>

						<?php echo form_input( array(
							'name' => 'product_unit',
							'value' => set_value( 'product_unit', show_data( @$product->product_unit ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_prd_unit'),
							'id' => 'product_unit'
						)); ?>

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('search_tag')?>
						</label>

						<?php echo form_input( array(
							'name' => 'search_tag',
							'value' => set_value( 'search_tag', show_data( @$product->search_tag), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_search_tag'),
							'id' => 'search_tag'
						)); ?>

					</div>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('prd_desc')?>
						</label>

						<?php echo form_textarea( array(
							'name' => 'description',
							'value' => set_value( 'desc', show_data( @$product->description), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('pls_prd_desc'),
							'id' => 'desc',
							'rows' => "5"
						)); ?>

					</div>
					<br>
					
		            <?php if ( !isset( $product )): ?>

		              <div class="form-group">
		                <span style="font-size: 17px; color: red;">*</span>
		                <label><?php echo get_msg('prd_image')?>
		                  <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('prd_image')?>">
		                    <span class='glyphicon glyphicon-info-sign menu-icon'>
		                  </a>
		                </label>

		                <br/>

		                <input class="btn btn-sm" type="file" name="images1">
		              </div>

		              <?php else: ?>
		              <span style="font-size: 17px; color: red;">*</span>
		              <label><?php echo get_msg('prd_image')?>
		                <a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
		                  <span class='glyphicon glyphicon-info-sign menu-icon'>
		                </a>
		              </label> 
		              
		              <div class="btn btn-sm btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
		                <?php echo get_msg('btn_replace_photo')?>
		              </div>
		              
		              <hr/>
		            
		              <?php
		                $conds = array( 'img_type' => 'product', 'img_parent_id' => $product->id );
		                $images = $this->Image->get_all_by( $conds )->result();
		                if (empty($images[0]->img_path)) {
		                  $img_path = 'no_image.png';
		                } else {
		                  $img_path = $images[0]->img_path;
		                }
		              ?>
		                
	                  <div class="col-md-4" style="height:100">

	                    <div class="thumbnail">

	                      <img src="<?php echo $this->ps_image->upload_thumbnail_url . $img_path; ?>">

	                      <br/>
	                      
	                      <p class="text-center">
	                        
	                        <a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $images[0]->img_id; ?>"   
	                          image="<?php echo $img->img_path; ?>">
	                          <?php echo get_msg('remove_label'); ?>
	                        </a>
	                      </p>

	                    </div>

	                  </div>

		            <?php endif; ?> 
		            <!-- End Item default photo -->
                     <br><br>
					<div class="form-group">
						<div class="form-check">
							<label>
							
							<?php echo form_checkbox( array(
								'name' => 'is_featured',
								'id' => 'is_featured',
								'value' => 'accept',
								'checked' => set_checkbox('is_featured', 1, ( @$product->is_featured == 1 )? true: false ),
								'class' => 'form-check-input'
							));	?>

							<?php echo get_msg( 'is_featured' ); ?>

							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="form-check">
							<label>
							
							<?php echo form_checkbox( array(
								'name' => 'is_available',
								'id' => 'is_available',
								'value' => 'accept',
								'checked' => set_checkbox('is_available', 1, ( @$product->is_available == 1 )? true: false ),
								'class' => 'form-check-input'
							));	?>

							<?php echo get_msg( 'is_available' ); ?>

							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="form-check">

							<label>
							
								<?php echo form_checkbox( array(
									'name' => 'status',
									'id' => 'status',
									'value' => 'accept',
									'checked' => set_checkbox('status', 1, ( @$product->status == 1 )? true: false ),
									'class' => 'form-check-input'
								));	?>

								<?php echo get_msg( 'status' ); ?>
							</label>
						</div>
					</div>


				</div>
    		</div>
    		
    		<label><?php echo get_msg('prd_specification')?></label>
    		<!-- product specification for edit -->
			<?php if ( isset( $product )){ ?>

				<?php 

					$spec_data = $this->Specification->get_all_by( array( 'product_id' => @$product->id ))->result(); 
					$specs_count = count($spec_data);

					//counter need to plus one for edit default 
					$spec_data_count = $specs_count + 1;
				?>

					

				<?php if ( !empty( $spec_data )): ?>

					<?php 
						$i = 0;
						foreach( $spec_data as $spec ): 
						$i++;
					?>

					<div id="spec_data">
		    			<div class="col-md-6">
		    				<div class="form-group">
								<label>
									<?php echo get_msg('product_title') . " : " . $i?>
								</label>
								
								<?php echo form_input( array(
									'name' => 'prd_spec_title' . $i,
									'value' => $spec->name,
									'class' => 'form-control form-control-sm',
									'id' => 'prd_spec_title' . $i,
								)); ?>
							
							</div>

							<div class="form-group">
								<label>
									<?php echo get_msg('product_desc') . " : "  .$i?>
								</label>
								
								<?php echo form_input( array(
									'name' => 'prd_spec_desc' . $i,
									'value' => $spec->description,
									'class' => 'form-control form-control-sm',
									'id' => 'prd_spec_desc' . $i,
								)); ?>
								
							</div>
						</div>		
		    		</div>
		    		<?php endforeach; ?>

				<?php endif; ?>
				<!-- Edit Default save -->
				<div id="spec_data1">
					<div class="col-md-6">
    					<div class="form-group">
							<label>
								<?php echo get_msg('product_title') . " : " . $spec_data_count ?>
							</label>
						
							<?php echo form_input( array(
								'name' => 'prd_spec_title'.$spec_data_count,
								'value' => set_value( 'prd_spec_title1', show_data( @$product->prd_spec_title1), false ),
								'class' => 'form-control form-control-sm',
								'id' => 'prd_spec_title'.$spec_data_count,
							)); ?>
						
						</div>

						<div class="form-group">
							<label>
								<?php echo get_msg('product_desc') . " : " . $spec_data_count ?>
							</label>
							
							<?php echo form_input( array(
								'name' => 'prd_spec_desc'.$spec_data_count,
								'value' => set_value( 'prd_spec_desc1', show_data( @$product->prd_spec_desc1), false ),
								'class' => 'form-control form-control-sm',
								'id' => 'prd_spec_desc'.$spec_data_count,
							)); ?>
							
						</div>
    				</div>
    			</div>

			<!-- product specification for save -->
			<?php } else { ?>
	    		<div id="spec_data1">
	    			<div class="col-md-6">
						<div class="form-group">
							<label>
								<?php echo get_msg('product_title') . " : 1"?>
							</label>
							
							<?php echo form_input( array(
								'name' => 'prd_spec_title1',
								'value' => set_value( 'prd_spec_title1', show_data( @$product->prd_spec_title1), false ),
								'class' => 'form-control form-control-sm',
								'id' => 'prd_spec_title1',
							)); ?>
							
						</div>

						<div class="form-group">
							<label>
								<?php echo get_msg('product_desc') . " : 1"?>
							</label>

							<div class="form-group">
								<?php echo form_input( array(
									'name' => 'prd_spec_desc1',
									'value' => set_value( 'prd_spec_desc1', show_data( @$product->prd_spec_desc1), false ),
									'class' => 'form-control form-control-sm',
									'id' => 'prd_spec_desc1',
								)); ?>
							</div>
						</div>
					</div>
	    		</div>
	    	<?php } ?>
	    		<div class="col-6">
					<div class="form-group">
						<div class="mt-2">
							<a id="addspec" class="pull-right">
								<i class="fa fa-plus" aria-hidden="true"></i>
							<?php echo get_msg('add_more_spec'); ?>
							</a>
						</div>
					</div>
				</div>
					
			</div>

		<?php 
			if (isset($color_count)) {
				$color_count = $color_count;
			} else {
				$color_count = 0;
			} 
		?>
		<input type="hidden" id="color_total_existing" name="color_total_existing" value="<?php echo $color_count; ?>">

		<?php 
			if (isset($spec_data)) {
				$specs_count = $specs_count;
			} else {
				$specs_count = 0;
			} 
		?>
		<input type="hidden" id="spec_total_existing" name="spec_total_existing" value="<?php echo $specs_count; ?>">

		<?php 
			if ( isset( $product )) { 
		?>
			<input type="hidden" id="edit_product" name="edit_product" value="1">
		<?php		
			} else {
		?>
			<input type="hidden" id="edit_product" name="edit_product" value="0">
		<?php } ?> 

		<input type="hidden" id="is_featured_stage" name="is_featured_stage" value="<?php echo @$product->is_featured; ?>">

		<div class="card-footer">
            <button type="submit" class="btn btn-sm btn-primary" style="margin-top: 3px;">
				<?php echo get_msg('btn_save')?>
			</button>

			<button type="submit" name="gallery" id="gallery" class="btn btn-sm btn-primary" style="margin-top: 3px;">
				<?php echo get_msg('btn_save_gallery')?>
			</button>

			<button type="submit" name="attribute" id="attribute" class="btn btn-sm btn-primary" style="margin-top: 3px;">
				<?php echo get_msg('btn_save_prd_att')?>
			</button>

			<a href="<?php echo site_url() . '/admin/attributes/index/'.$product->id ?>" class="btn btn-sm btn-primary" style="margin-top: 3px;">
				<?php echo get_msg('btn_att_list')?>
			</a>


			<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary" style="margin-top: 3px;">
				<?php echo get_msg('btn_cancel')?>
			</a>
        </div>

	</div>
</section>
<?php echo form_close(); ?>
