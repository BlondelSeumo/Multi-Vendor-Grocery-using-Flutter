  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand border-bottom">
    <?php $be_url = $this->config->item('be_url'); ?>
    
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>

      <!-- Brand Logo -->
      
        <span class="brand-text">
          <?php 
              

            $selected_menu_child_name = $this->uri->segment(2); 

            $conds['module_name'] = $selected_menu_child_name;

            $selected_module_desc = $this->Module->get_one_by($conds)->module_desc;

            if($selected_module_desc != "") {
                echo $selected_module_desc; 
            } else {
                echo "Dashboard";
            }
            
          
          ?></span>
      
      </ul>
      <ul class="navbar-nav ml-auto">


       <li class="user user-menu">
        
            <a href="<?php echo site_url ( $be_url . '/profile');?>" class="d-block">
                <?php $logged_in_user = $this->ps_auth->get_user_info(); 
                  if( $logged_in_user->user_profile_photo  != "") {
                ?>
                  <img src="<?php echo img_url( $logged_in_user->user_profile_photo ); ?>" class="user-image" alt="User Image">
                <?php } else { ?>
                   <img src="<?php echo img_url( 'thumbnail/avatar.png'); ?>" class="user-image" alt="User Image">
                <?php } ?>

              <span class="hidden-xs"><?php echo $logged_in_user->user_name;?></span>

            </a>
            
            
      </li>

      <li class="messages-menu open" style="padding-left: 30px;">
        <a href="<?php echo site_url('logout');?>" aria-expanded="true">
          <i class="fa fa-sign-out" style="font-size: 1.5em; color: #000;"></i>
        </a>
        
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->