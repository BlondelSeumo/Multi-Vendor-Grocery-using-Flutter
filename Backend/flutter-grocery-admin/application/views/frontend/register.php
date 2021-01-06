<?php
$attributes = array('id' => 'register-form','enctype' => 'multipart/form-data');
echo form_open(site_url("save"), $attributes);
?>

<div class="main">

    <div class="container1">
        <div class="signup-content">
			<div class="signup-img">
		        <img src="<?php echo base_url('assets/img/form-img.png'); ?>" alt="Default Image" style="width: 385px;height: 100%;">
		    </div>

		    <div class="signup-form">
		    	<div class="register-form">
					<div class="row">
						<legend><?php echo get_msg('shop_info')?></legend>
						<div class="col-md-6">
							
							<div class="form-group">
								<label>
									<span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('name_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="Please enter shop name" name='name' id='name'
								value="">
							</div>

							<div class="form-group">
								<label>
									<span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('description_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_desc_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<textarea class="form-control" name="description" placeholder="Description" rows="5"></textarea>
							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">
				              	<label>
				              		<span style="font-size: 17px; color: red;">*</span>
				              		<?php echo get_msg('shop_tags') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_tags')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label><br>

				                <select class="form-control select2" multiple="multiple" name="shoptag" id="shoptag" style="width: 370px;">
				                   	<?php
										$register="";
										$tags = $this->Tag->get_all()->result();

										$i = 1;
										foreach ($tags as $tag) {

											if($register->id != "") {
												$conds['shop_id'] = $register->id;
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

										if($register->id != "") {
												$conds1['shop_id'] = $register->id;
											} else {
												$conds1['shop_id'] = 0;
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
							
								<label><span style="font-size: 17px; color: red;">*</span><?php echo get_msg('shop_cover_photo_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_photo_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<br>

								<?php echo get_msg('shop_image_recommended_size')?>

								<input class="btn btn-sm" type="file" name="cover" id="cover">
							</div>

							<!-- Icon  -->
							<div class="form-group">
							
								<label><span style="font-size: 17px; color: red;">*</span><?php echo get_msg('shop_icon_photo_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_photo_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<br>

								<?php echo get_msg('shop_image_recommended_size_icon')?>

								<input class="btn btn-sm" type="file" name="icon" id="icon">
							</div>

						</div>

					</div>
					
					<div class="row">
						<legend><?php echo get_msg('contact_info')?></legend>
						<div class="col-md-6">

							<div class="form-group">
								<label>
									<?php echo get_msg('phone_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label') ?>" name='about_phone1' id='about_phone1' value="">
							</div>


							<div class="form-group">
								<label>
									<?php echo get_msg('phone_label3') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label3') ?>" name='about_phone3' id='about_phone3' value="">
							</div>
						</div>

						<div class="col-md-6">
							
							<div class="form-group">
								<label>
									<?php echo get_msg('phone_label2') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label2') ?>" name='about_phone2' id='about_phone2' value="">
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-md-6">

							<div class="form-group">
								<label><?php echo get_msg('address_label1')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address1" placeholder="<?php echo get_msg('address_label1')?>" rows="5"></textarea>
							</div>

							<div class="form-group">
								<label><?php echo get_msg('address_label3')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address3" placeholder="<?php echo get_msg('address_label3')?>" rows="5"></textarea>
							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">
								<label><?php echo get_msg('address_label2')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address2" placeholder="<?php echo get_msg('address_label2')?>" rows="5"></textarea>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo get_msg('contact_email_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_email_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								
								<input class="form-control" type="text" placeholder="Email" name='email' id='email'
								value="">
							</div>	
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo get_msg('about_website_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'about_website',
										'id' => 'about_website',
										'class' => 'form-control',
										'placeholder' => 'Website',
										'value' => ''
									));
								?>
							</div>
						</div>
					</div>

					<div class="row">
						<legend><?php echo get_msg('user_info')?></legend>
						<div class="col-md-6">

							<div class="form-group">
								<label>
									<span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('user_name') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" 
										title="<?php echo get_msg('shop_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="Please enter your name" name='user_name' id='user_name'
								value="">
							</div>

							<div class="form-group">
								<label>
									<span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('user_email_label') ?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_desc_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>

								<input class="form-control" type="text" placeholder="Please enter your email" name='user_email' id='user_email'
								value="">
							</div>
							
						</div>

						<div class="col-md-6">

							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('user_password')?></label>

								<?php echo form_input(array(
									'type' => 'password',
									'name' => 'user_password',
									'value' => '',
									'class' => 'form-control form-control',
									'placeholder' => 'Password',
									'id' => 'user_password'
								)); ?>
							</div>
										
							<div class="form-group">
								<label> <span style="font-size: 17px; color: red;">*</span>
									<?php echo get_msg('conf_password')?></label>
								
								<?php echo form_input(array(
									'type' => 'password',
									'name' => 'conf_password',
									'value' => '',
									'class' => 'form-control form-control',
									'placeholder' => 'Confirm Password',
									'id' => 'conf_password'
								)); ?>
							</div>
						</div>
					</div>
					
					<div class="form-submit">
						 <input type="submit" value="<?php echo get_msg('go_to_paypal_label')?>" class="btn btn-outline-primary" name="save" />
                       
                        <input type="button" value="Reset" class="btn btn-outline-primary" id="reset" name="reset" />
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {
		
		$('#register-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$shop->id; ?>"
					
				},
				description:{
					required : true
				},
				shoptag:{
					required : true
				},
				cover:{
					required : true
				},
				icon:{
					required : true
				},
				user_name:{
					required : true
				},
				user_email:{
					required: true,
					remote: "<?php echo $module_site_url .'/ajx_exists_user/'.@$user->user_id; ?>"
				},
				user_password:{
					required: true,
					minlength: 4
				},
				conf_password:{
					required: true,
					equalTo: '#user_password'
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_shop_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_shop_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_shop_exist' ) ;?>."
				},
				description:{
					required : "<?php echo get_msg( 'err_description_label' ) ;?>."
				},
				shoptag:{
					required : "<?php echo get_msg( 'err_shop_tag_label' ) ;?>."
				},
				cover:{
					required : "<?php echo get_msg( 'err_image_missing' ) ;?>."
				},
				icon:{
					required : "<?php echo get_msg( 'err_icon_missing' ) ;?>."
				},
				user_name:{
					required: "<?php echo get_msg( 'err_user_name_blank' ); ?>"
				},
				user_email:{
					required: "<?php echo get_msg( 'err_user_email_blank' ); ?>",
					email: "<?php echo get_msg( 'err_user_email_invalid' ); ?>",
					remote: "<?php echo get_msg( 'err_user_email_exist' ); ?>"
				},
				user_password:{
					required: "<?php echo get_msg('f_user_pass_required'); ?>",
					minlength: "<?php echo get_msg('f_user_pass_length'); ?>"
				},
				conf_password:{
					required: "<?php echo get_msg('f_user_conf_required'); ?>",
					equalTo: "<?php echo get_msg('f_user_conf_length'); ?>"
				}
			}

		});

		// custom validation
		jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			    	return true;
			   }
		})
		

	}

	<?php endif; ?>
	$('#shoptag').change(function(){
		var shop_tag = $(this).val();

    	$('#tagselect').val(shop_tag);
    	
	});
</script>