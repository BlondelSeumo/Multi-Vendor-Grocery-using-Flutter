<?php 
	$logged_in_user = $this->ps_auth->get_user_info();
	if ( $logged_in_user->user_is_sys_admin ==1 ){ 
?>

	<div class="nav-container">
		<nav class="navbar navbar-expand-lg navbar-dark">
		  	<a class="navbar-brand" href="<?php echo site_url('admin/shops/');?>">
		  		<!-- Brand Logo -->
		  		<?php
	             	$conds = array( 'img_type' => 'backend-logo', 'img_parent_id' => 'be1' );
              		$images = $this->Image->get_all_by( $conds )->result();
	            ?>
			    <img src="<?php echo img_url( $images[0]->img_path ); ?>" class="img-circle img-sm" alt="User Image">
		  	</a>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  	</button>

		  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      	<li class="nav-item dropdown">
			      	    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			        		&#10148;
			        		<?php echo get_msg('shop_label'); ?>
			        	</a>
			        	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		            		<a class="dropdown-item" href="<?php echo site_url('/admin/shops/shopadd');?>"> 
		    	  					&#10148; <?php echo get_msg('btn_create_new_shop'); ?>
		    	  			</a>

		    	  			<div class="dropdown-divider"></div>
		            		<a class="dropdown-item" href='<?php echo site_url('/admin/shops/shoplist');?>'> 
		  				  		&#10148; <?php echo get_msg('btn_shop_list'); ?>
		  				    </a>
		  				    <div class="dropdown-divider"></div>
		  				    <a class="dropdown-item" href='<?php echo site_url('/admin/approves/');?>'> 
		  				  		&#10148; <?php echo get_msg('btn_approved_shop'); ?>
		  				    </a>
		  				    <div class="dropdown-divider"></div>
		  				    <a class="dropdown-item" href='<?php echo site_url('/admin/rejects/');?>'> 
		  				  		&#10148; <?php echo get_msg('btn_reject_shop'); ?>
		  				    </a>
		  				    <div class="dropdown-divider"></div>
		  				    <a class="dropdown-item" href='<?php echo site_url('/admin/shop_rates/');?>'> 
		  				  		&#10148; <?php echo get_msg('btn_shop_rating'); ?>
		  				    </a>	
		  				     <div class="dropdown-divider"></div>
		  				    <a class="dropdown-item" href='<?php echo site_url('/admin/tags/');?>'> 
		  				  		&#10148; <?php echo get_msg('btn_shop_tag'); ?>
		  				    </a>			

			          	</div>
			      	</li>
			      	<!-- start entry dropdown -->
			      	<li class="nav-item dropdown">
			      	    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			        		&#10148;
			        		<?php echo get_msg('entry_label'); ?>
			        	</a>
			        	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		            		<a class="dropdown-item" href="<?php echo site_url('/admin/categories');?>"> 
		    	  					&#10148; <?php echo get_msg('cat_module'); ?>
		    	  			</a>

		    	  			<div class="dropdown-divider"></div>
		            		<a class="dropdown-item" href='<?php echo site_url('/admin/subcategories');?>'> 
		  				  		&#10148; <?php echo get_msg('subcat_module'); ?>
		  				    </a>
		  				    <div class="dropdown-divider"></div>
		  				    <a class="dropdown-item" href='<?php echo site_url('/admin/transaction_status');?>'> 
		  				  		&#10148; <?php echo get_msg('trans_status_module'); ?>
		  				    </a>
		  				    <div class="dropdown-divider"></div>
		  				    <a class="dropdown-item" href='<?php echo site_url('/admin/payment_status');?>'> 
		  				  		&#10148; <?php echo get_msg('payment_status_module'); ?>
		  				    </a>
		  				    
			          	</div>
			      	</li>
			      	<!-- end entry dropdown -->
			      	<li class="nav-item">
				        <a class="nav-link text-expanded" href="<?php echo site_url('/admin/notis');?>"> 
						  	&#10148;
						  	<?php echo get_msg('btn_push_notification'); ?>
						</a>
					</li>		  	

			    <li class="nav-item">
				        <a class="nav-link text-expanded" href="<?php echo site_url('admin/shops/exports');?>"> 
					  		&#10148; <?php echo get_msg('btn_export_database'); ?>
					  	</a>
				    </li>
			      	<li class="nav-item dropdown">
				      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	&#10148;
				        	<?php echo get_msg('user_label'); ?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					        <a class="dropdown-item" href="<?php echo site_url('/admin/system_users');?>"> 
							  	&#10148; <?php echo get_msg('btn_system_user'); ?>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url('/admin/registered_users');?>"> 
							  	&#10148; <?php echo get_msg('btn_register_user'); ?>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url('/admin/deliboys');?>"> 
							  	&#10148; <?php echo get_msg('deliboys_module'); ?>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url('/admin/banusers');?>"> 
							  	&#10148; <?php echo get_msg('banusers_module'); ?>
							</a>
						</div>
				    </li>

				    <!--
			      	<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	&#10148;
				        	<?php echo get_msg('btn_approval'); ?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				        	<a class="dropdown-item" href="<?php echo site_url('admin/pendings');?>"> 
					  					&#10148;<?php echo get_msg('btn_pending'); ?>
					  		</a>
				          	<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/rejects');?>"> 
								  		&#10148; <?php echo get_msg('btn_reject'); ?>
							</a>
				        </div>
			      	</li>
			      -->

			      	<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	&#10148;
				        	<?php echo get_msg('setting_label'); ?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				        	<a class="dropdown-item" href="<?php echo site_url('admin/apis');?>"> 
					  					&#10148; <?php echo get_msg('api_info'); ?>
					  		</a>
				          	<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/abouts');?>"> 
								  		&#10148; <?php echo get_msg('btn_about_app'); ?>
							</a>
							<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/api_keys');?>"> 
								  		&#10148; <?php echo get_msg('btn_api_keys'); ?>
							</a>
							<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/paypal_configs');?>"> 
								  		&#10148; <?php echo get_msg('btn_paypal_config'); ?>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url('/admin/module_groups');?>"> 
								  		&#10148; <?php echo get_msg('module_group_lang'); ?>
							</a>
							<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/modules');?>"> 
								  		&#10148; <?php echo get_msg('module_lang'); ?>

				          	<a class="dropdown-item" href="<?php echo site_url('/admin/privacy_policies');?>"> 
								  		&#10148; <?php echo get_msg('privacy_policy_module'); ?>
							</a>
							<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/languages');?>"> 
								  		&#10148; <?php echo get_msg('language_module'); ?>
							</a>
							<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="<?php echo site_url('/admin/backend_configs');?>"> 
								  		&#10148; <?php echo get_msg('backend_setting_module'); ?>
							</a>
				        </div>
			      	</li>
			      	<li class="nav-item">
				        <a class="nav-link text-expanded" href="<?php echo site_url('/admin/versions/add');?>"> 
						  	&#10148; <?php echo get_msg('btn_version'); ?>
						</a>
			      	</li>
			      	<li class="nav-item">
				        <a class="nav-link text-expanded" href="<?php echo site_url('/admin/contacts');?>"> 
						  	&#10148; <?php echo get_msg('btn_contact'); ?>
						</a>
			      	</li>
			    </ul>
			   
			    <ul class="navbar-nav ml-auto">
		      		<li class="user user-menu">
		  				<a href="<?php echo site_url ('admin/profile');?>">
					        <?php 
					        	if( $logged_in_user->user_profile_photo  != "" ) {
					        ?>
					        	<img src="<?php echo img_url( $logged_in_user->user_profile_photo ); ?>" class="user-image" alt="User Image">
					        <?php } else if (!file_exists(img_url( 'thumbnail/'. $logged_in_user->user_profile_photo )) || $logged_in_user->user_profile_photo  == "") { ?>
					        	 <img src="<?php echo img_url( 'thumbnail/avatar.png'); ?>" class="user-image" alt="User Image">
					        <?php } ?>
					        <span class="hidden-xs" style="color: #fff; font-weight: bold;"><?php echo $logged_in_user->user_name;?></span>
					    </a>
					    <a href="<?php echo site_url('logout');?>">
					        <i class="fa fa-sign-out" style="font-size: 1.5em; color: #fff;"></i>
		            	</a>
		      		</li>
		    	</ul>
		  </div>
		</nav>
	</div>
<?php } ?>

<?php 
	$conds_user_shop['user_id'] =  $logged_in_user->user_id;
	$user_shop = $this->User_shop->get_all_by( $conds_user_shop )->result();
	if(count($user_shop) > 1) {
?>

<div class="nav-container">
	<nav class="navbar navbar-expand-lg navbar-dark">
		<a class="navbar-brand" href="#">
	  		<!-- Brand Logo -->
		   <img src="<?php echo img_url( "shopping-cart.png" ); ?>" class="img-circle img-sm" alt="User Image">
	  	</a>

	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  	</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
	  		<ul class="navbar-nav ml-auto">

		       	<li class="user user-menu">
		            <a href="<?php echo site_url ('admin/profile');?>">
				        <?php $logged_in_user = $this->ps_auth->get_user_info(); 
				        	if( $logged_in_user->user_profile_photo  != "") {
				        ?>
				        	<img src="<?php echo img_url( $logged_in_user->user_profile_photo ); ?>" class="user-image" alt="User Image">
				        <?php } else { ?>
				        	 <img src="<?php echo img_url( 'thumbnail/avatar.png'); ?>" class="user-image" alt="User Image">
				        <?php } ?>
				        <span class="hidden-xs" style="color: black; font-weight: bold;"><?php echo $logged_in_user->user_name;?></span>
				    </a>
				    <a href="<?php echo site_url('logout');?>">
				        <i class="fa fa-sign-out" style="font-size: 1.5em; color: #fff;"></i>
				    </a>
		      	</li>
	    	</ul>
	  	</div>
	</nav>
</div>

<?php } ?>