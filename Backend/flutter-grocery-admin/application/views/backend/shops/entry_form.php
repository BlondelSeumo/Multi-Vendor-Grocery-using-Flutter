<?php
$attributes = array('id' => 'shop-form','enctype' => 'multipart/form-data');
echo form_open( '', $attributes);
$logged_in_user = $this->ps_auth->get_user_info();
if($logged_in_user->role_id == 1) {
	$readonly = "";
	$disabled = "";
} else {
	$readonly = "readonly";
	$disabled = "disabled";
}
?>

<section class="content animated fadeInRight" style="padding: 30px 20px 20px 20px;">
	<div class="card">
	    <div class="card-header" style="border-top: 2px solid red;">
	    	<?php if ( $shop ) { ?>
		        <h3 class="card-title"><?php echo get_msg('shop_info')?>
	  			<a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>">(Go to Dashboard)</a>
				</h3>
			<?php } else{ ?>
				<h3 class="card-title"><?php echo get_msg('shop_info')?></h3>
			<?php } ?>
	    </div>	    <ul class="nav nav-tabs" id="myTab">

	    	<?php
	    		$active_tab_shopinfo="";
	    		if($current_tab == "shopinfo") {
	    			$active_tab_shopinfo = "active";
	    		}
	    		
	    		if($current_tab == "payment") {
	    			$active_tab_payment = "active";
	    		}

	    		if($current_tab == "currency") {
	    			$active_tab_currency = "active";
	    		}

	    		if($current_tab == "sender") {
	    			$active_tab_sender = "active";
	    		}

	    		if($current_tab == "tax") {
	    			$active_tab_tax = "active";
	    		}

	    		if($current_tab == "policy") {
	    			$active_tab_policy = "active";
	    		}

	    		if($current_tab == "order") {
	    			$active_tab_order = "active";
	    		}


	    		if($active_tab_shopinfo == "" && $active_tab_payment == "" &&  $active_tab_currency == "" && $active_tab_sender == "" && $active_tab_tax == "" && $active_tab_policy == "" && $active_tab_order == "") {

	    			$active_tab_shopinfo = "active";
	    		}  

	    	?>

            <li class="nav-item"><a class="nav-link <?php echo $active_tab_shopinfo;?>" href="#shopinfo" value="shopinfo" data-toggle="tab">Shop Information</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $active_tab_payment;?>" href="#payment"  value="payment" data-toggle="tab">Payment Setting</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $active_tab_currency;?>" href="#currency" value="currency" data-toggle="tab">Currency Setting</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $active_tab_sender;?>" href="#sender" value="sender" data-toggle="tab">Sending Email Setting(For SMTP)</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $active_tab_tax;?>" href="#tax" value="tax" data-toggle="tab">Tax</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $active_tab_policy;?>" href="#policy" value="policy" data-toggle="tab">Policy & Terms</a></li>
           <li class="nav-item"><a class="nav-link <?php echo $active_tab_order;?>" href="#order" value="order" data-toggle="tab">Order Setting</a></li>
             
        </ul>
        <!-- /.card-header -->
        <div class="card-body">
          	<div class="tab-content">
            	<div class="tab-pane <?php echo $active_tab_shopinfo;?>" id="shopinfo">
            		<div class="row">
			
						<div class="col-md-6">
							
							<br>

							<div class="form-group">
								<label>
									<span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('name_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('name_label') ?>" name='name' id='name' <?php echo $readonly; ?>
								value="<?php echo $shop->name;?>">
							</div>

							<div class="form-group">
								<label>
									<span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('description_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_desc_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<textarea class="form-control" name="description" <?php echo $readonly; ?> placeholder="<?php echo get_msg('description_label') ?>" rows="9"><?php echo $shop->description;?></textarea>
							</div>

			                <div class="form-group">
			                  	<label>
			                  		<span style="font-size: 17px; color: red;">*</span>
			                  		<?php echo get_msg('shop_tags') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_tags')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

				                <select class="form-control select2" multiple="multiple" name="shoptag" id="shoptag" <?php echo $disabled; ?>
				                          style="width: 100%;">
			                       	<?php
										//$options=array();
										$tags = $this->Tag->get_all()->result();

										$i = 1;
										foreach ($tags as $tag) {

											if($shop->id != "") {
												$conds['shop_id'] = $shop->id;
											} else {
												$conds['shop_id'] = '0';
											}
											
											$conds['tag_id'] = $tag->id;


												
											$shop_tags_id = $this->Shoptag->get_one_by($conds)->tag_id;
											
											$selected_value = "";
											if($shop_tags_id == "" ) {
												$selected_value = "";
											} else {
												$selected_value = "selected";
											}
											echo $selected_value . $i;
											echo '<option  '.$selected_value.' name="'.$tag->name.'" value="'.$tag->id.'">'.$tag->name.'</option>';

											$i++;
										}

										if($shop->id != "") {
												$conds1['shop_id'] = $shop->id;
											} else {
												$conds1['shop_id'] = '0';
											}
											
										$shop_tags_ids = $this->Shoptag->get_all_by($conds1)->result();
										$existing_tag_ids = "";
										
										foreach ($shop_tags_ids as $shop_tag) {

											$existing_tag_ids .= $shop_tag->tag_id .",";


										}

									?>
									<input type="hidden"  id="tagselect" name="tagselect">
									<input type="hidden"  id="existing_tagselect" name="existing_tagselect" value="<?php echo $existing_tag_ids; ?>">
				                </select>

			                </div>

							<div class="form-group">
								<label><input type="checkbox" name="status" <?php echo $disabled; ?> value="1" <?php if($shop->status == 1) echo "checked";?> >&nbsp;&nbsp;Status For Publish</label>
							</div>

							<?php $logged_in_user = $this->ps_auth->get_user_info(); ?>
							
								<?php if($logged_in_user->user_is_sys_admin == 1): ?>

									<div class="form-group">
									<div class="form-check">
										<label>
										
										<?php echo form_checkbox( array(
											'name' => 'is_featured',
											'id' => 'is_featured',
											'value' => 'accept',
											'checked' => set_checkbox('is_featured', 1, ( @$shop->is_featured == 1 )? true: false ),
											'class' => 'form-check-input',
											$disabled => $disabled
										));	?>

										<?php echo get_msg( 'is_featured' ); ?>

										</label>
									</div>
								</div>

									
							<?php  endif; ?>
							

							<div class="form-group">
								<label><?php echo get_msg('contact_email_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_email_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								
								<input class="form-control" type="text" placeholder="Email" name='email' <?php echo $readonly; ?> id='email'
								value="<?php echo $shop->email;?>">
							</div>

							<div class="form-group">
								<label>
									<?php echo get_msg('price_level')?>
								</label>

								<select id="price_level" name="price_level" <?php echo $disabled; ?> class="form-control">
								   <?php if ($shop->price_level == "Low") { ?> 
								   		<option value="1" selected>Low</option>
								   		<option value="2">Medium</option>
								   		<option value="3">High</option>
								   <?php }else if ($shop->price_level == "Medium") { ?>
								   		<option value="1">Low</option>
								   		<option value="2"  selected>Medium</option>
								   		<option value="3">High</option>
								   <?php }else{  ?>
								  		<option value="1">Low</option>
								   		<option value="2">Medium</option>
								   		<option value="3" selected>High</option>
								   <?php } ?>
								</select>

							</div>

							<div class="form-group">
								<label><?php echo get_msg('highlighted_info')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('highlighted_info')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								
								
								<input class="form-control" type="text" placeholder="<?php echo get_msg('highlighted_info') ?>" name='highlighted_info' <?php echo $readonly; ?> id='highlighted_info' value="<?php echo $shop->highlighted_info;?>">
							</div>

							<?php if ( !isset( $shop )): ?>
								<div class="form-group">
								
									<label><?php echo get_msg('shop_cover_photo_label')?>
										<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_photo_tooltips')?>">
											<span class='glyphicon glyphicon-info-sign menu-icon'>
										</a>
									</label>

									<br>

									<?php echo get_msg('shop_image_recommended_size')?>

									<input class="btn btn-sm" type="file" name="cover" id="cover">
								</div>

								<?php else: ?>

									<label><?php echo get_msg('shop_cover_photo_label')?>
										<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_photo_tooltips')?>">
											<span class='glyphicon glyphicon-info-sign menu-icon'>
										</a>
									</label>

									<br>

									<?php echo get_msg('shop_image_recommended_size')?>

									<a class="btn btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadImage">
										<?php echo get_msg('btn_replace_photo')?> 
									</a>

									<hr/>	
									<?php
										$conds = array( 'img_type' => 'shop', 'img_parent_id' => $shop->id );
				
										$images = $this->Image->get_all_by( $conds )->result();
									?>
				
									<?php if ( count($images) > 0 ): ?>
				
										<div class="row">

										<?php $i = 0; foreach ( $images as $img ) :?>

											<?php if ($i>0 && $i%3==0): ?>
													
										</div><div class='row'>
											
											<?php endif; ?>
												
											<div class="col-md-4" style="height:100">

												<div class="thumbnail">
													<?php
														if( $img->img_path !="" ) {
													?>
														<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">
													<?php } else if (!file_exists(img_url( 'thumbnail/'. $img->img_path )) || $img->img_path  == "") { ?>
							        	 				<img src="<?php echo img_url( 'thumbnail/avatar.png'); ?>" alt="User Image" style="width: 50px;">
							        				<?php } ?>
													<br/>
													
													<p class="text-center">
														
														<a data-toggle="modal" data-target="#deletePhoto" class="delete-img" id="<?php echo $img->img_id; ?>"   
															image="<?php echo $img->img_path; ?>">
															<?php echo get_msg('remove_label'); ?>
														</a>
													</p>

												</div>

											</div>

										<?php endforeach;?>

										</div>

									
									<?php endif; ?>
								<?php endif; ?>	
								<!-- Icon  -->
								<?php if ( !isset( $shop )): ?>
								<div class="form-group">
								
									<label><?php echo get_msg('shop_icon_photo_label')?>
										<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_photo_tooltips')?>">
											<span class='glyphicon glyphicon-info-sign menu-icon'>
										</a>
									</label>

									<br>

									<?php echo get_msg('shop_image_recommended_size_icon')?>

									<input class="btn btn-sm" type="file" name="icon" id="icon">
								</div>

								<?php else: ?>

									<label><?php echo get_msg('shop_icon_photo_label')?>
										<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_photo_tooltips')?>">
											<span class='glyphicon glyphicon-info-sign menu-icon'>
										</a>
									</label>

									<br>

									<?php echo get_msg('shop_image_recommended_size_icon')?>

									<a class="btn btn-primary btn-upload pull-right" data-toggle="modal" data-target="#uploadIcon">
										<?php echo get_msg('btn_replace_icon')?> 
									</a>

									<hr/>	
									<?php
										$conds = array( 'img_type' => 'shop-icon', 'img_parent_id' => $shop->id );
				
										$images = $this->Image->get_all_by( $conds )->result();
									?>
				
									<?php if ( count($images) > 0 ): ?>
				
										<div class="row">

										<?php $i = 0; foreach ( $images as $img ) :?>

											<?php if ($i>0 && $i%3==0): ?>
													
										</div><div class='row'>
											
											<?php endif; ?>
												
											<div class="col-md-4" style="height:100">

												<div class="thumbnail">

													<img src="<?php echo $this->ps_image->upload_thumbnail_url . $img->img_path; ?>">

													<br/>
													
													<p class="text-center">
														
														<a data-toggle="modal" data-target="#deleteIcon" class="delete-img" id="<?php echo $img->img_id; ?>"   
															image="<?php echo $img->img_path; ?>">
															<?php echo get_msg('remove_label'); ?>
														</a>
													</p>

												</div>

											</div>

										<?php endforeach;?>

										</div>

									
									<?php endif; ?>
								<?php endif; ?>	

						</div>

						<div class="col-md-6">
							<br/>

							<div class="form-group">
								<label>
									<?php echo get_msg('phone_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label') ?>" name='about_phone1' <?php echo $readonly; ?> id='about_phone1' value="<?php echo $shop->about_phone1;?>">
							</div>

							<div class="form-group">
								<label>
									<?php echo get_msg('phone_label2') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label2') ?>" name='about_phone2' <?php echo $readonly; ?> id='about_phone2' value="<?php echo $shop->about_phone2;?>">
							</div>

							<div class="form-group">
								<label>
									<?php echo get_msg('phone_label3') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label') ?>" name='about_phone3' <?php echo $readonly; ?> id='about_phone3' value="<?php echo $shop->about_phone3;?>">
							</div>
								
							<div class="form-group">
								<label><?php echo get_msg('address_label1')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address1" <?php echo $readonly; ?> placeholder="<?php echo get_msg('address_label1')?>" rows="5"><?php echo $shop->address1;?></textarea>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('address_label2')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address2" <?php echo $readonly; ?> placeholder="<?php echo get_msg('address_label2')?>" rows="5"><?php echo $shop->address2;?></textarea>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('address_label3')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address3" <?php echo $readonly; ?> placeholder="<?php echo get_msg('address_label3')?>" rows="5"><?php echo $shop->address3;?></textarea>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('about_website_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'about_website',
										'id' => 'about_website',
										'class' => 'form-control',
										'placeholder' => 'Website',
										'value' => set_value( 'about_website', show_data( @$shop->about_website ), false ),
										$readonly => $readonly
									));
								?>
							</div>

						</div>

					</div>
					<div class="row">

						<legend><?php echo get_msg('about_social_section')?></legend>

						<div class="col-6">

							<div class="form-group">
								<label><?php echo get_msg('about_facebook_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'facebook',
										'id' => 'facebook',
										'class' => 'form-control',
										'placeholder' => 'Facebook',
										'value' => set_value( 'facebook', show_data( @$shop->facebook ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('about_gplus_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'google_plus',
										'id' => 'google_plus',
										'class' => 'form-control',
										'placeholder' => 'Google+',
										'value' => set_value( 'google_plus', show_data( @$shop->google_plus ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('about_instagram_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'instagram',
										'id' => 'instagram',
										'class' => 'form-control',
										'placeholder' => 'Instagram',
										'value' => set_value( 'instagram', show_data( @$shop->instagram ), false ),
										$readonly => $readonly
									));
								?>
							</div>

						</div>

						<div class="col-6">

							<div class="form-group">
								<label><?php echo get_msg('about_youtube_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'youtube',
										'id' => 'youtube',
										'class' => 'form-control',
										'placeholder' => 'Youtube',
										'value' => set_value( 'youtube', show_data( @$shop->youtube ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('about_pinterest_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'pinterest',
										'id' => 'pinterest',
										'class' => 'form-control',
										'placeholder' => 'Pinterest',
										'value' => set_value( 'pinterest', show_data( @$shop->pinterest ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('about_twitter_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'twitter',
										'id' => 'twitter',
										'class' => 'form-control',
										'placeholder' => 'Twitter',
										'value' => set_value( 'twitter', show_data( @$shop->twitter ), false ),
										$readonly => $readonly
									));
								?>
							</div>
						</div>
					</div>
					
					<div class="row">

						<legend><?php echo get_msg('about_chart_section')?></legend>

						<div class="col-6">

							<div class="form-group">
								<label>
									<?php echo get_msg('whapsapp_no_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('whapsapp_no_label') ?>" name='whapsapp_no' <?php echo $readonly; ?> id='whapsapp_no' value="<?php echo $shop->whapsapp_no;?>">
							</div>

						</div>

						<div class="col-6">

							<div class="form-group">
								<label><?php echo get_msg('about_mess_label')?></label>
								
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'messenger',
										'id' => 'messenger',
										'class' => 'form-control',
										'placeholder' => 'Messenger',
										'value' => set_value( 'messenger', show_data( @$shop->messenger ), false ),
										$readonly => $readonly
									));
								?>
							</div>
						</div>
					</div>

					<div class="row">

						<legend><?php echo get_msg('about_location_section')?></legend>
						<div class="col-6">

				          	<div id="restaurant_map" style="width: 100%; height: 300px;"></div>

				          	<div class="clearfix">&nbsp;</div>
								
							<div class="form-group">
								<label>
									<?php echo get_msg('rest_lat_label') ?>
					              	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('rest_lat_label')?>">
					              		<span class='glyphicon glyphicon-info-sign menu-icon'>
					              	</a>
				              	</label>

								<br>

								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'lat',
										'id' => 'lat',
										'class' => 'form-control',
										'placeholder' => '',
										'value' => set_value( 'lat', show_data( @$shop->lat ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label>
									<?php echo get_msg('rest_lng_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('rest_lng_label')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<br>

								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'lng',
										'id' => 'lng',
										'class' => 'form-control',
										'placeholder' => '',
										'value' =>  set_value( 'lng', show_data( @$shop->lng ), false ),
										$readonly => $readonly
									));
								?>
							</div>

						</div>

						<div class="col-6">
							<div class="form-group">
								<label><?php echo get_msg('opening_hour_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'opening_hour',
										'id' => 'opening_hour',
										'class' => 'form-control',
										'placeholder' => get_msg('opening_hour_label'),
										'value' => set_value( 'opening_hour', show_data( @$shop->opening_hour ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('closing_hour_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'closing_hour',
										'id' => 'closing_hour',
										'class' => 'form-control',
										'placeholder' => get_msg('closing_hour_label'),
										'value' => set_value( 'closing_hour', show_data( @$shop->closing_hour ), false ),
										$readonly => $readonly
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('closed_date_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'closed_date',
										'id' => 'closed_date',
										'class' => 'form-control',
										'placeholder' => get_msg('closed_date_label'),
										'value' => set_value( 'closed_date', show_data( @$shop->closed_date ), false ),
										$readonly => $readonly
									));
								?>
								( <i><?php echo get_msg('closed_date_example'); ?></i> )
							</div>
						</div>
					</div>
					
          		</div>
                
          		<div class="tab-pane <?php echo $active_tab_payment;?>" id="payment">
           			<div class="form-group">
		
						<br>

						<label><?php echo get_msg('stripe_label')?></label>
						
						<br>

						<label><?php echo get_msg('stripe_publishable_key')?>

							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('stripe_publishable_key_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
							
							
							
						</label>
						
						<input class="form-control" type="text" placeholder="Publishable Key" <?php echo $readonly; ?> name='stripe_publishable_key' id='stripe_publishable_key'
							 value="<?php echo $shop->stripe_publishable_key;?>">
							 <br>
						
						
						<label><?php echo get_msg('stripe_secret_key')?>
					
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('stripe_secret_key_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
							
						</label>

						<input class="form-control" type="text" placeholder="Secret Key" <?php echo $readonly; ?> name='stripe_secret_key' id='stripe_secret_key'
							 value="<?php echo $shop->stripe_secret_key;?>">
							 <br>

						<div class="form-group">
							<div class="form-check">
								<label>
								
								<?php echo form_checkbox( array(
									'name' => 'stripe_enabled',
									'id' => 'stripe_enabled',
									'value' => 'accept',
									'checked' => set_checkbox('stripe_enabled', 1, ( @$shop->stripe_enabled == 1 )? true: false ),
									'class' => 'form-check-input',
									$disabled => $disabled
								));	?>

								<?php echo get_msg( 'stripe_enable_label' ); ?>

								</label>
							</div>
						</div>

						<br>

						<hr>

						<label><?php echo get_msg('paypal_label')?></label>

						<br>

						<label><?php echo get_msg('paypal_env_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('paypal_env_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('paypal_env_label')?>" <?php echo $readonly; ?> name='paypal_environment' id='paypal_environment'
						value="<?php echo $shop->paypal_environment;?>">

						<br>

						<label><?php echo get_msg('paypal_merchant_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('paypal_merchant_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>  	
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('paypal_merchant_label')?>" name='paypal_merchant_id' <?php echo $readonly; ?> id='paypal_merchant_id'
						value="<?php echo $shop->paypal_merchant_id;?>">

						<br>

						<label><?php echo get_msg('paypal_pub_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('paypal_pub_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('paypal_pub_label')?>" name='paypal_public_key' <?php echo $readonly; ?> id='paypal_public_key'
						value="<?php echo $shop->paypal_public_key;?>">

						<br>

						<label><?php echo get_msg('paypal_pri_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('paypal_pri_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('paypal_pri_label')?>" name='paypal_private_key' <?php echo $readonly; ?> id='paypal_private_key'
						value="<?php echo $shop->paypal_private_key;?>">
						<br>

						<div class="form-group">
							<div class="form-check">
								<label>
								
								<?php echo form_checkbox( array(
									'name' => 'paypal_enabled',
									'id' => 'paypal_enabled',
									'value' => 'accept',
									'checked' => set_checkbox('paypal_enabled', 1, ( @$shop->paypal_enabled == 1 )? true: false ),
									'class' => 'form-check-input',
									$disabled => $disabled
								));	?>

								<?php echo get_msg( 'paypal_enabled_label' ); ?>

								</label>
							</div>
						</div>

						<br>

						<hr>

						<label><?php echo get_msg('bank_transfer_label')?></label>

						<br>

						<label><?php echo get_msg('bank_account_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('bank_account_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('bank_account_label')?>" name='bank_account' <?php echo $readonly; ?> id='bank_account'
						value="<?php echo $shop->bank_account;?>">

						<br>

						<label><?php echo get_msg('bank_name_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('bank_name_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>  	
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('bank_name_label')?>" name='bank_name' <?php echo $readonly; ?> id='bank_name'
						value="<?php echo $shop->bank_name;?>">

						<br>

						<label><?php echo get_msg('bank_code_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('bank_code_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('bank_code_label')?>" name='bank_code' <?php echo $readonly; ?> id='bank_code'
						value="<?php echo $shop->bank_code;?>">

						<br>

						<label><?php echo get_msg('branch_code_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('branch_code_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('branch_code_label')?>" name='branch_code' <?php echo $readonly; ?> id='branch_code'
						value="<?php echo $shop->branch_code;?>">

						<br>

						<label><?php echo get_msg('swift_code_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('swift_code_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('swift_code_label')?>" name='swift_code' <?php echo $readonly; ?> id='swift_code'
						value="<?php echo $shop->swift_code;?>">

						<br>

						<div class="form-group">
							<div class="form-check">
								<label>
								
								<?php echo form_checkbox( array(
									'name' => 'banktransfer_enabled',
									'id' => 'banktransfer_enabled',
									'value' => 'accept',
									'checked' => set_checkbox('banktransfer_enabled', 1, ( @$shop->banktransfer_enabled == 1 )? true: false ),
									'class' => 'form-check-input',
									$disabled => $disabled
								));	?>

								<?php echo get_msg( 'banktransfer_label' ); ?>

								</label>
							</div>
						</div>

						<hr>

						<label><?php echo get_msg('cod_label')?></label>

						<br>

						<label><?php echo get_msg('cod_email_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('code_email_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="COD Confirmation Email" name='cod_email' id='cod_email'
						value="<?php echo $shop->cod_email;?>">
						
						<br>

						<div class="form-group">
							<div class="form-check">
								<label>
								
								<?php echo form_checkbox( array(
									'name' => 'cod_enabled',
									'id' => 'cod_enabled',
									'value' => 'accept',
									'checked' => set_checkbox('cod_enabled', 1, ( @$shop->cod_enabled == 1 )? true: false ),
									'class' => 'form-check-input',
									$disabled => $disabled
								));	?>

								<?php echo get_msg( 'cod_enable_label' ); ?>

								</label>
							</div>
						</div>

						<br>

						<hr>

						<label><?php echo get_msg('razor_label')?></label>

						<br>

						<label><?php echo get_msg('razor_key_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('razor_key_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('razor_key_label')?>" name='razor_key' id='razor_key'
						value="<?php echo $shop->razor_key;?>">
						
						<br>

						<div class="form-group">
							<div class="form-check">
								<label>
								
								<?php echo form_checkbox( array(
									'name' => 'razor_enabled',
									'id' => 'razor_enabled',
									'value' => 'accept',
									'checked' => set_checkbox('razor_enabled', 1, ( @$shop->razor_enabled == 1 )? true: false ),
									'class' => 'form-check-input',
									$disabled => $disabled
								));	?>

								<?php echo get_msg( 'razor_enabled_label' ); ?>

								</label>
							</div>
						</div> 

						<hr width="100%" size="8">
				        <div class="col-md-6">
				        	<label><?php echo get_msg('pickup_label')?></label>

							<br>

							<label><?php echo get_msg('pickup_message')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('message_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<?php echo form_textarea( array(
								'name' => 'pickup_message',
								'value' => set_value( 'pickup_message', show_data( @$shop->pickup_message ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'pickup_message' ),
								'rows' => '5',
								'id' => 'pickup_message',
							)); ?>
							
							<br>

							<div class="form-group">
								<div class="form-check">
									<label>
									
									<?php echo form_checkbox( array(
										'name' => 'pickup_enabled',
										'id' => 'pickup_enabled',
										'value' => 'accept',
										'checked' => set_checkbox('pickup_enabled', 1, ( @$shop->pickup_enabled == 1 )? true: false ),
										'class' => 'form-check-input'
									));	?>

									<?php echo get_msg( 'pickup_enabled_label' ); ?>

									</label>
								</div>
							</div> 
				        </div>

				        <hr>

						<label><?php echo get_msg('paystack_label')?></label>

						<br>

						<label><?php echo get_msg('paystack_key_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('paystack_key_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<input class="form-control" type="text" placeholder="<?php echo get_msg('paystack_key_label')?>" name='paystack_key' id='paystack_key' <?php echo $readonly; ?>
						value="<?php echo $shop->paystack_key;?>">
						
						<br>

						<div class="form-group">
							<div class="form-check">
								<label>
								
								<?php echo form_checkbox( array(
									'name' => 'paystack_enabled',
									'id' => 'paystack_enabled',
									'value' => 'accept',
									'checked' => set_checkbox('paystack_enabled', 1, ( @$shop->paystack_enabled == 1 )? true: false ),
									'class' => 'form-check-input',
									$disabled => $disabled
								));	?>

								<?php echo get_msg( 'paystack_enabled_label' ); ?>

								</label>
							</div>
						</div> 

					</div>
          		</div>
                  
          		<div class="tab-pane <?php echo $active_tab_currency;?>" id="currency">
           			<br>
		
					<div class="col-sm-6">
						<div class="form-group">
							<label><?php echo get_msg('currency_symbol_label')?> 
								<a href="#" class="tooltip-ps" data-toggle="tooltip" \
									title="<?php echo get_msg('currency_symbol_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<input class="form-control" type="text" placeholder="Currency Symbol" name='currency_symbol' <?php echo $readonly; ?> id='currency_symbol'
							value="<?php echo $shop->currency_symbol;?>">
						</div>

						<div class="form-group">
							<label><?php echo get_msg('currency_form_label')?> 
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('currency_form_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<input class="form-control" type="text" placeholder="Currency Short Form" name='currency_short_form' <?php echo $readonly; ?> id='currency_short_form'
							value="<?php echo $shop->currency_short_form;?>">

						</div>
					</div>
          		</div>
                  
           		<div class="tab-pane <?php echo $active_tab_sender;?>" id="sender">
            		
					<br>

					<div class="col-sm-6">
						<div class="form-group">
							<label><?php echo get_msg('sender_email_label')?> 
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('sender_email_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<input class="form-control" type="text" placeholder="Sender Email" name='sender_email' id='sender_email' <?php echo $readonly; ?> value="<?php echo $shop->sender_email;?>">
						</div>
					</div>
          		</div>

          		<div class="tab-pane <?php echo $active_tab_tax;?>" id="tax">
          			<div class="row">
          				<div class="col-md-6">
          					<div class="form-group">
								<label>
									<?php echo get_msg('overall_tax_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('overall_tax_label');?>" name='overall_tax_label' <?php echo $readonly; ?> id='overall_tax_label'
								value="<?php echo $shop->overall_tax_label;?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>
									<?php echo get_msg('shipping_tax_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('shipping_tax_label');?>" name='shipping_tax_label' <?php echo $readonly; ?> id='shipping_tax_label'
								value="<?php echo $shop->shipping_tax_label;?>">
							</div>
						</div>	
          			</div>
          		</div>

          		<div class="tab-pane <?php echo $active_tab_policy;?>" id="policy">
          			<div class="row">
          				<div class="col-md-6">
      						<div class="form-group">
								<label>
									<?php echo get_msg('refund_policy_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<textarea class="form-control" name="refund_policy" <?php echo $readonly; ?> placeholder="<?php echo get_msg('refund_policy_label') ?>" rows="5"><?php echo $shop->refund_policy;?></textarea>
								
							</div>
          				</div>

          				<div class="col-md-6">
      						<div class="form-group">
								<label>
									<?php echo get_msg('terms_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<textarea class="form-control" name="terms" <?php echo $readonly; ?> placeholder="<?php echo get_msg('terms_label') ?>" rows="5"><?php echo $shop->terms;?></textarea>
								
							</div>
          				</div>
          			</div>
          		</div>

          	  <div class="tab-pane <?php echo $active_tab_order;?>" id="order">
          			<div class="row">
          				<div class="col-md-6">
          					<div class="form-group">
								<label>
									<?php echo get_msg('minimum_order_amount') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('minimum_order_amount');?>" name='minimum_order_amount' <?php echo $readonly; ?> id='minimum_order_amount'
								value="<?php echo $shop->minimum_order_amount;?>">
							</div>
						</div>	
          			</div>
          		</div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.card-body -->
        <input type="hidden" id="is_featured_stage" name="is_featured_stage" value="<?php echo @$shop->is_featured; ?>">
        <?php if($logged_in_user->role_id == 1) { ?>
		<div class="card-footer">
			
           <button type="submit" name="save" class="btn btn-primary">
				<?php echo get_msg('btn_save')?>
			</button>
				
			<a href="<?php echo site_url('admin/shops');?>" class="btn btn-primary"><?php echo get_msg('btn_cancel'); ?></a>

        </div>
       	<?php } ?>
    </div>
    <!-- card info -->

    <input type="hidden"  id="current_tab" name="current_tab" value="current_tab">

</section>
<?php echo form_close(); ?>

<div class="modal fade"  id="deleteShop">
		
	<div class="modal-dialog">
		
		<div class="modal-content">
		
			<div class="modal-header">
				<h4 class="modal-title"><?php echo get_msg('delete_shop_label')?></h4>

				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>

			</div>

			<div class="modal-body">
				<p><?php echo get_msg('delete_shop_confirm_message')?></p>
				<p>1. Categories</p>
				<p>2. Sub-Categories</p>
				<p>3. Products and Discounts</p>
				<p>4. Products and Collection</p>
				<p>5. News Feeds</p>
				<p>6. Shipping Methods</p>
				<p>7. Watch List</p>
				<p>8. Comments</p>
				<p>9. Transactions</p>
				<p>10. Reports</p>
				<p>11. User Shop</p>
				<p>12. Shop Tag</p>
				<p>13. Likes</p>
				<p>14. Favourites</p>
				<p>15. Coupon</p>
			</div>

			<div class="modal-footer">
				<a type="button" class="btn btn-default btn-delete-shop">Yes</a>
				<a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
			</div>

		</div>
	
	</div>			
		
</div>