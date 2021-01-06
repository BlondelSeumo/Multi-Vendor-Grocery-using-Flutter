<?php
	$attributes = array('id' => 'user-form');
	echo form_open( '', $attributes );
?>
<?php 
	$logged_in_user = $this->ps_auth->get_user_info();

	$conds_user_shop['user_id'] = $logged_in_user->user_id;
?>
<div class="container-fluid">
	<div class="col-12"  style="padding: 30px 20px 20px 20px;">
		<div class="card earning-widget">
		    <div class="card-header" style="border-top: 2px solid red;">
		        <h3 class="card-title"><?php echo get_msg('user_info')?></h3>
		    </div>

		<div id="perm_err" class="alert alert-danger fade in" style="display: none">
			<label for="permissions[]" class="error"></label>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		</div>
			
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
							'placeholder' => get_msg('user_name'),
							'id' => 'name'
						)); ?>

					</div>
					
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('user_email')?></label>

						<?php echo form_input(array(
							'name' => 'user_email',
							'value' => set_value( 'user_email', show_data( @$user->user_email ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('user_email'),
							'id' => 'user_email'
						)); ?>

					</div>
					
					<?php if ( @$user->user_is_sys_admin == false ): ?>

					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('user_password')?></label>

						<?php echo form_input(array(
							'type' => 'password',
							'name' => 'user_password',
							'value' => set_value( 'user_password' ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('user_password'),
							'id' => 'user_password'
						)); ?>
					</div>
								
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('conf_password')?></label>
						
						<?php echo form_input(array(
							'type' => 'password',
							'name' => 'conf_password',
							'value' => set_value( 'conf_password' ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('conf_password'),
							'id' => 'conf_password'
						)); ?>
					</div>
					
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('role_label')?></label>

						<?php 
							$options = array();
							foreach($this->Role->get_all()->result() as $role) {
								if ( $role->role_id != 1 ) {
									$options[$role->role_id] = $role->role_desc;
									
								} else if ( $role->role_id == 1 ) {
									$admin[$role->role_id] = $role->role_desc;
								} 
							}

							if ($user->role_id == 1) {
								$disabled = "disabled";
								echo form_dropdown(
									'role_id',
									$admin,
									set_value( 'role_id', @$user->role_id ),
									'class="form-control form-control-sm" id="role_id" '.$disabled.''
								);
							} else {
								$disabled = "";
								echo form_dropdown(
									'role_id',
									$options,
									set_value( 'role_id', @$user->role_id ),
									'class="form-control form-control-sm" id="role_id" '.$disabled.''
								);
							}
						?>
					</div>

					<div class="form-group">
						<?php 
							$user_shop = $this->User_shop->get_all_by( $conds_user_shop )->result();
							if(count($user_shop) == 1) {
					 	?>
	                  	<label>
							<?php echo get_msg('shop_name'); ?>
							<?php 
							    $selected_shop_id = $this->session->userdata('selected_shop_id');
							    $shop_id = $selected_shop_id['shop_id'];
							?>
							<input type="hidden" id="shop_id" name="shop_id" value="<?php echo $shop_id; ?>">
							<?php echo $this->Shop->get_one($shop_id)->name; ?>
						</label>
						<?php } elseif ( count($user_shop) > 1 ) { ?>
		                <select class="form-control select2" multiple="multiple" id="usershop" 
		                          style="width: 100%;">
	                       	<?php
	                       		$conds2['user_id'] = $logged_in_user->user_id;
								$shops = $this->User_shop->get_shop_id($conds2)->result();

								$i = 1;
								foreach ($shops as $shop) {

									if($shop->shop_id != "") {
										$conds['shop_id'] = $shop->shop_id;
									} else {
										$conds['shop_id'] = '0';
									}
									
								

									if(isset($user->user_id)) {
										$conds['user_id'] = $user->user_id;
									} else {
										$conds['user_id'] = '0';
									}
									
									
									$user_shop_id = $this->User_shop->get_one_by($conds)->user_id;
									
									$selected_value = "";
									if($user_shop_id == "" ) {
										$selected_value = "";
									} else {
										$selected_value = "selected";
									}
									echo $selected_value . $i;
									echo '<option  '.$selected_value.' name="'.$this->Shop->get_one($shop->shop_id)->name.'" value="'.$shop->shop_id.'">'.$this->Shop->get_one($shop->shop_id)->name.'</option>';

									$i++;
								}

								if($user->user_id != "") {
										$conds1['user_id'] = $user->user_id;
									} else {
										$conds1['user_id'] = 0;
									}
									
								$existing_shop_ids = $this->User_shop->get_all_by($conds1)->result();
								
								foreach ($existing_shop_ids as $exist_user_shop) {
									$result_shop_ids .= $exist_user_shop->shop_id .",";
								}

							?>
							<input type="hidden"  id="shopselect" name="shopselect">
							<input type="hidden"  id="existing_shopselect" name="existing_shopselect" value="<?php echo $result_shop_ids; ?>">
		                </select>
		                <?php } ?>
			        </div>

					<?php endif; ?>
				</div>
			
				<?php if ( @$user->user_is_sys_admin == false ): ?>

				<div class="col-md-6">
					<div class="form-group">
						<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('allowed_modules')?></label>
						
						<?php 
							if (!@$user) {
								foreach($this->Module->get_all_module()->result() as $module): 
								if( $module->module_id != 4 ) {
						?>

							<div class="form-check">
								<label class="form-check-label">
								
								<?php echo form_checkbox('permissions[]', $module->module_id, set_checkbox('permissions', $module->module_id, $this->User->has_permission( $module->module_id, @$user->user_id )), 'checked'); ?>

								<?php echo $module->module_desc; ?>

								</label>
							</div>
						<?php } ?>
						<?php endforeach; ?>
						<?php 
							} else { 
								foreach($this->Module->get_all_module()->result() as $module): 
								if( $module->module_id != 4 ) {
						?>
							<div class="form-check">
								<label class="form-check-label">
								
								<?php echo form_checkbox('permissions[]', $module->module_id, set_checkbox('permissions', $module->module_id, $this->User->has_permission( $module->module_id, @$user->user_id ))); ?>

								<?php echo $module->module_desc; ?>

								</label>
							</div>
							<?php } ?>
						<?php endforeach; ?>
						<?php } ?>
					</div>
				</div>

				<?php endif; ?>

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
    <!-- card info -->
	</div>
</div>

<?php echo form_close(); ?>
<script>
	$('#usershop').change(function(){
	var usershop = $(this).val();
	$('#shopselect').val(usershop);
	
});
</script>