<?php
$attributes = array('id' => 'shop-form','enctype' => 'multipart/form-data');
echo form_open( '', $attributes);
?>

<section class="content animated fadeInRight" style="padding: 30px 20px 20px 20px;">
	<div class="card">
	    <div class="card-header" style="border-top: 2px solid red;">
			<div class="card-body">
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
							value="<?php echo $shop->name; ?>" disabled>
						</div>

						<div class="form-group">
							<label>
								<span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('description_label') ?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_desc_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<textarea class="form-control" value="<?php echo $shop->description; ?>" name="description" placeholder="Description" rows="5" disabled></textarea>
						</div>

						<?php if ( $shop->payment_status == 1 ){ ?>
						<div class="form-group" style="background-color: #64CE14; height: 70px;">
							<div class="card-body">
								<table class="table v-middle no-border">
	        						<tbody>
										<tr>
	                            			
											<td>
												<h3 class="text-center"><?php echo get_msg('paypal_success_label')?></h3>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<?php } else { ?>
						<div class="form-group" style="background-color: #E62A28; height: 70px;">
							<div class="card-body">
								<table class="table v-middle no-border">
	        						<tbody>
										<tr>
	                            			<td>
												<span class="fa fa-frown-o"></span>
											</td>
											<td>
												<h3><?php echo get_msg('paypal_success_label')?></h3>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<?php } ?>
						
					</div>

					<div class="col-md-6">

						<div class="form-group">
			              	<label>
			              		<span style="font-size: 17px; color: red;">*</span>
			              		<?php echo get_msg('shop_tags') ?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_tags')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

			                <select class="form-control select2" multiple="multiple" name="shoptag" id="shoptag" disabled>
			                   	<?php
			                   		$conds['shop_id'] = $id;
			                   		$tags = $this->Shoptag->get_all_by($conds)->result();

			                   		foreach ($tags as $tag) {
			                   			$tag_id = $tag->tag_id;

			                   			$selected_value = "";
										if($tag_id == "" ) {
											$selected_value = "";
										} else {
											$selected_value = "selected";
										}
										echo $selected_value . $i;
										echo '<option  '.$selected_value.' name="'.$this->Tag->get_one($tag->tag_id)->name.'" value="'.$tag->tag_id.'">'.$this->Tag->get_one($tag->tag_id)->name.'</option>';

										$i++;
			                   		}

								?>
			                </select>

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

							<hr/>	
							<?php
								$conds = array( 'img_type' => 'shop', 'img_parent_id' => $id );
		
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
											
										</div>

									</div>

								<?php endforeach;?>

								</div>
							
							<?php endif; ?>
						<?php endif; ?>	

						<br><br>

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

							<hr/>	
							<?php
								$conds = array( 'img_type' => 'shop-icon', 'img_parent_id' => $id );
		
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

										</div>

									</div>

								<?php endforeach;?>

								</div>

							
							<?php endif; ?>
						<?php endif; ?>	


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

							<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label') ?>" name='about_phone1' id='about_phone1' value="<?php echo $shop->about_phone1; ?>" disabled>
						</div>


						<div class="form-group">
							<label>
								<?php echo get_msg('phone_label3') ?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" 
									title="<?php echo get_msg('shop_name_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label') ?>" name='about_phone3' id='about_phone3' value="<?php echo $shop->about_phone3; ?>" disabled>
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

							<input class="form-control" type="text" placeholder="<?php echo get_msg('phone_label2') ?>" name='about_phone2' id='about_phone2' value="<?php echo $shop->about_phone2; ?>" disabled>

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
							<textarea class="form-control" name="address1" value="<?php echo $shop->address1; ?>" placeholder="<?php echo get_msg('address_label1')?>" rows="5" disabled></textarea>
						</div>

						<div class="form-group">
							<label><?php echo get_msg('address_label3')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<textarea class="form-control" value="<?php echo $shop->address3; ?>" name="address3" placeholder="<?php echo get_msg('address_label3')?>" rows="5" disabled></textarea>
						</div>

					</div>

					<div class="col-md-6">

						<div class="form-group">
							<label><?php echo get_msg('address_label2')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('shop_address_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>
							<textarea class="form-control" name="address2" value="<?php echo $shop->address2; ?>" placeholder="<?php echo get_msg('address_label2')?>" rows="5" disabled></textarea>
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
							
							<input class="form-control" type="text" value="<?php echo $shop->email; ?>" placeholder="Email" name='email' id='email' disabled>
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
									'value' => set_value( 'about_website', show_data( @$shop->about_website ), false ),
									'disabled' => 'true'
								));
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="content animated fadeInRight" style="padding: 10px 20px 20px 20px;">
	<div class="card">
	    <div class="card-header" style="border-top: 2px solid red;">
	    	<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('user_name')?></label>

							<?php echo form_input(array(
								'name' => 'user_name',
								'value' => set_value( 'user_name', show_data( @$user->user_name ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => 'Name',
								'id' => 'name',
								'disabled' => 'true'
							)); ?>

						</div>
						
						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('user_email')?></label>

							<?php echo form_input(array(
								'name' => 'user_email',
								'value' => set_value( 'user_email', show_data( @$user->user_email ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => 'Email',
								'id' => 'user_email',
								'disabled' => 'true'
							)); ?>

						</div>
						
						<?php if ( @$user->user_is_sys_admin == false ): ?>

						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('role_label')?></label>

							<?php 
								$options = array();
								foreach($this->Role->get_all()->result() as $role) {
									$options[$role->role_id] = $role->role_desc;
								}

								echo form_dropdown(
									'role_id',
									$options,
									set_value( 'role_id', @$user->role_id ),
									'class="form-control form-control-sm" id="role_id" disabled'
								);
							?>
						</div>

						<?php endif; ?>
					</div>
				
					<?php if ( @$user->user_is_sys_admin == false ): ?>

					<div class="col-md-6">
						<div class="form-group">
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('allowed_modules')?></label>
							
							<?php foreach($this->Module->get_all_module()->result() as $module): 
								if( $module->module_id != 4 ) {
							?>

								<div class="form-check" id="mycheck">
									<label class="form-check-label">
									
									<?php echo form_checkbox('permissions[]', $module->module_id, set_checkbox('permissions', $module->module_id, $this->User->has_permission( $module->module_id, @$user->user_id )),'checked'); ?>

									<?php echo $module->module_desc; ?>
									
									</label>
									<input type="hidden" name="module_id[]" value="<?php echo $module->module_id;?>">
								</div>
							<?php } ?>
							<?php endforeach; ?>
							
						</div>
					</div>

					<?php endif; ?>

				</div>

				<div class="form-group" style="background-color: #edbbbb; padding: 20px;">
					<label>
						<strong><?php echo get_msg('select_status')?></strong>
					</label>

					<select id="status" name="status" class="form-control">
					   <option value="1">Approved</option>
					   <option value="3">Reject</option>
					</select>
				</div>
			</div>
			
			<div class="card-footer">
		        <button type="submit" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_save')?>
				</button>

				<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
					<?php echo get_msg('btn_cancel')?>
				</a>
		    </div>
	    </div>
	</div>
</section>